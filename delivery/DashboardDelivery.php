<?php
session_start();
include('../elements/dbconnect.php');

// Ensure user is logged in
if(isset($_SESSION['otp_user_id'])) {
    $userId = $_SESSION['otp_user_id'];

    $sql = "SELECT `Name`, `Surname` FROM `delivery_admin` WHERE del_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['del_id'] = $userId; // Set the user session variable
            $userName = $user['Name'];
            $surname = $user['Surname'];
        } else {
            echo ("<script>alert('User not found in the database')</script>");
        }
    } else {
        echo ("<script>alert('Database query failed')</script>". $conn->error);
    }
    $stmt->close();
} 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../images/fast-food.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../admin/admin_style.css">
</head>
<body>

<?php include '../elements/delivery.header.php' ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

    <h1 class="heading"> Student Delivery Dashboard</h1>

    <div class="box-container">

    <div class="box">
            <!-- Check if $userName is set before echoing -->
            <h3>Welcome! <?= isset($userName, $surname) ? htmlspecialchars($userName . ' ' . $surname, ENT_QUOTES, 'UTF-8') : 'Guest'; ?></h3>
            <p><img src="../admin/icons/welcome-back.png" alt=""></p>
            <a href="DeliveryUpdateInfo.php" class="btn">update profile</a>
        </div>


        <div class="box">
          <?php
          // Modify the query to exclude orders that are already accepted
          $sql_orders = "SELECT * FROM `orders` WHERE Delivery_Status = 'Out For Delivery' AND Accept_to_deliver != 'Accepted'"; 
          $result_orders = mysqli_query($conn, $sql_orders);
          $numbers_of_orders = mysqli_num_rows($result_orders);
           ?>
          <h3>Incoming Orders</h3>
          <h3 id="incoming-orders-count"><?= $numbers_of_orders; ?></h3> 
          <p><img src="../admin/icons/return.png" alt=""></p>
          <a href="IncomingOrders.php" class="btn">view orders</a>
       </div>

        <div class="box">
        <?php
// Assuming that $userId is set correctly to the delivery person's ID
        $total_pendings = 0;
        $sql_pendings = "SELECT * FROM `orders` WHERE Accept_to_deliver = 'Accepted' AND del_id = ?";
        $stmt_pendings = $conn->prepare($sql_pendings);
        $stmt_pendings->bind_param("i", $userId);
        $stmt_pendings->execute();
        $result_pendings = $stmt_pendings->get_result();

        while ($fetch_pendings = $result_pendings->fetch_assoc()) {
        $total_pendings += $fetch_pendings['delivery_fee'];
        }

        $stmt_pendings->close();
        ?>
        <h3>Pending Orders</h3>
        <h3><span>R</span><?= $total_pendings; ?>.00<span></span></h3>
        <p><img src="../admin/icons/time-management.png" alt=""></p>
        <a href="Orders_Pending.php" class="btn">view orders</a>
        </div>

        <div class="box">
            <?php
            $total_completes = 0;
            $sql_completes = "SELECT * FROM `orders` WHERE Delivery_Status = 'Completed' AND del_id = ?";
            $stmt_completes = $conn->prepare($sql_completes);
            $stmt_completes->bind_param("i", $userId);
            $stmt_completes->execute();
            $result_completes = $stmt_completes->get_result();
            while ($fetch_completes =  $result_completes->fetch_assoc()) {

                $total_completes += $fetch_completes['delivery_fee'];
            }
            ?>
              <h3>Total Income</h3>
            <h3><span>R</span><?= $total_completes; ?>.00<span></span></h3>
            <p><img src="../admin/icons/salary.png" alt=""></p>
            <a href="Total_Income.php" class="btn">view revenue</a>
        </div>


    </div>

</section>

<!-- admin dashboard section ends -->

<!-- custom js file link  -->
<script src="../admin/admin.js"></script>
<script src="../homePage.js"></script>

</body>
</html>
