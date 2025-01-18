<?php
session_start();
include '../pages/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password if it's set
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = null;
    }

    // Update user profile
    $update_sql = "UPDATE users SET full_name = ?, phone = ?, email = ?";
    if ($hashed_password) {
        $update_sql .= ", password = ?";
    }
    $update_sql .= " WHERE id = ?";

    $update_stmt = $conn->prepare($update_sql);
    if ($hashed_password) {
        $update_stmt->bind_param("ssssi", $full_name, $phone, $email, $hashed_password, $user_id);
    } else {
        $update_stmt->bind_param("sssi", $full_name, $phone, $email, $user_id);
    }

    if ($update_stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating profile.";
    }
}

// Close the connection
$conn->close();
?>
