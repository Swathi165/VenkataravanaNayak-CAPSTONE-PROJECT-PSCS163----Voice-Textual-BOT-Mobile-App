<?php
session_start();
include '../pages/db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for this user, including the product image
$sql = "SELECT c.id, c.product_id, c.quantity, i.p_name, i.p_price, i.p_total_price, i.image1, i.product_discount
        FROM addtocart c
        JOIN items i ON c.product_id = i.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_quantity = 0; // Initialize total quantity
$total_amount = 0; // Initialize total amount

while ($row = $result->fetch_assoc()) {
    $row['total_price'] = $row['quantity'] * $row['p_total_price']; // Calculate total price for each item
    $cart_items[] = $row;
    $total_quantity += $row['quantity']; // Add to total quantity
    $total_amount += $row['total_price']; // Add to total amount
}

// If no items are in the cart, display no_items.php
if ($total_quantity === 0) {
    include 'empty_cart.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title>View Cart</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/view_cart.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <h1>Shopping Cart</h1>
    
    <div class="shopping-section">
        <div class="cart-container">
            <?php foreach ($cart_items as $item): ?>
            <div class="cart-item">
                <img src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Product Image" class="product-image">
                <div class="product-details">
                    <div class="product-info">
                        <p class="product-name"><?php echo htmlspecialchars($item['p_name']); ?></p>
                        <div class="product-price">
                            <?php if ($item['product_discount'] > 0): ?>
                                <p class='cost'>₹ <?php echo number_format($item['p_total_price'], 2); ?></p>
                                <div class="cost-flex">
                                    <p><strike>₹ <?php echo number_format($item['p_price'], 2); ?></strike></p>
                                    <b class="product-discount"><?php echo number_format($item['product_discount']); ?>% off</b>
                                </div>
                            <?php else: ?>
                                <p>₹ <?php echo number_format($item['p_total_price'], 2); ?></p>
                            <?php endif; ?>
                        </div>
                        <a href="#" class='remove-btn' data-product-id="<?php echo $item['product_id']; ?>">Remove</a>
                    </div>
                    <div class="product-quantity">
                        <p class="total-price" id="total_<?php echo $item['product_id']; ?>">
                            Total : ₹ <?php echo number_format($item['total_price'], 2); ?>
                        </p>
                        <button class="quantity-btn minus" data-product-id="<?php echo $item['product_id']; ?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
                        <input type="number" class="quantity-input" 
                            data-product-id="<?php echo $item['product_id']; ?>" 
                            value="<?php echo $item['quantity']; ?>" 
                            min="1">
                        <button class="quantity-btn plus" data-product-id="<?php echo $item['product_id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
        </div>
        <div class='bill-card'>
            <h2>Order Summary</h2>
            <div class="cart-summary">
                <p><i class="fa-solid fa-cart-shopping"></i> <b>Total Quantity:</b> <span id="total-quantity"><?php echo $total_quantity; ?></span></p>
                <p><b><i class="fa-solid fa-arrow-up-wide-short"></i> Total Amount:</b> <span id="total-amount">₹ <?php echo number_format($total_amount, 2); ?></span></p>
            </div>
            <div class="check-out-div">
                <a href="checkout.php" class='check-out-btn'><i class="fa-solid fa-truck-fast"></i> Proceed to Buy</a>
            </div>
        </div>
    </div>

    <script>
        $(document).on("click", ".quantity-btn", function () {
            let button = $(this);
            let product_id = button.data("product-id");
            let input = button.siblings(".quantity-input");
            let quantity = parseInt(input.val());

            if (button.hasClass("plus")) {
                quantity++;
            } else if (button.hasClass("minus") && quantity > 1) {
                quantity--;
            }

            input.val(quantity);

            $.ajax({
                url: "update_quantity.php",
                method: "POST",
                data: {
                    user_id: <?php echo $user_id; ?>,
                    product_id: product_id,
                    quantity: quantity
                },
                success: function (data) {
                    let result = JSON.parse(data);
                    if (result.success) {
                        let newTotalPrice = quantity * parseFloat(result.product_price);
                        $("#total_" + product_id).text("Total : ₹ " + newTotalPrice.toFixed(2));
                        updateCartSummary();
                    } else {
                        alert("Error updating quantity.");
                    }
                }
            });
        });

        $(document).on("click", ".remove-btn", function (event) {
            event.preventDefault();

            let button = $(this);
            let product_id = button.data("product-id");

            $.ajax({
                url: "remove_item.php",
                method: "POST",
                data: {
                    product_id: product_id
                },
                success: function (data) {
                    let result = JSON.parse(data);
                    if (result.success) {
                        button.closest('.cart-item').remove();
                        updateCartSummary();
                        if ($(".cart-item").length === 0) {
                            location.reload();
                        }
                    } else {
                        alert(result.message || "Error removing item.");
                    }
                }
            });
        });

        function updateCartSummary() {
            let totalQuantity = 0;
            let totalAmount = 0;

            $(".cart-item").each(function() {
                let quantity = parseInt($(this).find('.quantity-input').val());
                let productTotalPrice = parseFloat($(this).find('.total-price').text().replace("Total : ₹ ", ""));
                
                totalQuantity += quantity;
                totalAmount += productTotalPrice;
            });

            $("#total-quantity").text(totalQuantity);
            $("#total-amount").text(totalAmount.toFixed(2));
        }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
