<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'loader.php';

if (isset($_SESSION['USERNAME'])) {
    header('Location: index.php');
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(128));
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user->login($username, $password);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/register.css">
    <link rel="stylesheet" href="styles/main.css">
    <!-- <script src="scripts/main.js" defer ></script> -->
</head>

<body>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

        <fieldset class='pos-center'>
            <legend>Sign in</legend>
            <input type="text" name="username" id="username">
            <input type="password" name="password" id="password">
            <a href="./register.php">Sign Up</a>
            <input type="submit" value="Sign In">
        </fieldset>
    </form>
</body>

</html>