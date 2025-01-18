<?php
session_start();
include '../pages/db_conn.php';

$error = "";
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../users/home';
$productToAdd = isset($_GET['product_id']) ? $_GET['product_id'] : null;
$quantityToAdd = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrPhone = mysqli_real_escape_string($conn, $_POST['email_or_phone']);
    $password = $_POST['password'];

    // Check if email/phone exists in the database
    $query = "SELECT * FROM users WHERE email = '$emailOrPhone' OR phone = '$emailOrPhone'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password hash
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];

            // Add the product to the cart immediately after login if product and quantity are set
            if ($productToAdd && $quantityToAdd) {
                $user_id = $user['id'];

                // Check if product already exists in the cart for the user
                $checkCartQuery = "SELECT quantity FROM addtocart WHERE user_id = '$user_id' AND product_id = '$productToAdd'";
                $cartResult = mysqli_query($conn, $checkCartQuery);

                if (mysqli_num_rows($cartResult) > 0) {
                    // Product exists, update the quantity
                    $existingCart = mysqli_fetch_assoc($cartResult);
                    $newQuantity = $existingCart['quantity'] + $quantityToAdd;
                    $updateCartQuery = "UPDATE addtocart SET quantity = '$newQuantity' WHERE user_id = '$user_id' AND product_id = '$productToAdd'";
                    mysqli_query($conn, $updateCartQuery);
                } else {
                    // Product does not exist, insert a new row
                    $addCartQuery = "INSERT INTO addtocart (user_id, product_id, quantity) VALUES ('$user_id', '$productToAdd', '$quantityToAdd')";
                    mysqli_query($conn, $addCartQuery);
                }
            }

            // Redirect to the original page
            header("Location: $redirect");
            exit;
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <!-- Left Image Section -->
        <div class="image-container">
            <h1>ShopSphere</h1>
            <p>Get access to your Orders, Wishlist and Recommendations</p>
        </div> 

        <!-- Right Form Section -->
        <div class="form-container"> 
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            
            <h2>Login</h2>
            <form action="login?redirect=<?php echo urlencode($redirect); ?>&product_id=<?php echo htmlspecialchars($productToAdd); ?>&quantity=<?php echo htmlspecialchars($quantityToAdd); ?>" method="POST">
                <label for="email_or_phone">Email or Phone</label>
                <input type="text" name="email_or_phone" id="email_or_phone" required>
                
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                
                <button type="submit">Login</button>
            </form>
            
            <p>Don't have an account? <a href="register_form">Sign up</a></p>
        </div>
    </div>
</body>
</html>
