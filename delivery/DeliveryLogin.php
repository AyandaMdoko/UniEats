<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

function generateOTP() {
    return rand(100000, 999999);
}

function storeOTP($conn, $userId, $otp) {
    $otpHash = hash('sha256', $otp);
    $expiry = date("Y-m-d H:i:s", time() + 300); // OTP is valid for 5 minutes
    $sql = "UPDATE delivery_admin SET OTP_Hash = ?, OTP_Expiry = ? WHERE del_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $otpHash, $expiry, $userId);
    $stmt->execute();
}

function sendOTP($email, $otp) {
    include "../Mailer.php";
    $mail->setFrom('admin@unieats.co.za', 'UniEats');
    $mail->addAddress($email);
    $mail->Subject = "Your OTP Code";
    $mail->Body = "Your OTP code is $otp. It is valid for 5 minutes.";
    
    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo); // Log the error
        return false;
    }
}

$message = []; // Initialize the message array

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    @include('../elements/dbconnect.php');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user credentials
    $login = "SELECT Email_Address, del_id, Password_Hash FROM delivery_admin WHERE Email_Address = ? LIMIT 1";
    $stmt = $conn->prepare($login);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password_Hash'])) {
        // Generate and store OTP
        $otp = generateOTP();
        storeOTP($conn, $user['del_id'], $otp);
        
        if (sendOTP($user['Email_Address'], $otp)) {
            $_SESSION['otp_user_id'] = $user['del_id'];
            $_SESSION['email'] = $user['Email_Address'];
            header('Location: verifyOTP.php');
            exit();
        } else {
            $message[] = 'Failed to send OTP. Please try again later.';
        }
    } else {
        $message[] = 'Incorrect username or password!';
    }
}

// Include the login form page to display messages
include('LoginDelivery.php');
