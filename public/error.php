<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: #f33;
            text-align: center;
            padding-top: 100px;
        }
        .error-box {
            background: #222;
            border: 2px solid #f33;
            padding: 30px;
            display: inline-block;
            border-radius: 10px;
        }
        a {
            color: #0af;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h2>Error</h2>
        <?php
            if (isset($_SESSION['login_error'])) {
                echo "<p>" . $_SESSION['login_error'] . "</p>";
                unset($_SESSION['login_error']); 
            }elseif (isset($_SESSION['register_error'])) {
                echo "<p>" . $_SESSION['register_error'] . "</p>";
                unset($_SESSION['register_error']); 
            }
            
            else {
                echo "<p>An unknown error occurred.</p>";
            }
        ?>
        <br><br>
        <a href="./login.php">← Back to Login</a>
    </div>
</body>
</html>
