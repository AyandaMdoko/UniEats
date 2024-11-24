<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);
$mysqli = require __DIR__ . "/elements/dbconnect.php";

$sql = "SELECT * FROM users WHERE Reset_token_hash = ?";
$stmt = $conn->prepare($sql);  // Ensure you use the correct variable for the connection
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    echo ("<script>alert('Token not found'); window.location.href = 'reset_password.php';</script>");
    exit();
}

if (strtotime($user["Reset_token_expires_at"]) <= time()) {
    echo ("<script>alert('Token has expired'); window.location.href = 'reset_password.php';</script>");
    exit();
}

// Validate password
$password = $_POST["pass"];
$password_confirm = $_POST["password"];

if (strlen($password) < 8) {  
    echo ("<script>alert('Password must be at least 8 characters long.'); window.location.href = 'reset_password.php';</script>");
    exit();
}

if (!preg_match("/[a-z]/i", $password)) {
    echo ("<script>alert('Password must contain at least one letter'); window.location.href = 'reset_password.php';</script>");
    exit();
}

if (!preg_match("/[0-9]/", $password)) {
    echo ("<script>alert('Password must contain at least one number'); window.location.href = 'reset_password.php';</script>");
    exit();
}

if ($password !== $password_confirm) {
    echo ("<script>alert('Passwords must match'); window.location.href = 'reset_password.php';</script>");
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$update = "UPDATE users SET Password_hash = ?, Reset_token_hash = NULL, Reset_token_expires_at = NULL WHERE id = ?";
$stmt = $conn->prepare($update);  // Ensure you use the correct variable for the connection
$stmt->bind_param("ss", $password_hash, $user["id"]);
$stmt->execute();

// Show alert and redirect to login page
echo ("<script>alert('Your password has been successfully reset.'); window.location.href = 'login.php';</script>");
exit();

?>
