<!DOCTYPE HTML>

<?php	
        session_start();       

       $judge_username="user";	
       $judge_password="password";
       $admin_username="admin";	
       $admin_password="admin123";	

       // Handle logout
       if(isset($_GET['logout'])) {
           session_destroy();
           header("location:index.php");
           exit;
       }

       if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
                 if($_SESSION['role'] == 'admin') {
                     header("location:admin.php");
                 } else {
                     header("location:loginsuccess.php");
                 }
                 exit;
       }	

       if(isset($_POST['username']) && isset($_POST['password'])) {
                 $username = $_POST['username'];
                 $password = $_POST['password'];
                 
                 // Check admin credentials
                 if($username == $admin_username && $password == $admin_password) {
                     $_SESSION['loggedin'] = true;
                     $_SESSION['role'] = 'admin';
                     $_SESSION['username'] = $username;
                     header("location:admin.php");
                     exit;
                 }
                 // Check judge credentials
                 elseif($username == $judge_username && $password == $judge_password) {
                     $_SESSION['loggedin'] = true;
                     $_SESSION['role'] = 'judge';
                     $_SESSION['username'] = $username;
                     header("location:loginsuccess.php");
                     exit;
                 }
                 else {
                     $error = "Username or password is incorrect";
                 }
        }
?>

<html>
<head>
    <title>Judge Login - Computer Science Project Grading</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p style="text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
            Judge: user / password<br>
            Admin: admin / admin123
        </p>
    </div>
</body>
</html>

