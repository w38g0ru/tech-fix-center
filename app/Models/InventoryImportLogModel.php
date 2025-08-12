<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryImportLogModel extends Model
{
    protected $table = 'inventory_import_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'filename',
        'imported_by',
        'total_rows',
        'successful_rows',
        'failed_rows',
        'error_log',
        'status'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'filename' => [
            'label' => 'Filename',
            'rules' => 'required|max_length[255]'
        ],
        'imported_by' => [
            'label' => 'Imported By',
            'rules' => 'required|is_natural_no_zero'
        ],
        'total_rows' => [
            'label' => 'Total Rows',
            'rules' => 'required|is_natural'
        ],
        'successful_rows' => [
            'label' => 'Successful Rows',
            'rules' => 'required|is_natural'
        ],
        'failed_rows' => [
            'label' => 'Failed Rows',
            'rules' => 'required|is_natural'
        ],
        'error_log' => [
            'label' => 'Error Log',
            'rules' => 'permit_empty'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|in_list[Processing,Completed,Failed]'
        ]
    ];

    protected $validationMessages = [
        'filename' => [
            'required' => 'Filename is required',
            'max_length' => 'Filename cannot exceed 255 characters'
        ],
        'imported_by' => [
            'required' => 'Imported by user ID is required',
            'is_natural_no_zero' => 'Imported by must be a valid user ID'
        ],
        'total_rows' => [
            'required' => 'Total rows count is required',
            'is_natural' => 'Total rows must be a valid number'
        ],
        'successful_rows' => [
            'required' => 'Successful rows count is required',
            'is_natural' => 'Successful rows must be a valid number'
        ],
        'failed_rows' => [
            'required' => 'Failed rows count is required',
            'is_natural' => 'Failed rows must be a valid number'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be one of: Processing, Completed, Failed'
        ]
    ];

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setCreatedAt'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Set created_at timestamp before insert
     */
    protected function setCreatedAt(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    /**
     * Get import logs with user details
     */
    public function getImportLogsWithDetails($perPage = null)
    {
        $builder = $this->select('inventory_import_logs.*,
                            admin_users.full_name as imported_by_name,
                            admin_users.username as imported_by_username')
                    ->join('admin_users', 'admin_users.id = inventory_import_logs.imported_by', 'left')
                    ->orderBy('inventory_import_logs.created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get import statistics
     */
    public function getImportStats()
    {
        $totalImports = $this->countAll();
        $successfulImports = $this->where('status', 'Completed')->where('failed_rows', 0)->countAllResults();
        $partialImports = $this->where('status', 'Completed')->where('failed_rows >', 0)->countAllResults();
        $failedImports = $this->where('status', 'Failed')->countAllResults();

        $totalRowsImported = $this->selectSum('successful_rows')->first()['successful_rows'] ?? 0;
        $totalRowsFailed = $this->selectSum('failed_rows')->first()['failed_rows'] ?? 0;

        return [
            'total_imports' => $totalImports,
            'successful_imports' => $successfulImports,
            'partial_imports' => $partialImports,
            'failed_imports' => $failedImports,
            'total_rows_imported' => $totalRowsImported,
            'total_rows_failed' => $totalRowsFailed,
            'success_rate' => $totalImports > 0 ? round(($successfulImports / $totalImports) * 100, 2) : 0
        ];
    }

    /**
     * Get recent import logs
     */
    public function getRecentImports($limit = 10)
    {
        return $this->select('inventory_import_logs.*,
                            admin_users.full_name as imported_by_name')
                    ->join('admin_users', 'admin_users.id = inventory_import_logs.imported_by', 'left')
                    ->orderBy('inventory_import_logs.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get imports by user
     */
    public function getImportsByUser($userId, $perPage = null)
    {
        $builder = $this->where('imported_by', $userId)
                        ->orderBy('created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get failed imports
     */
    public function getFailedImports($perPage = null)
    {
        $builder = $this->select('inventory_import_logs.*,
                            admin_users.full_name as imported_by_name')
                    ->join('admin_users', 'admin_users.id = inventory_import_logs.imported_by', 'left')
                    ->where('inventory_import_logs.status', 'Failed')
                    ->orWhere('inventory_import_logs.failed_rows >', 0)
                    ->orderBy('inventory_import_logs.created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Clean old import logs
     */
    public function cleanOldLogs($days = 90)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        return $this->where('created_at <', $cutoffDate)->delete();
    }

    /**
     * Get status options
     */
    public function getStatusOptions()
    {
        return ['Processing', 'Completed', 'Failed'];
    }

    /**
     * Create import log entry
     */
    public function createImportLog($filename, $importedBy, $totalRows, $successfulRows, $failedRows, $errorLog = null, $status = 'Completed')
    {
        $data = [
            'filename' => $filename,
            'imported_by' => $importedBy,
            'total_rows' => $totalRows,
            'successful_rows' => $successfulRows,
            'failed_rows' => $failedRows,
            'error_log' => $errorLog,
            'status' => $status
        ];

        return $this->insert($data);
    }

    /**
     * Update import status
     */
    public function updateImportStatus($id, $status, $errorLog = null)
    {
        $data = ['status' => $status];
        
        if ($errorLog !== null) {
            $data['error_log'] = $errorLog;
        }

        return $this->update($id, $data);
    }
}
