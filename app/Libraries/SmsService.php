<?php

namespace App\Libraries;

class SmsService
{
    protected string $authToken = 'cdb430b1996fbe2f4bed4434716790728984dc708056d1a3fa1358ec9b9f1319';
    protected string $from = '31001';
    protected string $apiUrl = 'http://aakashsms.com/admin/public/sms/v1/send/';

    protected array $responseMessages = [
        4000 => 'A required field is missing',
        4001 => 'Invalid IP Address',
        4002 => 'Invalid URL',
        4003 => 'Invalid AuthToken',
        4004 => 'Account is not active',
        4005 => 'Account has expired',
        4006 => 'Invalid phone number',
        4007 => 'Invalid sender',
        4008 => 'Text cannot be empty',
        4009 => 'No credits available',
        4010 => 'Insufficient credits',
    ];

    public function send($to, string $message): array
    {
        $to = is_array($to) ? implode(',', $to) : $to;

        $args = http_build_query([
            'auth_token' => $this->authToken,
            'from'       => $this->from,
            'to'         => $to,
            'text'       => $message,
        ]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->apiUrl,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $args,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $rawResponse = curl_exec($ch);
        $error       = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                'status'  => false,
                'message' => 'cURL Error: ' . $error,
                'code'    => null,
            ];
        }

        // Try to decode the response
        $decoded = json_decode($rawResponse, true);

        if (!is_array($decoded)) {
            return [
                'status'  => false,
                'message' => 'Invalid response from SMS API.',
                'raw'     => $rawResponse,
            ];
        }

        $code = $decoded['response_code'] ?? null;
        $msg  = $this->responseMessages[$code] ?? ($decoded['response'] ?? 'Unknown error');

        return [
            'status'  => $code === 2000,
            'message' => $msg,
            'code'    => $code,
            'raw'     => $decoded
        ];
    }
}
