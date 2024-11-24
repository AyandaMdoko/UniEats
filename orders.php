<?php
session_start();
if(isset($_SESSION['otp_user_id'])){
    include('elements/dbconnect.php');

    $resulted = $_SESSION['otp_user_id'];
    $sql = "SELECT `Name` FROM `users` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $resulted);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userName = $user['Name'];
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
    <link rel="icon" href="images/fast-food.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="SystemDesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="chat.css">
    <title>UniEats</title>
</head>
<body>
<!-- header section starts  -->
<?php include 'elements/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
    <h3>your orders</h3>
    <p><a href="homePage.php">home</a><span> / checkout</span></p>
</div>

<!--order section starts-->
<section class="orders">
    <h1 class="title">your orders</h1>

    <div class="box-container">
        <?php
        if(!isset($resulted)){
            echo '<p class="empty">please login to see your orders</p>';
        } else {
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE User_id = ?");
            $select_orders->bind_param("i", $resulted);
            $select_orders->execute();
            $result = $select_orders->get_result();

            if($result->num_rows > 0){
                while($fetch_orders = $result->fetch_assoc()){
                    $accepted_order = $fetch_orders['Accept_to_deliver'];
        ?>

        <div class="box">
            <p>placed on: <span><?= htmlspecialchars($fetch_orders['Placed_On']); ?></span></p>
            <p>time order: <span><?= htmlspecialchars($fetch_orders['time_placed']); ?></span></p>
            <p>name: <span><?= htmlspecialchars($fetch_orders['Name']); ?></span></p>
            <p>surname: <span><?= htmlspecialchars($fetch_orders['Surname']); ?></span></p>
            <p>cell number: <span><?= htmlspecialchars($fetch_orders['Phone_Number']); ?></span></p>
            <p>email: <span style="text-transform:none"><?= htmlspecialchars($fetch_orders['Email_Add']); ?></span></p>
            <p>address: <span><?= htmlspecialchars($fetch_orders['Ress_Add']); ?></span></p>
            <p>your orders: <span><?= htmlspecialchars($fetch_orders['Total_Products']); ?></span></p>
            <p>payment method: <span><?= htmlspecialchars($fetch_orders['Payment_Method']); ?></span></p>
            <p>grand total: <span>R<?= htmlspecialchars($fetch_orders['Total_Price']); ?>.00</span></p>
            <p>delivery fee: <span>R<?= htmlspecialchars($fetch_orders['delivery_fee']); ?>.00</span></p>
            <p>vat amount: <span>R<?= htmlspecialchars($fetch_orders['vat_amount']); ?>.00</span></p>
            <p>order number: <span style="text-transform:none"><?= htmlspecialchars($fetch_orders['order_num']); ?></span></p>

            <!-- Order status display with color coding and default status -->
            <p>Order status: 
                <?php 
                    $statusColor = 'black'; // Default color for "In Progress..."
                    $orderStatus = 'In Progress...'; // Default status

                    // Update order status based on database value
                    if (!empty($fetch_orders['Delivery_Status'])) {
                        $orderStatus = htmlspecialchars($fetch_orders['Delivery_Status']);
                        switch ($orderStatus) {
                            case 'Pending':
                                $statusColor = 'red';
                                break;
                            case 'Out For Delivery':
                                $statusColor = 'orange';
                                break;
                            case 'Completed':
                                $statusColor = 'green';
                                break;
                        }
                    }
                ?>
                <span style="color:<?= $statusColor; ?>;">
                    <?= $orderStatus; ?>
                </span>
            </p>

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
        </div>

        <?php
                }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            $select_orders->close();
        }
        ?>
    </div>
</section>
<!--order section ends-->

<!--footer section starts-->
<?php include 'elements/footer.php'; ?>
<!--footer section ends-->

<script src="homePage.js"></script>
<script src="chat.js"></script>

</body>
</html>
