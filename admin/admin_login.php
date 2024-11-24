<?php
include '../elements/dbconnect.php';
session_start();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM `administrators` WHERE Admin_Num = ? AND Password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $name, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        $fetch_admin_id = mysqli_fetch_assoc($result);
        $_SESSION['Admin_id'] = $fetch_admin_id['Admin_id'];
        header('location:dashboard.php');
    } else {
        $message[] = 'incorrect username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="icon" href="../images/fast-food.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cafeteria Staff Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- admin login form section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3> Cafeteria Staff Login Portal</h3>
    
      <input type="text" name="name" maxlength="8" required placeholder="enter your staff number" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" id="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <div class="checkB">
      <input type="checkbox" class="check" id="show-password" onclick="togglePasswordVisibility()">
      <label for="show-password">Show Password</label>
     </div>
      <div style="display: flex;">
      <i class="fas fa-info-circle" onclick="showInfoAlert()" style="cursor: pointer; margin-top: 10px;"></i>
      </div>
  
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>

<!-- admin login form section ends -->

<!--JAVA SCRIPT SHOW PASSWORD STARTS-->

<script>
function togglePasswordVisibility() {
  const passwordInput = document.getElementById('password');
  const showPasswordCheckbox = document.getElementById('show-password');
  
  if (showPasswordCheckbox.checked) {
      passwordInput.type = 'text';
  } else {
      passwordInput.type = 'password';
  }
}

function showInfoAlert() {
  alert('This is the admin login portal. Please enter your staff number and password to log in.');
}
</script>

<!--JAVA SCRIPT SHOW PASSWORD ENDS-->

</body>
</html>
