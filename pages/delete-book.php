<?php
include("config.php");

$id = $_GET['id'];

$sql = "DELETE FROM books WHERE id=$id";
$conn->query($sql);

header("Location: admin-books.php");
?>