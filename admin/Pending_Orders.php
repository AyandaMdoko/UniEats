<?php

include 'readyToDel.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="icon" href="../images/fast-food.png">
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
  border-radius: 10px;
}

.table thead tr th{
  font-size: 1.5rem;
  font-weight: 600;
  letter-spacing: 0.35px;
  color: #222;
  opacity: 1;
  padding: 12PX;
  vertical-align: top;
  border: 1px solid #f1f1f1;

 
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
.table tbody tr td .drop-down{
  width: 170px;
  height: 50px;
  margin-top: 10px;
  font-size: 1.5rem;
  color: #222;
  font-weight: 600;
}
/* CSS to dim the row */
.dimmed {
        opacity: 0.5; /* Dims the row */
    }
    /* Disabled button styling */
    .disabled-btn {
        background-color: grey;
        cursor: not-allowed;
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

   <h1 class="heading">Pending Orders</h1>

   <table class="table">
      <thead>
         <tr>
            <th>Order Number</th>
            <th>Date of Order</th>
            <th>Time Placed</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Total Products</th>
            <th>Total Amount</th>
            <th> Delivery Status</th>
         </tr>
      </thead>
      <tbody>
         <?php
            $stmt = $conn->prepare("SELECT * FROM orders");
            $stmt->execute();
            $result = $stmt->get_result();
            $orders_shown = false; // To track if any orders are shown

            if ($result->num_rows > 0) {
               while ($fetch_orders = $result->fetch_assoc()) {
                  $delivery_status = $fetch_orders['Delivery_Status'];
                  $validate_status = $fetch_orders['validate_status'];
                  $row_class = ''; // Initialize without any class
                  $disabled = ''; // To disable dropdown and button

                  // If delivery status is "Out For Delivery", dim row and disable inputs
                  if ($delivery_status === 'Out For Delivery') {
                      $row_class = 'dimmed'; // Add dimmed class for dimming
                      $disabled = 'disabled'; // Disable dropdown and button
                  }

                  if ($validate_status === 'approved') {
                     $orders_shown = true;
         ?>
         <tr class="<?= $row_class; ?>"> <!-- Add the class to dim the row if applicable -->
            <td date-lable="Order Number"><?= $fetch_orders['order_num']; ?></td>
            <td date-lable="Date of Order"><?= $fetch_orders['Placed_On']; ?></td>
            <td date-lable="Time Placed"><?= $fetch_orders['time_placed']; ?></td>
            <td date-lable="Name"><?= $fetch_orders['Name']; ?> <?= $fetch_orders['Surname']; ?></td>
            <td date-lable="Phone Number"><?= $fetch_orders['Phone_Number']; ?></td>
            <td date-lable="Address"><?= $fetch_orders['Ress_Add']; ?></td>
            <td date-lable="Total Products"><?= $fetch_orders['Total_Products']; ?></td>
            <td date-lable="Total Amount">
                    <?php 
                        $subtotal = $fetch_orders['Total_Price'] - $fetch_orders['delivery_fee'];
                        echo "R " . number_format($subtotal, 2);
                    ?>
                </td> 
            <td date-lable="Delivery Status">
               <form action="" method="POST">
                  <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id']; ?>">
                  <select name="delivery_status" class="drop-down" <?= $disabled; ?>>
                     <option value="" selected disabled><?= $delivery_status; ?></option>
                     <option value="pending">Pending</option>
                     <option value="Out For Delivery">Out For Delivery</option>
                  </select>
                  <input type="submit" value="Update" class="btn" name="update_status" <?= $disabled; ?>>
               </form>
            </td>
         </tr>
         <?php
                  }
               }
            }

            // If no orders were displayed, show the message
            if (!$orders_shown) {
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