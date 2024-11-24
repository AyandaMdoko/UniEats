<?php
session_start();
$feedbackSent = false; // Track if feedback was sent
$userLoggedIn = isset($_SESSION['otp_user_id']); // Check if user is logged in

if ($userLoggedIn) {
    include('elements/dbconnect.php');

    $resulted = $_SESSION['otp_user_id'];
    $sql = "SELECT `Name` FROM `users` WHERE id = '$resulted'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userName = $user['Name'];
        } else {
            echo ("<script>alert('User not found in the database')</script>");
        }
    } else {
        echo ("<script>alert('Database query failed')</script>" . $conn->error);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    if ($userLoggedIn) { // Only process feedback if the user is logged in
        $Name = $_POST['name'];
        $Surname = $_POST['number'];
        $Email = $_POST['email'];
        $MessageRes = $_POST['message'];

        $sql = "INSERT INTO `messages`(`Name`, `Email_Add`, `Phone_Number`, `Message`) VALUES ('$Name','$Surname','$Email','$MessageRes')";
        $msg = mysqli_query($conn, $sql);

        if ($msg) {
            $feedbackSent = true; // Set feedback sent to true if query was successful
        } else {
            echo ("<script>alert('Failed to send feedback. Please try again.')</script>");
        }
    } else {
        echo "<script>alert('Please log in to send feedback.');</script>";
    }
}
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

<!-- header section starts  -->
<?php include 'elements/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
  <h3>Contact Us</h3>
  <p><a href="index.php">Home</a><span> / Contact</span></p>
</div>

<!-- Contact section starts -->
<section class="contact">
  <div class="row">
    <div class="image">
      <img src="images/contact us.jpg" alt="Contact Us">
    </div>
    <form action="" method="post">
      <h3>Give Us Feedback!</h3>
      <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
      <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required onkeypress="if(this.value.length == 10) return false;">
      <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
      <textarea name="message" class="box" required placeholder="Enter your response (500 words)" cols="30" rows="10"></textarea>
      <input type="submit" value="Send Message" name="send" class="btn">
    </form>
  </div>
</section>
<!-- Contact section ends -->

<!-- Footer section starts -->
<?php include 'elements/footer.php'; ?>
<!-- Footer section ends -->

<script src="homePage.js"></script>

<?php if ($feedbackSent): ?>
<script>
  alert("Thank you! Your feedback has been successfully sent.");
</script>
<?php endif; ?>

</body>
</html>