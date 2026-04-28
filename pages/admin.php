<?php
session_start();
include("config.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$message = "";

// إضافة مكتبة
if(isset($_POST['add_library'])){
    $name = mysqli_real_escape_string($conn, $_POST['library_name']);
    mysqli_query($conn, "INSERT INTO libraries(name) VALUES('$name')");
    $message = "تم إضافة المكتبة";
}

// إضافة كتاب
if(isset($_POST['add_book'])){
    $library_id = $_POST['library_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $pdf = mysqli_real_escape_string($conn, $_POST['pdf']);
    mysqli_query($conn, "INSERT INTO books(library_id, title, author, image, pdf) VALUES('$library_id', '$title', '$author', '$image', '$pdf')");
    $message = "تم إضافة الكتاب";
}

// تعديل كتاب
$edit = null;
if(isset($_GET['edit_book'])){
    $id = $_GET['edit_book'];
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$id"));
}

if(isset($_POST['update_book'])){
    $id = $_POST['id'];
    $library_id = $_POST['library_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $pdf = mysqli_real_escape_string($conn, $_POST['pdf']);
    mysqli_query($conn, "UPDATE books SET library_id='$library_id', title='$title', author='$author', image='$image', pdf='$pdf' WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// حذف مكتبة
if(isset($_GET['delete_library'])){
    $id = $_GET['delete_library'];
    mysqli_query($conn, "DELETE FROM libraries WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// حذف كتاب
if(isset($_GET['delete_book'])){
    $id = $_GET['delete_book'];
    mysqli_query($conn, "DELETE FROM books WHERE id=$id");
    header("Location: admin.php");
    exit();
}

$libraries = mysqli_query($conn, "SELECT * FROM libraries");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>لوحة الإدارة</title>
<style>
body{font-family:Arial;margin:0;padding:20px;background:#f4f6f9;}
.box{background:white;padding:20px;margin:20px 0;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.1);}
table{width:100%;border-collapse:collapse;}
th,td{border:1px solid #ddd;padding:8px;text-align:center;}
th{background:#2c3e50;color:white;}
input,select,button{padding:8px;margin:5px;}
button{background:#27ae60;color:white;border:none;border-radius:5px;cursor:pointer;}
.edit{color:blue;text-decoration:none;}
.msg{color:green;margin:10px 0;}
</style>
</head>
<body>

<h1>لوحة الإدارة</h1>

<div class="msg"><?php echo $message; ?></div>

<!-- إضافة مكتبة -->
<div class="box">
<h3>إضافة مكتبة</h3>
<form method="POST">
<input type="text" name="library_name" placeholder="اسم المكتبة" required>
<button type="submit" name="add_library">إضافة</button>
</form>
</div>

<!-- إضافة/تعديل كتاب -->
<div class="box">
<h3><?php echo $edit ? 'تعديل كتاب' : 'إضافة كتاب'; ?></h3>
<form method="POST">
<?php if($edit) echo '<input type="hidden" name="id" value="'.$edit['id'].'">'; ?>

<select name="library_id" required>
<option value="">اختر المكتبة</option>
<?php while($lib = mysqli_fetch_assoc($libraries)){ ?>
<option value="<?php echo $lib['id']; ?>" <?php if($edit && $edit['library_id']==$lib['id']) echo "selected"; ?>><?php echo $lib['name']; ?></option>
<?php } ?>
</select>

<input type="text" name="title" placeholder="اسم الكتاب" value="<?php echo $edit['title'] ?? ''; ?>" required>
<input type="text" name="author" placeholder="اسم المؤلف" value="<?php echo $edit['author'] ?? ''; ?>">
<input type="text" name="image" placeholder="رابط الصورة" value="<?php echo $edit['image'] ?? ''; ?>">
<input type="text" name="pdf" placeholder="رابط PDF" value="<?php echo $edit['pdf'] ?? ''; ?>">

<button type="submit" name="<?php echo $edit ? 'update_book':'add_book'; ?>"><?php echo $edit ? 'تعديل الكتاب':'إضافة كتاب'; ?></button>
</form>
</div>

<!-- قائمة المكتبات -->
<div class="box">
<h3>قائمة المكتبات</h3>
<table>
<tr><th>ID</th><th>اسم المكتبة</th><th>حذف</th></tr>
<?php
$libraries = mysqli_query($conn,"SELECT * FROM libraries");
while($row = mysqli_fetch_assoc($libraries)){
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><a href="admin.php?delete_library=<?php echo $row['id']; ?>" onclick="return confirm('حذف المكتبة مع كل الكتب؟')">حذف</a></td>
</tr>
<?php } ?>
</table>
</div>

<!-- قائمة الكتب -->
<div class="box">
<h3>قائمة الكتب</h3>
<table>
<tr><th>ID</th><th>المكتبة</th><th>الكتاب</th><th>المؤلف</th><th>تعديل</th><th>حذف</th></tr>
<?php
$books = mysqli_query($conn,"SELECT books.*, libraries.name AS library_name FROM books JOIN libraries ON books.library_id = libraries.id");
while($row = mysqli_fetch_assoc($books)){
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['library_name']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['author']; ?></td>
<td><a class="edit" href="admin.php?edit_book=<?php echo $row['id']; ?>">تعديل</a></td>
<td><a href="admin.php?delete_book=<?php echo $row['id']; ?>" onclick="return confirm('حذف الكتاب؟')">حذف</a></td>
</tr>
<?php } ?>
</table>
</div>

<a href="logout.php">تسجيل خروج</a>

</body>
</html>