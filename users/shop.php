<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/pop_card.css">
    <link rel="stylesheet" href="assets/css/category.css">
    <link rel="stylesheet" href="assets/css/shop.css">
    <title>Shop Now</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-icon"><img src="https://i.pinimg.com/originals/06/ae/07/06ae072fb343a704ee80c2c55d2da80a.gif" alt="" width="100"></div>
            <p class="modal-message" id="modal-message"></p>
            <button class="modal-button" id="modal-ok-btn">OK</button>
        </div>
    </div>
    
    <?php include '../pages/db_conn.php'; ?>
    <div class="all-products-section">
        <?php
        // Fetch all categories from the categories table
        $categoriesQuery = "SELECT * FROM categories";
        $categoriesResult = mysqli_query($conn, $categoriesQuery);

        while ($category = mysqli_fetch_assoc($categoriesResult)) {
            $categoryId = $category['id'];
            $categoryName = $category['c_name'];

            // Fetch the latest 8 items for each category
            $itemsQuery = "
                SELECT 
                    p.id AS product_id, 
                    p.p_name, 
                    p.p_price, 
                    p.p_total_price,
                    p.product_discount,
                    p.image1, 
                    b.brand_rating 
                FROM items p 
                JOIN brands b ON p.brand_id = b.id 
                WHERE p.category_id = $categoryId 
                ORDER BY p.created_at DESC 
                LIMIT 8";
            $itemsResult = mysqli_query($conn, $itemsQuery);
            
            // Check if there are items in this category
            if (mysqli_num_rows($itemsResult) > 0) {
        ?>

        <!-- Section for each category -->
        <div class="category-section" data-category="category<?php echo $categoryId; ?>">
            <h2 class="section-title">
                <div class="short-line"></div>
                <?php echo htmlspecialchars($categoryName); ?>
            </h2>

            <div class="product-items">
                <?php while ($row = mysqli_fetch_assoc($itemsResult)) { ?>
                    <div class="product-card">
                        <div class="product-img">
                            <a href="view_items.php?id=<?php echo $row['product_id']; ?>">
                                <img src="../admin/<?php echo htmlspecialchars($row['image1']); ?>" alt="">
                            </a>
                        </div>
                        <div class="product-name">
                            <p><?php echo htmlspecialchars($row['p_name']); ?></p>
                            <div class="ratings">
                                <?php 
                                // Display stars based on brand rating
                                $rating = $row['brand_rating'];
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < floor($rating)) {
                                        echo '<i class="fa-solid fa-star"></i>'; // Full star
                                    } elseif ($i < ceil($rating) && $rating - $i >= 0.5) {
                                        echo '<i class="fa-solid fa-star-half-stroke"></i>'; // Half star
                                    } else {
                                        echo '<i class="fa-regular fa-star"></i>'; // Empty star
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="product-price">
                            <div class="cost-div">
                                <?php if ($row['product_discount'] > 0): ?>
                                    <b>₹ <?php echo number_format($row['p_total_price'], 2); ?></b>
                                    <div class="strike-cost">
                                        <p><strike>₹ <?php echo number_format($row['p_price'], 2); ?></strike></p>
                                        <p class="off"><?php echo number_format($row['product_discount']); ?>% off</p>
                                    </div>
                                <?php else: ?>
                                    <p>₹ <?php echo number_format($row['p_total_price'], 2); ?></p>
                                <?php endif; ?>
                            </div>
                            <section>
                                <form action="">
                                    <p class="qty">
                                        <button type="button" class="qtyminus" aria-hidden="true">&minus;</button>
                                        <input type="number" name="qty" id="quantity-<?php echo $row['product_id']; ?>" min="1" max="10" step="1" value="1">
                                        <button type="button" class="qtyplus" aria-hidden="true">&plus;</button>
                                    </p>
                                </form>            
                            </section>
                        </div>
                        <div class="cart-button">
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <a href="javascript:void(0);" onclick="addToCart(<?php echo $row['product_id']; ?>)">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart
                                </a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" onclick="redirectToLogin(<?php echo $row['product_id']; ?>)">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart
                                </a>
                            <?php } ?>
                            <a href=""><i class="fa fa-bolt" aria-hidden="true"></i> Buy Now</a>
                        </div>
                    </div>
                <?php } // End of items loop ?>
            </div>
            <div class="button">
                <form action="products.php" method="get">
                    <input type="hidden" name="category_id" value="<?php echo $categoryId; ?>">
                    <button class='btn' type="submit">View All Products</button>
                </form>
            </div>
        </div>
        <?php 
            } // End of if items check
        } // End of categories loop ?>
    </div>
    
    <script src='assets/js/qty.js'></script>
    <script>
        function showModal(message) {
            document.getElementById("modal-message").textContent = message;
            document.getElementById("modal").style.display = "flex";
        }

        document.getElementById("modal-ok-btn").addEventListener("click", function() {
            document.getElementById("modal").style.display = "none";
            location.reload();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const brandSelect = document.getElementById('category-select');
            const productCards = document.querySelectorAll('.product-card');

            const filterByBrand = () => {
                const selectedBrand = brandSelect.value;
                
                productCards.forEach(card => {
                    const cardBrand = card.getAttribute('data-category');

                    if (selectedBrand === 'all' || selectedBrand === cardBrand) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            };

            brandSelect.addEventListener('change', filterByBrand);
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const productFlex = document.querySelector('.product-flex');
            const productItems = document.querySelectorAll('.product-items');
            const productCards = document.querySelectorAll('.product-card');
            
            setTimeout(() => {
                if (productFlex) productFlex.classList.add('show');
            }, 400); 

            productCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, 200 * index);
            });

            productItems.forEach((items, index) => {
                setTimeout(() => {
                    items.classList.add('show');
                }, 200 * index);
            });
        });
        function redirectToLogin() {
            const currentUrl = window.location.href;
            window.location.href = `../pages/login.php?redirect=${encodeURIComponent(currentUrl)}`;
        }

        function addToCart(productId) {
            // Get the quantity from the input field
            var quantityField = document.getElementById('quantity-' + productId);
            var quantity = quantityField ? quantityField.value : 1; // Default to 1 if not found

            // Ensure quantity is a valid number
            if (isNaN(quantity) || quantity < 1) {
                alert('Please enter a valid quantity (1 or more).');
                return;
            }

            // Make an AJAX request to add the product to the cart
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    showModal(xhr.responseText); // Show the server response
                    // You may want to refresh the cart display here
                    updateCartDisplay();
                }
            };

            // Send product_id and quantity to the server
            xhr.send('product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantity));
        }
    </script>

    <?php include 'includes/footer.php'?>
</body>
</html>
