<?php  
session_start();  
include '../config/koneksi.php';  

$username = $_POST['username'];  
$password = $_POST['password'];  

$data = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");  

if(mysqli_num_rows($data) > 0){  
    $_SESSION['login'] = true;  
    header("Location: ../dashboard.php");  
}else{  
    header("Location: login.php?error=gagal"); // 🔥 redirect
}

exit;
?>