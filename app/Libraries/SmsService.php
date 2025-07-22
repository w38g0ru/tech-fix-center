<?php

namespace App\Libraries;

class SmsService
{
    protected string $authToken = 'cdb430b1996fbe2f4bed4434716790728984dc708056d1a3fa1358ec9b9f1319';
    protected string $from = '31001';
    protected string $apiUrl = 'http://aakashsms.com/admin/public/sms/v1/send/';

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

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['status' => false, 'error' => $error];
        }

        return ['status' => true, 'response' => $response];
    }
}
