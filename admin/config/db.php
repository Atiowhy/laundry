
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbName = 'angkatan3_laundry';

$connection = mysqli_connect($host, $username, $password, $dbName);
if (!$connection) {
    echo 'Connection Failed';
}
?>
