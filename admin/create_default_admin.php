<?php
include '../elements/dbconnect.php';

// Define default credentials
$default_username = '38601990';
$default_password = sha1('12345');  // Default password is '12345'
$default_position = 'Manager';  // Default position

// Check if the default admin already exists
$sql_check = "SELECT * FROM `administrators` WHERE Admin_Num = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, 's', $default_username);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if(mysqli_num_rows($result_check) == 0) {
    // Default admin does not exist, so insert it
    $sql_insert = "INSERT INTO `administrators` (Admin_Num, Password, Position) VALUES (?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, 'sss', $default_username, $default_password, $default_position);
    if(mysqli_stmt_execute($stmt_insert)) {
        echo "Default admin created successfully.";
    } else {
        echo "Error creating default admin: " . mysqli_error($conn);
    }
} else {
    echo "Default admin already exists.";
}

mysqli_close($conn);
?>
