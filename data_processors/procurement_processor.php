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

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $requisitionId = $_GET['requisition_id'];

// Create a SQL query to retrieve requisition details and user information
    $query = "SELECT r.* FROM requisitions AS r INNER JOIN users AS u ON r.user_id = u.id WHERE r.requisition_id = ?";

// Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $requisitionId); // Assuming requisition_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

// Check if there are results
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Access the retrieved data
        $requisitionId = $row['requisition_id'];
        $requisitionName = $row['requisition_name'];
        $dateCreated = $row['date_created'];
        $description = $row['description'];
        $reason = $row['reason'];
        $quantity = $row['quantity'];
        $amount = $row['amount'];
        $category = $row['category'];

        // Now you can use these variables as needed
        // For example, you can format and return them as JSON or HTML
        $formattedData = [
            'requisition_id' => $requisitionId,
            'requisition_name' => $requisitionName,
            'date_created' => $dateCreated,
            'description' => $description,
            'reason' => $reason,
            'category' => $category,
            'amount' => $amount,
            'quantity' => $quantity
        ];

        // Send the formatted data as JSON response
        echo json_encode($formattedData);
    }
    $stmt->close();
// Close the database connection
    $conn->close();
}
//elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
//    $requisition_id = $_POST['requisition_id'];
//    $approval_type = $_POST['approval_type'];
//    ;
//
//    $updateQuery = ($approval_type == 'Yes') ? "UPDATE requisitions SET status = 'Approved' WHERE requisition_id = ?" : "UPDATE requisitions SET status = 'Declined' WHERE requisition_id = ?";
//
//    // Prepare and execute the query
//    $stmt = $conn->prepare($updateQuery);
//    $stmt->bind_param("i", $requisition_id); // Assuming requisition_id is an integer
//    $stmt->execute();
//
//    // Close the prepared statement
//    $stmt->close();
//}
//

