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
    // Check if 'data_number' is set and is a valid integer
    if (isset($_POST['data_number']) && is_numeric($_POST['data_number'])) {
        $id = $_POST['data_number'];

        // Prepare and execute the SQL statement to fetch quotation data
        $get_info = "SELECT bidder_id, rfq_number FROM quotations WHERE id = ?";
        $stmt = $conn->prepare($get_info);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Extract data from the fetched row
            $bidder_id = $row['bidder_id'];
            $rfq_number = $row['rfq_number'];

            // Update the status in the request_for_quotations table to 'Completed'
            $updateStatusQuery = "UPDATE request_for_quotations SET status = 'Completed' WHERE rfq_number = ?";
            $updateStatusStmt = $conn->prepare($updateStatusQuery);
            $updateStatusStmt->bind_param("s", $rfq_number);

            // Prepare and execute the SQL statement to insert into contract_awards
            $date_awarded = date('Y-m-d');
            $sql = "INSERT INTO contract_awards (date_awarded, quotation_id, bidder_id, rfq_number)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt && $stmt->bind_param("siis", $date_awarded, $id, $bidder_id, $rfq_number) && $stmt->execute()) {
                // Now update the status in the request_for_quotations table to 'Completed'
                $updateStatusQuery = "UPDATE request_for_quotations SET status = 'Completed' WHERE rfq_number = ?";
                $updateStatusStmt = $conn->prepare($updateStatusQuery);
                $updateStatusStmt->bind_param("s", $rfq_number);
                if ($updateStatusStmt->execute()) {
                    // Status updated successfully
                    $response['success'] = true;
                    $response['message'] = "Awarded successfully!";
                } else {
                    // Error updating status
                    $response['success'] = false;
                    $response['message'] = "Error updating status: " . $conn->error;
                }
                $updateStatusStmt->close();
            } else {
                $response['success'] = false;
                $response['message'] = "Error submitting contract award: " . $conn->error;
            }

            if ($stmt) {
                $stmt->close();
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Error fetching quotation data: " . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Invalid 'data_number' value!";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method!";
}

// Send the JSON response
echo json_encode($response);
