<?php
$servername = "localhost";
$username = "user";
$password = "Password";
$dbname = "mariadb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Server Localhost Connection Problem ! ";
?>
