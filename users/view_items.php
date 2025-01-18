<?php
// view_items.php
session_start();
include '../pages/db_conn.php';

// Check if `item_id` is set in the URL
if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    
    // Prepare and execute the query to fetch item details
    $sql = "SELECT id AS product_id, p_name, p_specification, p_description, p_about_product, p_rating, 
                   p_price, product_discount, p_total_price, offers, EMIs, image1, image2, image3, 
                   category_id, created_at, brand_id
            FROM items
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    
    if (!$item) {
        echo "Item not found.";
        exit();
    }
   
} else {
    echo "No item specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title><?php echo htmlspecialchars($item['p_name']); ?> - Product Details</title>
    <link rel="stylesheet" href="assets/css/view_items.css">
    <script>
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
            document.getElementById('productMainImage').src = src;
        }
    </script>
</head>
<body>
    <?php include 'includes/navbar.php' ?>
    <div class="container">
        <div class="product-page">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-img-container">
                    <img id="mainImage" class="main-image" src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Product Image">
                </div>
                <!-- Thumbnail Images -->
                <div class="thumbnail-images">
                    <img src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Thumbnail 1" onclick="changeMainImage('../admin/<?php echo htmlspecialchars($item['image1']); ?>')">
                    <?php if (!empty($item['image2'])): ?>
                        <img src="../admin/<?php echo htmlspecialchars($item['image2']); ?>" alt="Thumbnail 2" onclick="changeMainImage('../admin/<?php echo htmlspecialchars($item['image2']); ?>')">
                    <?php endif; ?>
                    <?php if (!empty($item['image3'])): ?>
                        <img src="../admin/<?php echo htmlspecialchars($item['image3']); ?>" alt="Thumbnail 3" onclick="changeMainImage('../admin/<?php echo htmlspecialchars($item['image3']); ?>')">
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-details">
                <h1><?php echo htmlspecialchars($item['p_name']); ?></h1>
                <div class="price">
                    ₹ <?php echo number_format($item['p_total_price'], 2); ?>
                </div>

                <?php if ($item['product_discount'] > 0): ?>
                    <div class="cost-flex">
                        <p class="discount"><strike>₹ <?php echo number_format($item['p_price']); ?></strike></p>
                        <p style='color: green; font-weight: 600;'><?php echo number_format($item['product_discount']); ?>% off</p>
                    </div>
                <?php endif; ?>

                <div class="offers">
                    <h4>Offers</h4>
                    <p><?php echo htmlspecialchars($item['offers']); ?></p>
                </div>

                <div class="emi">
                    <h4>EMI Options</h4>
                    <p><?php echo htmlspecialchars($item['EMIs']); ?></p>
                </div>
                
                <div class="product-spec specification">
                    <h4>Specification</h4>
                    <p><?php echo htmlspecialchars($item['p_specification']); ?></p>
                </div>

                <div class="description">
                    <h4>Description</h4>
                    <p><?php echo htmlspecialchars($item['p_description']); ?></p>
                </div>
                <div class="installation">
                    <p>Free Installation avaliable within Bengaluru</p>
                </div>
            </div>
            <div class="product-price">
                <div class="img-container">
                    <img id="mainImage" class="main-image" src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Product Image">
                </div>
                <h1><?php echo htmlspecialchars($item['p_name']); ?></h1>
                <p class='text-loc'><i class="fa-solid fa-location-dot"></i> Your orders will arrive within 7 days,<br> guaranteed!</p>
                <section class='flex'>
                    <b>Quantity : </b>
                    <form action="">
                        <p class="qty">
                            <button type="button" class="qtyminus" aria-hidden="true">&minus;</button>
                            <input type="number" name="qty" id="qty-<?php echo $item['product_id']; ?>" min="1" max="10" step="1" value="1">
                            <button type="button" class="qtyplus" aria-hidden="true">&plus;</button>
                        </p>
                    </form>           
                </section>
                <div class="cta-buttons">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="javascript:void(0);" onclick="addToCart(<?php echo $item['product_id']; ?>)">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart
                        </a>
                    <?php } else { ?>
                        <a href="javascript:void(0);" onclick="redirectToLogin(<?php echo $item['product_id']; ?>)">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart
                        </a>
                    <?php } ?>
                    <a href=""><i class="fa fa-bolt" aria-hidden="true"></i> Buy Now</a>
                </div>
            </div>
        </div>
        <div class="about-product">
            <h2>About Product</h2>
            <p><?php echo htmlspecialchars($item['p_about_product']); ?></p>
        </div>
        <div class="product-details-images">
            <div class="product-thumbnail-images">
                <img src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Thumbnail 1" onclick="changeMainImage('../admin/<?php echo htmlspecialchars($item['image1']); ?>')">
                <?php if (!empty($item['image2'])): ?>
                    <img src="../admin/<?php echo htmlspecialchars($item['image2']); ?>" alt="Thumbnail 2" onclick="changeMainImage('../admin/<?php echo htmlspecialchars($item['image2']); ?>')">
                <?php endif; ?>
                <?php if (!empty($item['image3'])): ?>
                    <img src="../admin/<?php echo htmlspecialchars($item['image3']); ?>" alt="Thumbnail 3" onclick="changeMainImage('../admin/<?php echo htmlspecialchars($item['image3']); ?>')">
                <?php endif; ?>
            </div>
            <div class="main-img-container1">
                <img id="productMainImage" class="product-main-image" src="../admin/<?php echo htmlspecialchars($item['image1']); ?>" alt="Product Image">
            </div>
        </div>

    </div>
    <?php include 'includes/footer.php' ?>
<script src='assets/js/qty.js'></script>
    <script>
function addToCart(productId) {
    const quantity = document.getElementById(`qty-${productId}`).value;
    
    // Send data to add_to_cart_items.php
    fetch('add_to_cart_items.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'view_cart.php';
        } else {
            alert("Failed to add to cart. Please try again.");
        }
    })
    .catch(error => console.error('Error:', error));
}

function redirectToLogin(productId) {
    const quantity = document.getElementById(`qty-${productId}`).value;
    // Redirect with product_id and quantity as URL parameters
    window.location.href = `login.php?product_id=${encodeURIComponent(productId)}&quantity=${encodeURIComponent(quantity)}`;
}
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.qtyminus').forEach(button => {
        button.addEventListener('click', function () {
            let qtyInput = button.nextElementSibling;
            let currentQty = parseInt(qtyInput.value);
            if (currentQty > 1) qtyInput.value = currentQty - 1;
        });
    });

    document.querySelectorAll('.qtyplus').forEach(button => {
        button.addEventListener('click', function () {
            let qtyInput = button.previousElementSibling;
            qtyInput.value = parseInt(qtyInput.value) + 1;
        });
    });
});
</script>

</body>
</html>
