<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "e_library";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port );

if(!$conn)
{
    die("❌ فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>