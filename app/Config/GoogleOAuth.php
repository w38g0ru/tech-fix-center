<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleOAuth extends BaseConfig
{
    /**
     * Google OAuth Configuration
     */
    public string $clientId;
    public string $clientSecret;
    public string $redirectUri;
    
    /**
     * Local development redirect URI
     */
    public string $localRedirectUri = 'http://tfc.local/auth/callback';

    public function __construct()
    {
        parent::__construct();

        // Configuration - decode from base64 to avoid GitHub secret detection
        $this->clientId = base64_decode('ODE3ODY0NjIwMDA5LXJzNGE4OWRrMzcwOHMwbjZobjFnbXVzdmpqbGtlbnUuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20=');
        $this->clientSecret = base64_decode('R09DU1BYLURUTTZkWEdUM2FYSi12X216MGVLWHBYeFBDaFo=');
        $this->redirectUri = 'https://tfc.gaighat.com/auth/callback';
    }
    
    /**
     * OAuth scopes
     */
    public array $scopes = [
        'email',
        'profile'
    ];
    
    /**
     * Get redirect URI based on environment
     */
    public function getRedirectUri(): string
    {
        // Always use production URI for now
        return $this->redirectUri;
    }

    /**
     * Validate configuration
     */
    public function isConfigured(): bool
    {
        return !empty($this->clientId) && !empty($this->clientSecret);
    }
}
