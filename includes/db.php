<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$instamojo_redirect_url = $_ENV['INSTAMOJO_REDIRECT_URL'];
$limit1 = $_ENV['CHECKINLIMIT'];
$limit2 = $_ENV['CHECKOUTLIMIT'];
$prefix = $_ENV['PREFIX'];
$host = $_ENV['SMTP_HOST'];
$username = $_ENV['SMTP_USERNAME'];
$password = $_ENV['SMTP_PASSWORD'];
$from1 = $_ENV['FROMNAME'];
$from2 = $_ENV['FROMEMAIL'];

?>