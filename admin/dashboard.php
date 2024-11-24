<?php
include '../elements/dbconnect.php';
session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../images/fast-food.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

    <h1 class="heading"> Cafeteria Management Dashboard</h1>

    <div class="box-container">

        <div class="box">
            <h3>Welcome! <?= $fetch_profile['Surname']; ?></h3>
            <p><img src="icons/welcome-back.png" alt=""></p>
            <a href="update_profile.php" class="btn">update profile</a>
        </div>
        
         <div class="box">
          <?php
             $sql_orders = "SELECT * FROM `orders` WHERE validate_status != 'approved'"; // only count non-approved orders
             $result_orders = mysqli_query($conn, $sql_orders);
             $numbers_of_orders = mysqli_num_rows($result_orders);
          ?>
            <h3>Incoming Orders</h3>
            <h3 id="incoming-orders-count"><?= $numbers_of_orders; ?></h3> <!-- Added id for dynamic update -->
            <p><img src="icons/return.png" alt=""></p>
            <a href="placed_orders.php" class="btn">view orders</a>
         </div>

        <div class="box">
          <?php
           $total_pendings = 0;
           $sql_pendings = "SELECT * FROM `orders` WHERE validate_status = 'approved'";
           $result_pendings = mysqli_query($conn, $sql_pendings);

           // Loop through the orders with 'approved' status and subtract 10 from each Total_Price
           while ($fetch_pendings = mysqli_fetch_assoc($result_pendings)) {
           $total_pendings += ($fetch_pendings['Total_Price'] - 10); // Subtract 10
            }
          ?>
           <h3>Pending Orders</h3>
           <h3><span>R</span><?= $total_pendings; ?>.00<span></span></h3>
           <p><img src="icons/time-management.png" alt=""></p>
           <a href="Pending_Orders.php" class="btn">view orders</a>
           </div>

         <div class="box">
            <?php
            $total_completes = 0;
            $sql_completes = "SELECT * FROM `orders` WHERE Delivery_Status = 'Out For Delivery'";
            $result_completes = mysqli_query($conn, $sql_completes);
            while ($fetch_completes = mysqli_fetch_assoc($result_completes)) {
                $total_completes += ($fetch_completes['Total_Price'] -10);
            }
            ?>
              <h3>Total Revenue</h3>
            <h3><span>R</span><?= $total_completes; ?>.00<span></span></h3>
            <p><img src="icons/salary.png" alt=""></p>
            <a href="Total_Revenue.php" class="btn">view revenue</a>
        </div>


        <div class="box">
            <?php
            $sql_products = "SELECT * FROM `menu`";
            $result_products = mysqli_query($conn, $sql_products);
            $numbers_of_products = mysqli_num_rows($result_products);
            ?>
            <h3>Add Products</h3>
            <h3><?= $numbers_of_products; ?></h3>
            <p><img src="icons/iftar.png" alt=""></p>
            <a href="products.php" class="btn">view products </a>
        </div>

        <div class="box">
            <?php
            $sql_users = "SELECT * FROM `users`";
            $result_users = mysqli_query($conn, $sql_users);
            $numbers_of_users = mysqli_num_rows($result_users);
            ?>
            <h3>Customers</h3>
            <h3><?= $numbers_of_users; ?></h3>
            <p><img src="icons/customer-loyalty.png" alt=""></p>
            <a href="user_accounts.php" class="btn">view customers</a>
        </div>

        <div class="box">
            <?php
            $sql_admins = "SELECT * FROM `administrators`";
            $result_admins = mysqli_query($conn, $sql_admins);
            $numbers_of_admins = mysqli_num_rows($result_admins);
            ?>
             <h3>Staff Members</h3>
            <h3><?= $numbers_of_admins; ?></h3>
            <p><img src="icons/staff.png" alt=""></p>
            <a href="admin_accounts.php" class="btn">view staff members</a>
        </div>

        <div class="box">
            <?php
            $sql_messages = "SELECT * FROM `messages`";
            $result_messages = mysqli_query($conn, $sql_messages);
            $numbers_of_messages = mysqli_num_rows($result_messages);
            ?>
              <h3>Feedback</h3>
            <h3><?= $numbers_of_messages; ?></h3>
            <p><img src="icons/feedback.png" alt=""></p>
            <a href="messages.php" class="btn">view feedback</a>
        </div>

    </div>

</section>

<!-- admin dashboard section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>
<script src="homePage.js"></script>

</body>
</html>
