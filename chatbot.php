<?php
require_once '../pages/db_conn.php'; // Database connection

header('Content-Type: application/json');

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
    // Query to fetch orders by Phone number
    $phoneQuery = "
        SELECT id, full_name, phone 
        FROM users 
        WHERE phone = ?";
    $stmt = $conn->prepare($phoneQuery);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $user_id = $user['id'];
        $user_name = $user['full_name'];
        $user_phone = $user['phone'];

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
                    'name' => $user_name,
                    'phone' => $user_phone,
                ],
                'orders' => $orders
            ]);
        }
    } else {
        echo json_encode(['error' => "No user found with phone number: $phone"]);
    }
} else {
    echo json_encode(['error' => 'Order ID or Phone number is required.']);
}

$conn->close(); // Close the database connection
?>
