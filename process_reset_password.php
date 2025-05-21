<?php
session_start();
require_once 'config/database.php';

// Verify reset code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    if (!isset($_SESSION['reset_email'])) {
        header("Location: forgot-password.html");
        exit();
    }
    
    $code = $_POST['code'];
    $email = $_SESSION['reset_email'];
    
    try {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email AND reset_code = :code AND reset_code_expiry > NOW()");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            header("Location: new-password.html");
            exit();
        } else {
            header("Location: send-code.html?error=invalid_code");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: send-code.html?error=database_error");
        exit();
    }
}

// Update password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Password'])) {
    if (!isset($_SESSION['reset_email'])) {
        header("Location: forgot-password.html");
        exit();
    }
    
    $password = $_POST['Password'];
    $confirm_password = $_POST['rePassword'];
    $email = $_SESSION['reset_email'];
    
    if ($password !== $confirm_password) {
        header("Location: new-password.html?error=passwords_dont_match");
        exit();
    }
    
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("UPDATE users SET password = :password, reset_code = NULL, reset_code_expiry = NULL WHERE email = :email");
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Clear session
        unset($_SESSION['reset_email']);
        
        header("Location: login.html?success=password_updated");
        exit();
    } catch(PDOException $e) {
        header("Location: new-password.html?error=database_error");
        exit();
    }
}
?> 