<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="icon" href="../images/fast-food.png">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- placed orders section starts  -->


<style>
  .heading{
  font-size: 40px;
  text-align: center;
  color: #222;
  margin-bottom: 40px;
}
.table{
  width: 100%;
  border-collapse: collapse;
}
.table thead{
  background-color: rgb(88, 233, 69);
}

.table thead tr th{
  font-size: 1.5rem;
  font-weight: 600;
  letter-spacing: 0.35px;
  color: #222;
  opacity: 1;
  padding: 12PX;
  vertical-align: top;
  border: 1px solid #dee2e685;
}
.table tbody tr td{
  font-size: 14px;
  letter-spacing: 0.35px;
  font-weight: normal;
  color: #f1f1f1;
  background-color: #3c3f44;
  padding: 8px;
  text-align: center;
  border: 1px solid #dee2e685;
}
@media (max-width: 768px) {
  .table thead{
    display: none;
  }
  .table, .table tbody, .table tr, .table td{
    display: block;
    width: 100%;
  }
  .table tr{
    margin-bottom: 15px;
  }
  .table tbody tr td{
    text-align: right;
    padding-left: 50%;
    position: relative;
  }
  .table td::before{
    content: attr(date-lable);
    position: absolute;
    left: 0;
    width: 50%;
    padding-left: 15px;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
  }
}


</style>

<section class="placed-orders">

   <h1 class="heading">Total Revenue</h1>

   <table class="table">
      <thead>
         <tr>
            <th>Order Number</th>
            <th>Date of Order</th>
            <th>Time Placed</th>
            <th>Total Products</th>
            <th>Sub total (VAT Excl)</th>
            <th>VAT Amount</th>
            <th>Total Amount (VAT Incl)</th>
            
         </tr>
      </thead>
      <tbody>
         <?php
            $stmt = $conn->prepare("SELECT * FROM orders");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
               while ($fetch_orders = $result->fetch_assoc()) {
         ?>
      <tr>
    <!-- Order Details Columns -->
    <td date-lable="Order Number"><?= $fetch_orders['order_num']; ?></td>
    <td date-lable="Date of Order"><?= $fetch_orders['Placed_On']; ?></td>
    <td date-lable="Time Placed"><?= $fetch_orders['time_placed']; ?></td>
    <td date-lable="Total Products"><?= $fetch_orders['Total_Products']; ?></td>
    
    <!-- Base Amount (excluding VAT) -->
    <td date-lable="Sub Total">
        <?php 
            // Total price including VAT
            $total_price = $fetch_orders['Total_Price']- $fetch_orders['delivery_fee']; // Delivery fee deduction if applicable; 
            $vat_rate = 0.15; // 15% VAT rate

            // Calculate the base amount (price without VAT)
            $base_amount = $total_price / (1 + $vat_rate);

            // Display the base amount
            echo "R " . number_format($base_amount, 2); 
        ?>
    </td>
    
    <!-- VAT Amount Column -->
    <td date-lable="VAT Amount">
        <?php 
            // Calculate the VAT amount
            $vat_amount = $total_price - $base_amount;

            // Display the VAT amount
            echo "R " . number_format($vat_amount, 2); 
        ?>
    </td>
    
    <!-- Total Amount (VAT Inclusive) -->
    <td date-lable="Total Amount (VAT Incl)">
        <span>R <?= number_format($total_price, 2); ?></span>
    </td>
</tr>



         <?php
               }
            } else {
               echo '<tr><td colspan="12" class="empty">No orders placed yet!</td></tr>';
            }

            $stmt->close();
         ?>
      </tbody>
   </table>

</section>

<!-- placed orders section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>

</body>
</html>