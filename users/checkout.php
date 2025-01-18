<?php
    session_start();
    include '../pages/db_conn.php';

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch cart items for the user
    $sql = "SELECT c.id, c.product_id, c.quantity, i.p_name, i.p_price, i.p_total_price, i.image1, i.product_discount 
            FROM addtocart c
            JOIN items i ON c.product_id = i.id
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cart_items = [];
    $total_quantity = 0;
    $total_amount = 0;

    while ($row = $result->fetch_assoc()) {
        $row['total_price'] = $row['quantity'] * $row['p_total_price'];
        $cart_items[] = $row;
        $total_quantity += $row['quantity'];
        $total_amount += $row['total_price'];
    }

    // Fetch addresses for the user, including the address type
    $address_sql = "SELECT * FROM address WHERE user_id = ?";
    $address_stmt = $conn->prepare($address_sql);
    $address_stmt->bind_param("i", $user_id);
    $address_stmt->execute();
    $address_result = $address_stmt->get_result();
    $addresses = [];
    while ($address = $address_result->fetch_assoc()) {
        $addresses[] = $address;
    }

    // Check if there are no shipping or billing addresses
    $has_shipping_address = false;
    $has_billing_address = false;
    foreach ($addresses as $address) {
        if ($address['address_type'] === 'shipping') {
            $has_shipping_address = true;
        }
        if ($address['address_type'] === 'billing') {
            $has_billing_address = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/checkout.css">
    <script>
        function updateFormAction() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const form = document.getElementById('checkoutForm');
            form.action = paymentMethod === 'cod' ? 'process_order.php' : 'process_online_pay.php';
        }

        // Check total quantity and redirect if zero
        function checkQuantityAndRedirect() {
            const totalQuantity = <?php echo json_encode($total_quantity); ?>;
            if (totalQuantity === 0) {
                alert("Your cart is empty. Redirecting to the cart page.");
                window.location.href = 'view_cart.php';
            }
        }

        window.onload = checkQuantityAndRedirect;
    </script>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="checkout-section">
        <h1>Checkout</h1>
        
        <!-- Cart Items Summary -->
        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><img src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Product Image" class="product-image" style="width: 50px; height: auto;"></td>
                            <td><?php echo htmlspecialchars($item['p_name']); ?></td>
                            <td>₹ <?php echo number_format($item['p_total_price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹ <?php echo number_format($item['total_price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class='th'><strong>Total Quantity:</strong></td>
                        <td class='td'><?php echo $total_quantity; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class='th'><strong>Total Amount:</strong></td>
                        <td class='td'>₹ <?php echo number_format($total_amount, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div><br><br>

        <!-- Checkout Form -->
        <form id="checkoutForm" class="address" method="POST" action="process_order.php" onsubmit="return showLoader()">
            <!-- Hidden inputs for quantity and total amount -->
            <input type="hidden" name="total_quantity" value="<?php echo $total_quantity; ?>">
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">

            <!-- Address Selection Section -->
            <!-- Address Selection Section -->
            <div class="address-selection">
                <!-- Shipping Address -->
                <div class="flex">
                    <h2 class='heading'>Select Shipping Address</h2>
                    <div>
                        <a class="btn" href="add_address.php"><i class="fa-solid fa-plus"></i> Add Address</a>
                    </div>
                </div>
                <div class="shipping-add">
                    <?php if ($has_shipping_address): ?>
                        <?php foreach ($addresses as $address): ?>
                            <?php if ($address['address_type'] === 'shipping'): ?>
                                <label>
                                    <input type="radio" name="shipping_address" value="<?php echo $address['id']; ?>" required onchange="toggleBillingAddress()">
                                    <div class="address-box">
                                        <?php echo htmlspecialchars($address['full_name']); ?><br>
                                        <?php echo htmlspecialchars($address['phone_number']); ?><br>
                                        <?php echo htmlspecialchars($address['street_address']); ?><br>
                                        <?php echo htmlspecialchars($address['city'] . ', ' . $address['state'] . ', ' . $address['postal_code']); ?>
                                    </div>
                                </label><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No shipping address found.</p>
                    <?php endif; ?>
                </div>

                <!-- Billing Address Section -->
                <div>
                    <div class="flex">
                        <h2 class='heading'>Select Billing Address</h2>
                        <div><a class="btn" href="add_address.php"><i class="fa-solid fa-plus"></i> Add Address</a></div>
                    </div>
                    <div class='select'>
                        <input type="checkbox" id="sameAsShipping" onchange="toggleBillingAddress()">
                        <label for="sameAsShipping">Billing address is the same as shipping</label>
                    </div>
                </div>

                <div class="billing-add" id="billingAddressSection">
                    <?php if ($has_billing_address): ?>
                        <?php foreach ($addresses as $address): ?>
                            <?php if ($address['address_type'] === 'billing'): ?>
                                <label>
                                    <input type="radio" name="billing_address_radio" value="<?php echo $address['id']; ?>" onchange="document.getElementById('billingAddressId').value = this.value;">
                                    <div class="address-box">
                                        <?php echo htmlspecialchars($address['full_name']); ?><br>
                                        <?php echo htmlspecialchars($address['phone_number']); ?><br>
                                        <?php echo htmlspecialchars($address['street_address']); ?><br>
                                        <?php echo htmlspecialchars($address['city'] . ', ' . $address['state'] . ', ' . $address['postal_code']); ?>
                                    </div>
                                </label><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No billing address found.</p>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Payment Method Section -->
            <div class="payment-mode">
                <div class="payment-method">
                    <img src="assets/images/payment-methods.jpg" alt="" width="100%">
                    <h2 class='heading'>Select Payment Method</h2>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" required onchange="updateFormAction()">
                        <div class="payment-content">
                            <span class="payment-title">Cash on Delivery / Pay on Delivery</span>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" required onchange="updateFormAction()">
                        <div class="payment-content">
                            <span class="payment-title">Pay Online</span>
                        </div>
                    </label>
                </div>

                <!-- Submit Button with Loader -->
                 <button class="place-order-btn" type="submit" <?php echo $total_quantity === 0 ? 'disabled' : ''; ?> id="placeOrderBtn">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span class="button-text">Place Order</span>
                    <span class="loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                </button> 
                <p style='text-align: center;'><b>Note:</b> kindly select Shipping and Billing Address befor processiding</p>
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script>
        function showLoader() {
            const button = document.getElementById("placeOrderBtn");
            const buttonText = button.querySelector(".button-text");
            const loader = button.querySelector(".loader");

            // Show loader, hide text, and disable button
            buttonText.style.display = "none";
            loader.style.display = "inline-block";
            button.disabled = true;

            // Allow form submission to proceed
            return true;
        }
        function toggleBillingAddress() {
            const sameAsShippingCheckbox = document.getElementById('sameAsShipping');
            const billingAddressSection = document.getElementById('billingAddressSection');
            billingAddressSection.style.display = sameAsShippingCheckbox.checked ? 'none' : 'block';

            // Auto-fill billing address if same as shipping
            if (sameAsShippingCheckbox.checked) {
                const selectedShippingAddress = document.querySelector('input[name="shipping_address"]:checked');
                if (selectedShippingAddress) {
                    document.getElementById('billingAddressId').value = selectedShippingAddress.value;
                }
            } else {
                document.getElementById('billingAddressId').value = '';
            }
        }
        
    </script>
</body>
</html>
