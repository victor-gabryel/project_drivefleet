<?php
$host = "localhost";
$user = "root";
$pass = ""; // ou "root" dependendo do seu XAMPP
$db = "drivefleet";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
