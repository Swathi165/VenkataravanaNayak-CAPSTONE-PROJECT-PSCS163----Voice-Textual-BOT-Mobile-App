<?php
session_start();
include '../pages/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Initialize response array
    $response = ['success' => false];

    // Update quantity in the addtocart table
    $update_sql = "UPDATE addtocart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    
    if ($update_stmt) {
        $update_stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $update_stmt->execute();
        
        if ($update_stmt->affected_rows > 0) { // Check if the update was successful
            // Fetch the new total price based on the updated quantity
            $price_sql = "SELECT p_total_price FROM items WHERE id = ?";
            $price_stmt = $conn->prepare($price_sql);
            
            if ($price_stmt) {
                $price_stmt->bind_param("i", $product_id);
                $price_stmt->execute();
                $price_result = $price_stmt->get_result();
                
                if ($price_row = $price_result->fetch_assoc()) {
                    $new_total_price = $quantity * $price_row['p_total_price'];
                    $response['success'] = true;
                    $response['new_total_price'] = $new_total_price;
                    $response['product_price'] = $price_row['p_total_price']; // Include product price if needed
                } else {
                    $response['message'] = "Product not found.";
                }
                
                $price_stmt->close();
            } else {
                $response['message'] = "Error fetching product price.";
            }
        } else {
            $response['message'] = "No changes made to the cart.";
        }
        
        $update_stmt->close();
    } else {
        $response['message'] = "Error updating quantity.";
    }
    
    // Return the updated total price as JSON
    echo json_encode($response);
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
