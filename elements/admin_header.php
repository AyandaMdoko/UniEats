<?php
if (isset($_SESSION['message'])) {
   foreach ($_SESSION['message'] as $message) {
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
   // Clear the message after displaying it once
   unset($_SESSION['message']);
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">🍽 Uni Eats<span>Panel</span></a>

      <nav class="navbar">
         <a href="dashboard.php">home</a>
         <a href="products.php">products</a>
         <a href="placed_orders.php">orders</a>
         <a href="admin_accounts.php">admins</a>
         <a href="user_accounts.php">users</a>
         <a href="messages.php">messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $sql = "SELECT * FROM `administrators` WHERE Admin_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $admin_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($fetch_profile = mysqli_fetch_assoc($result)) {
                echo '<p>' . $fetch_profile['Admin_Num'] . '</p>';
            }
         ?>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
         </div>
         <a href="../elements/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>
