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
        </style>

    </head>

    <body>
            <div class="container">
                <div class="card">
                    <img src="images/original.png" alt="This is the logo" style="border-radius: 50%;">
                    <form action="process_reset_password.php" method="POST">
                        <input type="password" placeholder="Password" name="Password" required>
                        <input type="password" placeholder="Confirm Password" name="rePassword" required>
                        <button type="submit">Change Password</button>
                        <?php if(isset($_GET['error'])): ?>
                            <p style="color: red">
                                <?php 
                                    $error = $_GET['error'];
                                    if($error == 'passwords_dont_match') echo "Passwords do not match";
                                    if($error == 'database_error') echo "An error occurred. Please try again.";
                                ?>
                            </p>
                        <?php endif; ?>
                    </form>
                </div>

            </div>
    </body>

</html>