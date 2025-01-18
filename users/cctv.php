<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/category.css">
    <title>CCTV Page</title>
</head>
<body>
    <?php include 'includes/navbar.php'?>

    <div class="cctv-section">
        <div class="brand-filter">
            <label for="brand-select">Filter by Brand:</label>
            <select id="brand-select">
                <option value="all">All Brands</option>
                <option value="brand1">Brand 1</option>
                <option value="brand2">Brand 2</option>
                <option value="brand3">Brand 3</option>
            </select>
            <div class="brands">
                <div class="brand-title">
                    Avaliable Brands
                </div>
                <div class="line"></div>
                <p>Brand Name</p>
                <p>Brand Name</p>
                <p>Brand Name</p>
                <p>Brand Name</p>
                <p>Brand Name</p>
            </div>
        </div>

        <div class="product-container" id='best_selling'>
            <div class="heading">
                <h3>BEST SELLING CAMERAS</h3>
            </div>
            <div class="product-items">
                <div class="product-card" data-brand="brand1">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand1">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand3">
                    <div class="product-img">
                    <a href="">
                            <img src="assets/images/img1.png" alt="">
                    </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand2">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand2">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand3">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand3">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
                <div class="product-card" data-brand="brand1">
                    <div class="product-img">
                        <a href="">
                            <img src="assets/images/img1.png" alt="">
                        </a>
                    </div>
                    <div class="product-name">
                        <p>CCTV Camera</p>
                        <div class="ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <p>₹ 1500</p>
                        <section>
                            <form action="">
                                <p class="qty">
                                    <button class="qtyminus" aria-hidden="true">&minus;</button>
                                    <input type="number" name="qty" id="qty" min="1" max="10" step="1" value="1">
                                    <button class="qtyplus" aria-hidden="true">&plus;</button>
                                </p>
                            </form>			
                        </section>
                    </div>
                    <div class="cart-button">
                        <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD TO CART</a>
                        <a href="">BUY NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'?>
    <!--Filter by Brand Script-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const brandSelect = document.getElementById('brand-select');
            const productCards = document.querySelectorAll('.product-card');

            const filterByBrand = () => {
                const selectedBrand = brandSelect.value;
                
                productCards.forEach(card => {
                    // Assuming each card has a data-brand attribute like data-brand="brand1"
                    const cardBrand = card.getAttribute('data-brand');

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

    <!-- animation of cards script-->
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        const brandFilter = document.querySelector('.brand-filter');
        const productCards = document.querySelectorAll('.product-card');
        
        // Add 'show' class to the brand filter after the page loads
        setTimeout(() => {
            if (brandFilter) brandFilter.classList.add('show');
        }, 400);

        // Add 'show' class to each product card one by one
        productCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('show');
            }, 400 + (index * 200)); // Adjust the delay between each card as needed
        });
    });
</script>

    <script src="assets/js/qty.js"></script>
</body>
</html>