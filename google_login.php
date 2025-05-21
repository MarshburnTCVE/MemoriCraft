<?php
require_once 'config/google_config.php';

// Generate the Google login URL
$auth_url = $client->createAuthUrl();

// Redirect to Google's OAuth 2.0 server
header('Location: ' . $auth_url);
exit();
?> 