<?php

namespace App\Libraries;

class SmsService
{
    protected string $authToken = 'cdb430b1996fbe2f4bed4434716790728984dc708056d1a3fa1358ec9b9f1319';
    protected string $from = '31001';
    protected string $apiUrl = 'http://aakashsms.com/admin/public/sms/v1/send/';

    protected array $responseMessages = [
        2000 => 'SMS sent successfully',
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
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'TeknoPhix SMS Service/1.0'
        ]);

        $rawResponse = curl_exec($ch);
        $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error       = curl_error($ch);
        curl_close($ch);

        // Handle cURL errors
        if ($error) {
            return [
                'status'  => false,
                'message' => 'Network error: ' . $error,
                'code'    => 'CURL_ERROR',
                'raw'     => ['curl_error' => $error, 'http_code' => $httpCode]
            ];
        }

        // Handle HTTP errors
        if ($httpCode !== 200) {
            return [
                'status'  => false,
                'message' => 'HTTP error: ' . $httpCode,
                'code'    => 'HTTP_ERROR_' . $httpCode,
                'raw'     => ['response' => $rawResponse, 'http_code' => $httpCode]
            ];
        }

        // Handle empty response
        if (empty($rawResponse)) {
            return [
                'status'  => false,
                'message' => 'Empty response from SMS API',
                'code'    => 'EMPTY_RESPONSE',
                'raw'     => ['response' => $rawResponse, 'http_code' => $httpCode]
            ];
        }

        // Try to decode the response
        $decoded = json_decode($rawResponse, true);

        if (!is_array($decoded)) {
            return [
                'status'  => false,
                'message' => 'Invalid JSON response from SMS API',
                'code'    => 'INVALID_JSON',
                'raw'     => ['response' => $rawResponse, 'http_code' => $httpCode]
            ];
        }

        $code = $decoded['response_code'] ?? null;
        $msg  = $this->responseMessages[$code] ?? ($decoded['response'] ?? 'Unknown error from SMS API');

        return [
            'status'  => $code === 2000,
            'message' => $msg,
            'code'    => $code,
            'raw'     => $decoded
        ];
    }
}
