
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
   <link rel="icon" href="images/fast-food.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="SystemDesign.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>UniEats</title>
  
</head>
<body>
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->
 <!--login section ends-->
 <section class="form-container">
  <form action="loginOTP.php" method="post">
    <h3>Login Now</h3>
    <?php
    if (isset($message) && is_array($message)) {
        foreach ($message as $msg) {
            echo "<p class='error'>$msg</p>";
        }
    }
    ?>
    <input type="email" name="email" required placeholder="enter your email address" 
    class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="password" id="password" required placeholder="enter your password" 
    class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
  <div class="checkB">
      <input type="checkbox" class="check" id="show-password" onclick="togglePasswordVisibility()">
      <label for="show-password">Show Password</label>
  </div>
    <input type="submit" name= "submit" value="login now" class="btn">

    <p><a href="forgotPass.php">Forgot Password!</a></p>
    <p><a href="register.php">Don't have a account Register Here!</a></p>
  </form>
</section>


 <!--login section ends-->

<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<script src="homePage.js"></script>

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
</script>
<!--JAVA SCRIPT SHOW PASSWORD ENDS-->

</body>
</html>
