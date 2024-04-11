<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h2>Home Page</h2>
    <?php 
        session_start();
        if (isset($_SESSION['logged'])) {
            echo "<h3>Welcome, {$_SESSION['nome']}</h3>";
        }
    ?>
    <a href="login">Login</a>
    <a href="register">Register</a>
</body>
</html>