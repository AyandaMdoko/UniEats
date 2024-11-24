<?php

include('dbconnect.php');

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['User_Num'])) {
        header('Location: login.php');
        exit();
    } else {
        $user_Num = $_SESSION['User_Num'];
        $message = []; // Initialize message as an array

        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
        $itemName = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $itemPrice = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $itemQuantity = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);
        $itemImage = filter_var($_POST['image'], FILTER_SANITIZE_STRING);
        $itemDescription = filter_var($_POST['description'], FILTER_SANITIZE_STRING); // Sanitize description

        // Check if the item is already in the cart
        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE `Item_Name` = ? AND `User_id` = ?");
        $check_cart_numbers->bind_param('si', $itemName, $user_Num);
        $check_cart_numbers->execute();
        $result = $check_cart_numbers->get_result();

        if ($result->num_rows > 0) {
            $message[] = 'already added to cart';
        } else {
            // Insert the item into the cart including the description
            $insert_cart = $conn->prepare("INSERT INTO `cart` (`User_id`, `pid`, `Item_Name`, `Item_Price`, `Item_Quantity`, `Item_Image`, `Item_Description`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_cart->bind_param('iisdiss', $user_Num, $pid, $itemName, $itemPrice, $itemQuantity, $itemImage, $itemDescription);
            $insert_cart->execute();
            $message[] = 'added to cart!';
        }

        $check_cart_numbers->close();
        if (isset($insert_cart)) {
            $insert_cart->close();
        }

        $_SESSION['messages'] = $message; // Store messages in the session
    }
    $conn->close();
}
?>
