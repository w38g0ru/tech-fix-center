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

        // Configuration - use environment variables
        $this->clientId = env('GOOGLE_CLIENT_ID');
        $this->clientSecret = env('GOOGLE_CLIENT_SECRET');
        $this->redirectUri = 'https://tfc.gaighat.com/auth/google/callback';
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
        // Use current domain for redirect URI
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . '://' . $host . '/auth/google/callback';
    }

    /**
     * Validate configuration
     */
    public function isConfigured(): bool
    {
        // Simple check - just verify credentials exist
        return !empty($this->clientId) && !empty($this->clientSecret);
    }

    /**
     * Get debug information for troubleshooting
     */
    public function getDebugInfo(): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret_length' => strlen($this->clientSecret),
            'redirect_uri' => $this->getRedirectUri(),
            'scopes' => $this->scopes,
            'is_configured' => $this->isConfigured(),
            'current_host' => $_SERVER['HTTP_HOST'] ?? 'unknown'
        ];
    }
}
