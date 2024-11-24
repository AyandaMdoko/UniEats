<?php
session_start();
include('elements/dbconnect.php');

// Ensure user is logged in
if(isset($_SESSION['otp_user_id'])) {
    $userId = $_SESSION['otp_user_id'];

    $sql = "SELECT `Name` FROM `users` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['User_Num'] = $userId; // Set the user session variable
            $userName = $user['Name'];
        } else {
            echo ("<script>alert('User not found in the database')</script>");
        }
    } else {
        echo ("<script>alert('Database query failed')</script>". $conn->error);
    }
    $stmt->close();
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

<!-- header section starts  -->
<?php include 'elements/user_header.php'; ?>
<!-- header section ends -->

<style>
    /* Popup Modal Styles */
    .popup-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .popup-content {
      background: #fff;
      padding: 20px;
      max-width: 500px;
      text-align: center;
      border-radius: 8px;
    }
    .popup-content h2 {
      margin-top: 0;
    }
    .popup-content ul {
      text-align: left;
      margin: 10px 0;
    }
    .popup-content ul li {
      margin-bottom: 8px;
    }
    .popup-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 20px;
    }
    .popup-buttons button {
      padding: 10px 20px;
      cursor: pointer;
      font-size: 1.4rem;
    }
 .close-btn {
      position: absolute; /* Change to absolute */
      top: 10px; /* Adjust position */
      left: 15px; /* Move to the left */
      font-size: 20px;
      font-weight: bold;
      color: #333;
      cursor: pointer;
    }
    .products .more-btn button{
font-size: 1.8rem ;
}
  </style>

<!-- Popup Modal -->
<div class="popup-modal" id="popupModal">
  <div class="popup-content">
    <span class="close-btn" onclick="closePopup()">×</span>
    <h2>Welcome to UniEats!</h2>
    <p>This is a food ordering system for North-West University Cafeteria.</p>
    <ul>
        <li>🍽️ Please note: Orders must be above R50 to proceed with checkout.</li>
      <li>🔄 Remember to refresh the order page after placing a order for order status to update.</li>
      <li>🔑 To add items to your cart, please log in or register first.</li>
      <li>🚚 A delivery fee of R10 applies to all orders.</li>
      <li>🎓 Delivery is exclusively for students. Make sure you're a student to deliver!</li>
      <li>📋 Interested in becoming a delivery personnel? Use the 'About' section to register!</li>
      <li>🏫 Please be aware that orders take place **on campus** and not off campus.</li>
    </ul>
    <div class="popup-buttons">
      <?php if (!isset($_SESSION['otp_user_id'])): ?>
          <button class="btn" onclick="location.href='login.php'">Login</button>
          <button class="btn" onclick="location.href='register.php'">Register</button>
      <?php endif; ?>
      <button class="btn" onclick="location.href='about.php'">Tutorial</button>
    </div>
  </div>
</div>

<!--slider display starts here-->
<section class="hero">
  <div class="swiper hero-slider">
    <div class="swiper-wrapper">


      <div class="swiper-slide slide">
        <div class="content">
          <span>Order Online</span>
          <h3>Sphatlho: The Ultimate Street Feast! Loaded with Flavor, Loved by All!</h3>
          <a href="SandwichesMenu.php" class="btn"> see menu</a>
        </div>
        <div class="image">
          <img src="images/ikota.jpeg" alt="">
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="content">
          <span>Want To Deliver</span>
          <h3>Apply and Register To Deliver</h3>
          <a href="delivery/DeliveryLogin.php" class="btn">Register to Deliver</a>
        </div>
        <div class="image">
          <img src="images/student delivery 1.png" alt="">
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="content">
          <span>Order Online</span>
          <h3>Meal of the Day: A Fresh, Flavorful Delight Awaiting You!</h3>
          <a href="menu.php" class="btn"> see menu</a>
        </div>
        <div class="image">
          <img src="images/meals/homePromoPic2.jpeg" alt="">
        </div>
      </div>

    </div>
    <div class="swiper-pagination"></div>
  </div>
</section>
<!--slider display ends here-->

<!--category section starts here-->
<section class="category">
  <h1 class="title">Our Food Category</h1>
  <div class="box-container">

    <a href="BreakfastMenu.php" class="box">
      <img src="images/meals/Vetkoek_ the easy, delicious recipe for a classic South African bread.jpeg" alt="">
      <h3>Breakfast</h3>
    </a>

    <a href="SandwichesMenu.php" class="box">
      <img src="images/meals/Sándwich Saludable y Fitness.jpeg" alt="">
      <h3>Sandwiches</h3>
    </a>

    <a href="MealOfDayMenu.php" class="box">
      <img src="images/meals/mealspo.jpeg" alt="">
      <h3>Meal of the Day</h3>
    </a>

    <a href="BeveragsMenu.php" class="box">
      <img src="images/meals/Do drinks stay colder in a plastic or metal container_.jpeg" alt="">
      <h3>Beverages</h3>
    </a>

  </div>
</section>
<!--category section ends here-->

<!--home products section starts here-->
<section class="products">
  <h1 class="title">latest meals</h1>
  <div class="box-container">
  <?php
     $select_products = $conn->prepare("SELECT * FROM `menu` LIMIT 6");
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
       
       <img src="uploaded_img/<?= $fetch_products['Item_Image']; ?>" alt="<?= $fetch_products['Item_Image']; ?>">
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
       echo '<p class="empty">no products added yet!</p>';
     }
  ?>
  </div>
  
  <div class="more-btn">
    <a href="menu.php" class="btn">view all</a>
    <button class="btn" onclick="resetPopupPreference()">QUICK INFO</button>
  </div>
</section>
<!--home products section ends here-->



<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<!--loader section starts-->
<!--<div class="loader">
  <img src="images/loader.gif" alt="">
</div>
  loader section ends-->


<!--javaScript-->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- JavaScript to control popup visibility -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const popup = document.getElementById("popupModal");
    
    // Check if the popup has been shown before by using localStorage
    if (!localStorage.getItem("popupShown")) {
      popup.style.display = "flex"; // Show the popup
      localStorage.setItem("popupShown", "true"); // Mark it as shown
    }

    // Event listener to close popup when clicking outside of it
    popup.addEventListener("click", function(event) {
        // Check if the click is outside the popup content
        if (event.target === popup) {
            closePopup(); // Close the popup
        }
    });
});

// Function to close the popup and hide it
function closePopup() {
    document.getElementById("popupModal").style.display = "none";
}

// Function to reset popup preference for testing purposes
function resetPopupPreference() {
    console.log("Resetting popup preference..."); // Debug log
    localStorage.removeItem("popupShown");
    alert("Popup preference reset. Refresh the page to see the popup again.");
}

function updatePrice(itemId, quantity) {
    const priceElement = document.getElementById('price-' + itemId);
    const unitPrice = priceElement.getAttribute('data-price');
    const totalPrice = (unitPrice * quantity).toFixed(2);
    priceElement.innerHTML = `<span>R</span>${totalPrice}`;
}
</script>


<script>
  function updatePrice(itemId, quantity) {
    const priceElement = document.getElementById('price-' + itemId);
    const unitPrice = priceElement.getAttribute('data-price');
    const totalPrice = (unitPrice * quantity).toFixed(2);
    priceElement.innerHTML = `<span>R</span>${totalPrice}`;
  }
</script>
<script>
  var swiper = new Swiper(".hero-slider", {
    loop:true,
    grabCursor: true,
    effect: "flip",
    pagination: {
      el: ".swiper-pagination",
      clickable:true, 
    },
  });
</script>

<script src="homePage.js"></script>

</body>
</html>
