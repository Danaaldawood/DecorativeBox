<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="header">
    <img src="images/logo.png" alt="Logo" class="logo" height="200" width="250">
  </div>
  
  <div class="container">
    <img id="userimg" src="images/UserImg.png" alt="User Image">
  
    <div id="login-form">
      <div id="login-container">
        <h1 class="login-lable">Welcome Back!</h1>
        <form method="POST">
          <label for="user-type">User Type:</label>
          <select id="user-type" name="user-type" required>
            <option value="" disabled selected hidden>Select</option>
            <option value="designer">Designer</option>
            <option value="client">Client</option>
          </select>
          
          <label for="email">Email Address:</label>
          <input type="email" id="email" name="email" required>

          <label for="password">Password:</label>
          <div class="passBox">
            <input type="password" id="password" name="password" required>
            <img src="images/closeEye.png" class="eye" alt="" onclick="togglePasswordVisibility()">
          </div>
          <br>
          <div class="login-sumbit">
            <input type="submit" class="login-submit-button" value="Login" style="width: 80px; align-items: center;"> 
          </div>

          <p>Don't have an account? <a href="SignUp.php">Sign Up</a></p>
        </form>
      </div>
    </div>
  </div>

  <script>


    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("password");
      var eyeIcon = document.querySelector(".eye");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.src = "images/openEye.png";
      } else {
        passwordInput.type = "password";
        eyeIcon.src = "images/closeEye.png";
      }
    }
  </script>
 <?php
session_start();
include_once './Database_Connect.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userType = $_POST['user-type'];
    $email = $_POST['email'];
    $password = $_POST['password'];


   
$tableName="";
    if ($userType === "designer") {
    $tableName =  'designer' ;}
 else {
      $tableName =  'client' ;  
    }
    
    $email = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT * FROM $tableName WHERE emailAddress = '$email'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = $userType;

                if ($userType === 'designer') {
                    header('Location: designerHomepage.php');
                } else {
                    header('Location: clientHomepage.php');
                }
            } else {
                echo "<div class='error-message'>Please enter valid information</div>";
            }
        }
        else {
                echo "<div class='error-message'>Please enter valid information</div>";
            }
    } 
} 
?>
</body>
</html>
