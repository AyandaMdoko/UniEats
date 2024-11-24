<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
  include('elements/dbconnect.php');
   
  $resulted = $_SESSION['otp_user_id'];
  $sql = "SELECT  * FROM `users` WHERE id = '$resulted'";
  $result = $conn->query($sql);

  if ($result) {
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $userName = $user['Name'];
    } else {
      echo ("<script>alert('User not found in the database')</script>");
    }
  } else {
     echo ("<script>alert('Database query failed')</script>". $conn->error);
  }
}
?>
<?php
if (isset($_POST['submit'])) {
  @include('dbconnect.php');
  //creating variables//
  $surname = $_POST['surname'];
  $EmailAddress = $_POST['email'];
  $PhoneNumber = $_POST['regNumber'];
  
  $sql = "UPDATE users SET Surname='$surname', Email_Add='$EmailAddress', Phone_Number='$PhoneNumber' WHERE id='$resulted'";
  $Bio = mysqli_query($conn, $sql);

  if ($Bio) {
    echo ("<script>alert('Profile updated successfully')</script>");
  } else {
    echo ("<script>alert('Profile update failed')</script>" . $conn->error);
  }
}
include 'elements/add_to_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="images/fast-food.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="SystemDesign.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>UniEats</title>
</head>
<body>
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->

<!--update profile section starts-->
<section class="form-container">
  <form action="" method="post">
    <h3>Update Profile</h3>
    <select id="myDropdown" name="myDropdown" class="box" readonly>
      <option value="" disabled selected hidden class="placeholder">TYPE OF USER</option>
      <option value="ADMIN" <?php if (isset($user) && $user['User_type'] == 'ADMIN') echo 'selected'; ?>>ADMIN</option>
      <option value="STAFF" <?php if (isset($user) && $user['User_type'] == 'STAFF') echo 'selected'; ?>>STAFF</option>
      <option value="STUDENT" <?php if (isset($user) && $user['User_type'] == 'STUDENT') echo 'selected'; ?>>STUDENT</option>
      <option value="VISITOR" <?php if (isset($user) && $user['User_type'] == 'VISITOR') echo 'selected'; ?>>VISITOR</option>
    </select>
    <input type="text" name="name" required placeholder="Enter your name" class="box" maxlength="30" value="<?= isset($user) ? $user['Name'] : ''; ?>" readonly>
    <input type="text" name="surname" id="regName" required placeholder="Enter your surname" class="box" maxlength="30" value="<?= isset($user) ? $user['Surname'] : ''; ?>">
    <input type="text" name="userNum" id="studentStaffNumber" required placeholder="Enter your Student/Staff number" class="box" maxlength="15" value="<?= isset($user) ? $user['User_Num'] : ''; ?>" readonly>
    <input type="email" name="email" required placeholder="Enter your email address" class="box" maxlength="50" value="<?= isset($user) ? $user['Email_Add'] : ''; ?>">
    <input type="text" name="regNumber" id="regNumber" required placeholder="Enter your phone number" class="box" maxlength="15" value="<?= isset($user) ? $user['Phone_Number'] : ''; ?>">
    <input type="submit" name="submit" value="Update now" class="btn">
  </form>
</section>
<!--update profile section ends-->

<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<script src="homePage.js"></script>
</body>
</html>


