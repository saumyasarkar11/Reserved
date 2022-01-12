<?php

require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];

$con = mysqli_connect($db_host, $db_username, $db_password, $db_name)
or die(mysqli_error($con));

?>