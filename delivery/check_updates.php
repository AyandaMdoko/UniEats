<?php
include '../elements/dbconnect.php'; // Ensure the database connection is included

session_start();
$admin_id = $_SESSION['del_id'];

if (!isset($admin_id)) {
    http_response_code(403); // Forbidden if not logged in
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Query to fetch orders with Delivery_Status 'Out For Delivery'
$stmt = $conn->prepare("SELECT * FROM orders WHERE Delivery_Status = 'Out For Delivery'");
$stmt->execute();
$result = $stmt->get_result();

$orders = [];

while ($order = $result->fetch_assoc()) {
    $orders[] = $order; // Add each order to the orders array
}

header('Content-Type: application/json');
echo json_encode($orders); // Return the orders as JSON

$stmt->close();
$conn->close();
?>
