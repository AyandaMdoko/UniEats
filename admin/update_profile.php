<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $select_name = $conn->prepare("SELECT * FROM `administrators` WHERE Admin_Num = ?");
        $select_name->bind_param("s", $name);
        $select_name->execute();
        $result = $select_name->get_result();

        if ($result->num_rows > 0) {
            $message[] = 'Username already taken!';
        } else {
            $update_name = $conn->prepare("UPDATE `administrators` SET Admin_Num = ? WHERE Admin_id = ?");
            $update_name->bind_param("si", $name, $admin_id);
            $update_name->execute();
            $message[] = 'Username updated successfully!';
        }
    }

    $empty_pass = sha1('');
    $select_old_pass = $conn->prepare("SELECT Password FROM `administrators` WHERE Admin_id = ?");
    $select_old_pass->bind_param("i", $admin_id);
    $select_old_pass->execute();
    $result = $select_old_pass->get_result();
    $fetch_prev_pass = $result->fetch_assoc();
    $prev_pass = $fetch_prev_pass['Password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    $select_position = $conn->prepare("SELECT Position FROM `administrators` WHERE Admin_id = ?");

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $message[] = 'Old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'Confirm password not matched!';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `administrators` SET Password = ? WHERE Admin_id = ?");
                $update_pass->bind_param("si", $confirm_pass, $admin_id);
                $update_pass->execute();
                $message[] = 'Password updated successfully!';
            } else {
                $message[] = 'Please enter a new password!';
            }
        }
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
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- admin profile update section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="name" maxlength="20" class="box" readonly oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['Admin_Num']; ?>">
      <input type="text" name="name" maxlength="20" class="box" readonly oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['Position']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>

</section>

<!-- admin profile update section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>

</body>
</html>
