<?php
include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['del_id'];

if (!isset($admin_id)) {
    header('location:DeliveryLogin.php');
    exit;
}

$message = []; // Initialize the message array
if (isset($_POST['Complete_order'])) {
  $order_id = intval($_POST['order_id']); // The order that is being completed
  $delivery_status = $_POST['delivery_status'];

  // Update the order in the orders table to mark it as completed
  $update = "UPDATE orders SET Delivery_Status = 'Completed' WHERE order_id = ?";
  $stmt = $conn->prepare($update);

  if (!$stmt) {
      $message[] = "Prepare statement failed: " . $conn->error;
  } else {
      // Bind parameter (order_id)
      $stmt->bind_param("i", $order_id);

      if ($stmt->execute()) {
          $message[] = "Order marked as completed!";
      } else {
          $message[] = "Failed to complete the order: " . $stmt->error;
      }

      $stmt->close();
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="../images/fast-food.png">
   
   <title>Placed Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../admin/admin_style.css">

</head>
<body>

<?php include '../elements/delivery.header.php' ?>

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
.table tbody tr td {
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
.message.success {
    background-color: rgb(88, 233, 69);  /* Success message color */
}
.message.error {
    background-color: red;    /* Error message color */
}


</style>

<section class="placed-orders">
   <h1 class="heading">Orders to Be Delivered</h1>
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
            <th>Delivery Amount</th>
            <th>Delivery Status</th>
         </tr>
      </thead>
      <tbody>
      <?php
         // Fetch orders where the specific delivery person has accepted the order
         $stmt = $conn->prepare("SELECT * FROM orders WHERE Accept_to_deliver = 'Accepted' AND del_id = ?");
         $stmt->bind_param("i", $admin_id);
         $stmt->execute();
         $result = $stmt->get_result();
         $orders_shown = false; // To track if any orders are shown

         if ($result->num_rows > 0) {
             while ($fetch_orders = $result->fetch_assoc()) {
                 $orders_shown = true; // Mark that we've shown an order
                 $delivery_status = $fetch_orders['Delivery_Status'];
                 $row_class = '';
                 $disabled = '';

                 // If the order is completed, dim the row and disable the button
                 if ($delivery_status === 'Completed') {
                     $row_class = 'dimmed';  // Apply dimming class
                     $disabled = 'disabled'; // Disable the button
                 }
      ?>
            <tr class="<?= $row_class; ?>">
                <td><?= htmlspecialchars($fetch_orders['order_num']); ?></td>
                <td><?= htmlspecialchars($fetch_orders['Placed_On']); ?></td>
                <td><?= htmlspecialchars($fetch_orders['time_placed']); ?></td>
                <td><?= htmlspecialchars($fetch_orders['Name'] . ' ' . $fetch_orders['Surname']); ?></td>
                <td><?= htmlspecialchars($fetch_orders['Phone_Number']); ?></td>
                <td><?= htmlspecialchars($fetch_orders['Ress_Add']); ?></td>
                <td><?= htmlspecialchars($fetch_orders['Total_Products']); ?></td>
                <td>R <?= htmlspecialchars($fetch_orders['delivery_fee']); ?>.00</td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_orders['order_id']); ?>">
                        <select name="delivery_status" class="drop-down" <?= $disabled; ?>>
                           <option value="" selected disabled><?= htmlspecialchars($delivery_status); ?></option>
                           <option value="Completed">Completed</option>
                        </select>
                        <button type="submit" name="Complete_order" class="btn approve-btn" <?= $disabled; ?>>Complete</button>
                    </form>
                </td>
            </tr>
      <?php
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
<script src="../admin/admin.js"></script>



</body>
</html>
<?php

