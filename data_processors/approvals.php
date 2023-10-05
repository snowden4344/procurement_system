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
    $query = "SELECT r.*, u.department, u.firstname, u.lastname
              FROM requisitions AS r
              INNER JOIN users AS u ON r.user_id = u.id
              WHERE r.requisition_id = ?";

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
        $department = $row['department'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];

        $formattedData = [
            'requisition_id' => $requisitionId,
            'requisition_name' => $requisitionName,
            'date_created' => $dateCreated,
            'description' => $description,
            'reason' => $reason,
            'category' => $category,
            'amount' => $amount,
            'quantity' => $quantity,
            'department' => $department,
            'first_name' => $firstname,
            'last_name' => $lastname,
        ];
        $response = [
            'success' => true,
            'data' => $formattedData
        ];
        // Send the formatted data as JSON response
        echo json_encode($response);
    }
    $stmt->close();
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $requisition_id = $_POST['requisition_id'];
    $approval_type = $_POST['approval_type'];

    $updateQuery = ($approval_type == 'Yes') ? "UPDATE requisitions SET status = 'Approved' WHERE requisition_id = ?" : "UPDATE requisitions SET status = 'Declined' WHERE requisition_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $requisition_id); // Assuming requisition_id is an integer
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        $response = [
            'success' => true,
            'message' => 'Requisition approved successfully.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error updating requisition status.'
        ];
    }

    // Close the prepared statement
    $stmt->close();

    // Send a JSON response back to the JavaScript
    echo json_encode($response);
}

// Close the database connection
$conn->close();

