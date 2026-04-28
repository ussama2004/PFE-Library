<?php include("config.php"); ?>

<h2>📚 إدارة الكتب</h2>

<a href="admin-add-book.php">➕ إضافة كتاب</a>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">

<?php
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
?>

<div style="border:1px solid #ccc;padding:10px;text-align:center;">

    <img src="<?php echo $row['image']; ?>" width="100%" height="150">

    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['category']; ?></p>

    <a href="<?php echo $row['file']; ?>" target="_blank">
        <button>📖 قراءة</button>
    </a>

    <a href="edit-book.php?id=<?php echo $row['id']; ?>">
        <button style="background:orange;color:white;">✏️ تعديل</button>
    </a>

    <a href="delete-book.php?id=<?php echo $row['id']; ?>" onclick="return confirm('حذف الكتاب؟')">
        <button style="background:red;color:white;">❌ حذف</button>
    </a>

</div>

<?php } ?>

</div>