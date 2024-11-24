<?php
include('dbconnect.php');

// Initialize session variables
$user_Num = isset($_SESSION['del_id']) ? $_SESSION['del_id'] : null;
$UserId = isset($_SESSION['otp_user_id']) ? $_SESSION['otp_user_id'] : null;

if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $msg) {
        echo '
        <div class="message">
        <span>' . $msg . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
    unset($_SESSION['messages']); // Clear messages after displaying
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">🍽 Uni Eats<span>Delivery</span></a>

      <nav class="navbar">
         <a href="DashboardDelivery.php">home</a>
         <a href="IncomingOrders.php">orders</a>
         <a href="Orders_Pending.php">pending orders</a>
         <a href="Total_Income.php">Income</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $sql = "SELECT * FROM `delivery_admin` WHERE del_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $UserId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($fetch_profile = mysqli_fetch_assoc($result)) {
                echo '<p>' . $fetch_profile['stu_Num'] . '</p>';
            }
         ?>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
         </div>
         <a href="../elements/delivery_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>
