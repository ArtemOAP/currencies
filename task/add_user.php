<?php
require_once '../vendor/autoload.php';

if (count($argv) < 2) {
    exit("require 2 params \n");
}
$name = $argv[1];
$pass = $argv[2];
$hash = password_hash($pass, PASSWORD_DEFAULT);
\App\Api\entity\User::getInstance(\App\Api\ManagerDb::Connect())->addUser($name,$hash);
echo 'create user name '. $name.PHP_EOL;