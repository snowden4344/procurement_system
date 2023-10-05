<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'internalprocurement';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array(); // Create a response array to send JSON data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pricePerItem = $_POST["price_per_item"];
    $pricePerUnit = $_POST["price_per_unit"];
    $expectedDeliveryDate = $_POST["expected_delivery_date"];
    $rfqId = $_POST['rfq_number'];
    $bidderId = $_POST['bidder_id'];
    $date_created = date('Y-m-d');

    // Calculate the total price (you can modify this calculation)
//    $totalPrice = $pricePerItem * $pricePerUnit;


    $sql = "INSERT INTO quotations (price_per_item, price_per_unit, date_created, expected_delivery_date, bidder_id, rfq_number)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $response['success'] = false;
        $response['message'] = "Error preparing SQL statement: " . $conn->error;
    } else {
        $stmt->bind_param("ddssis", $pricePerItem, $pricePerUnit, $date_created, $expectedDeliveryDate, $bidderId, $rfqId);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Quotation submitted successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error submitting quotation data: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method!";
}

// Send the JSON response
echo json_encode($response);
