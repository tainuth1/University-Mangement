<?php

require_once 'connection/db.php';
function login(){
    if(isset($_POST['admin_login_btn'])){
        $email = $_POST['admin_email'];
        $password = $_POST['admin_password'];
        if(!empty($email) && !empty($password)){
            $stmt = connection()->prepare("SELECT * FROM admin WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();

            if($email && password_verify($password, $admin['password'])){
                session_start();
                $_SESSION['id'] = $admin['admin_id'];
                header('location:admin/index.php');
                exit();
            }else{
                echo '
                    <p class="error-login">Invalid Login</p>
                ';
            }
            
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="admin/css/alert.css">
    <title>Login</title>
    <style>
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="post">
                <h1>Admin Login</h1>
                <p>Enter email and password to login</p>
                <?php 
                    login();
                ?>
                <input type="email" name="admin_email" placeholder="Email" />
                <input type="password" name="admin_password" placeholder="Password" />
                <button type="submit" name="admin_login_btn">Login</button>
            </form>
        </div>
    </div>
</body>
<script src="login.js"></script>
</html>