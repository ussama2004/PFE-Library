<?php
session_start();
include("config.php");

$message = "";

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    /* دخول الأدمن */
    if($username == "admin" && $password == "admin123")
    {
        $_SESSION['admin'] = $username;
        header("Location: admin.php");
        exit();
    }

    /* دخول المستخدم العادي */
    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    }
    else
    {
        $message = "اسم المستخدم أو كلمة السر خاطئة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تسجيل الدخول</title>

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
background:#27ae60;
color:white;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#219150;
}

a{
display:block;
margin-top:12px;
text-decoration:none;
color:#2c3e50;
font-size:14px;
}

.msg{
color:red;
margin-top:10px;
font-size:14px;
}
</style>

</head>
<body>

<div class="box">

<h2>🔐 تسجيل الدخول</h2>

<form method="POST">

<input type="text" 
name="username" 
placeholder="اسم المستخدم"
required>

<input type="password" 
name="password" 
placeholder="كلمة السر"
required>

<button type="submit" name="login">
دخول
</button>

</form>

<div class="msg">
<?php echo $message; ?>
</div>

<a href="register.php">إنشاء حساب جديد</a>
<a href="index.php">⬅ الرجوع للرئيسية</a>

</div>

</body>
</html>