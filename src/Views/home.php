<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <h2>Home Page</h2>
    <?php 
        session_start();
        if (isset($_SESSION['email'])) {
            echo "<h3>Welcome, {$_SESSION['email']}</h3>";
        }
    ?>
    <a href="login">Login</a>
    <a href="register">Register</a>
</body>
</html>