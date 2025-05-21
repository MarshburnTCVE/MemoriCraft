<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles/style.css">
        <meta charset="UTF-8"> 

        <style>
            img{
                height: 100px;
            }
            .password-requirements {
                color: #888;
                font-size: 0.8em;
                margin: 5px 0;
                text-align: left;
            }
            .requirement {
                margin: 3px 0;
            }
            .requirement.valid {
                color: #4CAF50;
            }
            .requirement.invalid {
                color: #f44336;
            }
        </style>

    </head>

    <body>
            <div class="container">
                <div class="card">
                    <img src="images/memoricraft.png" alt="This is the logo">
                    <form action="process_signup.php" method="POST" id="signupForm" onsubmit="return validateForm()">
                        <input type="text" placeholder="Username" name="Username" required>
                        <input type="text" placeholder="Full Name" name="fullname" required>
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="Password" id="password" required onkeyup="validatePassword()">
                        <div class="password-requirements">
                            <div class="requirement" id="length">• At least 8 characters</div>
                            <div class="requirement" id="special">• At least one special character (@, #, $, etc.)</div>
                        </div>
                        <input type="password" placeholder="Confirm Password" name="rePassword" id="rePassword" required>
                        <button type="submit">Signup</button>
                        <p style="color: aliceblue">Already have an account? <a href="login.php">Login</a></p>
                        <?php if(isset($_GET['error'])): ?>
                            <p style="color: red">
                                <?php 
                                    $error = $_GET['error'];
                                    if($error == 'passwords_dont_match') echo "Passwords do not match";
                                    if($error == 'user_exists') echo "Username or email already exists";
                                    if($error == 'database_error') echo "An error occurred. Please try again.";
                                ?>
                            </p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <script>
                function validatePassword() {
                    const password = document.getElementById('password').value;
                    const lengthReq = document.getElementById('length');
                    const specialReq = document.getElementById('special');
                    
                    // Check length
                    if (password.length >= 8) {
                        lengthReq.classList.add('valid');
                        lengthReq.classList.remove('invalid');
                    } else {
                        lengthReq.classList.add('invalid');
                        lengthReq.classList.remove('valid');
                    }
                    
                    // Check for special character
                    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                        specialReq.classList.add('valid');
                        specialReq.classList.remove('invalid');
                    } else {
                        specialReq.classList.add('invalid');
                        specialReq.classList.remove('valid');
                    }
                }

                function validateForm() {
                    const password = document.getElementById('password').value;
                    const rePassword = document.getElementById('rePassword').value;
                    
                    // Check if password meets requirements
                    if (password.length < 8 || !/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                        alert('Password must be at least 8 characters long and contain at least one special character.');
                        return false;
                    }
                    
                    // Check if passwords match
                    if (password !== rePassword) {
                        alert('Passwords do not match!');
                        return false;
                    }
                    
                    return true;
                }
            </script>
    </body>
</html> 