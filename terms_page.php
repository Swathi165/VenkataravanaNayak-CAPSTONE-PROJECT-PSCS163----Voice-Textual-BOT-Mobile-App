<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title>Terms and Conditions - Shiva Gowri Enterprise</title>
    <style>
        /* assets/css/terms.css */
        @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Kannada:wght@100..900&family=Poppins:wght@300;400;500;700;800&display=swap');
        body {
            font-family: "Jost", sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .headings {
            text-align: center;
            padding: 20px;
        }

        .heading  h1 {
            margin: 0;
            font-size: 2em;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        section {
            margin-bottom: 20px;
        }

        section h2 {
            font-size: 1.5em;
            color: #000080;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        section p, section ul {
            line-height: 1.6;
            font-size: 1em;
            color: #555;
        }

        section ul {
            list-style-type: none;
            padding: 0;
        }

        section ul li {
            padding: 5px 0;
        }

        section ul li a {
            color: #007bff;
            text-decoration: none;
        }

        section ul li a:hover {
            text-decoration: underline;
        }
        
        /* Responsive Design */
        @media (max-width: 600px) {
            main {
                padding: 10px;
                margin: 10px;
            }

            .heading  h1 {
                font-size: 1.5em;
            }

            section h2 {
                font-size: 1.2em;
            }
        }

    </style>
</head>
<body>
    <?php include 'includes/navbar.php';?>
    <div class='headings'>
        <h1>Terms and Conditions</h1>
    </div>

    <main>
        <section>
            <h2>1. Introduction</h2>
            <p>Welcome to Shiva Gowri Enterprise. These Terms and Conditions govern your use of our website and the purchase of products. By accessing or using our site, you agree to be bound by these terms.</p>
        </section>

        <section>
            <h2>2. Definitions</h2>
            <p>"We", "us", and "our" refer to Shiva Gowri Enterprise. "You" and "your" refer to the user or customer accessing our website.</p>
        </section>

        <section>
            <h2>3. User Accounts</h2>
            <p>You may need to create an account to place orders. You are responsible for maintaining the confidentiality of your account information and for all activities under your account.</p>
        </section>

        <section>
            <h2>4. Product Information</h2>
            <p>We strive to provide accurate product information, including descriptions, images, and prices. However, errors may occur, and we reserve the right to correct any errors, inaccuracies, or omissions.</p>
        </section>

        <section>
            <h2>5. Orders and Payments</h2>
            <p>All orders are subject to availability and acceptance. We reserve the right to cancel or refuse any order for any reason. Payments must be made in full at the time of purchase. Prices are subject to change without notice.</p>
        </section>

        <section>
            <h2>6. Shipping and Delivery</h2>
            <p>We will make every effort to deliver your products promptly. Delivery times may vary based on your location and other factors. We are not responsible for delays caused by external factors such as weather or logistics issues.</p>
        </section>

        <section>
            <h2>7. Returns and Refunds</h2>
            <p>If you are not satisfied with your purchase, you may request a return or refund within [specify number] days of receiving your order, subject to our return policy.</p>
        </section>

        <section>
            <h2>8. Limitation of Liability</h2>
            <p>We are not liable for any damages, including but not limited to direct, indirect, incidental, or consequential damages, arising from your use of our website or products.</p>
        </section>

        <section>
            <h2>9. Intellectual Property</h2>
            <p>All content on our website, including text, images, and logos, is the property of Shiva Gowri Enterprise and is protected by copyright laws. You may not use, copy, or distribute any content without our permission.</p>
        </section>

        <section>
            <h2>10. Governing Law</h2>
            <p>These Terms and Conditions are governed by the laws of [Your State/Country]. Any disputes arising from these terms will be resolved in the appropriate courts of [Your State/Country].</p>
        </section>

        <section>
            <h2>11. Changes to These Terms</h2>
            <p>We may update these Terms and Conditions periodically. Your continued use of our website signifies your acceptance of any changes.</p>
        </section>

        <section>
            <h2>12. Contact Us</h2>
            <p>If you have any questions about these Terms and Conditions, please contact us at:</p>
            <ul>
                <li>Email: <a href="mailto:support@shivagowrienterprise.com">support@shivagowrienterprise.com</a></li>
                <li>Phone: [Your Contact Number]</li>
                <li>Address: [Your Office Address]</li>
            </ul>
        </section>
    </main>
    <?php include 'includes/footer.php'?>
</body>
</html>
