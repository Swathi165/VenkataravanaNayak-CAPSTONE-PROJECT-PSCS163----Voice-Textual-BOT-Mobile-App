<?php
session_start();
include '../pages/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "You need to log in to add items to your cart.";
        exit;
    }

    // Get the product ID and quantity from the POST request
    $userId = $_SESSION['user_id'];
    $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = (int)$_POST['quantity'];

    // Check if quantity is valid
    if ($quantity <= 0) {
        echo "Invalid quantity.";
        exit;
    }

    // Check if the product already exists in the cart for this user
    $checkQuery = "
        SELECT quantity FROM addtocart 
        WHERE user_id = '$userId' AND product_id = '$productId'
    ";
    $result = mysqli_query($conn, $checkQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        // Product exists, so update the quantity
        $row = mysqli_fetch_assoc($result);
        $newQuantity = $row['quantity'] + $quantity;

        $updateQuery = "
            UPDATE addtocart 
            SET quantity = '$newQuantity' 
            WHERE user_id = '$userId' AND product_id = '$productId'
        ";

        if (mysqli_query($conn, $updateQuery)) {
            echo "Product quantity updated successfully!";
        } else {
            echo "Error updating product quantity: " . mysqli_error($conn);
        }
    } else {
        // Product does not exist, so insert a new row
        $insertQuery = "
            INSERT INTO addtocart (user_id, product_id, quantity)
            VALUES ('$userId', '$productId', '$quantity')
        ";

        if (mysqli_query($conn, $insertQuery)) {
            echo "Product added to cart successfully!";
        } else {
            echo "Error adding product to cart: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request method.";
}
?>
