<?php
session_start();
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    try {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Generate reset code
            $reset_code = sprintf("%06d", mt_rand(1, 999999));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store reset code in database
            $stmt = $conn->prepare("UPDATE users SET reset_code = :reset_code, reset_code_expiry = :expiry WHERE email = :email");
            $stmt->bindParam(':reset_code', $reset_code);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Store email in session for verification
            $_SESSION['reset_email'] = $email;
            
            // In a real application, you would send this code via email
            // For demonstration, we'll just redirect to the code entry page
            header("Location: send-code.html");
            exit();
        } else {
            header("Location: forgot-password.html?error=email_not_found");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: forgot-password.html?error=database_error");
        exit();
    }
}
?> 