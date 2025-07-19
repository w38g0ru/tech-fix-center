<?php

namespace App\Models;

use CodeIgniter\Model;

class BugReportModel extends Model
{
    protected $table = 'bug_reports';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'url',
        'feedback',
        'bug_type',
        'severity',
        'screenshot',
        'user_agent',
        'ip_address',
        'email',
        'can_contact'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false; // We only have created_at with DEFAULT CURRENT_TIMESTAMP
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'url' => [
            'label' => 'URL',
            'rules' => 'required|valid_url|max_length[500]'
        ],
        'feedback' => [
            'label' => 'Feedback',
            'rules' => 'required|min_length[10]'
        ],
        'bug_type' => [
            'label' => 'Bug Type',
            'rules' => 'permit_empty|in_list[UI,Functional,Crash,Typo,Other]'
        ],
        'severity' => [
            'label' => 'Severity',
            'rules' => 'permit_empty|in_list[Low,Medium,High,Critical]'
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'permit_empty|valid_email|max_length[255]'
        ],
        'can_contact' => [
            'label' => 'Can Contact',
            'rules' => 'permit_empty|in_list[0,1]'
        ]
    ];

    protected $validationMessages = [
        'url' => [
            'required' => 'URL is required.',
            'valid_url' => 'Please provide a valid URL.',
            'max_length' => 'URL cannot exceed 500 characters.'
        ],
        'feedback' => [
            'required' => 'Feedback is required.',
            'min_length' => 'Feedback must be at least 10 characters long.'
        ],
        'bug_type' => [
            'in_list' => 'Please select a valid bug type.'
        ],
        'severity' => [
            'in_list' => 'Please select a valid severity level.'
        ],
        'email' => [
            'valid_email' => 'Please provide a valid email address.',
            'max_length' => 'Email cannot exceed 255 characters.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get bug reports with pagination
     */
    public function getBugReportsWithPagination($perPage = 20, $search = null, $bug_type = null, $severity = null)
    {
        if ($search) {
            $this->groupStart()
                 ->like('url', $search)
                 ->orLike('feedback', $search)
                 ->orLike('email', $search)
                 ->groupEnd();
        }

        if ($bug_type) {
            $this->where('bug_type', $bug_type);
        }

        if ($severity) {
            $this->where('severity', $severity);
        }

        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    /**
     * Get bug report statistics
     */
    public function getBugReportStats()
    {
        return [
            'total' => $this->countAll(),
            'ui' => $this->where('bug_type', 'UI')->countAllResults(false),
            'functional' => $this->where('bug_type', 'Functional')->countAllResults(false),
            'crash' => $this->where('bug_type', 'Crash')->countAllResults(false),
            'critical' => $this->where('severity', 'Critical')->countAllResults(false),
            'high' => $this->where('severity', 'High')->countAllResults(false),
            'medium' => $this->where('severity', 'Medium')->countAllResults(false),
            'low' => $this->where('severity', 'Low')->countAllResults(false),
        ];
    }

    /**
     * Get recent bug reports
     */
    public function getRecentBugReports($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }

    /**
     * Get bug type options
     */
    public function getBugTypeOptions()
    {
        return ['UI', 'Functional', 'Crash', 'Typo', 'Other'];
    }

    /**
     * Get severity options
     */
    public function getSeverityOptions()
    {
        return ['Low', 'Medium', 'High', 'Critical'];
    }
}
