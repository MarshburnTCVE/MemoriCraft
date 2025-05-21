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
                    <img src="images/memoricraft.png" alt="This is the logo" style="border-radius: 50%;">
                    <form action="process_forgot_password.php" method="POST">
                        <input type="email" placeholder="Enter your email" name="email" required>
                        <button type="submit">Send Code</button>
                        <?php if(isset($_GET['error'])): ?>
                            <p style="color: red">
                                <?php 
                                    $error = $_GET['error'];
                                    if($error == 'email_not_found') echo "Email not found";
                                    if($error == 'database_error') echo "An error occurred. Please try again.";
                                ?>
                            </p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
    </body>
</html>