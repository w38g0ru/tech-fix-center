<?php
// Debug OAuth configuration
echo "<h2>Google OAuth Debug Information</h2>";

// Show current environment
echo "<h3>Current Environment:</h3>";
echo "<p><strong>HTTP Host:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Not set') . "</p>";
echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'Yes' : 'No') . "</p>";

// Calculate redirect URI
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$redirectUri = $protocol . '://' . $host . '/auth/callback';

echo "<h3>OAuth Configuration:</h3>";
echo "<p><strong>Redirect URI:</strong> " . htmlspecialchars($redirectUri) . "</p>";

// Decode credentials
$clientId = base64_decode('ODE3ODY0NjIwMDA5LXJzNGE4OWRrMzcwOHMwbjZobjFnbXVzdmpqbGtlbnUuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20=');
echo "<p><strong>Client ID:</strong> " . htmlspecialchars($clientId) . "</p>";

// Create OAuth URL
$authUrl = "https://accounts.google.com/o/oauth2/auth?" . http_build_query([
    'client_id' => $clientId,
    'redirect_uri' => $redirectUri,
    'scope' => 'email profile',
    'response_type' => 'code',
    'access_type' => 'offline',
    'prompt' => 'select_account consent'
]);

echo "<h3>Test OAuth:</h3>";
echo "<p><a href='" . htmlspecialchars($authUrl) . "' target='_blank' style='background: #4285f4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Google OAuth</a></p>";

echo "<h3>Required Google Cloud Console Setup:</h3>";
echo "<p>Make sure this redirect URI is added to your Google Cloud Console:</p>";
echo "<p><code>" . htmlspecialchars($redirectUri) . "</code></p>";
?>
