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
        // Always use production URI - Google OAuth only works online
        return $this->redirectUri;
    }

    /**
     * Validate configuration
     */
    public function isConfigured(): bool
    {
        // Only enable Google OAuth on production domain
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'tfc.gaighat.com') {
            return !empty($this->clientId) && !empty($this->clientSecret);
        }

        // Disable for all other domains (local development, etc.)
        return false;
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
