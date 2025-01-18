<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title>Orders History</title>
    <link rel="stylesheet" href="assets/css/view_orders.css">
    <style>
        .download-btn {
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }
        
        /* Hide the download button when printing */
        @media print {
            .download-btn {
                display: none;
            }
        }
    </style>
    <script>
        function downloadInvoice(orderId) {
            const printContent = document.getElementById(`order-${orderId}`).innerHTML;
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload();
        }
    </script>
</head>
<body>
<?php 
    include 'includes/navbar.php'; 
    include '../pages/db_conn.php';

    $user_id = $_SESSION['user_id'];

    // Fetch all orders for the logged-in user
    $order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("i", $user_id);
    $order_stmt->execute();
    $orders = $order_stmt->get_result();

    if ($orders->num_rows == 0) {
        include 'no_orders.php'; // Include no_orders.php if there are no orders
        exit();
    }
?>

    <div class="orders-container">
        <h2>Orders History</h2>

        <?php while ($order = $orders->fetch_assoc()): ?>
            <?php
            $order_id = $order['order_id'];
            $total_quantity = $order['total_quantity'];
            $total_amount = $order['total_amount'];
            $order_date = $order['order_date'];
            $payment_mode = $order['payment_mode'];

            if ($total_quantity == 0) {
                include 'no_orders.php';
                exit();
            }

            // Fetch items for this order
            $items_sql = "SELECT oi.product_id, oi.quantity, oi.total_price, i.p_name, i.image1 
                          FROM order_items oi 
                          JOIN items i ON oi.product_id = i.id 
                          WHERE oi.order_id = ?";
            $items_stmt = $conn->prepare($items_sql);
            $items_stmt->bind_param("s", $order_id);
            $items_stmt->execute();
            $order_items = $items_stmt->get_result();

            // Fetch address details for this order
            $address_sql = "SELECT * FROM orders_address WHERE order_id = ?";
            $address_stmt = $conn->prepare($address_sql);
            $address_stmt->bind_param("s", $order_id);
            $address_stmt->execute();
            $address = $address_stmt->get_result()->fetch_assoc();
            ?>

            <div class="order-details" id="order-<?php echo $order_id; ?>">
                <div class="order">
                    <div class="flex">
                        <div class="logo">
                            <img src="assets/images/logo.png" alt="logo">
                        </div>
                        <div class='order-title' >
                            <h1>Shop Sphere</h1>
                            <p>29, 6th C cross, Precidency University, Bengaluru, Karnataka 560097</p>
                            <p><b>GSTIN :</b> 29ABCABC589B1ZJ</p>
                        </div>
                    </div>
                    <div class="order-number flex">
                        <p><b>Order ID:</b> <?php echo htmlspecialchars($order_id); ?></p>
                        <p><strong>Order Date:</strong> <?php echo date("Y-m-d", strtotime($order_date)); ?></p>
                    </div>

                    <div class="address grid">
                        <div>
                            <h4><i class="fa-solid fa-location-dot"></i> Billing Address:</h4>
                            <p>
                                <?php echo htmlspecialchars($address['full_name']) . "<br>" . htmlspecialchars($address['street_address']) . "<br>" . htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['state']) . "<br>" . htmlspecialchars($address['postal_code']); ?>
                            </p>
                        </div>
                        <div>
                            <h4><i class="fa-solid fa-location-dot"></i> Shipping Address:</h4>
                            <p>
                                <?php echo htmlspecialchars($address['full_name']) . "<br>" . htmlspecialchars($address['street_address']) . "<br>" . htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['state']) . "<br>" . htmlspecialchars($address['postal_code']); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        <h4>Order Items:</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $order_items->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <img src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['p_name']); ?>" width="100" height="100">
                                        </td>
                                        <td><?php echo htmlspecialchars($item['p_name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td>₹<?php echo number_format($item['total_price'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="order-summary">
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong>Payment Mode:</strong></td>
                                    <td>
                                        <?php 
                                            if($payment_mode=="cod"){
                                                echo "Cash On Delivery";
                                            }
                                            elseif($payment_mode=="online"){
                                                echo "Online";
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Quantity:</strong></td>
                                    <td><?php echo htmlspecialchars($total_quantity); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Amount:</strong></td>
                                    <td>₹<?php echo number_format($total_amount, 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <p style='color: #C11C43'><b>Note : </b>
                            This is an electronicaly generated bill, do not require physical signature.
                        </p>
                        <p style='color: #000080; text-align: center;'>Thank You for shopping with us!</p>
                    </div>
                    <div class='footer'>
                        <p><b>Phone :</b> +91 890 431 0529</p>
                        <p><b>Email :</b> support@shopsphere.com</p>
                        <p><b>Website :</b> www.shopsphere.com</p>
                    </div>
                </div>
                <div class="download-btn" onclick="downloadInvoice('<?php echo $order_id; ?>')">Download Invoice</div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
