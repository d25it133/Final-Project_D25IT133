<?php
header("Content-Type: application/json");

// Capture JSON input
$json = file_get_contents("php://input");

// Log received data
file_put_contents("log.txt", "Received JSON: " . $json . PHP_EOL, FILE_APPEND);

$data = json_decode($json, true);

// Validate data
if (!$data || !isset($data['products']) || !isset($data['paymentMethod'])) {
    echo json_encode(["error" => "Invalid order data"]);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO orders (product_name, price, quantity, total_price, payment_method, order_date) VALUES (?, ?, ?, ?, ?, NOW())");

if (!$stmt) {
    echo json_encode(["error" => "SQL error: " . $conn->error]);
    exit;
}

// Insert each product
foreach ($data['products'] as $product) {
    $stmt->bind_param("sdiis", 
        $product['name'], 
        $product['price'], 
        $product['quantity'], 
        $product['total'], 
        $data['paymentMethod']
    );

    if (!$stmt->execute()) {
        echo json_encode(["error" => "Insert error: " . $stmt->error]);
        exit;
    }
}

$stmt->close();
$conn->close();

echo json_encode(["success" => "Order stored successfully"]);
?>
