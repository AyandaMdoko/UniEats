<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
  include('elements/dbconnect.php');
   
  $resulted = $_SESSION['otp_user_id'];
  $sql = "SELECT  `Name` FROM `users` WHERE id = '$resulted'";
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <title>UniEats</title>
  
</head>
<body>
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->

<div class="heading">
  <h3>our menu</h3>
  <p><a href="index.php">home</a><span> / menu</span></p>
</div>

<!--menu section starts-->
<section class="products">
  <h1 class="title">our meal categories</h1>
  <div  class="box-contain">

    <a href="BreakfastMenu.php" class="category-link">
      <div class="category-list">
      <img src="images/English breakfast with fried eggs.jpeg" alt="">
      <div style=" display:flex; align-items:center; justify-content: center;"><h1>Breakfast</h1></div>
      </div>
    </a>

    <a href="SandwichesMenu.php" class="category-link">
    <div class="category-list">
      <img src="images/Premium Photo _ Close-up of two sandwiches with bacon, salami, prosciutto and fresh vegetables on rustic wooden cutting board_ club sandwich concept_.jpeg" alt="">
      <div style=" display:flex; align-items:center; justify-content: center;"><h1>Sandwiches & Sphatlho</h1></div>
      </div>
    </a>

    <a href="Baskets&HambugersMenu.php" class="category-link">
    <div class="category-list">
      <img src="images/download.jpeg" alt="">
      <div style=" display:flex; align-items:center; justify-content: center;"><h1>Baskets & Hamburgers</h1></div>
      </div>
    </a>

    <a href="RollsMenu.php" class="category-link">
    <div class="category-list">
      <img src="images/Chipotle Chicken Sandwich.jpeg" alt="">
      <div style=" display:flex; align-items:center; justify-content: center;"><h1>Rolls</h1></div>
      </div>
    </a>

    <a href="MealOfDayMenu.php" class="category-link">
    <div class="category-list">
      <img src="images/Creamy samp and beef stew_ Traditional South African flavour.jpeg" alt="">
      <div style=" display:flex; align-items:center; justify-content: center;"><h1>Meal of the Day</h1></div>
      </div>
    </a>

    <a href="BeveragsMenu.php" class="category-link">
    <div class="category-list">
      <img src="images/download (1).jpeg" alt="">
      <div style=" display:flex; align-items:center; justify-content: center;"><h1>Beverages</h1></div>
      </div>
    </a>

  </div>
</div>
</div>

  
</section>
<!--menu section ends-->




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