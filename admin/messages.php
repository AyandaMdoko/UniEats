<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM `messages` WHERE Message_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header('location:messages.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="../images/fast-food.png">
   <title>Messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- messages section starts  -->

<section class="messages">

   <h1 class="heading">Messages</h1>

   <div class="box-container">

   <?php
      $stmt = $conn->prepare("SELECT * FROM `messages`");
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
         while ($fetch_messages = $result->fetch_assoc()) {
   ?>
   <div class="box">
      <p> Name : <span><?= $fetch_messages['Name']; ?></span> </p>
      <p> Phone Number : <span><?= $fetch_messages['Email_Add']; ?></span> </p>
      <p> Email Adress : <span><?= $fetch_messages['Phone_Number']; ?></span> </p>
      <p> Message : <span><?= $fetch_messages['Message']; ?></span> </p>
      <a href="messages.php?delete=<?= $fetch_messages['Message_id']; ?>" class="delete-btn" onclick="return confirm('delete this message?');">delete</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">You have no messages</p>';
      }
      $stmt->close();
   ?>

   </div>

</section>

<!-- messages section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>

</body>
</html>
