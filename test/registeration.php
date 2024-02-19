<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'loader.php';
$username = "Ola";
$email = "Ola@gmail.com";
$password = "Old Password";
$user->register($username, $email, $password);
$user->login($username, $password);