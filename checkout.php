<?php

include('elements/dbconnect.php');
include('receipt.php');

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
    <h3>checkout</h3>
    <p><a href="index.php">home</a><span> / checkout</span></p>
</div>


<style>
.payment-popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.payment-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    max-width: 400px; /* Adjust as needed */
    width: 100%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: auto; /* Ensures centering */
    position: relative; /* Required for positioning close button */
}

.close-button {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 1.5rem;
    cursor: pointer;
}

.payment-popup .cards img {
    height: 30px;
    margin-right: 10px;
}

.payment-popup .form-group {
    margin-bottom: 15px;
}

.payment-popup .form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.payment-popup .form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.payment-popup .expiry-cvv {
    display: flex;
    gap: 10px;
}

.payment-popup .expiry-cvv div {
    flex: 1;
}

.payment-popup .btn {
    width: 100%;
    background-color: #222;
    color: #fff;
    padding: 10px;
    font-size: 1.2rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.payment-popup .btn:hover {
    background-color: #3e2062;
}
</style>
<!--Ordering Information Starts-->
<section class="checkout">
    <h1 class="title">order information</h1>
    <form id="orderForm" action="receipt.php"  method="post">
        <div class="cart-items">
            <h3>cart items</h3>
            <?php
            $grand_total = 0;
            $cart_items = [];
            $delivery_fee = 10; 
            $vat_amount = 0;
            $select_cart = $conn->prepare("SELECT * FROM cart WHERE User_id = ?");
            $select_cart->bind_param("i", $resulted);
            $select_cart->execute();
            $result_cart = $select_cart->get_result();

            if ($result_cart->num_rows > 0) {
                while ($fetch_cart = $result_cart->fetch_assoc()) {
                    $cart_items[] = $fetch_cart['Item_Name'] . ' (' . $fetch_cart['Item_Price'] . ' x ' . $fetch_cart['Item_Quantity'] . ') - ';
                    $total_products = implode($cart_items);
                    $grand_total += ($fetch_cart['Item_Price'] * $fetch_cart['Item_Quantity']);
                    ?>
                    <p><span class="name"><?= htmlspecialchars($fetch_cart['Item_Name']); ?></span><span class="price">R<?= htmlspecialchars($fetch_cart['Item_Price']); ?>.00 x <?= htmlspecialchars($fetch_cart['Item_Quantity']); ?></span></p>
                    <?php
                }
                
                $grand_total += $delivery_fee; 
            }
                
            ?>
            <p><span class="name">Delivery Fee :</span><span class="price">R<?= $delivery_fee; ?>.00</span></p>
            <p><span class="name">*Vat Amount included in base price</span></p>
            <p class="grand-total"><span class="name">Total :</span><span class="price">R <?= $grand_total; ?>.00</span></p>
            <a href="cart.php" class="btn">view cart</a>
        </div>

        <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products); ?>">
        <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
        <input type="hidden" name="delivery_fee" value="<?= $delivery_fee; ?>">
        <input type="hidden" name="vat_amount" value="<?= $vat_amount; ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($userName); ?>">
        <input type="hidden" name="surname" value="<?= htmlspecialchars($fetch_profile['Surname']); ?>">
        <input type="hidden" name="number" value="<?= htmlspecialchars($fetch_profile['Phone_Number']); ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($fetch_profile['Email_Add']); ?>">
        <input type="hidden" name="address" value="<?= htmlspecialchars($fetch_profile['Ress_Add']); ?>">

        <div class="user-profile">
            <h3>meal customisation</h3>
             <textarea name="meal_customerization" placeholder="Please note your meal customisation, e.g., remove tomatoes from my hamburger." maxlength="200" class="box"></textarea>
            <h3>your information</h3>
            <p><i class="fas fa-user"></i><span><?= htmlspecialchars($userName);?>  <?= htmlspecialchars($fetch_profile['Surname']); ?></span></p>
            <p><i class="fas fa-phone"></i><span><?= htmlspecialchars($fetch_profile['Phone_Number']); ?></span></p>
            <p><i class="fas fa-envelope"></i><span><?= htmlspecialchars($fetch_profile['Email_Add']); ?></span></p>
            <a href="update_profile.php" class="btn">update profile</a>
            <h3>delivery address</h3>
            <p><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['Ress_Add'] == '') {
                    echo 'please enter your address';
                } else {
                    echo htmlspecialchars($fetch_profile['Ress_Add']);
                } ?></span></p>
            <a href="update_address.php" class="btn">update address</a>
            <input type="text" class="box" name="method" value="Online Payment" placeholder="Online Payment" readonly>
            <input type="submit" id="place_order" name="proceed" value="place order" class="btn" style="width: 100%; background-color: var(--black); color: var(--white); font-size: 1.4rem;" name="submit" <?php if ($fetch_profile['Ress_Add'] == '') {
                echo 'disabled';
            } ?>>
        </div>

         <!-- Payment form in popup (still inside the same form) -->
    <div id="payment-popup" class="payment-popup" style="display: none;">
        <div class="payment-content">
            <span class="close-button">&times;</span>
            <h3>Online Payment</h3>
            <p>Cards Accepted</p>
            <div class="cards">
                <img src="images/type of cards.jpg" alt="PayPal">
            </div>
            <p>Amount: <span>R<?= $grand_total?>.00</span></p>
            <div class="form-group">
                <label for="card-name">Name on Card</label>
                <input type="text" id="card-name" name="card_name" placeholder="MR NS MNDAWE" required>
            </div>
            <div class="form-group">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" name="card_number" placeholder="Card number" required maxlength="16">
            </div>
            <div id= "cardTypeDisplay" class="card-type-display"></div>
            <div class="form-group expiry-cvv">
                <div>
                    <label for="expiry-date">Expiry Date</label>
                    <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" required maxlength="5">
                </div>
                <div>
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="CVV" required maxlength="3">
                </div>
            </div>
            <button type="submit" name="make_payment" class="btn">Make Payment</button>
        </div>
    </div>
    </form>
</section>


<!--Ordering Information Ends-->

<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<!--loader section starts-->
<!--<div class="loader">
  <img src="images/loader.gif" alt="">
</div>
  loader section ends-->
  <script>
    const expiryDateInput = document.getElementById('expiry-date');

    expiryDateInput.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // Remove all non-digit characters
        value = value.replace(/\D/g, '');

        // Format as MM/YY
        if (value.length >= 3) {
            value = value.slice(0, 2) + '/' + value.slice(2);
        }

        e.target.value = value;
    });
</script>
  <script>
 
 // Function to identify the card type based on the card number
 function identifyCardType(cardNumber) {
   // Define regular expressions for different card types
   const cardPatterns = {
     visa: /^4\d{15}$/,
     mastercard: /^5[1-5]\d{14}$/,
     amex: /^3[47]\d{13}$/,
     discover: /^6(?:011|5\d{2})\d{12}$/
     // Add more card types and patterns as needed
   };
 
   for (const cardType in cardPatterns) {
     if (cardPatterns[cardType].test(cardNumber)) {
       return cardType;
     }
   }
 
   return "Unknown"; // Card type not identified
 }
 
 // Function to update the card type display
 function updateCardTypeDisplay(cardType) {
   const cardTypeDisplay = document.getElementById('cardTypeDisplay');
   cardTypeDisplay.textContent = cardType;
 }
 
 // Add an input event listener to the card number input
 const cardNumberInput = document.getElementById('card-number');
 cardNumberInput.addEventListener('input', function () {
   const cardNumber = cardNumberInput.value.replace(/\s/g, ''); // Remove spaces
   const cardType = identifyCardType(cardNumber);
   updateCardTypeDisplay(cardType);
 });
  </script>


  <script>
const paymentPopup = document.getElementById('payment-popup');
const placeOrderBtn = document.getElementById('place_order');
const closeButton = document.querySelector('.close-button');

// Show payment popup when "Place Order" is clicked
placeOrderBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission
    paymentPopup.style.display = 'flex'; // Show the payment popup
});

// Hide payment popup when the close button or outside area is clicked
closeButton.addEventListener('click', function() {
    paymentPopup.style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === paymentPopup) {
        paymentPopup.style.display = 'none';
    }
});

  </script>
<script src="homePage.js"></script>

</body>
</html>