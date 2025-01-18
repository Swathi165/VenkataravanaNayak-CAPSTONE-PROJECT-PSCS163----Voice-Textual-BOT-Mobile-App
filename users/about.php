<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/about.css">
    <title>About Us</title>
</head>
<body>
    <?php include 'includes/navbar.php';?>
    <div class="about-section">
        <div class="about-banner">
            <img src="assets/images/about-banner.png" alt="">
            <div class="heading">
                <h1>About</h1>
                <h2>ShopSphere</h2>
                <p>Your trusted source for top-quality products. We provide cutting-edge solutions to keep you 
                secure and connected. Explore our range of products and enjoy the best in Shopping.</p>
            </div>
        </div>
        
        <!--About Us container-->
        <div class="about-container">
            <div class="about-flex">
                <div class="about-left">
                    <p class='title'>ABOUT US</p>
                    <h2>A BETTER WAY TO SHOP ONLINE WITH US!</h2>
                    <p class='text'>
                        ShopSphere, <b>established in 2024</b>, is your premier destination for high-quality online shopping solutions, specializing in the 
                        latest fashion trends and innovative security products. We are dedicated to providing an exceptional shopping experience, ensuring 
                        that our customers receive reliable and stylish products that keep them both secure and fashionable.
                    </p>
                    <div class="about-cards">
                        <div class="about-card">
                            <h3>125+</h3>
                            <p>UNIQUE PRODUCTS</p>
                        </div>
                        <div class="about-card">
                            <h3>1000+</h3>
                            <p>HAPPY CUSTOMERS</p>
                        </div>
                        <div class="about-card">
                            <h3>100+</h3>
                            <p>PRODUCT DEALERS</p>
                        </div>
                        <div class="about-card">
                            <h3>24 X 7</h3>
                            <p>PRODUCT SUPPORTS</p>
                        </div>

                    </div>
                </div>
                <div class="about-right">
                    <div class="img">
                        <img src="assets/images/logo.png" alt="logo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for client Carasoul--->
    <script>
        let index = 0;

        function moveSlide(step) {
            const slides = document.querySelectorAll('.testimonial-item');
            const totalSlides = slides.length;
            index = (index + step + totalSlides) % totalSlides; 
            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.style.transform = `translateX(${-index * 100}%)`;
        }
    </script>
    
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const aboutBanner = document.querySelector('.about-banner');
            const aboutLeft = document.querySelector('.about-left');
            const aboutRight = document.querySelector('.about-right');
            
            // Add 'show' class after the page loads
            setTimeout(() => {
                if (aboutBanner) aboutBanner.classList.add('show');
                if (aboutLeft) aboutLeft.classList.add('show');
                if (aboutRight) aboutRight.classList.add('show');
            }, 400); // Adjust the delay if needed
        });
    </script>

</body>
<?php include 'includes/footer.php'?>
</html>