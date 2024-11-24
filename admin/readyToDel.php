<?php

include '../elements/dbconnect.php';
require __DIR__ . "/../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_POST['update_status'])) {

    $order_id = $_POST['order_id'];
    $delivery_status = $_POST['delivery_status'];

    $stmt = $conn->prepare("UPDATE orders SET Delivery_Status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $delivery_status, $order_id);
    $stmt->execute();
    $stmt->close();

    $message = []; // Initialize as an array

    if ($delivery_status == "Out For Delivery") {
     
        // Fetch all delivery personnel emails
        $deliveryPersonnelEmails = [];
        $query = "SELECT Email_Address FROM delivery_admin";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $deliveryPersonnelEmails[] = $row['Email_Address'];
        }

        // Fetch user_id based on order_id
        $userIdQuery = $conn->prepare("SELECT user_id FROM orders WHERE order_id = ?");
        $userIdQuery->bind_param("i", $order_id);
        $userIdQuery->execute();
        $userResult = $userIdQuery->get_result();

        $user_id = null;
        if ($userRow = $userResult->fetch_assoc()) {
            $user_id = $userRow['user_id'];
        }
        $userIdQuery->close();

        // Fetch the user’s email based on user_id
        $userEmail = '';
        if ($user_id) {
            $userEmailQuery = $conn->prepare("SELECT Email_Add FROM users WHERE id = ?");
            $userEmailQuery->bind_param("i", $user_id);
            $userEmailQuery->execute();
            $userEmailResult = $userEmailQuery->get_result();
            if ($emailRow = $userEmailResult->fetch_assoc()) {
                $userEmail = $emailRow['Email_Add'];
            }
            $userEmailQuery->close();
        }


         // Set up PHPMailer
         $mail = new PHPMailer(true);

        try {
            
         $mail->isSMTP();
         $mail->SMTPAuth = true;
         $mail->Host = "mail.unieats.co.za"; // Or the SMTP server name provided by cPanel
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS if using SSL
         $mail->Port = 587; // Use 465 if using SSL
         $mail->Username = "admin@unieats.co.za";
         $mail->Password = "Stan1542@";
         $mail->isHTML(true);
         $mail->CharSet = 'UTF-8';

         $orderNum = $conn->prepare("SELECT order_num FROM orders WHERE order_id = ?");
         $orderNum->bind_param("i", $order_id); // Use "i" for integer if $order_id is an integer
         $orderNum->execute();
         $result = $orderNum->get_result();
         
         if ($row = $result->fetch_assoc()) {
             $orderNumber = $row['order_num'];
         }
         $orderNum->close();

            // Notify all delivery personnel
            foreach ($deliveryPersonnelEmails as $email) {
                $mail->clearAddresses();
                $mail->addAddress($email);
               
                $mail->setFrom('admin@unieats.co.za', 'UniEats');
                $mail->Subject = "New Delivery Opportunity";
                $mail->Body ='
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd;">
                <div style="padding-bottom: 10px; border-bottom: 1px solid #e6e6e6;">
                    <h1 style="font-size: 1.8rem; color: #222;">UniEats</h1>
                </div>
                <div style="padding: 20px 0;">
                    <h2 style="color: #333333; font-size: 24px;">New Delivery Request</h2>
                    <p style="font-size: 16px; color: #555555;">
                        Order ' . $orderNumber . ' is ready for delivery. Please pick it up.
                    </p>
                    <p style="text-align: center; margin: 30px 0;">
                       <a href="https://unieats.co.za/delivery/DeliveryLogin.php" 
                           style="background-color: #1a73e8; 
                                  color: white; 
                                  padding: 12px 24px; 
                                  text-decoration: none; 
                                  border-radius: 4px; 
                                  display: inline-block;
                                  font-size: 16px;">
                            Log in to Accept/Decline the delivery.
                        </a>
                    </p>
                    <p style="font-size: 16px; color: #555555;">
                        Please respond promptly to ensure timely delivery to our customers.
                    </p>
                </div>
                <div style="font-size: 12px; color: #999999; padding-top: 10px; border-top: 1px solid #e6e6e6;">
                    © 2024 UniEats. All rights reserved.
                </div>
            </div>';

                $mail->send();
            }

            // Notify the user
            $mail->clearAddresses();
            $mail->addAddress($userEmail);
            $mail->setFrom('admin@unieats.co.za', 'UniEats');
            $mail->Subject = "Your Order is Out for Delivery!";
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd;">
                <div style="padding-bottom: 10px; border-bottom: 1px solid #e6e6e6;">
                    <h1 style="font-size: 1.8rem; color: #222;">UniEats</h1>
                </div>
                <div style="padding: 20px 0;">
                    <h2 style="color: #333333; font-size: 24px;">Your Order is Out for Delivery!</h2>
                    <p style="font-size: 16px; color: #555555;">
                        Order ' . $orderNumber . ' is now out for delivery. You can log in to track your order status and chat with the delivery personnel.
                    </p>
                    <p style="text-align: center; margin: 30px 0;">
                        <a href="https://unieats.co.za/login.php" 
                           style="background-color: #1a73e8; 
                                  color: white; 
                                  padding: 12px 24px; 
                                  text-decoration: none; 
                                  border-radius: 4px; 
                                  display: inline-block;
                                  font-size: 16px;">
                            Log in to Track and Chat
                        </a>
                    </p>
                    <p style="font-size: 16px; color: #555555;">
                        Thank you for choosing UniEats!
                    </p>
                </div>
                <div style="font-size: 12px; color: #999999; padding-top: 10px; border-top: 1px solid #e6e6e6;">
                    © 2024 UniEats. All rights reserved.
                </div>
            </div>';

            $mail->send();

            $message[] = 'Order Status Updated and notification sent to delivery personnel and user!';
        } catch (Exception $e) {
            $message[] = "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        $message[] = 'Order Status Updated!!';
    }

    $_SESSION['message'] = $message;
    header('Location: Pending_Orders.php');
    exit;
}

?>
