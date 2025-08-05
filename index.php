<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'loader.php';
if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Chat</title>
    <link rel="stylesheet" href="styles/index.css">
    <script src="scripts/index.js
    " defer></script>
</head>

<body>
    <div id="nameTag">
        <?= $_SESSION['USERNAME'] ?>
    </div>
    <div id="alert">
    </div>
    <div id="mask"></div>
    <aside id="preview">
        <div class="preview">
        </div>
        <input name="p_comment" type="text" id="p_comment"></input>
        <input type="submit" value="Send" id="p_submit">
    </aside>
    <h1>Group Chat</h1>
    <aside action="" id="audioSection">
        <div class="mobile">
            <label for="audio">
                <img src="public/uploadsound.png" alt="Record Audio">
                <input type="file" name="audio" id="audio" accept="audio/*">
            </label>
            <label for="recAudio">
                <img src="public/mic.png" alt="Record Audio">
                <input type="file" name="recAudio" id="recAudio" accept="audio/*" capture="user">
            </label>
        </div>
        <div class="computer">
            <label for="audio">
                <img src="public/uploadsound.png" alt="Record Audio">
                <input type="file" name="audio" id="audio" accept="audio/*">
            </label>
            <img src="public/mic.png" alt="Record Audio" onclick="CaptureAudio()">
        </div>
    </aside>

    <aside action="" id="mediaSection">
        <div class="mobile">
            <label for="media">
                <img src="public/gallery.png" alt="Record Audio">
                <input type="file" name="media" id="media" accept="image/*, video/*">
            </label>
            <label for="imageMedia">
                <img src="public/capture.png" alt="Capture Pics">
                <input type="file" name="imageMedia" id="imageMedia" accept="image/*" capture="environment">
            </label>
            <label for="videoMedia">
                <img src="public/video.png" alt="Record video">
                <input type="file" name="videoMedia" id="videoMedia" accept="video/*" capture="environment">
            </label>
        </div>
        <div class="computer">
            <label for="media"><img src="public/gallery.png" alt="Record Audio"></label>
            <input type="file" name="media" id="media" accept="image/*, video/*">
            <img src="public/capture.png" alt="Capture Pics" onclick="CapturePics()">
            <img src="public/video.png" alt="Record video" onclick="CaptureVideo()">
        </div>
    </aside>

    <section id="commentSection">
        
    </section>

    <section action="" id="sendSection">
        <input type="text" name="comment" id="comment" placeholder="Enter Text"></input>
        <div class="icons">
            <label for="docs">
                <img src="public/docs.jpg" alt="" onclick="sendDocs()">
                <input type="file" name="docs" id="docs">
            </label>
            <img src="public/capture.png" alt="" id="altImageVid" onclick="DisplayCaptureSection()">
            <img src="public/mic.png" alt="" onclick="DisplayAudio()">
        </div>
        <input type="submit" value="Send" id="sendMessage">
    </section>
</body>

</html>
<!-- 

<div>
            <div class="profile">
                <img src="public/uploads/65d0c79aaf8dagithub_nitro.gif" alt="Profile">
                <p>User</p>
            </div>
            <div class="comments">
                <div class="file">
                    <img src="public/uploads/65d0c79aaf8dagithub_nitro.gif" alt="">
                </div>
                <div class="text">
                    Hello
                </div>
            </div>
        </div> -->