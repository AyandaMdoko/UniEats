<?php
include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['del_id'];

if (!isset($admin_id)) {
    header('location:DeliveryLogin.php');
    exit;
}

$order_id = null;
$order_num = null;
$delivery_fee = null;
$error_message = "";

// Check if the form is submitted with an order_id
$order_id = null;
$order_num = null;
$delivery_fee = null;
$error_message = "";

// Check if the popup form is submitted
if (isset($_POST['Claim_Amount']) && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Update the order's claim_order status to "Claimed"
    $update_query = "UPDATE orders SET claim_order = 'Claimed' WHERE order_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        // Refresh the page to reflect changes
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error_message = "Failed to update claim status.";
    }
    $stmt->close();
}

// Check if the form is submitted with an order_id to open the popup form
if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Fetch the order number and delivery fee from the database
    $query = "SELECT order_num, delivery_fee FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $order_num = $row['order_num'];
        $delivery_fee = $row['delivery_fee'];
    } else {
        $error_message = "Order not found.";
    }

    $stmt->close();
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
.popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
      .popup-form input, .popup-form select {
          width: 100%;
          margin-bottom: 10px;
          padding: 8px;
          font-size: 1.9rem;
          border: 1px solid #34495e;
          border-radius: 4px;
      }
      .popup-form button {
          background: #28a745;
          color: #fff;
          border: none;
          padding: 10px 15px;
          border-radius: 4px;
          cursor: pointer;
      }
      .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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
    <h1 class="heading">Total Income</h1>
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
                <th>Claim Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $conn->prepare("SELECT * FROM orders WHERE Accept_to_deliver = 'Accepted' AND del_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($fetch_orders = $result->fetch_assoc()) {
            $claim_order = $fetch_orders['claim_order'];
            $row_class = $claim_order === 'Claimed' ? 'dimmed' : '';
            $button_disabled = $claim_order === 'Claimed' ? 'disabled' : '';
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
                <td><?= htmlspecialchars($fetch_orders['Delivery_Status']); ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id']; ?>">
                        <button type="submit" class="btn claim-btn" <?= $button_disabled; ?>>Claim</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        $stmt->close();
        ?>
        </tbody>
    </table>
</section>

<!-- Pop-up form for claiming amount -->
<!-- Pop-up form for claiming amount -->
<!-- Pop-up form for claiming amount (displayed if an order is selected) -->
 <!-- Pop-up form for claiming amount (displayed if an order is selected) -->
 <?php if ($order_id && $order_num && $delivery_fee !== null): ?>
    <div class="overlay"></div>
    <div class="popup-form" id="claimPopup">
        <form action="" method="POST">
            <h1>UniEats Delivery Cash Out</h1>
            <input type="hidden" name="order_id" value="<?= $order_id; ?>">
            <input type="text" name="account_holder_name" placeholder="Account Holder Name" required>
            <input type="text" name="order_number" value="<?= $order_num; ?>" readonly required>
            <input type="text" name="account_type" placeholder="Account Type" required>
            <input type="text" name="account_number" placeholder="Account Number" required>
            <input type="text" name="amount" value="R <?= $delivery_fee; ?>.00" readonly required>
            <select name="bank" class="drop-down"  required value = "Select Type of Bank">
                 <option value="" disabled selected>Select Bank</option>
                 <option value="">ABSA</option>
                 <option value="">Capitec</option>
                 <option value="">FNB</option>
                 <option value="">Nedbank</option>
                 <option value="">Standard Bank</option>
                 <option value="">Other</option>
             </select>
            <button type="submit" class="btn" name="Claim_Amount">Claim</button>
        </form>
    </div>
    <script>
        document.querySelector('.overlay').style.display = 'block';
        document.getElementById('claimPopup').style.display = 'block';
    </script>
<?php endif; ?>

<!-- placed orders section ends -->

<!-- custom js file link  -->
<script src="../admin/admin.js"></script>
<script>
    document.querySelectorAll('.claim-btn').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.closest('form').querySelector('input[name="order_id"]').value;
            document.querySelector('.overlay').style.display = 'block';
            document.getElementById('claimPopup').style.display = 'block';
        });
    });

    document.querySelector('.overlay').addEventListener('click', function () {
        this.style.display = 'none';
        document.getElementById('claimPopup').style.display = 'none';
    });
</script>



</body>
</html>
<?php

