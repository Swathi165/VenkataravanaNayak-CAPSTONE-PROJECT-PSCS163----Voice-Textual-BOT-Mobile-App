<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/category.css">
    <link rel="stylesheet" href="assets/css/shop.css">
    <title>All Products</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'pages/db_conn.php'; ?>

    <?php
        // Fetch the category_id from the URL
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 'all';
    ?>

    <div class="all-products-section">
        <?php
        // Fetch category items for the selected category ID
        $categoriesQuery = "SELECT * FROM categories WHERE id = $categoryId";
        $categoriesResult = mysqli_query($conn, $categoriesQuery);

        while ($category = mysqli_fetch_assoc($categoriesResult)) {
            $currentCategoryId = $category['id'];
            $categoryName = $category['c_name'];

            // Fetch items in the selected category or all if "all" is selected
            $itemsQuery = "
                SELECT 
                    p.id AS product_id, 
                    p.p_name, 
                    p.p_price, 
                    p.p_total_price,
                    p.product_discount,
                    p.image1, 
                    b.brand_rating,
                    b.brand_name,
                    b.id AS brand_id
                FROM items p 
                JOIN brands b ON p.brand_id = b.id 
                WHERE p.category_id = $currentCategoryId 
                ORDER BY p.created_at DESC";
            $itemsResult = mysqli_query($conn, $itemsQuery);

            // Display items only if category has products
            if (mysqli_num_rows($itemsResult) > 0) {
        ?>
        
        <!-- Section for each category -->
        <div class="category-section" data-category="category<?php echo $currentCategoryId; ?>">
            <h2 class="section-title flex">

                <div class="section-title">
                    <div class="short-line"></div>
                    <?php echo htmlspecialchars($categoryName); ?>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <p>Filter By</p>
                    <select id="category-select" disabled style='display: none;'>
                        <?php
                            $categoryQuery = "SELECT * FROM categories WHERE id = $categoryId";
                            $categoryResult = mysqli_query($conn, $categoryQuery);
                            if ($category = mysqli_fetch_assoc($categoryResult)) {
                                echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['c_name']) . '</option>';
                            }
                        ?>
                    </select>

                    <select id="brand-select" onchange="filterProducts()">
                        <option value="all">All Brands</option>
                    </select>

                    <button onclick="filterProducts()" style='display: none;'>Filter</button>
                </div>
            </h2>

            <div class="product-items">
                <?php while ($row = mysqli_fetch_assoc($itemsResult)) { ?>
                    <div class="product-card" data-category-id="<?php echo $currentCategoryId; ?>" data-brand-id="<?php echo $row['brand_id']; ?>">
                        <div class="product-img">
                            <a href="view_items.php?id=<?php echo $row['product_id']; ?>">
                                <img src="admin/<?php echo htmlspecialchars($row['image1']); ?>" alt="">
                            </a>
                        </div>
                        <div class="product-name">
                            <p><?php echo htmlspecialchars($row['p_name']); ?></p>
                        </div>
                        <div class="ratings">
                            <?php 
                            $rating = $row['brand_rating'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < floor($rating)) {
                                    echo '<i class="fa-solid fa-star"></i>';
                                } elseif ($i < ceil($rating) && $rating - $i >= 0.5) {
                                    echo '<i class="fa-solid fa-star-half-stroke"></i>';
                                } else {
                                    echo '<i class="fa-regular fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                        <div class="product-price">
                            <div class="cost-div">
                                <?php if ($row['product_discount'] > 0): ?>
                                    <b>₹ <?php echo number_format($row['p_total_price'], 2); ?></b>
                                    <div class="strike-cost flex">
                                        <p><strike>₹ <?php echo number_format($row['p_price']); ?></strike></p>
                                        <p class="off"><?php echo number_format($row['product_discount']); ?>% off</p>
                                    </div>
                                <?php else: ?>
                                    <b>₹ <?php echo number_format($row['p_total_price'], 2); ?></b>
                                <?php endif; ?>
                            </div>
                            <section>
                                <form action="">
                                    <p class="qty">
                                        <button type="button" class="qtyminus" aria-hidden="true">&minus;</button>
                                        <input type="number" name="qty" id="quantity-<?php echo $row['product_id']; ?>" min="1" max="10" step="1" value="1" readonly>
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
                           
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <a href="javascript:void(0);" onclick="addToCart(<?php echo $row['product_id']; ?>)">
                                    <i class="fa-solid fa-bolt" aria-hidden="true"></i> Buy Now
                                </a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" onclick="redirectToLogin(<?php echo $row['product_id']; ?>)">
                                    <i class="fa-solid fa-bolt" aria-hidden="true"></i> Buy Now
                                </a>
                            <?php } ?>
                        </div>
                        
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php 
            }
        }
        ?>
    </div>  

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    // Populate brands based on selected category and update product display
    function updateBrandOptions() {
        const categoryId = <?php echo $categoryId; ?>; // Use selected category ID
        fetch(`users/fetch_brands.php?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const brandSelect = document.getElementById("brand-select");
                brandSelect.innerHTML = '<option value="all">All Brands</option>';
                
                // Populate the brand dropdown with options
                data.brands.forEach(brand => {
                    const option = document.createElement("option");
                    option.value = brand.id;
                    option.textContent = brand.name;
                    brandSelect.appendChild(option);
                });
                filterProducts(); // Filter products based on initial selection
            });
    }

    // Filter products based on selected brand
    function filterProducts() {
        const selectedBrand = document.getElementById("brand-select").value;
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            const brandId = card.getAttribute("data-brand-id");
            const matchBrand = selectedBrand === "all" || selectedBrand === brandId;

            // Toggle visibility based on the match
            card.style.display = matchBrand ? "block" : "none";
        });
    }

    // Initial call to populate brands and apply filter
    updateBrandOptions();

    // Add event listener for brand selection change
    document.getElementById("brand-select").addEventListener("change", filterProducts);
});

    </script>
    <script src='assets/js/qty.js'></script>
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
        
        function redirectToLogin(productId) {
            const quantity = document.getElementById(`quantity-${productId}`).value;
            // Redirect with product_id and quantity as URL parameters
            window.location.href = `users/login.php?product_id=${encodeURIComponent(productId)}&quantity=${encodeURIComponent(quantity)}`;
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
            xhr.open('POST', 'users/add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText); // Show the server response
                    location.reload();
                    // You may want to refresh the cart display here
                    updateCartDisplay();
                }
            };

            // Send product_id and quantity to the server
            xhr.send('product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantity));
        }
    </script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
