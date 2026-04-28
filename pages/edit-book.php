<?php
include("config.php");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM books WHERE id=$id");
$row = $result->fetch_assoc();
?>

<h2>✏️ تعديل كتاب</h2>

<form action="" method="POST">

<input type="text" name="title" value="<?php echo $row['title']; ?>"><br><br>
<input type="text" name="image" value="<?php echo $row['image']; ?>"><br><br>
<input type="text" name="file" value="<?php echo $row['file']; ?>"><br><br>
<input type="text" name="category" value="<?php echo $row['category']; ?>"><br><br>

<button type="submit" name="update">تحديث</button>

</form>

<?php

if(isset($_POST['update'])){
    $title = $_POST['title'];
    $image = $_POST['image'];
    $file = $_POST['file'];
    $category = $_POST['category'];

    $sql = "UPDATE books SET 
            title='$title',
            image='$image',
            file='$file',
            category='$category'
            WHERE id=$id";

    $conn->query($sql);

    header("Location: admin-books.php");
}

?>