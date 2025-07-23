<?php

namespace App\Controllers;

use App\Libraries\SmsService;
use CodeIgniter\RESTful\ResourceController;

class Sms extends ResourceController
{
    protected $adminUserModel;
    protected $smsService;

    public function __construct()
    {
        $this->adminUserModel = new \App\Models\AdminUserModel();
        $this->smsService = new SmsService();

        // Load auth helper
        helper('auth');
    }

    /**
     * Send bulk SMS to all active users
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function sendBulkSms()
    {
        // Check if user is logged in and has permission
        if (!isLoggedIn()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Authentication required.'
            ])->setStatusCode(401);
        }

        if (!canCreateTechnician()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'You do not have permission to send bulk SMS.'
            ])->setStatusCode(403);
        }

        // Get all active users with valid phone numbers
        $users = $this->adminUserModel
                    ->where('status', 'active')
                    ->where('phone !=', '')
                    ->where('phone IS NOT NULL')
                    ->findAll();

        if (empty($users)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'No active users with valid phone numbers found.'
            ])->setStatusCode(404);
        }

        // Extract phone numbers
        $phoneNumbers = array_column($users, 'phone');

        // Compose SMS message
        helper('nepali_date');
        $currentDateTime = formatNepaliDateTime(date('Y-m-d H:i:s'), 'medium');
        $message = "Hi message from website sent on {$currentDateTime}. Sample message.";

        try {
            $result = $this->smsService->send($phoneNumbers, $message);

            // Check if SMS service returned an error
            if (!$result['status']) {
                $errorMessage = $result['message'] ?? 'SMS service error';
                log_message('error', 'Bulk SMS failed. Count: ' . count($phoneNumbers) . ', Error: ' . $errorMessage);

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Failed to send bulk SMS: ' . $errorMessage,
                    'count'   => count($phoneNumbers),
                    'code'    => $result['code'] ?? 'BULK_SMS_FAILED'
                ])->setStatusCode(500);
            }

            // SMS sent successfully
            log_message('info', 'Bulk SMS sent successfully to ' . count($phoneNumbers) . ' users');

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'SMS sent successfully to ' . count($phoneNumbers) . ' active users!',
                'count'   => count($phoneNumbers),
                'code'    => $result['code'] ?? 'BULK_SMS_SENT'
            ])->setStatusCode(200);

        } catch (\Exception $e) {
            // Handle any exceptions during SMS sending
            log_message('error', 'Bulk SMS sending exception. Count: ' . count($phoneNumbers) . ', Error: ' . $e->getMessage());

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'SMS service unavailable: ' . $e->getMessage(),
                'count'   => count($phoneNumbers),
                'code'    => 'SMS_SERVICE_ERROR'
            ])->setStatusCode(503);
        }
    }

    /**
     * Send SMS to user by ID
     *
     * @param int $id User ID
     * @return \CodeIgniter\HTTP\Response
     */
    public function sendSmsToUser($id = null)
    {
        // Check if user is logged in and has permission
        if (!isLoggedIn()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Authentication required.'
            ])->setStatusCode(401);
        }

        if (!canCreateTechnician()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'You do not have permission to send SMS.'
            ])->setStatusCode(403);
        }

        $id = intval($id);

        if ($id <= 0) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Invalid user ID. Must be a positive integer.'
            ])->setStatusCode(422);
        }

        $user = $this->adminUserModel
            ->where('id', $id)
            ->where('status', 'active')
            ->where('phone IS NOT NULL')
            ->where('phone !=', '')
            ->first();

        if (!$user) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'User not found, inactive, or missing a valid phone number.'
            ])->setStatusCode(404);
        }

        helper('nepali_date');
        $currentDateTime = formatNepaliDateTime(date('Y-m-d H:i:s'), 'medium');

        $message = "Hi {$user['full_name']}, message from website sent on {$currentDateTime}. Sample message.";

        try {
            $result = $this->smsService->send($user['phone'], $message);

            if (!$result['status'] || ($result['code'] ?? null) !== 2000) {
                log_message('error', 'SMS failed: ' . json_encode([
                    'user_id' => $id,
                    'phone'   => $user['phone'],
                    'response_code' => $result['code'] ?? 'unknown',
                    'response' => $result,
                ]));

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Failed to send SMS.',
                    'code'    => $result['code'] ?? 'UNKNOWN'
                ])->setStatusCode(500);
            }

            log_message('info', "SMS sent successfully to user ID {$id} at phone {$user['phone']}");

            return $this->response->setJSON([
                'status'  => true,
                'message' => "SMS sent successfully to {$user['full_name']}.",
                'code'    => 2000
            ])->setStatusCode(200);

        } catch (\Exception $e) {
            log_message('error', 'SMS exception for user ID ' . $id . ': ' . $e->getMessage());

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'SMS service unavailable.',
                'code'    => 'SMS_EXCEPTION'
            ])->setStatusCode(503);
        }
    }
}
