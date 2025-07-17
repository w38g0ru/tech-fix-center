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

        // Load from environment variables - configure in .env file
        $this->clientId = env('GOOGLE_CLIENT_ID', '');
        $this->clientSecret = env('GOOGLE_CLIENT_SECRET', '');
        $this->redirectUri = env('GOOGLE_REDIRECT_URI', 'https://tfc.gaighat.com/auth/callback');
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
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

        if (in_array($host, ['localhost', 'tfc.local', 'teknophix.local'])) {
            return $this->localRedirectUri;
        }

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
