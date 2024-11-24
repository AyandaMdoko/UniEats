<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = include('elements/dbconnect.php');

$sql = "SELECT * FROM users WHERE Reset_token_hash = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo("<script>alert('token not found')</script>");
} else {
    if (strtotime($user["Reset_token_expires_at"]) <= time()) {
        echo("<script>alert('token has expired');</script>");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/fast-food.png">
    <link rel="stylesheet" href="SystemDesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <title>Reset password</title>
   
</head>
<body>
<!-- header section starts  -->
<?php include 'elements/user_header.php'; ?>
<!-- header section ends -->
       

<section class="form-container">
    <form action="process_reset_pass.php" method="POST">
      <h3>Reset Your password</h3>

      
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

      <div class="password-input">
      <input type="password" name="pass" id="regPass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      
    <div class="restictions">
       
       <div class="circle-container">
        <div class="circle" id="length-circle"></div>
        <span class="requirement-label">At least 8 characters</span>
       </div>
       <div class="circle-container">
        <div class="circle" id="uppercase-circle"></div>
        <span class="requirement-label">Uppercase letter</span>
       </div>
       <div class="circle-container">
        <div class="circle" id="lowercase-circle"></div>
        <span class="requirement-label">Lowercase letter</span>
       </div>
      <div class="circle-container">
        <div class="circle" id="number-circle"></div>
        <span class="requirement-label">Numerical character</span>
      </div>
      <div class="circle-container">
        <div class="circle" id="special-char-circle"></div>
        <span class="requirement-label">Special character</span>
       </div>
      </div>
     </div>

     <input type="password" name="password" id="regConfPass" required placeholder="Confirm password" 
     class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">

     <div class="checkB">
        <input type="checkbox" class="check" id="show-password" onclick="togglePasswordVisibility()">
        <label for="show-password">Show Password</label>
    </div>
    <p id="passwordError" style="color: red;"></p>

        <input type="submit" value="Submit" class="btn">
      
</form>
  </section>

  
    <!--footer section starts-->
<footer class="footer">
  <section class="grid">
    <div class="box">
      <img src="images/email.pic.png" alt="">
      <h3>Our Email</h3>
      <a href="UniEats@gmail.com">UniEats@gmail.com</a>
    </div>

    <div class="box">
      <img src="images/time.pic.png" alt="">
      <h3>Our Operating Hours</h3>
      <p>08:00am to 19:00pm</p>
    </div>

    <div class="box">
      <img src="images/map.png" alt="">
      <h3>Our Address </h3>
      <a href="#">Mmabatho Unit 5, Mahikeng, 2790</a>
    </div>

    <div class="box">
      <img src="images/phone-book.png" alt="">
      <h3>Our Number</h3>
      <a href="tel:0115697894">011 569 7894</a>
      <a href="Phone:0787857895">078 785 7895</a>
    </div>
  </section>
<div class="credit"> created by <span>project x </span> |all rights reserved</div>
</footer>
<!--footer section ends-->

<!--loader section starts-->
<!--<div class="loader">
  <img src="images/loader.gif" alt="">
</div>
  loader section ends-->

  
<script src=""></script>

<script>
   navbar = document.querySelector(' .header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
  navbar.classList.toggle('active');
  profile.classList.remove('active');
}

profile = document.querySelector(' .header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
  profile.classList.toggle('active');
  navbar.classList.remove('active');
}

window.onscroll = () =>{
  navbar.classList.remove('active');
  profile/classList.remove('active');
}

</script>

       
 <!--JAVA SCRIPT SHOW PASSWORD STARTS-->

<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('regPass');
    const confirmPassword = document.getElementById('regConfPass')
    const showPasswordCheckbox = document.getElementById('show-password');
    
    if (showPasswordCheckbox.checked) {
        passwordInput.type = 'text';
        confirmPassword.type = 'text';
    } else {
        passwordInput.type = 'password';
        confirmPassword.type = 'password';
    }
  }
  
  </script>
  
  <!--JAVA SCRIPT SHOW PASSWORD ENDS-->

  <script>
    const passwordInput = document.getElementById('regPass');
const confirmPasswordInput = document.getElementById('regConfPass');
const passwordError = document.getElementById('passwordError');

function validatePasswords() {
  const password = passwordInput.value;
  const confirmPassword = confirmPasswordInput.value;

  if (password && confirmPassword && password !== confirmPassword) {
    passwordError.textContent = 'Passwords do not match!';
  } else {
    passwordError.textContent = '';
  }
}



passwordInput.addEventListener('input', validatePasswords);
confirmPasswordInput.addEventListener('input', validatePasswords);

      
        const lengthCircle = document.getElementById('length-circle');
        const uppercaseCircle = document.getElementById('uppercase-circle');
        const lowercaseCircle = document.getElementById('lowercase-circle');
        const numberCircle = document.getElementById('number-circle');
        const specialCharCircle = document.getElementById('special-char-circle');

        passwordInput.addEventListener('input', updateCircles);

        function updateCircles() {
            const password = passwordInput.value;
            lengthCircle.classList.toggle('valid', password.length >= 8);
            uppercaseCircle.classList.toggle('valid', /[A-Z]/.test(password));
            lowercaseCircle.classList.toggle('valid', /[a-z]/.test(password));
            numberCircle.classList.toggle('valid', /\d/.test(password));
            specialCharCircle.classList.toggle('valid', /[!@#$%^&*]/.test(password));
        }

  </script>
  


</body>
</html>