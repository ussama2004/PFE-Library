<?php
session_start();
include("config.php");

/* جلب المكتبات */
$libraries = mysqli_query($conn,"SELECT * FROM libraries");

/* جلب الكتب */
$books = mysqli_query($conn,"
SELECT books.*, libraries.name AS library_name
FROM books
JOIN libraries ON books.library_id = libraries.id
ORDER BY books.id DESC
");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>المكتبة الإلكترونية</title>

<style>
body{
font-family:Arial;
margin:0;
background:#f4f6f9;
}

header{
background:#2c3e50;
color:white;
padding:15px;
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
}

header h2{
margin:0;
}

nav a{
color:white;
text-decoration:none;
margin:8px;
font-size:15px;
}

.hero{
background:linear-gradient(135deg,#4ca1af,#2c3e50);
color:white;
text-align:center;
padding:50px 20px;
}

.hero h1{
margin:0;
font-size:32px;
}

.container{
width:90%;
margin:auto;
padding:25px 0;
}

.section-title{
margin-bottom:15px;
color:#2c3e50;
}

.libs{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:15px;
margin-bottom:35px;
}

.lib{
background:white;
padding:20px;
border-radius:10px;
text-align:center;
box-shadow:0 3px 8px rgba(0,0,0,0.1);
font-weight:bold;
}

.books{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

.book{
background:white;
padding:15px;
border-radius:10px;
box-shadow:0 3px 8px rgba(0,0,0,0.1);
text-align:center;
}

.book img{
width:100%;
height:220px;
object-fit:cover;
border-radius:8px;
}

.book h3{
margin:10px 0 5px;
font-size:18px;
}

.book p{
margin:5px 0;
color:#666;
}

.btn{
display:inline-block;
margin-top:10px;
padding:10px 15px;
background:#27ae60;
color:white;
text-decoration:none;
border-radius:6px;
}

footer{
margin-top:40px;
background:#2c3e50;
color:white;
text-align:center;
padding:15px;
}
</style>

</head>
<body>

<header>

<h2>📚 المكتبة الإلكترونية</h2>

<nav>

<a href="index.php">الرئيسية</a>

<?php if(isset($_SESSION['user'])){ ?>

<a href="#">👤 <?php echo $_SESSION['user']; ?></a>
<a href="logout.php">تسجيل خروج</a>

<?php } else { ?>

<a href="login.php">تسجيل الدخول</a>
<a href="register.php">إنشاء حساب</a>

<?php } ?>

<a href="admin.php">لوحة الأدمن</a>

</nav>

</header>

<section class="hero">
<h1>مرحبًا بكم في المكتبة الإلكترونية</h1>
<p>تصفح المكتبات والكتب بسهولة</p>
</section>

<div class="container">

<!-- المكتبات -->
<h2 class="section-title">🏛️ المكتبات المتوفرة</h2>

<div class="libs">

<?php while($lib = mysqli_fetch_assoc($libraries)){ ?>

<div class="lib">
<?php echo $lib['name']; ?>
</div>

<?php } ?>

</div>

<!-- الكتب -->
<h2 class="section-title">📖 أحدث الكتب</h2>

<div class="books">

<?php while($row = mysqli_fetch_assoc($books)){ ?>

<div class="book">

<img src="<?php echo $row['image']; ?>">

<h3><?php echo $row['title']; ?></h3>

<p>🏛️ <?php echo $row['library_name']; ?></p>

<a class="btn"
href="<?php echo $row['pdf']; ?>"
target="_blank">
قراءة الكتاب
</a>

</div>

<?php } ?>

</div>

</div>

<footer>
جميع الحقوق محفوظة © 2026
</footer>

</body>
</html>