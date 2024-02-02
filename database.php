<?php
session_start();
$hostname = "localhost";
$dbusername = "root";
$dbpassword = "root";
$dbname = "nuuk_workspace";

$con = mysqli_connect($hostname, $dbusername, $dbpassword, $dbname);

if (!$con) {
    die('Could not connect to server!' . mysqli_connect_error());
}
?>
