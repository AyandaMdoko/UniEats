

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="icon" href="../images/fast-food.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>UniEats Delivery Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="delivery.css">

</head>
<body>


<!-- admin login form section starts  -->

<section class="form-container">

   <form action="DeliveryLogin.php" method="POST">
      <h3> UniEats Student Delivery Login</h3>

      <?php
    if (isset($message) && is_array($message)) {
        foreach ($message as $msg) {
            echo "<p class='error'>$msg</p>";
        }
    }
    ?>
    
      <input type="email" name="email" maxlength="20" required placeholder="43525172@mynwu.ac.za" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" id="password" name="password" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <div class="checkB">
      <input type="checkbox" class="check" id="show-password" onclick="togglePasswordVisibility()">
      <label for="show-password">Show Password</label>
     </div>
      <div style="display: flex;">
      <p>Don't have an account? <a style="text-decoration: none; color: #fff; font-size:1.8rem;; " href="RegisterDelivery.php">Register here!</a></p>
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