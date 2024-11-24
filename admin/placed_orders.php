<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

$message = []; // Initialize the message array

if (isset($_POST['approve_order'])) {
    $order_id = $_POST['order_id'];

    // Update the delivery status to "approved"
    $update_status = $conn->prepare("UPDATE orders SET validate_status = 'approved' WHERE order_id = ?");
    $update_status->bind_param('i', $order_id);
    $update_status->execute();

  // Initialize a response array
  $response = [];

  // Check if the query was successful
  if ($update_status->affected_rows > 0) {
      $response['status'] = 'success';
      $response['message'] = 'Order approved successfully';
  } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to approve the order. Please try again.';
  }

  $update_status->close();

  // Return JSON response
  echo json_encode($response);
  exit;
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
.dim-row {
    background-color: #d3d3d3;  /* Light gray background */
    opacity: 0.6;  /* Lower the opacity to make the row appear dimmed */
    pointer-events: none;  /* Disable interactions with the row */
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

   <h1 class="heading">Placed Orders</h1>

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
            <th>Action</th>
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
            <tr class="<?= $fetch_orders['validate_status'] == 'approved' ? 'dim-row' : ''; ?>">
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
                <td date-lable="Action">
                <form class="approve-form" action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id']; ?>">
                        <button type="button" class="btn approve-btn" 
                                data-order-id="<?= $fetch_orders['order_id']; ?>"
                                <?= $fetch_orders['validate_status'] == 'approved' ? 'disabled' : ''; ?>>Approve</button>
                    </form>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    $('.approve-btn').click(function() {
        let button = $(this);
        let orderId = button.data('order-id');
        let row = button.closest('tr');

        $.ajax({
            url: 'placed_orders.php',
            type: 'POST',
            data: { approve_order: true, order_id: orderId },
            success: function(response) {
                response = JSON.parse(response); // Parse JSON response

                if (response.status === 'success') {
                    button.prop('disabled', true);
                    row.addClass('dim-row');
                    showMessage(response.message, 'success');
                    
                    // Decrement the Incoming Orders count dynamically
                    let currentCount = parseInt($('#incoming-orders-count').text());
                    $('#incoming-orders-count').text(currentCount - 1);
                } else {
                    showMessage(response.message, 'error');
                }
            },
            error: function() {
                showMessage('An error occurred while processing the request.', 'error');
            }
        });
    });
});


// Function to display messages dynamically
function showMessage(message, type) {
    let messageBox = `
        <div class="message ${type}">
            <span>${message}</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    `;
    $('body').prepend(messageBox);  // Insert message at the top of the body
}
</script>

</body>
</html>