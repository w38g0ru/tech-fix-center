<?php

/**
 * Google OAuth Credentials Example
 * 
 * Copy this file to GoogleCredentials.php and update with your actual credentials.
 * 
 * To get these credentials:
 * 1. Go to https://console.cloud.google.com/
 * 2. Create a new project or select existing one
 * 3. Go to APIs & Services > Credentials
 * 4. Create OAuth 2.0 Client ID
 * 5. Add authorized redirect URIs:
 *    - https://yourdomain.com/auth/google/callback
 *    - http://localhost/auth/google/callback (for local testing)
 */

return [
    'client_id' => 'your-google-client-id-here.apps.googleusercontent.com',
    'client_secret' => 'your-google-client-secret-here',
];
