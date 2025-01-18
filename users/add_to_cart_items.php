<?php
session_start();
header('Content-Type: application/json');

include '../pages/db_conn.php';

$response = [
    "success" => false,
    "message" => ""
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $response["message"] = "You need to log in to add items to your cart.";
        echo json_encode($response);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['product_id']) || empty($data['quantity'])) {
        $response["message"] = "Product ID and quantity are required.";
        echo json_encode($response);
        exit;
    }

    $productId = mysqli_real_escape_string($conn, $data['product_id']);
    $quantity = (int)$data['quantity'];

    if ($quantity <= 0) {
        $response["message"] = "Invalid quantity.";
        echo json_encode($response);
        exit;
    }

    // Check if the product already exists in the cart
    $checkQuery = "SELECT quantity FROM addtocart WHERE user_id = '$userId' AND product_id = '$productId'";
    $result = mysqli_query($conn, $checkQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update quantity if product exists
        $row = mysqli_fetch_assoc($result);
        $newQuantity = $row['quantity'] + $quantity;

        $updateQuery = "UPDATE addtocart SET quantity = '$newQuantity' WHERE user_id = '$userId' AND product_id = '$productId'";
        if (mysqli_query($conn, $updateQuery)) {
            $response["success"] = true;
            $response["message"] = "Product quantity updated successfully!";
        } else {
            $response["message"] = "Error updating product quantity: " . mysqli_error($conn);
        }
    } else {
        // Insert new product if not exists
        $insertQuery = "INSERT INTO addtocart (user_id, product_id, quantity) VALUES ('$userId', '$productId', '$quantity')";
        if (mysqli_query($conn, $insertQuery)) {
            $response["success"] = true;
            $response["message"] = "Product added to cart successfully!";
        } else {
            $response["message"] = "Error adding product to cart: " . mysqli_error($conn);
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
?>
