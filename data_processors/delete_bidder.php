<?php
// Database connection details
include '../db_connection.php';

$uid = $_POST['id'];


// SQL query to delete user
$sql = "DELETE FROM bidders WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Bidder deleted successfully.";
} else {
    $response['success'] = false;
    $response['message'] = "Error: " . $stmt->error;
}

// Close the statement and the database connection
$stmt->close();
$conn->close();

// Send JSON response back to AJAX
echo json_encode($response);


