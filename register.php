<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'loader.php';;

if (isset($_SESSION['USERNAME'])) {
    header('Location: index.php');
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(128));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $picture = $_FILES['picture'];

    $user->register($username, $picture, $password);
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
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
        <fieldset class="pos-center">
            <legend>Register</legend>
            <input type="hidden" name="csrf_token" value='<?= $_SESSION['csrf_token'] ?>'>
            <input type="text" name="username" id="username" placeholder="username" required>
            <input type="password" name="password" id="password" placeholder="**********" required>
            <label for="picture">Choose Image</label>
            <input type="file" name="picture" id="picture" required accept="image/*" style="display: none">
            <a href="./login.php">Sign In</a>
            <input type="submit" value="Create" name="submit">
        </fieldset>
    </form>
    <div><?= isset($_GET['error']) ? $_GET['error'] : null ?></div>
</body>

</html>