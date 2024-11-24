<?php
session_start();
include('elements/dbconnect.php');

// Ensure user is logged in
if (isset($_SESSION['otp_user_id'])) {
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
        echo ("<script>alert('Database query failed')</script>" . $conn->error);
    }
    $stmt->close();
} else {
    // Redirect to login page if session does not exist
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['User_Num'])) {
    $user_id = $_SESSION['User_Num'];
} else {
    $user_id = '';
    header('location:index.php');
}

if (isset($_POST['delete'])) {
    $cart_id = $_POST['Cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE Cart_id = ?");
    $delete_cart_item->bind_param('i', $cart_id);
    $delete_cart_item->execute();
    $message[] = 'cart item deleted!';
}
if (isset($_POST['delete_all'])) {
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE User_id = ?");
    $delete_cart_item->bind_param('i', $user_id);
    $delete_cart_item->execute();
    $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['Cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `cart` SET Item_Quantity = ? WHERE Cart_id = ?");
    $update_qty->bind_param('ii', $qty, $cart_id);
    $update_qty->execute();
    $message[] = 'cart quantity updated';
}

$grand_total = 0;
$delivery_fee = 10;
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
    <h3>shopping cart</h3>
    <p><a href="index.php">home</a><span> / cart</span></p>
</div>

<!--shopping cart section starts here-->
<section class="products">
    <h1 class="title">your cart</h1>

    <div class="box-container">

        <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE User_id = ?");
        $select_cart->bind_param('i', $user_id);
        $select_cart->execute();
        $result = $select_cart->get_result();
        if ($result->num_rows > 0) {
            while ($fetch_cart = $result->fetch_assoc()) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="Cart_id" value="<?= $fetch_cart['Cart_id']; ?>">
                    <button type="submit" class="fas fa-times" name="delete"
                            onclick="return confirm('delete this item?');"></button>
                    <img src="uploaded_img/<?= $fetch_cart['Item_Image']; ?>" alt="<?= $fetch_cart['Item_Image']; ?>">
                    <div class="name"> <?= $fetch_cart['Item_Name']; ?></div>
                    <div class="description"><?= $fetch_cart['Item_Description']; ?></div>
                    <div class="flex">
                        <div class="price"><span>R</span><?= $fetch_cart['Item_Price']; ?>.00</div>
                        <input type="number" name="qty" class="qty" min="1" max="99"
                               value="<?= $fetch_cart['Item_Quantity']; ?>"
                               onkeypress="if(this.value.length == 2) return false;">
                        <button type="submit" class="fas fa-save" name="update_qty"></button>
                    </div>
                    <div class="sub-total"> sub total : <span>R <?= $sub_total = ($fetch_cart['Item_Price'] * $fetch_cart['Item_Quantity']); ?>.00</span>
                    </div>
                </form>
                <?php
                $grand_total += $sub_total;
              
            }
        } else {
            echo '<p class="empty">your cart is empty</p>';
        }
        ?>
    </div>
    <div class="more-btn">
        <form action="" method="post">
            <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all"
                    onclick="return confirm('delete all from cart?');">delete all
            </button>
        </form>
        <a href="menu.php" style="border-radius: 50px;" class="btn">continue shopping</a>
    </div>

       <div class="cart-total">
        <p>cart total : <span>R<?= $grand_total; ?>.00</span></p>
        <p>Delivery Fee: <span>R<?= $delivery_fee; ?>.00</span></p>
        <?php $grand_total += $delivery_fee; ?>
        <p>Grand Total : <span>R<?= $grand_total; ?>.00</span></p>
        <a href="checkout.php" id="checkout-button" style="border-radius: 50px;"
           class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
    </div>
</section>
<!--shopping cart section ends here-->


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
   document.getElementById('checkout-button').addEventListener('click', function (e) {
    var grandTotal = <?= $grand_total; ?>;
    if (grandTotal < 50) {
        e.preventDefault();
        alert('To proceed, please add more items to your cart so that your total exceeds R50.00');
    }
});
</script>
</body>
</html>
