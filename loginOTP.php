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
    $sql = "UPDATE users SET OTP_hash = ?, OTP_expiry = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $otpHash, $expiry, $userId);
    $stmt->execute();
}

function sendOTP($email, $otp) {
    require __DIR__ . "/Mailer.php";
    $mail->setFrom('admin@unieats.co.za', 'UniEats');
    $mail->addAddress($email);
    $mail->Subject = "Your OTP Code";

     // Replace with your Base64-encoded image string
     $base64Image = 'data:images/Uni_Eats_new_background.jpg';

    // HTML Email Body
    $mail->isHTML(true);
    $mail->Body = '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd;">
        <div style="padding-bottom: 10px; border-bottom: 1px solid #e6e6e6;">
          <h1 style="font-size: 1.8rem; color: #222;"> UniEats</h1>
        </div>
        <div style="padding: 20px 0;">
            <h2 style="color: #333333; font-size: 24px;">OTP Password Assistance</h2>
            <p style="font-size: 16px; color: #555555;">To authenticate, please use the following 5 minute One Time Password (OTP):</p>
            <p style="font-size: 36px; font-weight: bold; color: #333333;">' . $otp . '</p>
            <p style="font-size: 16px; color: #555555;">
                Don\'t share this OTP with anyone. Our customer service is available should you need any assiatnce reply to us on this email account. 
            </p>
            <p style="font-size: 16px; color: #555555;">We hope to see you again soon.</p>
        </div>
        <div style="font-size: 12px; color: #999999; padding-top: 10px; border-top: 1px solid #e6e6e6;">
            © 2024 UniEats. All rights reserved.
        </div>
    </div>';

    // Attempt to send the email
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
    @include('elements/dbconnect.php');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user credentials
    $login = "SELECT Email_Add, id, Password_hash FROM users WHERE Email_Add = ? LIMIT 1";
    $stmt = $conn->prepare($login);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password_hash'])) {
        // Generate and store OTP
        $otp = generateOTP();
        storeOTP($conn, $user['id'], $otp);
        
        if (sendOTP($user['Email_Add'], $otp)) {
            $_SESSION['otp_user_id'] = $user['id'];
            $_SESSION['email'] = $user['Email_Add'];
            echo("<script>alert('Please check your email for your OTP'); window.location.href = 'validate_otp.php';</script>");
            exit();
        } else {
            $message[] = 'Failed to send OTP. Please try again later.';
        }
    } else {
        $message[] = 'Incorrect username or password!';
    }
}

// Include the login form page to display messages
include('login.php');
