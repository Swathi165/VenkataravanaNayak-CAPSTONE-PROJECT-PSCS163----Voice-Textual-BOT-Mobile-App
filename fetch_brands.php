<?php
include 'pages/db_conn.php';

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 'all';

if ($category_id !== 'all') {
    $query = "SELECT DISTINCT b.id, b.brand_name FROM brands b 
              JOIN items i ON b.id = i.brand_id 
              WHERE i.category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
} else {
    $query = "SELECT id, brand_name FROM brands";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

$brands = [];
while ($row = $result->fetch_assoc()) {
    $brands[] = ['id' => $row['id'], 'name' => $row['brand_name']];
}

echo json_encode(['brands' => $brands]);
?>
