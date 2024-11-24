<?php
include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['del_id'];

$sql = "SELECT `Name` FROM `delivery_admin` WHERE del_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userName = $user['Name'];
   
} else {
    echo "<script>alert('User not found');</script>";
}
$stmt->close();

if (!isset($admin_id)) {
    header('location:DeliveryLogin.php');
    exit;
}

$message = []; // Initialize the message array

if (isset($_POST['accept_order'])) {
    $order_id = intval($_POST['order_id']); // The order that is being accepted

    // Update the order in the `orders` table to mark it as accepted
    $update = "UPDATE orders SET del_id = ?, Accept_to_deliver = 'Accepted' WHERE order_id = ?";
    $stmt = $conn->prepare($update);

    if (!$stmt) {
        $message[] = "Prepare statement failed: " . $conn->error;
    } else {
        // Bind parameters (del_id = $admin_id, order_id = $order_id)
        $stmt->bind_param("ii", $admin_id, $order_id);

        if ($stmt->execute()) {
            $message[] = "Order accepted successfully!";
        } else {
            $message[] = "Failed to accept the order: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    $message[] = "Order not found.";
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
   <link rel="stylesheet" href="../chat.css">

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
   <h1 class="heading">Delivery Orders</h1>

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
      <tbody id="order-table-body">
    <?php
    // Fetch orders with Delivery_Status 'Out For Delivery'
    $stmt = $conn->prepare("SELECT * FROM orders WHERE Delivery_Status = 'Out For Delivery'");
    $stmt->execute();
    $result = $stmt->get_result();
    $orders_shown = false;

    if ($result->num_rows > 0) {
        while ($fetch_orders = $result->fetch_assoc()) {
            $orders_shown = true;
            $accepted_order = $fetch_orders['Accept_to_deliver'];
            $row_class = '';
            $disabled = '';

            // If the order is accepted, add the dimmed class and disable buttons
            if ($accepted_order === 'Accepted') {
                $row_class = 'dimmed';
                $disabled = 'disabled';
                
                
            }
    ?>
            <tr class="<?= $row_class; ?>" id="order-row-<?= $fetch_orders['order_id']; ?>">
                <td date-lable="Order Number"><?= $fetch_orders['order_num']; ?></td>
                <td date-lable="Date of Order"><?= $fetch_orders['Placed_On']; ?></td>
                <td date-lable="Time Placed"><?= $fetch_orders['time_placed']; ?></td>
                <td date-lable="Name"><?= $fetch_orders['Name']; ?> <?= $fetch_orders['Surname']; ?></td>
                <td date-lable="Phone Number"><?= $fetch_orders['Phone_Number']; ?></td>
                <td date-lable="Address"><?= $fetch_orders['Ress_Add']; ?></td>
                <td date-lable="Total Products"><?= $fetch_orders['Total_Products']; ?></td>
                <td date-lable="Delivery Fee">R <?= $fetch_orders['delivery_fee']; ?>.00</td>
                <td date-lable="Action">
                    <form class="approve-form" action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id']; ?>">
                        <button type="submit" name="accept_order" <?= $disabled; ?> class="btn approve-btn">Accept</button>
                        <button type="button" class="btn decline-btn" <?= $disabled; ?> data-order-id="<?= $fetch_orders['order_id']; ?>" onclick="confirmDecline(<?= $fetch_orders['order_id']; ?>)">Decline</button>
                    </form>
                </td>
            </tr>
    <?php
    

        

        }
    }

    if (!$orders_shown) {
        echo '<tr><td colspan="12" class="empty">No orders placed yet!</td></tr>';
    }

    $stmt->close();
    ?>
</tbody>
   </table>
</section>
<?php if ($accepted_order === 'Accepted') : ?>
    <div id="chat-icon" onclick="toggleChat()">
    <i class="fas fa-comments"></i>
    <span id="alert-icon" class="notification-badge" style="display: none;">!</span> <!-- Red notification badge -->
</div>
    <div id="chat-container" class="collapsed">
        <div id="chat-header" onclick="toggleChat()">
            <h2>UniEats Chat</h2>
            <span id="toggle-arrow">&#x25BC;</span> <!-- Down arrow -->
        </div>

        <div id="chat-messages"></div>

        <form id="chat-form" onsubmit="sendMessage(event)">
            <input type="text" id="message-input" placeholder="Type your message..." required />
            <input type="hidden" id="sender-type" value="<?= htmlspecialchars($userName); ?>" /> <!-- User's name -->
            <button type="submit">Send</button>
        </form>
    </div>
<?php endif; ?>


<!-- placed orders section ends -->

<!-- custom js file link  -->
<script src="../admin/admin.js"></script>
<script src="../chat.js"></script>

<script>
// Handle Decline button
function confirmDecline(orderId) {
    if (confirm("Are you sure you want to decline?")) {
        var row = document.getElementById("order-row-" + orderId);
        if (row) {
            row.remove();
        }
        checkNoOrders();
    }
}

// Handle Accept button
// Handle Accept button
function confirmAccept(orderId) {
    if (confirm("Are you sure you want to accept?")) {
        // Send data to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "IncomingOrders.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            console.log(xhr.responseText); // Log the response from the server
            if (xhr.status === 200) {
                // Dim the row and disable buttons if success
                var row = document.getElementById("order-row-" + orderId);
                if (row) {
                    row.classList.add('dim-row');  // Dim the row
                    disableButtons(row);
                }
            } else {
                alert("Error: " + xhr.statusText); // Alert on error
                console.error(xhr.responseText); // Log the error response
            }
        };
        xhr.onerror = function () {
            console.error("Error sending request"); // Log the error
        };
        xhr.send("accept_order=true&order_id=" + orderId); // Send accept_order parameter
    }
}

function disableButtons(row) {
    var buttons = row.querySelectorAll('button');
    buttons.forEach(function(button) {
        button.disabled = true;
    });
}

function checkNoOrders() {
    var tableBody = document.getElementById("order-table-body");
    if (tableBody.rows.length === 0) {
        var noOrdersRow = document.createElement('tr');
        noOrdersRow.innerHTML = '<td colspan="12" class="empty">No orders placed yet!</td>';
        tableBody.appendChild(noOrdersRow);
    }
}

// Long polling function for live updates
function longPolling() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "check_updates.php", true);  // check_updates.php will return the updated orders
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Parse and update the table with the new data (depending on the returned format)
            var updatedOrders = JSON.parse(xhr.responseText);
            // Logic to update the table rows based on the updatedOrders data

            setTimeout(longPolling, 5000);  // Continue polling
        }
    };
    xhr.send();
}

// Start polling after page load
longPolling();
</script>

</body>
</html>
<?php

