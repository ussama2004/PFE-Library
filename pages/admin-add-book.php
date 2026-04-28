<?php include("config.php"); ?>

<h2>➕ إضافة كتاب</h2>

<form method="POST">

<input type="text" name="title" placeholder="اسم الكتاب"><br><br>
<input type="text" name="image" placeholder="الصورة"><br><br>
<input type="text" name="file" placeholder="PDF"><br><br>
<input type="text" name="category" placeholder="التصنيف"><br><br>

<button type="submit" name="add">إضافة</button>

</form>

<?php

if(isset($_POST['add'])){
    $title = $_POST['title'];
    $image = $_POST['image'];
    $file = $_POST['file'];
    $category = $_POST['category'];

    $sql = "INSERT INTO books(title,image,file,category)
            VALUES('$title','$image','$file','$category')";

    $conn->query($sql);

    header("Location: admin-books.php");
}

?>