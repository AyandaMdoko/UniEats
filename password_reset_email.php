<?php

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash('sha256', $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/elements/dbconnect.php";

$update= "UPDATE `users` SET `Reset_token_hash`= ?,`Reset_token_expires_at`= ? WHERE Email_Add = ?";

$stmt = $conn->prepare($update);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($conn->affected_rows) {

    $mail = require __DIR__ . "/Mailer.php";

    $mail->setFrom('admin@unieats.co.za', 'UniEats');
    $mail->addAddress($email);
    $mail->Subject = " Unieats Password Reset";
    $mail->Body = '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd;">
        <div style="padding-bottom: 10px; border-bottom: 1px solid #e6e6e6;">
             <h1 style="font-size: 1.8rem; color: #222;"> UniEats</h1>
        </div>
        <div style="padding: 20px 0;">
            <h2 style="color: #333333; font-size: 24px;">Password Reset Request</h2>
            <p style="font-size: 16px; color: #555555;">
                You requested a password reset for your Unieats account. Please click the link below to reset your password.
            </p>
            <p>
                <a href="https://unieats.co.za/reset_password.php?token=' . $token . '" style="font-size: 18px; color: #1a73e8; text-decoration: none;">
                    Reset Password
                </a>
            </p>
            <p style="font-size: 16px; color: #555555;">
                If you did not request a password reset, please ignore this email. The link will expire in 30 minutes.
            </p>
        </div>
        <div style="font-size: 12px; color: #999999; padding-top: 10px; border-top: 1px solid #e6e6e6;">
            © 2024 Uni Eats. All rights reserved.
        </div>
    </div>';
   
    try {

        $mail->send();

    } catch (Exception $e) {

        echo ("script>alert('Message could not be sent.' Mailer error: {$mail->ErrorInfo}</scritp>");

    }

}
echo ("<script>alert('Message sent, please check your inbox')</script>");

include('forgotPass.php')

?>