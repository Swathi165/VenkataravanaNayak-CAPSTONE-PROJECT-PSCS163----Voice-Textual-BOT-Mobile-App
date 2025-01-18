<?php
require_once '../../pages/db_conn.php'; // Database connection
session_start(); // Start the session

header('Content-Type: application/json');

// Check if the session user_id is set
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized access. Please log in.']);
    exit;
}

$user_id = $_SESSION['user_id']; // Fetch the logged-in user's ID

// Decode the input JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Check if order_id or phone is provided
$order_id = $data['order_id'] ?? null;
$phone = $data['phone'] ?? null;

if ($order_id) {
    // Query to fetch order details by Order ID
    $orderQuery = "
        SELECT o.order_id, o.total_quantity, o.total_amount, o.order_date, o.payment_mode,
               u.full_name, u.phone, u.email,
               oa.street_address, oa.city, oa.state, oa.postal_code, oa.country,
               oi.product_id, oi.quantity, oi.total_price,
               p.p_name, p.p_specification, p.p_price, p.product_discount
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN orders_address oa ON o.address_id = oa.id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN items p ON oi.product_id = p.id
        WHERE o.order_id = ?";

    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orderDetails = [];
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }

    if (empty($orderDetails)) {
        echo json_encode(['error' => "No order found with ID: $order_id"]);
    } else {
        echo json_encode(['order' => $orderDetails]);
    }
} elseif ($phone) {
    // Fetch the user's phone number from the database using the session user_id
    $phoneQuery = "SELECT phone FROM users WHERE id = ?";
    $stmt = $conn->prepare($phoneQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(['error' => 'User not found in the database.']);
        exit;
    }

    $user_phone = $user['phone'];

    // Validate the provided phone number with the one in the database
    if ($phone !== $user_phone) {
        echo json_encode(['error' => 'Phone number mismatch This Is Not Your Logged In Number.']);
        exit;
    }

    // Fetch the user's details and orders
    $userDetailsQuery = "
        SELECT id, full_name, phone 
        FROM users 
        WHERE id = ?";
    $stmt = $conn->prepare($userDetailsQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();

    if ($userDetails) {
        $orderQuery = "
            SELECT o.order_id, o.total_quantity, o.total_amount, o.order_date, o.payment_mode
            FROM orders o
            WHERE o.user_id = ?";
        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        if (empty($orders)) {
            echo json_encode(['error' => "No orders found for phone number: $user_phone"]);
        } else {
            echo json_encode([
                'user' => [
                    'id' => $user_id,
                    'name' => $userDetails['full_name'],
                    'phone' => $userDetails['phone'],
                ],
                'orders' => $orders
            ]);
        }
    } else {
        echo json_encode(['error' => 'User details not found.']);
    }
} else {
    echo json_encode(['error' => 'Order ID or Phone number is required.']);
}

$conn->close(); // Close the database connection
?>
