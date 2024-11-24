<?php
if (isset($_POST['submit'])) {
    // Connect to the database
    include('../elements/dbconnect.php');

    // Retrieve and validate form inputs
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $phonNum = isset($_POST['phoneNum']) ? trim($_POST['phoneNum']) : null;
    $Student_Numb = isset($_POST['student_num']) ? trim($_POST['student_num']) : null;
    $password_hash = isset($_POST['pass']) ? password_hash($_POST['pass'], PASSWORD_DEFAULT) : null;

    // Check if any required fields are missing
    if (!$name || !$surname || !$email || !$phonNum || !$Student_Numb || !$password_hash) {
        echo "<script>alert('All fields are required. Please fill in all the details.')</script>";
        exit;
    }

    // Check if the email already exists
    $checkEmail = "SELECT * FROM `delivery_admin` WHERE `Email_Address` = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Validate email format
    if (!preg_match("/^[0-9]{8}@mynwu\.ac\.za$/", $email)) {
        echo "<script>
                alert('Invalid email format. Please use an 8-digit number followed by @mynwu.ac.za.');
                window.location.href = 'RegisterDelivery.php';
              </script>";
        exit;
    }

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists.')</script>";
    } else {
        // Insert user data into the database
        $register = "INSERT INTO `delivery_admin`(`Name`, `Surname`, `stu_Num`, `Email_Address`, `Cell_Number`, `Password_Hash`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($register);
        $stmt->bind_param("ssssss", $name, $surname, $Student_Numb, $email, $phonNum, $password_hash);

        if ($stmt->execute()) {
            echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const notification = document.createElement('div');
                    notification.className = 'notification';
                    notification.innerHTML = `
                        <div class='notification_body'>
                            <img src='assets/check-circle.svg' alt='Success' class='notification_icon'>
                            You Have Been Registered! 🚀
                        </div>
                        <div class='notification_progress'></div>
                    `;
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.style.opacity = '1';
                        notification.style.visibility = 'visible';
                    }, 100); 

                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.visibility = 'hidden';
                        window.location.href = 'LoginDelivery.php'; 
                    }, 5000);
                });
            </script>
            <style>
                .notification {
                    position: fixed;
                    top: 95%; /* Center vertically */
                    left: 50%; /* Center horizontally */
                    transform: translate(-50%, -50%); /* Adjust position */
                    background-color: #4CAF50;
                    color: white;
                    padding: 20px; /* Increased padding for a bigger size */
                    border-radius: 8px; /* Slightly larger border radius */
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
                    opacity: 0;
                    visibility: hidden;
                    transition: opacity 0.5s, visibility 0.5s;
                    z-index: 1000;
                    width: 300px; /* Set a specific width */
                    text-align: center; /* Center text */
                }
                .notification_body {
                    font-size: 1.6rem;
                    display: flex;
                    align-items: center;
                    justify-content: center; /* Center content horizontally */
                }
                .notification_icon {
                    margin-right: 10px;
                }
                .notification_progress {
                    height: 5px;
                    background-color: white;
                    animation: progress 3.5s linear forwards;
                }
                @keyframes progress { 
                    to { transform: scaleX(1); }
                }
            </style>";
        } else {
            echo "<script>alert('Error during registration.')</script>";
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
   <title>UniEats Delivery Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="delivery.css">

</head>
<body>



<!-- admin login form section starts  -->

<section class="form-container">

<form action="" method="POST"  >
    <h3>Register Now</h3>

    <input type="text" name="name" id="regName" required placeholder="Enter your name" 
    class="box" maxlength="30" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="text" name="surname" id="regName" required placeholder="Enter your surname" 
    class="box" maxlength="30" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="text" name="student_num" id="studentStaffNumber" maxlength="8" required placeholder="Enter Your Student Number" 
    class="box" maxlength="15" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="email" name="email" id="regEmail" required placeholder="45896398@mynwu.ac.za school email address" 
    class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="text" name="phoneNum" id="regNumber" maxlength="13" required placeholder="Enter your phone number" 
    class="box" maxlength="15" oninput="this.value = this.value.replace(/\s/g, '')">
    <div class="password-input">
      <input type="password" name="pass" id="regPass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <div class="restictions">
       
       <div class="circle-container">
        <div class="circle" id="length-circle"></div>
        <span class="requirement-label">At least 8 characters</span>
       </div>
       <div class="circle-container">
        <div class="circle" id="uppercase-circle"></div>
        <span class="requirement-label">Uppercase letter</span>
       </div>
       <div class="circle-container">
        <div class="circle" id="lowercase-circle"></div>
        <span class="requirement-label">Lowercase letter</span>
       </div>
      <div class="circle-container">
        <div class="circle" id="number-circle"></div>
        <span class="requirement-label">Numerical character</span>
      </div>
      <div class="circle-container">
        <div class="circle" id="special-char-circle"></div>
        <span class="requirement-label">Special character</span>
       </div>
      </div>
     </div>

  
    <input type="password" name="pass" id="regConfPass" required placeholder="Confirm password" 
    class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
     <div class="checkB">
      <input type="checkbox" class="check" id="show-password" onclick="togglePasswordVisibility()">
      <label for="show-password">Show Password</label>
    
     </div>
     <p id="passwordError" style="color: red;"></p>
      <div style="display: flex;">
      <p>Have an account? <a style="text-decoration: none; color: #fff; font-size:1.8rem; " href="LoginDelivery.php">Login</a></p>
      </div>
  
      <input type="submit" value="Register now" name="submit" class="btn">
   </form>

</section>

<!-- admin login form section ends -->

<!--JAVA SCRIPT SHOW PASSWORD STARTS-->
<script src="register.js"></script>
<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('regPass');
    const confirmPassword = document.getElementById('regConfPass')
    const showPasswordCheckbox = document.getElementById('show-password');
    
    if (showPasswordCheckbox.checked) {
        passwordInput.type = 'text';
        confirmPassword.type = 'text';
    } else {
        passwordInput.type = 'password';
        confirmPassword.type = 'password';
    }
  }
  </script>




<!--JAVA SCRIPT SHOW PASSWORD ENDS-->

</body>
</html>