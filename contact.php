<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/contact.css">
    <title>Contact Us</title>
</head>
<body>
    <?php include 'includes/navbar.php';?>

    <div class="contact-page">
        <div class="contact-container">
            <!-- Contact Form (Left Side) -->
            <div class="contact-form">
                <h2>Contact Us</h2>
                <form action="#" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="tel" name="phone" placeholder="Your Phone No.">
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
                    <button type="submit">Submit</button>
                </form>
            </div>

            <!-- Contact Details (Right Side) -->
            <div class="contact-details">
                <h2>Get In Touch</h2>
                <div class="contact-info">
                    <p><i class="fas fa-phone"></i> +1 234 567 890</p>
                    <p><i class="fas fa-envelope"></i> support@yourwebsite.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Main Street, City, Country</p>
                </div>
                <img src="assets/images/contactus.jpg" alt="">
            </div>
        </div>

        <!-- Google Maps Iframe (Bottom) -->
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345086104!2d144.95373531531856!3d-37.8162791797519!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f5d765fd%3A0x5045675218ce7e33!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sin!4v1612760073334!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const contactform = document.querySelector('.contact-form');
            const contactdetails = document.querySelector('.contact-details');

            // Add 'show' class after the page loads
            setTimeout(() => {
                if (contactform) contactform.classList.add('show');
                if (contactdetails) contactdetails.classList.add('show');
            }, 400); // Adjust the delay if needed
        });
    </script>
    <?php include 'includes/footer.php';?>
</body>
</html>
