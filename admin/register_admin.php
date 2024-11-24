<?php
include '../elements/dbconnect.php';
session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $Staff_Num= $_POST['staff_num'];
    $Staff_Num= filter_var($Staff_Num, FILTER_SANITIZE_STRING);
    $surname = $_POST['surname'];
    $surname = filter_var($surname, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Use FILTER_SANITIZE_EMAIL for email
    $position = $_POST['position'];
    $position = filter_var($position, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    // Check if email is already registered
    $sql_email = "SELECT * FROM `administrators` WHERE Email_Add = ?";
    $stmt_email = mysqli_prepare($conn, $sql_email);
    mysqli_stmt_bind_param($stmt_email, 's', $email);
    mysqli_stmt_execute($stmt_email);
    $result_email = mysqli_stmt_get_result($stmt_email);

    if (mysqli_num_rows($result_email) > 0) {
        $message[] = 'Email already exists!';
    } else {
        // Check if username is already taken
        $sql_name = "SELECT * FROM `administrators` WHERE Admin_Num = ?";
        $stmt_name = mysqli_prepare($conn, $sql_name);
        mysqli_stmt_bind_param($stmt_name, 's', $name);
        mysqli_stmt_execute($stmt_name);
        $result_name = mysqli_stmt_get_result($stmt_name);

        if (mysqli_num_rows($result_name) > 0) {
            $message[] = 'Username already exists!';
        } else {
            if ($pass != $cpass) {
                $message[] = 'Confirm password does not match!';
            } else {
                // Insert new admin into the database
                $sql_insert = "INSERT INTO `administrators` (Admin_Num, Surname, Name, Email_Add, Position, Password) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($conn, $sql_insert);
                mysqli_stmt_bind_param($stmt_insert, 'isssss', $Staff_Num, $surname, $name, $email, $position, $cpass);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $message[] = 'New admin registered!';
                } else {
                    $message[] = 'Registration failed, please try again!';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../images/fast-food.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- register admin section starts  -->

<section class="form-container">
    <form action="" method="POST">
        <h3>Register New Staff Member</h3>
        <input type="text" name="name" maxlength="20" required placeholder="Enter Staff Name" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="text" name="surname" maxlength="20" required placeholder="Enter Staff Surname" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="text" name="staff_num" maxlength="8" required placeholder="Enter Staff Number" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="email" name="email" required placeholder="Enter Staff email address" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <select id="myDropdownRegisterAdmin" name="position" class="box" required>
            <option value="" disabled selected hidden class="placeholder">POSITION</option>
            <option value="Manager">MANAGER</option>
            <option value="Staff member">STAFF MEMBER</option>
        </select>
        <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" maxlength="20" required placeholder="Confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Register Now" name="submit" class="btn">
    </form>
</section>

<!-- register admin section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>
</body>
</html>
