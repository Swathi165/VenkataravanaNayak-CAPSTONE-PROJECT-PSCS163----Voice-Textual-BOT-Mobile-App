<?php
require '../pages/db_conn.php';
require '../pages/email_config.php';

$registrationSuccess = false; // Track registration status

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Generate unique customer ID
    $customerId = uniqid('CUST_');

    // Check if email or phone already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email or phone number already exists.');</script>";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (full_name, phone, email, password, customer_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullName, $phone, $email, $hashedPassword, $customerId);
        
        if ($stmt->execute()) {
            sendWelcomeEmail($email, $fullName);
            $registrationSuccess = true; // Set success flag
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="assets/images/logo.png">
    <script src="https://kit.fontawesome.com/a8dce0582d.js" crossorigin="anonymous"></script>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/register_style.css">
</head>
<body>
    <div class="register-container">
        <!-- Left Image Section -->
        <div class="image-container overlay">
            <h1>Shop Sphere</h1>
            <p>Get access to your Orders, Wishlist and Recommendations</p>
        </div> 

        <!-- Right Form Section -->
        <div class="form-container">
            <form action="#" method="POST" onsubmit="return validateForm()">
                <h2>Register</h2>

                <label for="full_name"> <i class="fa fa-user" aria-hidden="true"></i> Full Name:</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter Name" required>
            
                <label for="phone"><i class="fa fa-phone" aria-hidden="true"></i> Phone:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter Phone no." required>

                <label for="email"><i class="fa fa-envelope" aria-hidden="true"></i> Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
                
                <label for="password"><i class="fa fa-lock" aria-hidden="true"></i> Password:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    <i class="fa fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                </div>
                
                <label for="confirm_password"><i class="fa fa-lock" aria-hidden="true"></i> Confirm Password:</label>
                <div class="password-container">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-Enter Password" required>
                    <i class="fa fa-eye" id="toggleConfirmPassword" style="cursor: pointer;"></i>
                </div>
                <span id="password-error" style="color: red; display: none;">Passwords do not match!</span><br>
                                 
                <div class="btn">
                    <button type="submit">Register</button>
                </div>
            </form>
            <p>Already have an account? <a href="login">Login</a></p>
        </div>
    </div>

    <!-- Popup Modal -->
    <?php if ($registrationSuccess): ?>
    <div id="successModal" class="modal" style="display: block;">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('successModal').style.display='none';">&times;</span>
            <h2>Registration Successful!</h2>
            <p>A welcome email has been sent to your email address.</p><br>
            <button onclick="redirectToLogin()">OK</button>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Function to validate password match in real-time
        function validatePasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorElement = document.getElementById("password-error");
            
            if (password !== confirmPassword) {
                errorElement.style.display = "inline"; // Show error message
            } else {
                errorElement.style.display = "none"; // Hide error message
            }
        }

        // Add event listener to confirm password input
        document.getElementById("confirm_password").addEventListener("input", validatePasswordMatch);

        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorElement = document.getElementById("password-error");
            
            if (password !== confirmPassword) {
                errorElement.style.display = "inline"; // Show error message on form submission
                return false; // Prevent form submission
            } else {
                errorElement.style.display = "none"; // Hide error message
            }
            return true; // Allow form submission
        }
        
        function redirectToLogin() {
            window.location.href = 'login'; // Redirect to login page
        }

        // Toggle password visibility
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordInput = document.getElementById("password");
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
            const confirmPasswordInput = document.getElementById("confirm_password");
            const type = confirmPasswordInput.getAttribute("type") === "password" ? "text" : "password";
            confirmPasswordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>
