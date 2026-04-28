<?php
session_start();
include("config.php");

$message = "";

if(isset($_POST['register']))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    /* التحقق من وجود المستخدم */
    $check = mysqli_query($conn,"
    SELECT * FROM users
    WHERE username='$username'
    ");

    if(mysqli_num_rows($check) > 0)
    {
        $message = "اسم المستخدم موجود من قبل";
    }
    else
    {
        mysqli_query($conn,"
        INSERT INTO users(username,password)
        VALUES('$username','$password')
        ");

        $message = "تم إنشاء الحساب بنجاح";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إنشاء حساب</title>

<style>
body{
font-family:Arial;
margin:0;
padding:0;
background:linear-gradient(135deg,#2c3e50,#4ca1af);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.box{
background:white;
width:360px;
padding:30px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
text-align:center;
}

h2{
margin-bottom:20px;
color:#2c3e50;
}

input{
width:100%;
padding:12px;
margin:8px 0;
border:1px solid #ccc;
border-radius:8px;
font-size:15px;
}

button{
width:100%;
padding:12px;
margin-top:10px;
background:#3498db;
color:white;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#2980b9;
}

a{
display:block;
margin-top:12px;
text-decoration:none;
color:#2c3e50;
font-size:14px;
}

.msg{
margin-top:10px;
font-size:14px;
color:green;
}
</style>

</head>
<body>

<div class="box">

<h2>👤 إنشاء حساب جديد</h2>

<form method="POST">

<input type="text"
name="username"
placeholder="اسم المستخدم"
required>

<input type="password"
name="password"
placeholder="كلمة السر"
required>

<button type="submit" name="register">
تسجيل
</button>

</form>

<div class="msg">
<?php echo $message; ?>
</div>

<a href="login.php">عندي حساب مسبقًا</a>
<a href="index.php">⬅ الرجوع للرئيسية</a>

</div>

</body>
</html>