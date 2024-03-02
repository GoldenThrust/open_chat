<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'loader.php';

session_unset();
session_destroy();

header('Location: login.php');