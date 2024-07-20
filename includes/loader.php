<?php
session_start();
use Gem\User;
use Gem\Database;
require dirname(__DIR__) . '/vendor/autoload.php';

$db = new Database('localhost', 'chat', 'root', '');

$user = new User($db);

define('UPLOADDIR', dirname(__DIR__) . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR);