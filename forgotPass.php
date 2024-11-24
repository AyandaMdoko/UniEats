
<?php
include('elements/dbconnect.php');


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
    <title>Forgot Password</title>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'elements/user_header.php'; ?>
<!-- header section ends -->


    <section class="form-container">
        <form action="password_reset_email.php"  method="POST">
          <h3>Forgot Password</h3>
          <h2>Reset your password<h2>
          <p style="color: black; font-size: medium;">  Enter your university email that entails @mynwu to Reset your password.</p>

          <input type="email" name="email" required placeholder="e.g 33525625@mynwu.ac.za" 
          class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
       
          <input type="submit" value="Submit" class="btn">
          
        </form>
    </section>


    <!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<!--loader section starts-->
<!--<div class="loader">
  <img src="images/loader.gif" alt="">
</div>
  loader section ends-->

<script src="homePage.js"></script>


   
</body>
</html>