<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'loader.php';;

if (isset($_SESSION['USERNAME'])) {
    header('Location: index.php');
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(128));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $picture = $_FILES['image'];

    $user->register($username, $picture, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <div id="error-message" class="error-message"><?= $_GET['error'] ?? '' ?></div>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="image">Profile Image</label>
                <div class="image-preview" id="imagePreview">
                    <input type="file" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
                    <img src="" alt="Image Preview" class="image-preview__image">
                    <span class="image-preview__default-text">Image Preview</span>
                </div>
            </div>

            <input type="submit" value="Signup">
        </form>
        <p class="redirect-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
    <script src="main.js"></script>
</body>
</html>
