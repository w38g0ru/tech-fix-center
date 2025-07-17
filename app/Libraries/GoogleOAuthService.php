<?php

namespace App\Libraries;

use Google_Client;
use Google_Service_Oauth2;
use Config\GoogleOAuth;

class GoogleOAuthService
{
    private $client;
    private $config;

    public function __construct()
    {
        $this->config = new GoogleOAuth();
        $this->client = new Google_Client();

        // Simple validation - just check if credentials exist
        if (empty($this->config->clientId) || empty($this->config->clientSecret)) {
            throw new \Exception('Google OAuth configuration is missing client_id or client_secret');
        }

        $this->client->setClientId($this->config->clientId);
        $this->client->setClientSecret($this->config->clientSecret);
        $this->client->setRedirectUri($this->config->getRedirectUri());
        $this->client->setScopes($this->config->scopes);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    /**
     * Get Google OAuth login URL
     */
    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle OAuth callback and get user info
     */
    public function handleCallback(string $code): ?array
    {
        try {
            // Exchange authorization code for access token
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
            
            if (isset($token['error'])) {
                log_message('error', 'Google OAuth error: ' . $token['error']);
                return null;
            }

            $this->client->setAccessToken($token);

            // Get user profile information
            $oauth2 = new Google_Service_Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();

            return [
                'id' => $userInfo->getId(),
                'email' => $userInfo->getEmail(),
                'name' => $userInfo->getName(),
                'given_name' => $userInfo->getGivenName(),
                'family_name' => $userInfo->getFamilyName(),
                'picture' => $userInfo->getPicture(),
                'verified_email' => $userInfo->getVerifiedEmail()
            ];

        } catch (\Exception $e) {
            log_message('error', 'Google OAuth callback error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify ID token (alternative method)
     */
    public function verifyIdToken(string $idToken): ?array
    {
        try {
            $payload = $this->client->verifyIdToken($idToken);
            
            if ($payload) {
                return [
                    'id' => $payload['sub'],
                    'email' => $payload['email'],
                    'name' => $payload['name'],
                    'given_name' => $payload['given_name'] ?? '',
                    'family_name' => $payload['family_name'] ?? '',
                    'picture' => $payload['picture'] ?? '',
                    'verified_email' => $payload['email_verified'] ?? false
                ];
            }

            return null;

        } catch (\Exception $e) {
            log_message('error', 'Google ID token verification error: ' . $e->getMessage());
            return null;
        }
    }
}
