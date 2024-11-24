<?php
session_start();
include('../elements/dbconnect.php');

// Ensure user is logged in
if (isset($_SESSION['otp_user_id'])) {
    $userId = $_SESSION['otp_user_id'];

    $sql = "SELECT `Name`, `Surname`, `Email_Address`, `Cell_Number` FROM `delivery_admin` WHERE del_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['del_id'] = $userId;
        $userName = $user['Name'];
        $surname = $user['Surname'];
        $email = $user['Email_Address'];
        $phone = $user['Cell_Number'];
    } else {
        echo ("<script>alert('User not found in the database')</script>");
        exit();
    }
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['Name'], filter: FILTER_SANITIZE_STRING);
    $surname = filter_var($_POST['Surname'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['Cell_Number'], FILTER_SANITIZE_STRING);
    $admin_id = $_SESSION['del_id'];

    // Update Name, Surname, Phone Number
    if (!empty($name) && !empty($surname) && !empty($phone)) {
        $update_details = $conn->prepare("UPDATE `delivery_admin` SET Name = ?, Surname = ?, Cell_Number = ? WHERE del_id = ?");
        $update_details->bind_param("sssi", $name, $surname, $phone, $admin_id);
        $update_details->execute();
        echo "<script>alert('Details updated successfully!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="icon" href="../images/fast-food.png">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile Update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../admin/admin_style.css">

</head>
<body>

<?php include '../elements/delivery.header.php' ?>


<!-- admin profile update section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="Name" maxlength="20" class="box"  oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['Name']; ?>">
      <input type="text" name="Surname" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['Surname']; ?>">
      <input type="text" name="Cell_Number" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['Cell_Number']; ?>">
      <input type="text" name="" maxlength="20" class="box" readonly oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['stu_Num']; ?>">
      <input type="text" name="" maxlength="20" class="box" readonly oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['Email_Address']; ?>">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>

</section>

<!-- admin profile update section ends -->

<!-- custom js file link  -->
<script src="../admin/admin.js"></script>

</body>
</html>



