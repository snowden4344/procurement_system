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

// Get the ID value from the AJAX POST request
if (isset($_POST['rfq_number'])) {
    $quotationId = $_POST['rfq_number'];
} else {
    // Handle the case when 'quotation_id' is not provided in the POST request
    die("Quotation ID not provided in POST request.");
}


$query_one = "SELECT id FROM quotations WHERE rfq_number = ?";
$stmt = $conn->prepare($query_one);
$stmt->bind_param("s", $quotationId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$qid = $row['id'];
// Query to fetch data from quotations, bidders, and request_for_quotations tables
$query = "SELECT q.*, b.business_name, rfq.rfq_title, rfq.deadline 
          FROM quotations q
          JOIN bidders b ON q.bidder_id = b.id
          JOIN request_for_quotations rfq ON q.rfq_number = rfq.rfq_number
          WHERE q.id = ?";

$response = array(); // Create an array to store the data

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $qid);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    $response['error'] = 'Error fetching data: ' . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();

// Return the data as JSON to be processed by AJAX
echo json_encode($response);
