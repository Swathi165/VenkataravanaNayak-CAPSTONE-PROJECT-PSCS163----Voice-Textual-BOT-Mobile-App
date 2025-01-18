<?php
session_start();
include '../pages/db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $address_type = $_POST['address_type'];
    $full_name = htmlspecialchars($_POST['full_name']);
    $street_address = htmlspecialchars($_POST['street_address']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $postal_code = htmlspecialchars($_POST['postal_code']);
    $country = htmlspecialchars($_POST['country']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $is_default = isset($_POST['is_default']) ? 1 : 0;

    // If setting as default, reset default on existing addresses for this user and type
    if ($is_default) {
        $reset_default_sql = "UPDATE address SET is_default = 0 WHERE user_id = ? AND address_type = ?";
        $reset_stmt = $conn->prepare($reset_default_sql);
        $reset_stmt->bind_param("is", $user_id, $address_type);
        $reset_stmt->execute();
    }

    // Insert new address
    $sql = "INSERT INTO address (user_id, address_type, full_name, street_address, city, state, postal_code, country, phone_number, is_default)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssi", $user_id, $address_type, $full_name, $street_address, $city, $state, $postal_code, $country, $phone_number, $is_default);

    if ($stmt->execute()) {
        $message = "Address added successfully.";
        sleep(2);
        header('Location: checkout.php');
    } else {
        $message = "Error adding address. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Address</title>
    <style>
        .container {
            font-size: larger;
            margin: 10px auto;
            width: 80%;
            padding: 10px 100px;
            box-sizing: border-box;
            background-color: #f4f4f4;
            font-family: "Jost", sans-serif;
        }

        .container h2{
            text-align: center;
        }

        .form-group{
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            margin-bottom: 15px;
            gap: 5px;
        }

        .form-group input{
            padding: 10px;
            border-radius: 30px;
            border: 2px solid #000080;
        }

        .form-group label{
            color: #000080
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        select{
            width: 100%;
            padding: 10px;
            cursor: pointer;
            background: #B6B6FF;
        }

        option{
            padding: 10px;
        }

        .btn {
            background-color: var( --main-color);
            color: white;
            border: none;
            border-radius: 30px; 
            padding: 12px 25px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            margin: 15px auto;
        }
        .btn:hover {
            background-color: #1c75d4; 
            border-color: #1c75d4;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        }
        .btn:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn:active {
            transform: scale(0.98); 
        }

        .btn:focus {
            outline: none; 
        }
        .success{
            color: green;
            background: #eee;
            padding: 5px;
            text-align: center;
        }
        /* Style for the select element */
        .custom-select {
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            color: #333;
            background-color: #e0e0e0; 
            border: 2px solid #000080;
            border-radius: 30px;
            appearance: none; 
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        /* Focused state for select */
        .custom-select:focus {
            border-color: #000080;
            outline: none;
        }

        /* Hover effect for select */
        .custom-select:hover {
            background-color: #d1d1d1;
        }

        /* Style for the option elements */
        .custom-select option {
            background-color: #ffffff;
            color: #333;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-bottom: 1px solid #f1f1f1; /* Subtle border for separation */
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Hover effect for option elements */
        .custom-select option:hover {
            background-color: #000080; /* Blue background on hover */
            color: #ffffff; /* White text on hover */
        }

        /* Highlight the selected option */
        .custom-select option:checked {
            background-color: #000080;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px 20px;
            }
        }
        @media (max-width: 426px) {
            .container {
               margin-bottom: 80px;
            }
            .grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h2>Add New Address</h2>
        <p class='success'><?php echo $message; ?></p>
        <form method="POST" action="">
            <div class="grid">
                <div class="form-group">
                    <label for="address_type">Select Address Type</label>
                    <select name="address_type" id="address_type" required class="custom-select">
                        <option value="shipping">Shipping ▼</option>
                        <option value="billing">Billing ▼</option>
                    </select>
                </div>

                <div class="form-group">
                        <label for="full_name"><i class="fa-solid fa-user"></i> Full Name</label>
                        <input type="text" id="full_name" name="full_name" placeholder='Full Name' required>
                </div>
            </div>
            <div class="grid">
                <div class="form-group">
                    <label for="street_address"><i class="fa-solid fa-address-book"></i> Street Address</label>
                    <input type="text" id="street_address" name="street_address" placeholder='Street' required>
                </div>

                <div class="form-group">
                    <label for="city"><i class="fa-solid fa-address-book"></i> City</label>
                    <input type="text" id="city" name="city" placeholder='City' required>
                </div>
            </div>
            <div class="grid">
                <div class="form-group">
                    <label for="state"><i class="fa-solid fa-address-book"></i> State</label>
                    <input type="text" id="state" name="state" placeholder='State' required>
                </div>
                <div class="form-group">
                    <label for="postal_code"><i class="fa-solid fa-location-pin"></i> Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" placeholder='Ex: 123123' required>
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label for="country"><i class="fa-solid fa-globe"></i> Country</label>
                    <input type="text" id="country" name="country" value="India" required>
                </div>

                <div class="form-group">
                    <label for="phone_number"><i class="fa-solid fa-phone"></i> Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder='Ex: 123 456 7890' required>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_default" value="1"> Set as Default Address
                </label>
            </div>

            <button class='btn' type="submit">Add Address</button>
        </form>
    </div>
</body>
</html>
