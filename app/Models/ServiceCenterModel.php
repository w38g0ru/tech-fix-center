<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceCenterModel extends Model
{
    protected $table = 'service_centers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'address', 'contact_person', 'phone', 'email', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'name' => [
            'label' => 'Service Center Name',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        'address' => [
            'label' => 'Address',
            'rules' => 'permit_empty|max_length[500]'
        ],
        'contact_person' => [
            'label' => 'Contact Person',
            'rules' => 'permit_empty|max_length[100]'
        ],
        'phone' => [
            'label' => 'Phone',
            'rules' => 'permit_empty|max_length[20]'
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'permit_empty|valid_email|max_length[100]'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|in_list[Active,Inactive]'
        ]
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Service center name is required',
            'min_length' => 'Service center name must be at least 2 characters long',
            'max_length' => 'Service center name cannot exceed 100 characters'
        ],
        'address' => [
            'max_length' => 'Address cannot exceed 500 characters'
        ],
        'contact_person' => [
            'max_length' => 'Contact person name cannot exceed 100 characters'
        ],
        'phone' => [
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Email cannot exceed 100 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be Active or Inactive'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get active service centers
     */
    public function getActiveServiceCenters($perPage = null)
    {
        $builder = $this->where('status', 'Active')
                    ->orderBy('name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get service center statistics
     */
    public function getServiceCenterStats()
    {
        $total = $this->countAll();
        $active = $this->where('status', 'Active')->countAllResults();
        $inactive = $this->where('status', 'Inactive')->countAllResults();
        
        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive
        ];
    }

    /**
     * Search service centers
     */
    public function searchServiceCenters($search, $perPage = null)
    {
        $builder = $this->like('name', $search)
                    ->orLike('contact_person', $search)
                    ->orLike('phone', $search)
                    ->orLike('email', $search)
                    ->orderBy('name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get service centers with job counts
     */
    public function getServiceCentersWithJobCounts($perPage = null)
    {
        $builder = $this->select('service_centers.*, COUNT(jobs.id) as job_count')
                    ->join('jobs', 'jobs.service_center_id = service_centers.id', 'left')
                    ->groupBy('service_centers.id')
                    ->orderBy('service_centers.name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    // ========================================
    // RELATIONSHIP METHODS
    // ========================================

    /**
     * Get all jobs referred to a specific service center
     * Relationship: service_centers.id -> jobs.service_center_id (One-to-Many)
     *
     * @param int $serviceCenterId
     * @param int|null $perPage
     * @return array
     */
    public function getJobs($serviceCenterId, $perPage = null)
    {
        $jobModel = new \App\Models\JobModel();
        return $jobModel->getJobsByServiceCenter($serviceCenterId, $perPage);
    }

    /**
     * Get all referrals to a specific service center
     * Relationship: service_centers.id -> referred.service_center_id (One-to-Many)
     *
     * @param int $serviceCenterId
     * @param int|null $perPage
     * @return array
     */
    public function getReferrals($serviceCenterId, $perPage = null)
    {
        $referredModel = new \App\Models\ReferredModel();

        $builder = $referredModel->where('service_center_id', $serviceCenterId)
                                ->orderBy('created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get service center with statistics
     *
     * @param int $serviceCenterId
     * @return array|null
     */
    public function getServiceCenterWithStats($serviceCenterId)
    {
        $serviceCenter = $this->find($serviceCenterId);
        if (!$serviceCenter) {
            return null;
        }

        $jobModel = new \App\Models\JobModel();
        $referredModel = new \App\Models\ReferredModel();

        // Get job statistics
        $totalJobs = $jobModel->where('service_center_id', $serviceCenterId)->countAllResults();
        $completedJobs = $jobModel->where('service_center_id', $serviceCenterId)->where('status', 'Completed')->countAllResults();
        $pendingJobs = $jobModel->where('service_center_id', $serviceCenterId)->whereNotIn('status', ['Completed', 'Returned'])->countAllResults();

        // Get referral statistics
        $totalReferrals = $referredModel->where('service_center_id', $serviceCenterId)->countAllResults();
        $completedReferrals = $referredModel->where('service_center_id', $serviceCenterId)->where('status', 'Completed')->countAllResults();

        $serviceCenter['stats'] = [
            'total_jobs' => $totalJobs,
            'completed_jobs' => $completedJobs,
            'pending_jobs' => $pendingJobs,
            'total_referrals' => $totalReferrals,
            'completed_referrals' => $completedReferrals,
            'job_completion_rate' => $totalJobs > 0 ? round(($completedJobs / $totalJobs) * 100, 2) : 0,
            'referral_completion_rate' => $totalReferrals > 0 ? round(($completedReferrals / $totalReferrals) * 100, 2) : 0
        ];

        return $serviceCenter;
    }

    /**
     * Get service centers with their workload
     *
     * @param int|null $perPage
     * @return array
     */
    public function getServiceCentersWithWorkload($perPage = null)
    {
        $builder = $this->select('service_centers.*,
                            COUNT(DISTINCT jobs.id) as total_jobs,
                            COUNT(DISTINCT CASE WHEN jobs.status IN ("Pending", "In Progress", "Referred to Service Center") THEN jobs.id END) as active_jobs,
                            COUNT(DISTINCT CASE WHEN jobs.status = "Completed" THEN jobs.id END) as completed_jobs,
                            COUNT(DISTINCT referred.id) as total_referrals,
                            COUNT(DISTINCT CASE WHEN referred.status = "Completed" THEN referred.id END) as completed_referrals')
                        ->join('jobs', 'jobs.service_center_id = service_centers.id', 'left')
                        ->join('referred', 'referred.service_center_id = service_centers.id', 'left')
                        ->where('service_centers.status', 'Active')
                        ->groupBy('service_centers.id')
                        ->orderBy('active_jobs', 'DESC')
                        ->orderBy('service_centers.name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get service center performance metrics
     */
    public function getServiceCenterPerformance($serviceCenterId, $days = 30)
    {
        $cutoffDate = date('Y-m-d', strtotime("-{$days} days"));

        $jobModel = new \App\Models\JobModel();
        $referredModel = new \App\Models\ReferredModel();

        // Recent jobs
        $recentJobs = $jobModel->where('service_center_id', $serviceCenterId)
                              ->where('created_at >=', $cutoffDate)
                              ->countAllResults();

        // Recent referred items
        $recentReferred = $referredModel->where('service_center_id', $serviceCenterId)
                                       ->where('created_at >=', $cutoffDate)
                                       ->countAllResults();

        // Completed items
        $completedJobs = $jobModel->where('service_center_id', $serviceCenterId)
                                 ->where('status', 'Completed')
                                 ->where('created_at >=', $cutoffDate)
                                 ->countAllResults();

        $completedReferred = $referredModel->where('service_center_id', $serviceCenterId)
                                          ->where('status', 'Completed')
                                          ->where('created_at >=', $cutoffDate)
                                          ->countAllResults();

        return [
            'recent_jobs' => $recentJobs,
            'recent_referred' => $recentReferred,
            'completed_jobs' => $completedJobs,
            'completed_referred' => $completedReferred,
            'total_recent' => $recentJobs + $recentReferred,
            'total_completed' => $completedJobs + $completedReferred,
            'completion_rate' => ($recentJobs + $recentReferred) > 0
                ? round((($completedJobs + $completedReferred) / ($recentJobs + $recentReferred)) * 100, 2)
                : 0
        ];
    }


}
