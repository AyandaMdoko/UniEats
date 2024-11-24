<?php
include('dbconnect.php');

// Initialize session variables
$user_Num = isset($_SESSION['User_Num']) ? $_SESSION['User_Num'] : null;
$UserId = isset($_SESSION['otp_user_id']) ? $_SESSION['otp_user_id'] : null;

if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $msg) {
        echo '
        <div class="message">
        <span>' . $msg . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
    unset($_SESSION['messages']); // Clear messages after displaying
}
?>

<!--header section starts-->
<header class="header">
    <section class="flex">
        <a class="logo" href="index.php">🍽 Uni Eats</a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="menu.php">Menu</a>
            <a href="orders.php">Orders</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="icons">
            <?php
            $stmt = $conn->prepare('SELECT * FROM `cart` WHERE User_id = ?');
            $stmt->bind_param('i', $user_Num);
            $stmt->execute();
            $result = $stmt->get_result();
            $total_cart_items = $result->num_rows;
            ?>
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i> <span>(<?= $total_cart_items; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>

        <div class="profile">
            <?php
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $stmt->bind_param('i', $UserId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $fetch_profile = $result->fetch_assoc();
            ?>
                <p class="name"><?= $fetch_profile['Name']; ?></p>
                <div class="flex">
                    <a class="btn" href="profile.php">Profile</a>
                    <a class="delete-btn" href="elements/User_logout.php" onclick="return confirm('Are you sure want to logout from the application?');">Logout</a>
                </div>
            <?php
            } else {
            ?>
                <p>Please Login/Register First!!</p>
                <a href="login.php" class="btn">login</a>
                <a href="register.php" class="btn">Register</a>
            <?php
            }
            ?>
        </div>
    </section>
</header>
<!--header section ends-->
