<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
  include('elements/dbconnect.php');
   
  $resulted = $_SESSION['otp_user_id'];
  $sql = "SELECT  `Name` FROM `users` WHERE id = '$resulted'";
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <title>About Us</title>
  
</head>
<body>
<!--header section starts-->
<?php include 'elements/user_header.php'; ?>
<!--header section ends-->

<style>
  /* Modal styles */
  .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            text-align: center;
            position: relative;
        }

        
        .modal-content video {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }


        .modal-content .btn {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }
   
</style>

<div class="heading">
  <h3>about us</h3>
  <p><a href="homePage.html">home</a><span> / about</span></p>
</div>



<!--about section starts-->
 <section class="about">

  <div class="row">
    <div class="image">
      <img src="images/Uni eats logo.jpg" alt="">
    </div>

    <div class="content">
      <h3>Who are we?</h3>
      <p>
        Welcome to the NWU Cafeteria Online Ordering System! 
        We deliver delicious meals on campus to students, lecturers, and visitors. Our service is run by students, providing them with opportunities to earn extra income while studying. Enjoy convenient, on-campus meal delivery with just a few clicks!
      </p>
      <a href="menu.php" class="btn"> our menu </a>
    </div>
  </div>

 </section>
<!--about section starts-->
<!--Import Information section starts-->
 <section class="steps">

  <h1 class="title">important information </h1>
  <div class="box-container">
     <div class="box">
      <img src="images/purchasing.jpeg" alt="">
      <h3>cart process</h3>
      <p>To enjoy our delicious meals, orders start at just R50, with a delivery fee of R10. 
      Orders are delivered promptly right to your campus location.</p>
        <a href="#" class="btn" onclick="openModal('videoModal1')"> View Process </a>
     </div>

     <div class="box">
      <img src="images/login-and-register.jpg" alt="">
      <h3>Login/Register</h3>
      <p>Create an account or log in to access our services. After logging in, you can browse menus, place orders, and track deliveries.
      </p>
        <a href="#" class="btn" onclick="openModal('videoModal2')"> View Process </a>
     </div>

     <div class="box">
      <img src="images/help tutorial.jpeg" alt="">
      <h3>Help Tutorial</h3>
      <p>Need help using our system? Check out our tutorial for a quick and easy guide to get started. Click blow access the tutorial.
      </p>
        <a href="#" class="btn" onclick="openModal('videoModal3')"> View Process </a>
     </div>

     <!-- Video Modals -->
     <div id="videoModal1" class="modal">
        <div class="modal-content">
        <span class="close-button" onclick="closeModal('videoModal1', 'video1')">&times;</span>
            <h2>Cart Process </h2>
            <video id="video1" controls>
                <source src="video/Cart.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <a href="TermsAndCondtions/Cart Tutorial.pdf" target="_blank" class="btn">View PDF Tutorial</a>
        </div>
    </div>

<div id="videoModal2" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('videoModal2', 'video2')">&times;</span>
            <h2>Login/Registeration Process</h2>
            <video id="video2" controls>
                <source src="video/Login_Register_Forgot_Password.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <a href="TermsAndCondtions/Login and Register Tutorial.pdf" class="btn">View PDF Tutorial</a>
        </div>
    </div>

<div id="videoModal3" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('videoModal3', 'video3')">&times;</span>
            <h2>Help Tutorial </h2>
            <video id="video3" controls>
                <source src="video/Summary.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <a href="TermsAndCondtions/Tutorial Summary of The System.pdf" target="_blank" class="btn">View PDF Tutorial</a>
        </div>
    </div>
  </div>

 </section>
<!--Import Information section ends-->

<!--Customer Service Section Starts-->
<section class="customers">
  <h1 class="title">customer service</h1>
  <div class="swiper review-slider">

       <div class="swiper-wrapper">
           <div class="swiper-slide slide">
            <img src="images/nwu students.jpg" alt="">
            <h3>University Students</h3>
            <p>
              Our service is dedicated to registered university students. Simply log in with your student 
              number and credentials to access our system.</p>
              <a href="login.php" class="btn"> Login / Register </a>
           </div>

           <div class=" swiper-slide slide">
            <img src="images/NWU LECTURERS.jpeg" alt="">
            <h3>University Lecturers/Staff</h3>
            <p>
              Our service is dedicated to registered university lecturers.  Simply log in with 
              your staff number and credentials to access our system.</p>
              <a href="login.php" class="btn"> Login / Register </a>
           </div>

           <div class=" swiper-slide slide">
            <img src="images/Visit-us-campus-visit.png" alt="">
            <h3>University Vistors</h3>
            <p> Our service is dedicated to campus visitors. Simply log in with 
              your visitor credentials to access our system and enjoy our offerings.
              </p>
              <a href="login.php" class="btn"> Login / Register </a>
           </div>

           <div class=" swiper-slide slide">
            <img src="images/cafe admin.jpg" alt="">
            <h3>University Cafeteria</h3>
            <p> Our service is dedicated to university cafeteria staff. 
              Simply log in with your staff credentials 
              to manage and receive orders through our system.
              </p>
              <a href="admin/admin_login.php" id="opt-admin" class="btn"> Login / Register </a>
           </div>

           <div class="swiper-slide slide">
            <img src="images/student delivery.jpg" alt="">
            <h3>Student Delivery</h3>
            <p> Our service is dedicated to students who can deliver and apply to deliver food. 
              Log in with your student credentials to manage and receive delivery orders.
              </p>
              <a href="delivery/LoginDelivery.php" class="btn"> Login / Register </a>
           </div>
       </div>
       <div class="swiper-pagination"></div>
  </div>
</section>

<!--Customer Service Section ends-->

<!-- OTP Modal -->
<div id="otpModal" class="modal">
  <div class="modal-content">
   <div> <span class="close">&times;</span></div>
   <div style="display:flex; justify-content:center"><h2>Cafeteria Access</h2></div> 
   <div style=" display:flex; justify-content:center"> <input type="text" id="otpInput" maxlength="5" placeholder="Enter OTP"></div>
    <div style=" display:flex; justify-content:center"><button id="submitOtp" class="btn">Submit</button></div>
  </div>
</div>


<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<!--loader section starts-->
<!--<div class="loader">
  <img src="images/loader.gif" alt="">
</div>
  loader section ends-->

<!--javaScript for the slider-->
<script>
   // Function to open the specified modal
   function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'flex';
        }

        // Function to close the specified modal and stop the video
        function closeModal(modalId, videoId) {
            const modal = document.getElementById(modalId);
            const video = document.getElementById(videoId);
            modal.style.display = 'none';
            video.pause();
            video.currentTime = 0; // Reset the video to the beginning
        }

        // Close modal when clicking outside the modal content
        window.onclick = function(event) {
            const modals = ['videoModal1', 'videoModal2', 'videoModal3'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    closeModal(modalId, modal.querySelector('video').id);
                }
            });
        }
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".review-slider", {
      loop:true,
      grabCursor: true,
      spacebetween: 20,
      pagination: {
        el: ".swiper-pagination",
        clickable:true, 
      },
      breakpoints: {
        640:{
          slidesPerView:1,
        },
        768:{
          slidesPerView:2,
        },
        1024:{
          slidesPerView:3,
        },
      }
    });

    // Modal functionality
  const modal = document.getElementById("otpModal");
  const btn = document.getElementById("opt-admin");
  const span = document.getElementsByClassName("close")[0];
  const submitOtp = document.getElementById("submitOtp");
  const otpInput = document.getElementById("otpInput");

  const defaultOtp = "12345"; // Default OTP

  btn.onclick = function(event) {
    event.preventDefault();
    modal.style.display = "block";
  }

  span.onclick = function() {
    modal.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  submitOtp.onclick = function() {
    if (otpInput.value === defaultOtp) {
      window.location.href = "admin/admin_login.php"; // Redirect to admin dashboard
      otpInput.value = ""; // Clear the input field
    } else {
      alert("Incorrect OTP. Please contact UniEats HQ for assistance.");
      otpInput.value = ""; // Clear the input field
    }
  }
</script>



<script src="homePage.js"></script>


</body>
</html>