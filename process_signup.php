<?php
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['rePassword'];
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        header("Location: sign.php?error=passwords_dont_match");
        exit();
    }
    
    try {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            header("Location: sign.php?error=user_exists");
            exit();
        }
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, fullname, email, password) VALUES (:username, :fullname, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        
        $stmt->execute();
        header("Location: login.php?success=registration_complete");
        exit();
        
    } catch(PDOException $e) {
        header("Location: sign.php?error=database_error");
        exit();
    }
}
?> 