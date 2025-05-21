<?php
session_start();
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify reCAPTCHA
    $recaptcha_secret = "6LfQC0MrAAAAAJpl9iKeBsk7zAmZYd-lVXcMko1h";
    $recaptcha_response = $_POST['g-recaptcha-response'];
    
    // Verify reCAPTCHA response
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $verify_response = file_get_contents($verify_url, false, $context);
    $captcha_success = json_decode($verify_response);

    if (!$captcha_success->success) {
        header("Location: login.php?error=captcha_failed");
        exit();
    }

    $username = $_POST['Username'];
    $password = $_POST['Password'];
    
    try {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard/index.php");
            exit();
        } else {
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: login.php?error=database_error");
        exit();
    }
}
?> 