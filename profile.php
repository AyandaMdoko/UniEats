<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
  include('elements/dbconnect.php');
   
  $resulted = $_SESSION['otp_user_id'];
  $sql = "SELECT  * FROM `users` WHERE id = '$resulted'";
  $result = $conn->query($sql);

  if ($result) {
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $userName = $user['Name'];
    } else {
      echo ("<script>alert('User not found in the database')</script>");
    }
  } else {
     echo ("<script>alert('Database query failed')</script>". $conn->error);
  }
}
include 'elements/add_to_cart.php';
?>

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
<!--profile section starts-->
<section class="user-details">
  <div class="user">
    <img src="images/User-Icon.png" alt="">
    <p><i class="fas fa-users"></i> <span><?= isset($user) ? $user['User_type'] : ''; ?></span></p>
    <p><i class="fas fa-user"></i> <span><?= isset($user) ? $user['Name'] . ' ' . $user['Surname'] : ''; ?></span></p>
    <p><i class="fas fa-id-badge"></i><span><?= isset($user) ? $user['User_Num'] : ''; ?></span></p>
    <p><i class="fas fa-envelope"></i><span><?= isset($user) ? $user['Email_Add'] : ''; ?></span></p>
    <p><i class="fas fa-phone"></i> <span><?= isset($user) ? $user['Phone_Number'] : ''; ?></span></p>
    <p><i class="fas fa-lock"></i><span>******</span></p>
    <a href="update_profile.php" class="btn">Update info</a>
    <p class="address"><i class="fas fa-map-marker-alt"></i><span><?= isset($user) ? $user['Ress_Add'] : ''; ?></span></p>
    <a href="update_address.php" class="btn">Update address</a>
  </div>
</section>
 
 </section>
<!--profile section ends-->



<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->




<script src="homePage.js"></script>


</body>
</html>