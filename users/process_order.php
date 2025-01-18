<?php
session_start();
include '../pages/db_conn.php';
// Make sure PHPMailer is installed and autoloaded
require '../PHPMailer/PHPMailerAutoload.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$shipping_address_id = $_POST['shipping_address'];
$payment_method = $_POST['payment_method'];
$total_quantity = $_POST['total_quantity'];
$total_amount = $_POST['total_amount'];

// Check if total quantity is zero
if ($total_quantity == 0) {
    exit("Total quantity cannot be zero. Please add items to your cart before placing an order.");
}

// Fetch user's cart items
$cart_sql = "SELECT c.product_id, c.quantity, i.p_name, i.p_price, (c.quantity * i.p_total_price) AS item_total 
             FROM addtocart c 
             JOIN items i ON c.product_id = i.id 
             WHERE c.user_id = ?";
$stmt = $conn->prepare($cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch user email
$user_sql = "SELECT email FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_email = $user_stmt->get_result()->fetch_assoc()['email'];

// Generate unique order ID
$order_id = "SGE_" . str_pad(rand(1, 999999), 10, '0', STR_PAD_LEFT);

// Insert into orders table
$order_sql = "INSERT INTO orders (order_id, user_id, total_quantity, total_amount, payment_mode, address_id) VALUES (?, ?, ?, ?, ?, ?)";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("siissi", $order_id, $user_id, $total_quantity, $total_amount, $payment_method, $shipping_address_id);
$order_stmt->execute();

// Insert each cart item into order_items
foreach ($cart_items as $item) {
    $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_sql);
    $item_stmt->bind_param("siid", $order_id, $item['product_id'], $item['quantity'], $item['item_total']);
    $item_stmt->execute();
}

// Fetch billing address details
$address_sql = "SELECT * FROM address WHERE id = ?";
$address_stmt = $conn->prepare($address_sql);
$address_stmt->bind_param("i", $shipping_address_id);
$address_stmt->execute();
$address = $address_stmt->get_result()->fetch_assoc();

if (!$address) {
    exit("Billing address not found. Please make sure a valid address is selected.");
}

// Save address in orders_address for reference
$order_address_sql = "INSERT INTO orders_address (order_id, full_name, phone_number, street_address, city, state, postal_code, country)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$order_address_stmt = $conn->prepare($order_address_sql);
$order_address_stmt->bind_param(
    "ssssssss",
    $order_id,
    $address['full_name'],
    $address['phone_number'],
    $address['street_address'],
    $address['city'],
    $address['state'],
    $address['postal_code'],
    $address['country']
);
$order_address_stmt->execute();

// Prepare email content
$email_subject = "Order Confirmation - Order #$order_id";
$email_body = "<h3>Order Confirmation</h3>";
$email_body .= "<p>Order ID: $order_id</p>";
$email_body .= "<p>Total Quantity: $total_quantity</p>";
$email_body .= "<p>Total Amount: ₹" . number_format($total_amount, 2) . "</p>";
$email_body .= "<p>Payment Mode: Cash on Delivery</p>";
$email_body .= "<h4>Shipping and Billing Address:</h4>";
$email_body .= "<p>" . htmlspecialchars($address['full_name']) . "<br>" .
               htmlspecialchars($address['phone_number']) . "<br>" .
               htmlspecialchars($address['street_address']) . "<br>" .
               htmlspecialchars($address['city'] . ', ' . $address['state'] . ', ' . $address['postal_code']) . "</p>";
$email_body .= "<h4>Order Items:</h4>";
foreach ($cart_items as $item) {
    $email_body .= "<p>" . htmlspecialchars($item['p_name']) . " - Quantity: " . $item['quantity'] . " - ₹" . number_format($item['item_total'], 2) . "</p>";
}

// Send email using PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'shopsphere1546@gmail.com';
    $mail->Password = 'rdvw lwtc niis gukr';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('shopsphere1546@gmail.com', 'Shop Sphere');
    $mail->addAddress($user_email);
    $mail->addAddress('shopsphere1546@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;

    $mail->send();
    $email_status = "Order placed successfully! A confirmation email has been sent.";

    // Clear the cart for the user
    $clear_cart_sql = "DELETE FROM addtocart WHERE user_id = ?";
    $clear_cart_stmt = $conn->prepare($clear_cart_sql);
    $clear_cart_stmt->bind_param("i", $user_id);
    $clear_cart_stmt->execute();
} catch (Exception $e) {
    $email_status = "Order placed, but the confirmation email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .confirmation-container {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
        }
        .checkmark {
            font-size: 48px;
            color: green;
            margin-bottom: 10px;
        }
        .order-id, .email-status {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .order-details {
            text-align: left;
            margin-top: 20px;
        }
        .order-summary, .address, .order-items {
            margin-top: 15px;
            padding: 10px;
            border-top: 1px solid #eee;
        }
        .product {
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
        }
        .actions {
            margin-top: 20px;
        }
        .actions button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 0 5px;
            cursor: pointer;
        }
        .actions button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="confirmation-container" id="orderReceipt">
        <div class="checkmark">✔</div>
        <p class="email-status"><?php echo htmlspecialchars($email_status); ?></p>
        <p class="order-id">Order ID: <?php echo htmlspecialchars($order_id); ?></p>

        <div class="order-details">
            <div class="order-summary">
                <h3>Order Summary</h3>
                <p><strong>Total Quantity:</strong> <?php echo htmlspecialchars($total_quantity); ?></p>
                <p><strong>Total Amount:</strong> ₹<?php echo number_format($total_amount, 2); ?></p>
                <p><strong>Payment Mode:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
            </div>

            <div class="address">
                <h4>Shipping Address:</h4>
                <p>
                    <?php 
                        echo htmlspecialchars($address['full_name']) . "<br>" .
                        htmlspecialchars($address['street_address']) . "<br>" .
                        htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['state']) . "<br>" .
                        htmlspecialchars($address['postal_code']); 
                    ?>
                </p>
                <h4>Billing Address:</h4>
                <p>
                    <!--<?php 
                        echo htmlspecialchars($billing_address['full_name']) . "<br>" . 
                        htmlspecialchars($billing_address['phone_number']) . "<br>" . 
                        htmlspecialchars($billing_address['street_address']) . "<br>" . 
                        htmlspecialchars($billing_address['city']) . ", " . 
                        htmlspecialchars($billing_address['state']) . "<br>" . 
                        htmlspecialchars($billing_address['postal_code']); 
                    ?>-->
                    <?php 
                        echo htmlspecialchars($address['full_name']) . "<br>" .
                        htmlspecialchars($address['street_address']) . "<br>" .
                        htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['state']) . "<br>" .
                        htmlspecialchars($address['postal_code']); 
                    ?>
                </p>
            </div>

            <div class="order-items">
                <h4>Order Items:</h4>
                <?php foreach ($cart_items as $item): ?>
                    <div class="product">
                        <p><?php echo htmlspecialchars($item['p_name']); ?> - Quantity: <?php echo htmlspecialchars($item['quantity']); ?> - ₹<?php echo number_format($item['item_total'], 2); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<div id="redirect-message" style="color: green; font-weight: bold;">
    This page will redirect to your orders in <span id="countdown">5</span> seconds.
</div>
        <!-- Actions: Print and Export to PDF -->
        <div class="actions">
            <button onclick="printReceipt()">Print</button>
            
            <!-- Add a form for exporting to PDF -->
            <form method="POST" style="display: inline;">
                <button type="submit" name="download_pdf">Export to PDF</button>
            </form>
        </div>
    </div>

    <script>
        function printReceipt() {
            const printContents = document.getElementById("orderReceipt").innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <script>
    let countdown = 5;
    const countdownElement = document.getElementById("countdown");

    // Countdown timer
    const timer = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;

        // Redirect after countdown reaches zero
        if (countdown === 0) {
            clearInterval(timer);
            window.location.href = "view_orders.php";
        }
    }, 1000); // Update every second (1000 ms)
</script>
</body>
</html>
