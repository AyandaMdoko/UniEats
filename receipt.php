<?php
session_start();
require 'vendor/autoload.php'; // Include the autoload file from Composer

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['otp_user_id'])) {
    include('elements/dbconnect.php');

    $resulted = $_SESSION['otp_user_id'];

    // Prepare and execute the SQL query to get the user's details
    $sql = "SELECT `Name`, `Email_Add` FROM `users` WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("i", $resulted);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userName = $user['Name'];
        $userEmail = $user['Email_Add']; // Corrected to match the database field
    } else {
        echo ("<script>alert('User not found in the database')</script>");
        exit;
    }
    $stmt->close();
}

if (isset($_POST['make_payment'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $surname = filter_var($_POST['surname'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
    $delivery_fee = $_POST['delivery_fee'];
    $vat_amount = $_POST['vat_amount'];

     // Sanitize and retrieve the meal customization input
    $meal_customization = isset($_POST['meal_customerization']) ? filter_var($_POST['meal_customerization'], FILTER_SANITIZE_STRING) : '';

    // Generate unique order number
    $order_num = "#ui" . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    $check_cart = $conn->prepare("SELECT * FROM cart WHERE User_id = ?");
    $check_cart->bind_param("i", $resulted);
    $check_cart->execute();
    $check_cart_result = $check_cart->get_result();

    if ($check_cart_result->num_rows > 0) {
        if ($address == '') {
            echo ("<script>alert('Please add your address!'); window.history.back();</script>");
            exit;
        } else {
            $insert_order = $conn->prepare("INSERT INTO orders (User_id, Name, Surname, Phone_Number, Email_Add, Payment_Method, Ress_Add, Total_Products, Total_Price, vat_amount, delivery_fee, order_num, Meal_customerization) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->bind_param("isssssssisiss", $resulted, $name, $surname, $number, $email, $method, $address, $total_products, $total_price, $vat_amount, $delivery_fee, $order_num, $meal_customization);
            $insert_order->execute();

            $delete_cart = $conn->prepare("DELETE FROM cart WHERE User_id = ?");
            $delete_cart->bind_param("i", $resulted);
            $delete_cart->execute();

            // Prepare the HTML content for the PDF
            $imagePath = 'images/Uni eats logo.jpg';
            $imageData = base64_encode(file_get_contents($imagePath));
            $src = 'data:image/jpg;base64,' . $imageData;

            $html = '
<style>
    body {
        font-family: Arial, sans-serif;
        color: #333;
    }
    h2 {
        font-size: 2rem;
        color: #2C3E50;
        text-align: center;
    }
    h3 {
        font-size: 2rem;
        color: #16A085;
        text-align: center;
    }
    p {
        font-size: 1.4rem;
        margin: 5px 0;
    }
    span {
        font-weight: bold;
    }
    .receipt-details {
        margin-top: 20px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
    .receipt-details p {
        margin-bottom: 10px;
    }
    .receipt-details span {
        color: #16A085;
    }
    hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 20px 0;
    }
</style>
<h2>Uni Eats</h2>
<img style="width: 15.5rem; margin-left: 250px;" src="' . $src . '" alt="Uni Eats Logo">
<h3>Order Receipt</h3>
<p>Order number: <span>' . htmlspecialchars($order_num) . '</span></p>
<div class="receipt-details">
    <p>Placed on: <span>' . date('Y-m-d H:i') . '</span></p>
    <p>Name: <span>' . htmlspecialchars($name) . '</span></p>
    <p>Surname: <span>' . htmlspecialchars($surname) . '</span></p>
    <p>Cell number: <span>' . htmlspecialchars($number) . '</span></p>
    <p>Email: <span>' . htmlspecialchars($email) . '</span></p>
    <p>Address: <span>' . htmlspecialchars($address) . '</span></p>
    <p>Your orders: <span>' . htmlspecialchars($total_products) . '</span></p>
    <p>Payment method: <span>' . htmlspecialchars($method) . '</span></p>
    <p>Grand total: <span>R' . htmlspecialchars($total_price) . '.00</span></p>
    <p>Delivery Fee: <span>R' . htmlspecialchars($delivery_fee) . '.00</span></p>
    <p>Vat Amount: <span> vat inclusive </span></p>
</div>
<hr>';

            // Generate the PDF
            $options = new Options();
            $options->set('isRemoteEnabled', true); // Enable loading of external assets
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Save the PDF to a file
            $pdfOutput = $dompdf->output();
            $filePath = 'order_receipt.pdf';
            file_put_contents($filePath, $pdfOutput);

            // Send the PDF via email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = "mail.unieats.co.za"; // Or the SMTP server name provided by cPanel
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS if using SSL
                $mail->Port = 587; // Use 465 if using SSL
                $mail->Username = "admin@unieats.co.za";
                $mail->Password = "Stan1542@";

                // Recipients
                $mail->setFrom('admin@unieats.co.za', 'UniEats');
                $mail->addAddress($userEmail, $userName);

                // Attachments
                $mail->addAttachment($filePath); // Attach the PDF

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Order Receipt';
                $mail->Body = '
                   <div style="font-family: Arial, sans-serif; color: #333333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd;">
                   <div style="text-align: center; padding-bottom: 20px;">
                    <h1 style="font-size: 1.8rem; color: #222;"> UniEats</h1>
                   </div>
    
                 <div style="background-color: #222; padding: 10px 20px; text-align: center; font-size: 18px; color: #fff;">
                 <strong>Order accepted by UniEats at North-West University Cafeteria</strong>
                 
                 </div>
    
                 <div style="padding: 20px 0;">
                 <h2 style="font-size: 20px; color: #333333;">Your Receipt Details</h2>
                <p style="margin: 5px 0; font-size: 16px;">
                <strong style="color: #222;">Order:</strong> ' . htmlspecialchars($order_num) . '<br>
                <strong style="color: #222;">Date:</strong> ' . date('Y-m-d H:i') . '<br>
                <strong style="color: #222;">Your contact details:</strong> ' . htmlspecialchars($email) . '<br>
                <strong style="color: #222;">Delivery from:</strong> North-West University Cafeteria<br>
                <strong style="color: #222;">Delivery to:</strong> ' . htmlspecialchars($address) . '
               </p>
               </div>
    
               <div style="border-top: 1px solid #dddddd; padding-top: 20px;">
               <h3 style="font-size: 18px; color: #333333;">Order Summary</h3>
           <p style="font-size: 16px;">
            1 x ' . htmlspecialchars($total_products) . '<br>
            <strong>Original Price:</strong> R' . htmlspecialchars($total_price) . '.00
        </p>
    </div>
    
    <div style="border-top: 1px solid #dddddd; padding-top: 20px;">
        <p style="font-size: 16px;">
            <strong style="color: #222;">Sub Total:</strong> R' . htmlspecialchars($total_price) . '.00<br>
            <strong style="color: #222;">Delivery Fee:</strong> R' . htmlspecialchars($delivery_fee) . '.00<br>
            <strong style="color: #222;">Total:</strong> R' . htmlspecialchars($total_price + $delivery_fee) . '.00<br>
            <strong style="color: #222;">VAT Amount:</strong> vat inclusive<br>
            <strong style="color: #222;">Amount Paid:</strong> R' . htmlspecialchars($total_price + $delivery_fee) . '.00<br>
            <strong style="color: #222;">Card Purchase Complete:</strong> -R' . htmlspecialchars($total_price + $delivery_fee) . '.00
        </p>
    </div>

        <div style="padding-top: 20px;">
        <p style="font-size: 16px; color: #333333;">
            Thank you for ordering with us! We can not wait to deliver your items. To track your order in real-time, open the UniEats app or go to the Orders section in the menu. 
        </p>
       </div>
    </div>';

                $mail->send();
                echo("<script>alert('Your order was placed successfully. Please check your email for the receipt!'); window.location.href = 'orders.php';</script>");
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Clean up the temporary PDF file
            unlink($filePath);

            // Optionally, you can redirect or exit after email is sent
            exit;
        }
    } else {
        echo ("<script>alert('Your cart is empty'); window.history.back();</script>");
        exit;
    }
}
?>
