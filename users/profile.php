<?php
session_start();
include 'includes/navbar.php';
include '../pages/db_conn.php';
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_sql = "SELECT * FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();

    // Fetch total orders count for this user
    $order_sql = "SELECT COUNT(*) AS total_orders FROM orders WHERE user_id = ?";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("i", $user_id);
    $order_stmt->execute();
    $order_result = $order_stmt->get_result()->fetch_assoc();
    $total_orders = $order_result['total_orders'] ?? 0;

    // Fetch total products in cart for this user
    $cart_sql = "SELECT COUNT(*) AS total_cart_items FROM addtocart WHERE user_id = ?";
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result()->fetch_assoc();
    $total_cart_items = $cart_result['total_cart_items'] ?? 0;
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <script src="https://kit.fontawesome.com/a8dce0582d.js" crossorigin="anonymous"></script>
    <title>Profile</title>
    <style>
        :root{
            --main-color: #000080;
            --second-color: #C11C43;
            --light-red: #C11C4359;
            --light-pink: #FFC2D0;
            --text-color: #000;
            --white-color: #fff;
            --body-color: #f6f8ff;
        }

        body{
            padding: 0;
            margin: 0;
            font-family: "Jost", sans-serif;
            background: var(--body-color);
        }
        .search-box {
            height: 36px;
        }
        .profile-container { 
            width: 90%; 
            max-width: 800px; 
            margin: 20px auto; 
            background-color: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .profile-info { 
            margin-bottom: 20px; 
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .profile-info p { 
            margin: 5px 0; 
        }
        .actions { 
            display: flex; 
            justify-content: space-between; 
        }
        .actions button { 
            background-color: #007bff; 
            color: #fff; 
            padding: 10px 20px; 
            border-radius: 5px; 
            cursor: pointer; 
            border: none; }
        .update-profile-popup { 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            background-color: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        .update-profile-popup input { 
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px; 
            border: 1px solid #ddd; 
        }
        .popup-overlay { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0, 0, 0, 0.5); 
            display: none; 
        }
        .card{
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            text-align: center;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Your Account</h2>

    <div class="profile-info">
        <p class='card'><strong><i class="fa-solid fa-user"></i> Name</strong> <br><?php echo htmlspecialchars($user['full_name']); ?></p>
        <p class='card'><strong><i class="fa-solid fa-phone"></i> Phone Number</strong><br> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p class='card'><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p class='card'><strong>Total Orders:</strong> <?php echo $total_orders; ?></p>
        <p class='card'><strong>Total Products in Cart:</strong> <?php echo $total_cart_items; ?></p>
    </div>

    <div class="actions">
        <button onclick="window.location.href='view_orders.php'">View Orders</button>
        <button onclick="window.location.href='add_address.php'">Add Address</button>
        <button onclick="openUpdateProfilePopup()">Update Profile</button>
    </div>
</div>

<!-- Update Profile Popup -->
<div class="popup-overlay" id="popup-overlay"></div>
<div class="update-profile-popup" id="update-profile-popup">
    <h3>Update Profile</h3>
    <form action="update_profile.php" method="POST">
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" placeholder="Full Name" required>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Phone Number" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email" required>
        <input type="password" name="password" placeholder="New Password (leave blank if no change)">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
        <button type="submit" name="update_profile">Update</button>
        <button type="button" onclick="closeUpdateProfilePopup()">Cancel</button>
    </form>
</div>

<script>
    function openUpdateProfilePopup() {
        document.getElementById('update-profile-popup').style.display = 'block';
        document.getElementById('popup-overlay').style.display = 'block';
    }

    function closeUpdateProfilePopup() {
        document.getElementById('update-profile-popup').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
    }
</script>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
