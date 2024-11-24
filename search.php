<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
    include('elements/dbconnect.php'); // Avoid using @ to suppress errors; better to handle them properly.
   
    $resulted = $_SESSION['otp_user_id'];
    
    // Prepare and execute the SQL query securely using prepared statements to prevent SQL injection.
    $stmt = $conn->prepare("SELECT `Name` FROM `users` WHERE id = ?");
    $stmt->bind_param("i", $resulted);
    $stmt->execute();
    $result = $stmt->get_result();

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
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->

<!--search section starts here-->
<section class="search-form">
    <form action="" method="post">
        <input type="text" name="search-box" placeholder="search here..." class="box">
        <button type="submit" name="search-btn" class="fas fa-search"></button>
    </form>
</section>
<!--search section ends here-->

<section class="products" style="min-height: 100vh; padding-top: 0;">
<div class="box-container">

    <?php
    if(isset($_POST['search-box']) OR isset($_POST['search-btn'])){
        $search_box = $conn->real_escape_string($_POST['search-box']);
        $stmt = $conn->prepare("SELECT * FROM `menu` WHERE Item_Name LIKE ?");
        $search_term = "%{$search_box}%";
        $stmt->bind_param("s", $search_term);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            while($fetch_products = $result->fetch_assoc()){
    ?>
    <form action="" method="post" class="box">
        <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_products['Item_id']); ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_products['Item_Name']); ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($fetch_products['Item_Price']); ?>">
        <input type="hidden" name="image" value="<?= htmlspecialchars($fetch_products['Item_Image']); ?>">
        <img src="uploaded_img/<?= htmlspecialchars($fetch_products['Item_Image']); ?>" alt="<?= htmlspecialchars($fetch_products['Item_Name']); ?>">
        <a href="menu.php?Category=<?= htmlspecialchars($fetch_products['Category']); ?>" class="cat"><?= htmlspecialchars($fetch_products['Category']); ?></a>
        <div class="name"><?= htmlspecialchars($fetch_products['Item_Name']); ?></div>
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
            echo '<p class="empty">No products found!</p>';
        }
        $stmt->close();
    }
    ?>

</div>
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
