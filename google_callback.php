<?php
require_once 'config/google_config.php';
require_once 'config/database.php';

if (isset($_GET['code'])) {
    try {
        // Get token
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Get user info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email = $google_account_info->email;
        $name = $google_account_info->name;
        $google_id = $google_account_info->id;

        // Check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update existing user
            $stmt = $conn->prepare("UPDATE users SET google_id = ?, name = ? WHERE email = ?");
            $stmt->execute([$google_id, $name, $email]);
        } else {
            // Create new user with username derived from email
            $username = explode('@', $email)[0];
            $stmt = $conn->prepare("INSERT INTO users (username, email, name, google_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $name, $google_id]);
        }

        // Start session and set user data
        session_start();
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
        } else {
            $_SESSION['user_id'] = $conn->lastInsertId();
        }
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['google_id'] = $google_id;
        $_SESSION['username'] = $username ?? explode('@', $email)[0];

        // Redirect to dashboard
        header('Location: dashboard/index.php');
        exit();

    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
} else {
    // If no code is received, redirect to login
    header('Location: login.php');
    exit();
}
?> 