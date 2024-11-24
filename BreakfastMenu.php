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
  <title>Breakfast Menu</title>
  
</head>
<body>
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->

<div class="heading">
  <h3>Breakfast menu</h3>
  <p><a href="menu.php">menu</a><span> / breakfast</span></p>
</div>

  <!--menu section starts-->
  <section class="products">
  <h1 class="title">Latest Meals</h1>

  <div class="box-container">
    <?php
      
      $category = 'Breakfast';
      $select_products = $conn->prepare("SELECT * FROM menu WHERE Category = ? LIMIT 6");
      $select_products->bind_param("s", $category);
      $select_products->execute();
      $result = $select_products->get_result();
      if($result->num_rows > 0){
        while($fetch_products = $result->fetch_assoc()){
    ?>
    <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_products['Item_id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['Item_Name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['Item_Price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['Item_Image']; ?>">
      <input type="hidden" name="description" value="<?= $fetch_products['Item_Description']; ?>"> 
      <img src="uploaded_img/<?= $fetch_products['Item_Image']; ?>" alt="<?= $fetch_products['Item_Name']; ?>">
      <a href="menu.php?Category=<?= $fetch_products['Category']; ?>" class="cat"><?= $fetch_products['Category']; ?></a>
      <div class="name"><?= $fetch_products['Item_Name']; ?></div>
      <div class="description"><?= $fetch_products['Item_Description']; ?></div>
      <div class="flex">
         <div class="price" id="price-<?= $fetch_products['Item_id']; ?>" data-price="<?= $fetch_products['Item_Price']; ?>">
           <span>R</span><?= $fetch_products['Item_Price'] ?>.00
         </div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" oninput="updatePrice(<?= $fetch_products['Item_id']; ?>, this.value)">
       </div>
      <div class="add-cartbtn">
        <button type="submit" name="add_to_cart" class="btn">Add To Cart</button>
      </div>
    </form>
    <?php
        }
      } else {
        echo '<p class="empty">No products added yet!</p>';
      }
      $select_products->close();
      $conn->close();
    ?>
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
<script>
  function updatePrice(itemId, quantity) {
    const priceElement = document.getElementById('price-' + itemId);
    const unitPrice = priceElement.getAttribute('data-price');
    const totalPrice = (unitPrice * quantity).toFixed(2);
    priceElement.innerHTML = `<span>R</span>${totalPrice}`;
  }
</script>

</body>
</html>