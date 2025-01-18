
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/pop_card.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/slider.css">
    <link rel="stylesheet" href="../assets/css/chatbot.css">
    <title>ShopSphere</title>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-icon"><img src="https://i.pinimg.com/originals/06/ae/07/06ae072fb343a704ee80c2c55d2da80a.gif" alt="" width="100"></div>
            <p class="modal-message" id="modal-message"></p>
            <button class="modal-button" id="modal-ok-btn">OK</button>
        </div>
    </div>
    <div class="social-fixed">
        <ul>
            <li><a href="#"><i class="fa-brands fa-whatsapp"></i> What's App</a></li>
            <li><a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
            <li><a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
            <li><a href="#"><i class="fa-brands fa-youtube"></i> YouTube</a></li>
        </ul>
    </div>
    <marquee>
        Shop Sphere: Trusted products, quick delivery, and exceptional customer service. Shop with confidence and get everything you need at the best prices!
    </marquee>
    <!-- <div class="chevron">
        <a href="#banner"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
    </div> -->
    <div class="chatbot-container">
        <button class="chatbot-button" id="chatbotToggle"><img src="chatbot/chatbot.png" alt=""></button>
        <div class="chatbot" id="chatbot" style="display: none;">
            <div class="chat">
                <?php include 'chatbot/chat.html'?>
            </div>
        </div>
    </div>
    <div class="carousel" id='banner'>
        <div class="list">
            <div class="item">
                <img src="assets/images/dress-1.png">
                <div class="introduce">
                    <div class="title">Women's Wear</div>
                    <div class="topic">Princess-Line</div>
                    <div class="des">
                        The princess-line dress is a timeless silhouette known for its flattering fit and elegant design. Characterized by its seamless construction, the dress features a fitted bodice that flows into a gently flared skirt, creating a graceful and feminine shape.
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">Women's Wear</div>
                    <div class="des">
                        The princess-line dress is a timeless silhouette known for its flattering fit and elegant design. Characterized by its seamless construction, the dress features a fitted bodice that flows into a gently flared skirt, creating a graceful and feminine shape. This style often emphasizes the waist, enhancing the wearer's natural curves. Ideal for various occasions, from casual outings to formal events, the princess-line dress can be crafted from a range of fabrics, making it versatile and suitable for different seasons. Its classic appeal ensures that it remains a popular choice among fashion enthusiasts.
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="assets/images/dress-2.png">
                <div class="introduce">
                    <div class="title">Women's Wear</div>
                    <div class="topic">Empire-Waist</div>
                    <div class="des">
                        Step into a world of timeless fashion with our stunning collection of empire-waist dresses. Designed to flatter every figure, these dresses feature a high waistline that sits just below the bust, flowing gracefully into a skirt that accentuates your natural shape
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">Empire-Waist</div>
                    <div class="des">
                        Step into a world of timeless fashion with our stunning collection of empire-waist dresses. Designed to flatter every figure, these dresses feature a high waistline that sits just below the bust, flowing gracefully into a skirt that accentuates your natural shape. Perfect for any occasion, from casual outings to formal events, the empire-waist dress is a versatile addition to your wardrobe.   
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="assets/images/dress-3.png">
                <div class="introduce">
                    <div class="title">Men's wear</div>
                    <div class="topic">Waist Coats</div>
                    <div class="des">
                        Discover the perfect blend of sophistication and versatility with our collection of men's waist coats. 
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">Waist Coats</div>
                    <div class="des">
                        Discover the perfect blend of sophistication and versatility with our collection of men's waist coats. Often considered a staple in formal and semi-formal attire, waist coats add an elegant touch to any outfit. Whether you're dressing for a wedding, a business meeting, or a night out, a well-fitted waist coat can elevate your look to new heights.
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="assets/images/dress-4.png">
                <div class="introduce">
                    <div class="title">Men's Wear</div>
                    <div class="topic">Men's Coats</div>
                    <div class="des">
                        When it comes to elevating your wardrobe, a well-fitted coat is an essential piece that combines style, functionality, and comfort.
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">Men's Coats</div>
                    <div class="des">
                        When it comes to elevating your wardrobe, a well-fitted coat is an essential piece that combines style, functionality, and comfort. Our collection of men's coats is designed to meet the needs of every modern man, whether you're dressing for a formal occasion, a casual outing, or braving the elements.
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="assets/images/dress-5.png">
                <div class="introduce">
                    <div class="title">Children's Wear</div>
                    <div class="topic">Adorable and Stylish</div>
                    <div class="des">
                        Dress your little ones in style with our delightful collection of children's dresses! Designed with both comfort and fashion in mind, our dresses are perfect for every occasion, from birthday parties to family gatherings and everyday adventures.
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">Children's Wear</div>
                    <div class="des">
                        Dress your little ones in style with our delightful collection of children's dresses! Designed with both comfort and fashion in mind, our dresses are perfect for every occasion, from birthday parties to family gatherings and everyday adventures.
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="assets/images/dress-6.png">
                <div class="introduce">
                    <div class="title">Sneakers</div>
                    <div class="topic">Nike Sneakers</div>
                    <div class="des">
                        Nike sneakers are more than just footwear; they are a statement of style, performance, and innovation. Whether you’re hitting the gym, running errands, or making a fashion statement, Nike has a sneaker that fits your lifestyle.    
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">Nike Sneakers</div>
                    <div class="des">
                        Nike sneakers are more than just footwear; they are a statement of style, performance, and innovation. Whether you’re hitting the gym, running errands, or making a fashion statement, Nike has a sneaker that fits your lifestyle.
                    </div>
                </div>
            </div>
        </div>
        <div class="arrows">
            <button id="prev"><</button>
            <button id="next">></button>
        </div>
    </div>

    <!--Category-->
    <div class="category">
        <div class="heading">
            <div class="line"></div>
            <h2>Shop by categories</h2>
        </div>
        <div class="category-container">
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/dress-6.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Men's <br>Shoes</h2>
                </div>
            </a>
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/category-2.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Men's <br>Trousers</h2>
                </div>
            </a>
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/category-3.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Women's Wear</h2>
                </div>
            </a>
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/category-4.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Men's <br>Shirts</h2>
                </div>
            </a>
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/category-5.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Mens'<br>Suits</h2>
                </div>
            </a>
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/category-6.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Shoes</h2>
                </div>
            </a>
            <a href='#' class="category-item">
                <div class="category-img">
                    <img src="assets/images/category-7.png" alt="">
                </div>
                <div class="category-name">
                    <h2>Cosmetics</h2>
                </div>
            </a>
        </div>
    </div>

    <!---Fetch latest item per category-->
    <?php
        include '../pages/db_conn.php'; // Database connection file

        // Fetch latest item per category
        $query = "
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
            JOIN categories c ON p.category_id = c.id
            GROUP BY p.category_id 
            ORDER BY p.created_at DESC
        ";
        $result = mysqli_query($conn, $query);
    ?>

     <!---Product Container-->
     <div class="product-container" id='best_selling'>
        <div class="heading">
            <h4>Most People Choose</h4>
            <h3>BEST SELLING</h3>
        </div>
        
        <!-- Swiper container -->
        <div class="swiper-container" style=" overflow-x: hidden;">
            <div class="swiper-wrapper">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <!-- Swiper slide for each product card -->
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="product-img">
                                <a href="view_items.php?id=<?php echo $row['product_id']; ?>">
                                    <img src="../admin/<?php echo htmlspecialchars($row['image1']); ?>" alt="">
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
                                        <div class='strike-cost'><p><strike>₹ <?php echo number_format($row['p_price']); ?></strike></p> <p class='off'><?php echo number_format($row['product_discount']); ?>% off</p></div>
                                    <?php else: ?>
                                        <b>₹ <?php echo number_format($row['p_total_price']); ?></b>
                                    <?php endif; ?>
                                </div>
                                <section>
                                    <form action="">
                                        <p class="qty">
                                            <button type="button" class="qtyminus" aria-hidden="true">&minus;</button>
                                            <input type="number" name="qty" id="qty-<?php echo $row['product_id']; ?>" min="1" max="10" step="1" value="1" readonly>
                                            <button type="button" class="qtyplus" aria-hidden="true">&plus;</button>
                                        </p>
                                    </form>            
                                </section>
                            </div>
                            <div class="cart-button">
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <a href="javascript:void(0);" onclick="addToCart(<?php echo $row['product_id']; ?>)"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0);" onclick="redirectToLogin(<?php echo $row['product_id']; ?>)"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart</a>
                                <?php } ?>

                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <a href="javascript:void(0);" onclick="addToCart(<?php echo $row['product_id']; ?>)"><i class="fa-solid fa-bolt" aria-hidden="true"></i> Buy Now</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0);" onclick="redirectToLogin(<?php echo $row['product_id']; ?>)"><i class="fa-solid fa-bolt" aria-hidden="true"></i> Buy Now</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Swiper Pagination and Navigation -->
            <div class="swiper-flex">
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <div class="view-all-btn">
            <a href='all.php' class="btn">View More</a>
        </div>
    </div>

    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 4,      // Default number of slides for larger screens
            spaceBetween: 20,      // Default space between slides
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1440: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                1024: { // For screens 1024px and below
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: { // For screens 768px and below
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                425: { // For screens 425px and below (small mobile)
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                375: { // For screens 375px and below (small mobile)
                    slidesPerView: 1,
                    spaceBetween: 8,
                },
                320: { // For screens 320px and below (extra small mobile)
                    slidesPerView: 1,
                    spaceBetween: 5,
                }
            }
        });
    </script>

    <!--- Discount Container-->
    <div class="discount-section">
        <div class="discount-container">
            <?php  $query = "SELECT * FROM offers WHERE activation_status = 1 LIMIT 1";
                $result = $conn->query($query);

                $offer = $result->fetch_assoc();
            ?>
            <?php if ($offer): ?>
                <div class="discount-text">
                <div class="discount-name">
                        <p>Cameras & Accessories</p>
                    </div>
                    <div class="grab-text">
                        <?php echo htmlspecialchars($offer['headlines']); ?>
                    </div>
                    <p>
                        <?php echo nl2br(htmlspecialchars($offer['description'])); ?>
                    </p><br>
                    <a href='' class="btn">
                        Discover More
                    </a>
                </div>
                <div class="discount-img">
                    <img src="../admin/product_images/<?php echo htmlspecialchars($offer['image']); ?>" alt="Offer Image">
                </div>
            <?php else: ?>
                <div class="discount-text">
                    <div class="grab-text">
                        Offers Coming Soon
                    </div>
                    <p>
                        Currently, there are no active offers. Please check back later for exciting deals.
                    </p><br>
                    <a href='' class="btn">
                        Discover More
                    </a>
                </div>
                <div class="discount-img">
                    <img src="../assets/images/logo.png" alt="Default Image">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Hightlights Products-->
    <?php
        include '../pages/db_conn.php'; // Database connection file

        // Step 1: Get all unique categories
        $category_query = "SELECT DISTINCT category_id FROM items";
        $category_result = mysqli_query($conn, $category_query);

        $products = [];
        while ($category = mysqli_fetch_assoc($category_result)) {
            // Step 2: Fetch one random product per category
            $category_id = $category['category_id'];
            $product_query = "
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
                WHERE p.category_id = $category_id 
                ORDER BY RAND() 
                LIMIT 1";
            
            $product_result = mysqli_query($conn, $product_query);
            $product = mysqli_fetch_assoc($product_result);
            
            if ($product) {
                $products[] = $product;
            }

            // Stop after four products
            if (count($products) >= 4) {
                break;
            }
        }
    ?>

<!-- Product Container -->
    <div class="highlits">
        <div class="heading">
            <h4>HIGHLIGHTED</h4>
            <h3>FEATURE PRODUCTS</h3>
        </div>
        <div class="product-items">
            <?php foreach ($products as $row): ?>
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
                                // Display filled, half, and unfilled stars based on brand rating
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
                                <div class='strike-cost'>
                                    <p><strike>₹ <?php echo number_format($row['p_price']); ?></strike></p>
                                    <p class='off'><?php echo number_format($row['product_discount']); ?>% off</p>
                                </div>
                            <?php else: ?>
                                <b>₹ <?php echo number_format($row['p_total_price']); ?></b>
                            <?php endif; ?>
                        </div>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button type="button" class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty-<?php echo $row['product_id']; ?>" min="1" max="10" step="1" value="1">
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
            <?php endforeach; ?>
        </div>
        <div class="view-all-btn">
            <a href='all.php' class="btn">View More</a>
        </div>
    </div>

    <div class="subscribe-section">
        <div class="subscribe-container">
            <div class="sub-img">
                <img src="assets/images/logo.png" alt="">
            </div>
            <div class="sub-text">
                <div class="heading">
                    SUBSCRIBE
                </div>
                <h3>STAY UPTO DATE WITH <br>THE LATEST NEWS !</h3>
                <p>Subscribe to our newsletter and get the latest deals, updates, and exclusive offers straight to your inbox.</p>
                <form class="subscribe">
                    <input placeholder="Enter Your E-mail" class="subscribe-input" name="email" type="email" required>
                    <br>
                    <input class="submit-btn" type="submit" value="SUBSCRIBE">
                </form>

            </div>
        </div>
    </div>

    <!--Brand Names-->
    <div class="brands">
        <h2>Our Brands</h2>
        <div class="brand-slider">
        <div class="slide-track">
                <div class="slide"><img src="Branches_img/Bengaluru.png" alt="Brand 1"><p>Bengaluru</p></div>
                <div class="slide"><img src="Branches_img/Mysuru.png" alt="Brand 4"><p>Mysuru</p></div>
                <div class="slide"><img src="Branches_img/Doddaballapur.png" alt="Brand 3"><p>Doddaballapur</p></div>
                <div class="slide"><img src="Branches_img/hosur.png" alt="Brand 4"><p>Hosur</p></div>
                <div class="slide"><img src="Branches_img/Hydrabad.png" alt="Brand 2"><p>Hydrabad</p></div>
                <div class="slide"><img src="Branches_img/Kolar.png" alt="Brand 5"><p>Kolar</p></div>
                <div class="slide"><img src="Branches_img/Tumkur.png" alt="Brand 5"><p>Tumkur</p></div>
                <!-- Repeat the logos for infinite loop -->
                <div class="slide"><img src="Branches_img/Bengaluru.png" alt="Brand 1"><p>Bengaluru</p></div>
                <div class="slide"><img src="Branches_img/Mysuru.png" alt="Brand 4"><p>Mysuru</p></div>
                <div class="slide"><img src="Branches_img/Doddaballapur.png" alt="Brand 3"><p>Doddaballapur</p></div>
                <div class="slide"><img src="Branches_img/hosur.png" alt="Brand 4"><p>Hosur</p></div>
                <div class="slide"><img src="Branches_img/Hydrabad.png" alt="Brand 2"><p>Hydrabad</p></div>
                <div class="slide"><img src="Branches_img/Kolar.png" alt="Brand 5"><p>Kolar</p></div>
                <div class="slide"><img src="Branches_img/Tumkur.png" alt="Brand 5"><p>Tumkur</p></div>
                <!-- Repeat the logos for infinite loop -->
                <div class="slide"><img src="Branches_img/Bengaluru.png" alt="Brand 1"><p>Bengaluru</p></div>
                <div class="slide"><img src="Branches_img/Mysuru.png" alt="Brand 4"><p>Mysuru</p></div>
                <div class="slide"><img src="Branches_img/Doddaballapur.png" alt="Brand 3"><p>Doddaballapur</p></div>
                <div class="slide"><img src="Branches_img/hosur.png" alt="Brand 4"><p>Hosur</p></div>
                <div class="slide"><img src="Branches_img/Hydrabad.png" alt="Brand 2"><p>Hydrabad</p></div>
                <div class="slide"><img src="Branches_img/Kolar.png" alt="Brand 5"><p>Kolar</p></div>
                <div class="slide"><img src="Branches_img/Tumkur.png" alt="Brand 5"><p>Tumkur</p></div>
            </div>
        </div>
    </div>

    <div class="support-container">
        <div class="support-card">
            <div class="support-icon">
                <i class="fa fa-truck" aria-hidden="true"></i>
            </div>
            <div class="support-text">
                <p>FREE <br>SHIPPING</p>
            </div>
        </div>
        <div class="support-card">
            <div class="support-icon">
                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
            </div>
            <div class="support-text">
                <p>ONLINE <br>PAYMENT</p>
            </div>
        </div>
        <div class="support-card">
            <div class="support-icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="support-text">
                <p>24 X 7 <br>SUPPORT</p>
            </div>
        </div>
        <div class="support-card">
            <div class="support-icon">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
            </div>
            <div class="support-text">
                <p>Timely <br>Delivery</p>
            </div>
        </div>
    </div>

    
    <!---Chatbot Script--->
    <script>
        document.getElementById('chatbotToggle').addEventListener('click', function() {
            document.getElementById('chatbot').style.display = 'block'; // Show chatbot
            this.style.display = 'none'; // Hide chatbot button
        });

        document.getElementById('closeChatbot').addEventListener('click', function() {
            document.getElementById('chatbot').style.display = 'none'; // Hide chatbot
            document.getElementById('chatbotToggle').style.display = 'block'; // Show chatbot button
        });
    </script>


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
        function redirectToLogin() {
            const currentUrl = window.location.href;
            window.location.href = `login.php?redirect=${encodeURIComponent(currentUrl)}`;
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
                    showModal(xhr.responseText); 
                    // You may want to refresh the cart display here
                    updateCartDisplay();
                }
            };

            // Send product_id and quantity to the server
            xhr.send('product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantity));
        }
    </script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/qty.js"></script>
    <script src="assets/js/anime.js"></script>
    <?php include 'includes/footer.php'?>
</body>
</html>