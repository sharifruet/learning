<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class OAuth extends BaseConfig
{
    // Google OAuth Configuration
    public string $googleClientId = '';
    public string $googleClientSecret = '';
    public string $googleRedirectUri = '';

    // Facebook OAuth Configuration
    public string $facebookAppId = '';
    public string $facebookAppSecret = '';
    public string $facebookRedirectUri = '';

    public function __construct()
    {
        parent::__construct();

        // Load from .env if available
        $this->googleClientId = $_ENV['GOOGLE_CLIENT_ID'] ?? getenv('GOOGLE_CLIENT_ID') ?: '';
        $this->googleClientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? getenv('GOOGLE_CLIENT_SECRET') ?: '';
        $this->googleRedirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? getenv('GOOGLE_REDIRECT_URI') ?: '';
        
        $this->facebookAppId = $_ENV['FACEBOOK_APP_ID'] ?? getenv('FACEBOOK_APP_ID') ?: '';
        $this->facebookAppSecret = $_ENV['FACEBOOK_APP_SECRET'] ?? getenv('FACEBOOK_APP_SECRET') ?: '';
        $this->facebookRedirectUri = $_ENV['FACEBOOK_REDIRECT_URI'] ?? getenv('FACEBOOK_REDIRECT_URI') ?: '';
    }
    
    /**
     * Get Google redirect URI, using default if not set
     */
    public function getGoogleRedirectUri(): string
    {
        if (empty($this->googleRedirectUri)) {
            return base_url('auth/google/callback');
        }
        return $this->googleRedirectUri;
    }
    
    /**
     * Get Facebook redirect URI, using default if not set
     */
    public function getFacebookRedirectUri(): string
    {
        if (empty($this->facebookRedirectUri)) {
            return base_url('auth/facebook/callback');
        }
        return $this->facebookRedirectUri;
    }
}

