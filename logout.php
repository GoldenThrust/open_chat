<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'loader.php';

session_unset();
session_destroy();

header('Location: login.php');