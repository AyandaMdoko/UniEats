session_start();
include('elements/dbconnect.php');

$user_id = $_SESSION['otp_user_id'];

// Get the last order status from the database
$stmt = $conn->prepare("SELECT `Delivery_Status` FROM `orders` WHERE `User_id` = ? ORDER BY `id` DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $new_status = $row['Delivery_Status'];

    // Compare with the last known status stored in the session
    if (!isset($_SESSION['last_order_status']) || $_SESSION['last_order_status'] !== $new_status) {
        // Update the last known status
        $_SESSION['last_order_status'] = $new_status;

        // Return the new status as JSON
        echo json_encode(['update' => true, 'status' => $new_status]);
    } else {
        // No change in status
        echo json_encode(['update' => false]);
    }
} else {
    echo json_encode(['update' => false]);
}

$stmt->close();
$conn->close();
