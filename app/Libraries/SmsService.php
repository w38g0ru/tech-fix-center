<?php

namespace App\Libraries;

class SmsService
{
    protected string $authToken = '3b483a2b26ddde842177118fa8db747bb3dec729cb44f60d0f1a05758363d8c5';
    protected string $from = '31001';
    protected string $apiUrl = 'https://sms.aakashsms.com/sms/v3/send';

    public function send($to, string $message): array
    {
        $to = is_array($to) ? implode(',', $to) : $to;

        $payload = http_build_query([
            'auth_token' => $this->authToken,
            'from'       => $this->from,
            'to'         => $to,
            'text'       => $message,
        ]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->apiUrl,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'SmsService/1.0'
        ]);

        $rawResponse = curl_exec($ch);
        $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error       = curl_error($ch);
        curl_close($ch);

        $logFile = WRITEPATH . 'logs/sms_errors.log';

        if ($error || $httpCode !== 200) {
            $this->logError($logFile, 'Network/HTTP error', $error ?: "HTTP $httpCode: $rawResponse");
            return [
                'status'  => false,
                'message' => 'SMS not sent',
                'code'    => 'HTTP_ERROR'
            ];
        }

        $decoded = json_decode($rawResponse, true);

        // Check if JSON decoding failed
        if (!is_array($decoded)) {
            $this->logError($logFile, 'JSON decode error', $rawResponse);
            return [
                'status'  => false,
                'message' => 'Invalid SMS API response format',
                'code'    => 'JSON_DECODE_ERROR'
            ];
        }

        // AakashSMS API returns: {"error": false, "message": "...", "data": {...}}
        // Success condition: error = false
        if (($decoded['error'] ?? true) !== false) {
            $errorMessage = $decoded['message'] ?? 'Unknown SMS API error';
            $this->logError($logFile, 'SMS API error', $rawResponse);
            return [
                'status'  => false,
                'message' => $errorMessage,
                'code'    => 'SMS_API_ERROR'
            ];
        }

        // SMS sent successfully
        $successMessage = $decoded['message'] ?? 'SMS sent successfully';
        log_message('info', 'SMS API Success: ' . $successMessage);

        return [
            'status'  => true,
            'message' => $successMessage,
            'code'    => 2000,
            'data'    => $decoded['data'] ?? null
        ];
    }

    protected function logError(string $file, string $type, string $data): void
    {
        $log = '[' . date('Y-m-d H:i:s') . "] $type: $data" . PHP_EOL;
        file_put_contents($file, $log, FILE_APPEND);
    }
}
