<?php

if (isset($_POST['submit'])) {
    // Connect to the database
    include('elements/dbconnect.php');

    // Variables
    $type = $_POST['type'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phonNum = $_POST['phoneNum'];
    $userNum = $_POST['userNum'];
    $password_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkEmail = "SELECT * FROM `users` WHERE `Email_Add` = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists.')</script>";
    } else {
        // Insert user data into the database
        $register = "INSERT INTO `users`(`User_Num`, `User_type`, `Name`, `Surname`, `Email_Add`, `Phone_Number`, `Password_hash`)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($register);
        $stmt->bind_param("sssssss", $userNum, $type, $name, $surname, $email, $phonNum, $password_hash);

        if ($stmt->execute()) {
            // Generate activation token
            $activation_token = bin2hex(random_bytes(16));
            $activation_token_hash = hash('sha256', $activation_token);

            // Update the user with the activation token hash
            $updateToken = "UPDATE `users` SET `Acc_activation_hash` = ? WHERE `Email_Add` = ?";
            $stmt = $conn->prepare($updateToken);
            $stmt->bind_param("ss", $activation_token_hash, $email);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Send activation email
                require __DIR__ . "/Mailer.php";

                $mail->setFrom('admin@unieats.co.za', 'UniEats');
                $mail->addAddress($email);
                $mail->Subject = "Email Verification";
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd;">
                    <div style="padding-bottom: 10px; border-bottom: 1px solid #e6e6e6;">
                        <h1 style="font-size: 1.8rem; color: #222;"> UniEats</h1>
                    </div>
                    <div style="padding: 20px 0;">
                        <h2 style="color: #333333; font-size: 24px;">Welcome to Uni Eats, ' . $name . '!</h2>
                        <p style="font-size: 16px; color: #555555;">
                            Thank you for registering with us. We’re excited to have you on board! To complete your registration, please verify your email by clicking the link below.
                        </p>
                        <p>
                            <a href="https://unieats.co.za/activate_account.php?token=' . $activation_token . '" style="font-size: 18px; color: #1a73e8; text-decoration: none;">
                                Verify My Email
                            </a>
                        </p>
                        <p style="font-size: 16px; color: #555555;">
                            If you did not create this account, please disregard this email.
                        </p>
                        <p style="font-size: 16px; color: #555555;">
                            We look forward to serving you the best experience with Uni Eats!
                        </p>
                    </div>
                    <div style="font-size: 12px; color: #999999; padding-top: 10px; border-top: 1px solid #e6e6e6;">
                        © 2024 Uni Eats. All rights reserved.
                    </div>
                </div>';

                try {
                    $mail->send();
                    echo "<script>alert('Signup successful. Please check your email inbox to verify your email.')</script>";
                    header('Location: index.php');
                } catch (Exception $e) {
                    echo "<script>alert('Message could not be sent. Mailer error: {$mail->ErrorInfo}')</script>";
                }
            }
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

<!--Reigster Section starts-->

<section class="form-container">
  <form action="" method="POST">
    <h3>Register Now</h3>
    <select id="myDropdownRegister" name="type" class="box">
      <option value="" disabled selected hidden class="placeholder">TYPE OF USER</option>
      <option name= "staff" value="Staff" id="staffReg">STAFF</option>
      <option name= "student" value="Student" id="studentReg">STUDENT</option>
      <option name= "visitor" value="Visitor" id="visitorReg">VISITOR</option> 
    </select>
    <input type="text" name="name" id="regName" required placeholder="Enter your name" 
    class="box" maxlength="30" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="text" name="surname" id="regName" required placeholder="Enter your surname" 
    class="box" maxlength="30" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="text" name="userNum" id="studentStaffNumber" maxlength="8" required placeholder="Enter your Student/Staff number" 
    class="box" maxlength="15" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="email" name="email" id="regEmail" required placeholder="Enter your email address" 
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

  <div class="checkB">
    <input type="checkbox" class="check" id="termsAgreed" required>
    <a href="TermsAndCondtions/UniEats Terms and Conditions.pdf" target="_blank">I agree with the terms and conditions</a>
  </div>

  <p id="passwordError" style="color: red;"></p>
    <input type="submit" name="submit" value="Register now" class="btn">
    <p>Already have an account? <a href="login.php">Login now!</a></p>
  </form>


</section>


<!--Register Section ends-->



<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->


<!--loader section starts-->
<!--<div class="loader">
  <img src="images/loader.gif" alt="">
</div>
  loader section ends-->





<script src="homePage.js"></script>

<!--JAVA SCRIPT SHOW PASSWORD STARTS-->

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