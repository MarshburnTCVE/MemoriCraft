<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles/style.css">
        <meta charset="UTF-8"> 
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <style>
            .login{
                color: white;
                text-decoration: none;
            }
            .google-btn {
                background-color: #fff;
                color: #757575;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 99%;
                margin-top: 10px;
                cursor: pointer;
                transition: background-color 0.3s;
                text-decoration: none;
            }
            .google-btn:hover {
                background-color: #f5f5f5;
                text-decoration: none;
            }
            .google-btn img {
                margin-top: 12px;
                width: 24px;
                height: 24px;
            }
            #recaptcha-container {
                display: none;
                margin: 10px 0;
                text-align: center;
            }
            .g-recaptcha {
                display: inline-block;
            }
        </style>

    </head>

    <body>
            <div class="container">
                <div class="card">
                    <img src="images/memoricraft.png" alt="This is the logo">
                    <form action="process_login.php" method="POST" id="loginForm">
                        <input type="text" placeholder="Username" name="Username" required>
                        <input type="password" placeholder="Password" name="Password" required>
                        <button type="button" id="loginButton">Login</button>
                        
                        <div id="recaptcha-container" style="display: none; margin: 10px 0;">
                            <div class="g-recaptcha" data-sitekey="6LfQC0MrAAAAAAoA2CVle_EyeRb-gEcsRmm3GWF0" data-callback="onRecaptchaSuccess"></div>
                        </div>
                        
                        <a href="google_login.php" class="google-btn">
                            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" style="width: 24px; height: 24px;">
                            Sign in with Google
                        </a>

                        <p style="color: aliceblue">Don't have an account? <a href="sign.php"> Sign up</a></p>
                        <p style="color: aliceblue">Forgot Password <a href="forgot-password.php"> Click here!</a></p>
                        <?php if(isset($_GET['error'])): ?>
                            <p style="color: red">
                                <?php 
                                    $error = $_GET['error'];
                                    if($error == 'invalid_credentials') echo "Invalid username or password";
                                    if($error == 'database_error') echo "An error occurred. Please try again.";
                                    if($error == 'captcha_failed') echo "Please complete the reCAPTCHA verification.";
                                ?>
                            </p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <script>
                document.getElementById('loginButton').addEventListener('click', function() {
                    // Show the reCAPTCHA container
                    document.getElementById('recaptcha-container').style.display = 'block';
                });

                function onRecaptchaSuccess(token) {
                    // Add the token to the form
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'g-recaptcha-response';
                    input.value = token;
                    document.getElementById('loginForm').appendChild(input);
                    
                    // Submit the form
                    document.getElementById('loginForm').submit();
                }
            </script>
    </body>
</html>