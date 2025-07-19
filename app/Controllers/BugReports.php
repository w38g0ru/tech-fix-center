<?php

namespace App\Controllers;

use App\Models\BugReportModel;
use CodeIgniter\Email\Email;

class BugReports extends BaseController
{
    protected $bugReportModel;
    protected $email;

    public function __construct()
    {
        $this->bugReportModel = new BugReportModel();
        $this->email = \Config\Services::email();
        
        // Load auth helper
        helper(['auth', 'form', 'url']);
    }

    /**
     * Check if user is admin
     */
    private function checkAdminAccess()
    {
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin access
        helper('menu');
        if (!\App\Config\MenuConfig::isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Access denied');
        }

        return true;
    }

    /**
     * Display bug reports list
     */
    public function index()
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $search = $this->request->getGet('search');
        $bug_type = $this->request->getGet('bug_type');
        $severity = $this->request->getGet('severity');
        $perPage = 20;

        $bugReports = $this->bugReportModel->getBugReportsWithPagination($perPage, $search, $bug_type, $severity);
        $stats = $this->bugReportModel->getBugReportStats();

        $data = [
            'title' => 'Bug Reports',
            'bugReports' => $bugReports,
            'stats' => $stats,
            'search' => $search,
            'bug_type' => $bug_type,
            'severity' => $severity,
            'bugTypeOptions' => $this->bugReportModel->getBugTypeOptions(),
            'severityOptions' => $this->bugReportModel->getSeverityOptions(),
            'pager' => $this->bugReportModel->pager
        ];

        return view('bug_reports/index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $data = [
            'title' => 'Report Bug',
            'bugTypeOptions' => $this->bugReportModel->getBugTypeOptions(),
            'severityOptions' => $this->bugReportModel->getSeverityOptions()
        ];

        return view('bug_reports/create', $data);
    }

    /**
     * Store new bug report
     */
    public function store()
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        // Get user info from session
        $session = session();
        $userEmail = $session->get('user_email') ?? $session->get('email') ?? null;

        // Handle file upload
        $screenshotPath = null;
        $screenshot = $this->request->getFile('screenshot');
        if ($screenshot && $screenshot->isValid() && !$screenshot->hasMoved()) {
            $uploadPath = WRITEPATH . 'uploads/bug_reports/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $screenshotName = $screenshot->getRandomName();
            if ($screenshot->move($uploadPath, $screenshotName)) {
                $screenshotPath = 'bug_reports/' . $screenshotName;
            }
        }

        // Prepare bug report data
        $bugData = [
            'url' => $this->request->getPost('url'),
            'feedback' => $this->request->getPost('feedback'),
            'bug_type' => $this->request->getPost('bug_type') ?: 'Other',
            'severity' => $this->request->getPost('severity') ?: 'Medium',
            'screenshot' => $screenshotPath,
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->request->getIPAddress(),
            'email' => $userEmail,
            'can_contact' => $this->request->getPost('can_contact') ? 1 : 0
        ];

        // Validate using BugReportModel
        if (!$this->bugReportModel->validate($bugData)) {
            return redirect()->back()->withInput()->with('errors', $this->bugReportModel->errors());
        }

        // Insert bug report
        $bugId = $this->bugReportModel->insert($bugData);

        if (!$bugId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create bug report.');
        }

        // Send email notification
        $this->sendBugReportEmail($bugData, $bugId);

        return redirect()->to('/dashboard/bug-reports')->with('success', 'Bug report created successfully! Email notification sent.');
    }

    /**
     * Show bug report details
     */
    public function view($id)
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $bugReport = $this->bugReportModel->find($id);

        if (!$bugReport) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bug report not found');
        }

        $data = [
            'title' => 'Bug Report #' . $id,
            'bugReport' => $bugReport
        ];

        return view('bug_reports/view', $data);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $bugReport = $this->bugReportModel->find($id);

        if (!$bugReport) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bug report not found');
        }

        $data = [
            'title' => 'Edit Bug Report #' . $id,
            'bugReport' => $bugReport,
            'bugTypeOptions' => $this->bugReportModel->getBugTypeOptions(),
            'severityOptions' => $this->bugReportModel->getSeverityOptions()
        ];

        return view('bug_reports/edit', $data);
    }

    /**
     * Update bug report
     */
    public function update($id)
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $bugReport = $this->bugReportModel->find($id);

        if (!$bugReport) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bug report not found');
        }

        // Handle file upload
        $screenshotPath = $bugReport['screenshot']; // Keep existing screenshot
        $screenshot = $this->request->getFile('screenshot');
        if ($screenshot && $screenshot->isValid() && !$screenshot->hasMoved()) {
            // Delete old screenshot if exists
            if (!empty($bugReport['screenshot'])) {
                $oldPath = WRITEPATH . 'uploads/' . $bugReport['screenshot'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $uploadPath = WRITEPATH . 'uploads/bug_reports/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $screenshotName = $screenshot->getRandomName();
            if ($screenshot->move($uploadPath, $screenshotName)) {
                $screenshotPath = 'bug_reports/' . $screenshotName;
            }
        }

        // Prepare update data
        $updateData = [
            'url' => $this->request->getPost('url'),
            'feedback' => $this->request->getPost('feedback'),
            'bug_type' => $this->request->getPost('bug_type'),
            'severity' => $this->request->getPost('severity'),
            'screenshot' => $screenshotPath,
            'can_contact' => $this->request->getPost('can_contact') ? 1 : 0
        ];

        // Validate using BugReportModel
        if (!$this->bugReportModel->validate($updateData)) {
            return redirect()->back()->withInput()->with('errors', $this->bugReportModel->errors());
        }

        // Update bug report
        if ($this->bugReportModel->update($id, $updateData)) {
            return redirect()->to('/dashboard/bug-reports')->with('success', 'Bug report updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update bug report.');
        }
    }

    /**
     * Delete bug report
     */
    public function delete($id)
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $bugReport = $this->bugReportModel->find($id);

        if (!$bugReport) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bug report not found');
        }

        // Delete associated screenshot
        if (!empty($bugReport['screenshot'])) {
            $screenshotPath = WRITEPATH . 'uploads/' . $bugReport['screenshot'];
            if (file_exists($screenshotPath)) {
                unlink($screenshotPath);
            }
        }

        // Delete bug report
        if ($this->bugReportModel->delete($id)) {
            return redirect()->to('/dashboard/bug-reports')->with('success', 'Bug report deleted successfully!');
        } else {
            return redirect()->to('/dashboard/bug-reports')->with('error', 'Failed to delete bug report.');
        }
    }

    /**
     * Serve uploaded screenshots
     */
    public function serve($filename)
    {
        $adminCheck = $this->checkAdminAccess();
        if ($adminCheck !== true) {
            return $adminCheck;
        }

        $filePath = WRITEPATH . 'uploads/bug_reports/' . $filename;

        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File not found');
        }

        // Set appropriate headers
        $mimeType = mime_content_type($filePath);
        $this->response->setHeader('Content-Type', $mimeType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"');

        return $this->response->setBody(file_get_contents($filePath));
    }

    /**
     * Send email notification for new bug report
     */
    private function sendBugReportEmail($bugData, $bugId)
    {
        try {
            $config = config('App');

            $adminEmail = $config->adminEmail ?? 'infoudayapur@gmail.com';
            $appName    = $config->appName ?? 'My App';
            $replyTo    = $bugData['email'] ?? $adminEmail;

            $this->email->setFrom($adminEmail, $appName);
            $this->email->setTo($adminEmail);

            if (!empty($bugData['reporter_email'])) {
                $this->email->setCC($bugData['reporter_email']);
            }

            $this->email->setReplyTo($replyTo);
            $this->email->setSubject('New Bug Report #' . $bugId . ' - ' . $bugData['title']);

            $message = $this->buildEmailMessage($bugData, $bugId);
            $this->email->setMessage($message);

            if (! $this->email->send()) {
                log_message('error', 'Email sending failed: ' . print_r($this->email->printDebugger(['headers', 'subject']), true));
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to send bug report email: ' . $e->getMessage());
        }
    }

    /**
     * Build email message for bug report
     */
    private function buildEmailMessage($bugData, $bugId)
    {
        $message = "<h2>New Bug Report Submitted</h2>";
        $message .= "<p><strong>Bug Report ID:</strong> #" . $bugId . "</p>";
        $message .= "<p><strong>URL:</strong> " . esc($bugData['url']) . "</p>";
        $message .= "<p><strong>Bug Type:</strong> " . esc($bugData['bug_type']) . "</p>";
        $message .= "<p><strong>Severity:</strong> " . esc($bugData['severity']) . "</p>";
        $message .= "<hr>";
        if (!empty($bugData['email'])) {
            $message .= "<p><strong>Reporter Email:</strong> " . esc($bugData['email']) . "</p>";
        }
        $message .= "<hr>";
        $message .= "<p><strong>Feedback:</strong></p>";
        $message .= "<p>" . nl2br(esc($bugData['feedback'])) . "</p>";
        $message .= "<hr>";
        $message .= "<p><strong>Technical Details:</strong></p>";
        $message .= "<p><strong>User Agent:</strong> " . esc($bugData['user_agent']) . "</p>";
        $message .= "<p><strong>IP Address:</strong> " . esc($bugData['ip_address']) . "</p>";
        $message .= "<hr>";
        $message .= "<p><a href='" . base_url('dashboard/bug-reports/view/' . $bugId) . "'>View Bug Report</a></p>";

        return $message;
    }
}
