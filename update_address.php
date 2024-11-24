<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
  include('elements/dbconnect.php');
   
  $resulted = $_SESSION['otp_user_id'];
  $sql = "SELECT `Name` FROM `users` WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $resulted);
  $stmt->execute();
  $result = $stmt->get_result();

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
  $stmt->close();
}

if(isset($_POST['submit'])){
  $user_type = $_POST['user_type'];
  $address = "";

  if($user_type == 'student' || $user_type == 'visitor') {
    $address = $_POST['student_location'];
  } elseif ($user_type == 'University_Staff') {
    $address = $_POST['lecturer_location'] . ', Office: ' . $_POST['lecturer_building'];
  }

  $address = filter_var($address, FILTER_SANITIZE_STRING);

  $update_address = $conn->prepare("UPDATE `users` SET Ress_Add = ? WHERE id = ?");
  $update_address->bind_param("si", $address, $resulted);
  $update_address->execute();

  if ($update_address->affected_rows > 0) {
    echo "<script>alert('Address saved successfully!');</script>";
  } else {
    echo "<script>alert('Failed to save address.');</script>";
  }

  $update_address->close();
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
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->

<!--update section starts here -->
<section class="form-container">
  <form action="" method="post">
    <h3>Your address</h3>
   
    <select name="user_type" id="user-select" class="box" required>
      <option value="" disabled selected>Type Of User</option>
      <option value="student">Student</option>
      <option value="University_Staff">University Staff</option>
      <option value="visitor">Visitor</option>
    </select>

    <select name="student_location" id="student-location" class="box hidden">
      <option value="" disabled selected>Select Building Location</option>
      <option value="CLUSTER 8">CLUSTER 8</option>
      <option value="CLUSTER 9">CLUSTER 9</option>
      <option value="CLUSTER 10">CLUSTER 10</option>
      <option value="CLUSTER 11">CLUSTER 11</option>
      <option value="CLUSTER 12">CLUSTER 12</option>
      <option value="CLUSTER 13">CLUSTER 13</option>
      <option value="Postgrad Residence">Postgrad Residence</option>
      <option value="Nelson Mandela Residence">Nelson Mandela Residence</option>
      <option value="Sedibeng Residence">Sedibeng Residence</option>
      <option value="James Moroka Residence">James Moroka Residence</option>
      <option value="Lost City Residence">Lost City Residence</option>
      <option value="Hopeville Residence">Hopeville Residence</option>
      <option value="Khayelitsha Residence">Khayelitsha Residence</option>
      <option value="MBADA Residence">MBADA Residence</option>
      <option value="SOL PLAATJIE Residence">SOL PLAATJIE Residence</option>
      <option value="Great Hall">Great Hall</option>
      <option value="Sports Field">Sports Field</option>
      <option value="library">library</option>
      <option value="The Stone">The Stone</option>
      <option value="Boss Mike">Boss Mike</option>
    </select>

    <select name="lecturer_location" id="lecturer-location" class="box hidden">
      <option value="" disabled selected>Select Building Location</option>
      <option value="A-1">A-1</option>
      <option value="A-2">A-2</option>
      <option value="A-3">A-3</option>
      <option value="A-4">A-4</option>
      <option value="A-5">A-5</option>
      <option value="A-6">A-6</option>
      <option value="A-7">A-7</option>
      <option value="A-8">A-8</option>
      <option value="A-9">A-9</option>
      <option value="A-10">A-10</option>
      <option value="A-11">A-11</option>
      <option value="A-12">A-12</option>
    </select>

    <input type="text" name="lecturer_building" id="lecturer-building" class="box hidden" placeholder="Enter office number e.g G10">

    <input type="submit" value="save address" name="submit" class="btn">
  </form>
</section>
<!--update section ends here -->

<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<script src="homePage.js"></script>

<!--JAVA SCRIPT FOR THE SELECTORS STARTS-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const userSelect = document.getElementById('user-select');
      const studentLocation = document.getElementById('student-location');
      const lecturerLocation = document.getElementById('lecturer-location');
      const lecturerBuilding = document.getElementById('lecturer-building');

      userSelect.addEventListener('change', function() {
          const selectedValue = this.value;

          // Hide all elements initially
          studentLocation.classList.add('hidden');
          lecturerLocation.classList.add('hidden');
          lecturerBuilding.classList.add('hidden');

          // Show elements based on the selected value
          if (selectedValue === 'student' || selectedValue === 'visitor') {
              studentLocation.classList.remove('hidden');
          } else if (selectedValue === 'University_Staff') {
              lecturerLocation.classList.remove('hidden');
              lecturerBuilding.classList.remove('hidden');
          }
      });
  });
</script>
<!--JAVA SCRIPT FOR THE SELECTORS ENDS-->

</body>
</html>
