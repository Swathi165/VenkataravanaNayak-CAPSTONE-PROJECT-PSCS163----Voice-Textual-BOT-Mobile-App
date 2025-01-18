<?php
    include '../pages/db_conn.php';
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login");
        exit();
    }
    // Assuming user_id is stored in session
    $user_id = $_SESSION['user_id'];

    // Query to get total quantity and total price for the logged-in user
    $query = "
        SELECT SUM(a.quantity) AS total_quantity, SUM(i.p_total_price * a.quantity) AS total_price
        FROM addtocart a
        JOIN items i ON a.product_id = i.id
        WHERE a.user_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $total_quantity = $row['total_quantity'] ?? 0;
    $total_price = $row['total_price'] ?? 0.00;
?>

<script src="https://kit.fontawesome.com/a8dce0582d.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="includes/css/navbar.css">
<style>
    /* Style for dropdown */
    .nav .dropdown {
        position: relative;
        display: inline-block;
    }

    .nav .dropdown-toggle {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .nav .dropdown-toggle i {
        margin-left: 5px;
        font-size: 0.8em;
    }

    .nav .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 4px;
        overflow: hidden;
    }

    .nav .dropdown-menu a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .nav .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }
</style>
<header>
    <!--- Mobile-navbar--->
    <div class="mobile-navbar">
        <div class="mobile-info">
            <div class="top-item">
                <i class="fa-solid fa-phone"></i>
                <a href="tel:1234567890">+91 890 431 0529</a>
            </div>
            <div class="top-item">
                <i class="fa-solid fa-envelope"></i>
                <a href="mailto:support@shopspherecom">support@shopsphere.com</a>
            </div>
            <div class="top-item">
                <i class="fa-solid fa-location-dot"></i>
                <a href="#">Bengaluru, Karnataka</a>
            </div>
        </div>
        <!-- search bar in navbar -->
        <div class="mobile-search">
            <div class="search-box box">
                <form action="search" method="GET">
                    <input type="text" placeholder="Search items" name="search" required>
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="mobile-nav-items">
            <nav>
                <ul class='nav-list'>
                    <li><a href="home"><i class="fa-solid fa-house"></i><br>Home</a></li>
                    <li class='hide'><a href="view_orders"><i class="fa-solid fa-calendar-days"></i><br>Orders</a></li>
                    <li><a href="profile"><i class="fa-solid fa-user"></i><br>User</a></li>
                    <li class='home'><a href="shop"><i class="fa-solid fa-layer-group"></i><br>More</a></li>
                    <li class='hide'><a href="contact"><i class="fa-solid fa-phone"></i><br>Contact</a></li>
                    <li><a href="view_cart"><i class="fa-solid fa-cart-shopping"></i><br>Cart(<?php echo $total_quantity; ?>)</a></li>
                    <li>
                        <div id="menu-icon-top" class="menu-icon">
                            <i class="fa-solid fa-bars"></i><br>Menu
                        </div>
                    </li>   
                </ul>
            </nav>
        </div>
    </div>
    <!---Top-nav--->
    <div class="top-nav">
        <div class="top-item">
            <i class="fa-solid fa-phone"></i>
            <a href="tel:1234567890">+91 890 431 0529</a>
        </div>
        <div class="top-item">
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:support@shopsphere.com">support@shopsphere.com</a>
        </div>
        <div class="top-item">
            <i class="fa-solid fa-location-dot"></i>
            <a href="#">Bengaluru, Karnataka</a>
        </div>
    </div>

    <!---Center Navbar-->
    <div class="nav">
        <div class="nav-item">
            <!-- Logo -->
            <a href="home">
                <div class="logo">
                    <img src="assets/images/logo.png" alt="logo">
                </div>
            </a>

            <!-- Search bar -->
            <div class="search">
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" placeholder="Search items" name="search" required>
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Menu Icon and Nav Right -->
            <div class="mobile-nav">
                <div class="nav-right">
                    <div class="nav-item right-item">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <a href="view_cart">Cart(<?php echo $total_quantity; ?>) ₹<?php echo number_format($total_price); ?></a>
                        <!--<a href="view_cart.php">cart(<?php echo $total_quantity; ?>) - $<?php echo number_format($total_price, 2); ?></a>-->
                    </div>
                    <div class="nav">
                        <!-- Other navigation items -->
                        <div class="nav-item right-item">
                            <i class="fa-solid fa-user"></i>
                            <?php if (isset($_SESSION['full_name'])): ?>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle">Profile <i class="fa fa-caret-down"></i></a>
                                    <div class="dropdown-menu">
                                        <a href="profile"><?php echo htmlspecialchars($_SESSION['full_name']); ?></a>
                                        <a href="logout">Logout</a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="login">Login</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- <div id="menu-icon-mobile" class="menu-icon">
                    <i class="fa-solid fa-bars"></i>
                </div> -->
            </div>
        </div>
    </div>
    
    <!--Lower Navbar -->
    <nav class="navbar">
        <ul class="navbar-menu">
            <div class="box-category">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" onclick="event.preventDefault();">Categories <span>&#9662;</span></a>
                    <ul class="dropdown-menu">
                        <?php
                            // Include the database connection file
                            include '../pages/db_conn.php';

                            // Fetch all categories from the categories table
                            $categoryQuery = "SELECT * FROM categories";
                            $categoryResult = mysqli_query($conn, $categoryQuery);

                            // Check if categories were found and display each as a menu item
                            if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                                while ($category = mysqli_fetch_assoc($categoryResult)) {
                                    // Default to a generic link with the category ID if 'link' column is missing
                                    $categoryLink = "products?category_id=" . urlencode($category['id']);
                                    echo '<li><a href="' . $categoryLink . '">' . htmlspecialchars($category['c_name']) . '</a></li>';
                                }
                            } else {
                                echo '<li>No categories found</li>';
                            }

                            // Close the database connection
                            mysqli_close($conn);
                        ?>
                    </ul>
                </li>
            </div>

            <li><a href="home">Home</a></li>
            <li><a href="about">About Us</a></li>
            <li><a href="home#best_selling">Best Selling </a></li>
            <li><a href="shop">Shop</a></li>
            <li><a href="contact">Contact Us</a></li>
            <li><a href="view_orders">Orders</a></li>
            <a href="view_cart"><i class="fa-solid fa-cart-shopping"></i> Cart(<?php echo $total_quantity; ?>)</a>
        </ul>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Get all dropdown toggles and menus
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');

        // Toggle dropdown menu visibility when clicking on the toggle
        dropdownToggles.forEach((toggle, index) => {
            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                dropdownMenus[index].style.display = 
                    dropdownMenus[index].style.display === 'block' ? 'none' : 'block';
            });
        });

        // Close dropdowns if clicked outside
        document.addEventListener('click', (event) => {
            dropdownToggles.forEach((toggle, index) => {
                if (!toggle.contains(event.target) && !dropdownMenus[index].contains(event.target)) {
                    dropdownMenus[index].style.display = 'none';
                }
            });
        });
    });

    // Select all nav links
    const navLinks = document.querySelectorAll('.nav-list li a');

    // Function to set active class based on URL
    function setActiveIcon() {
        // Get current URL path
        const currentPath = window.location.pathname.split("/").pop(); // e.g., "shop.php"

        let isMatchFound = false;

        // Loop through nav links
        navLinks.forEach(link => {
            // Remove any previous active class
            link.classList.remove('active');

            // Check if the href matches the current path
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
                isMatchFound = true;
            }
        });

        // If no match found, default to home icon
        if (!isMatchFound) {
                document.querySelector('.nav-list li a[href="home"]').classList.add('active');
        }
    }

    // Run the function when the page loads
    window.addEventListener('DOMContentLoaded', setActiveIcon);

</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.querySelector('.navbar');
        const menuIcon = document.querySelector('.menu-icon');
        const navbarMenu = document.querySelector('.navbar-menu');

        // Fix navbar on scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > navbar.offsetTop) {
                navbar.classList.add('fixed');
            } else {
                navbar.classList.remove('fixed');
            }
        });

        // Mobile menu toggle
        menuIcon.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
        });
    });
</script>



