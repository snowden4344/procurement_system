<?php
include '../includes/session_config.php';
require('../includes/fpdf/fpdf.php'); // Include the FPDF library

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    include '../db_connection.php';

    // Username of the user creating the requisition
    $user_id = $_SESSION['id']; // Replace with the actual username.
    // Retrieve data from the form
    $description = $_POST['description'];
    $quantity = (int)$_POST['quantity'];
    $category = $_POST['category'];
    $requisition_name = $category . " requisition";
    $amount = (int)$_POST['amount'];
    $status = 'Pending'; // You can set an initial status
    $reason = $_POST['reason'];
    $date_created = date('Y-m-d H:i:s'); // Use the current date and time

    $errors = [];

    if (empty($description)) {
        $errors[] = "Description is required.";
    }
    if (empty($reason)) {
        $errors[] = "Reason for requisition is required.";
    }

    if (!is_numeric($quantity) || $quantity <= 0) {
        $errors[] = "Quantity must be a positive number.";
    }

    if (empty($amount)) {
        $errors[] = "Amount is required.";
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $errors[] = "Amount must be a positive number.";
    }

    if (empty($category)) {
        $errors[] = "Category is required.";
    } elseif (!in_array($category, ["Hardware", "Stationery", "Electronics", "Furniture", "Appliances"])) {
        $errors[] = "Invalid category selected.";
    }

    // Check if there are any errors
    if (empty($errors)) {
        // Generate a PDF document
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Requisition Form for ' . $_SESSION['fullname'], 0, 1, 'C'); // Centered title (empty string)

        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Name: ' . $requisition_name);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Description: ' . $description);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Quantity: ' . $quantity);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Category: ' . $category);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Amount: ' . $amount);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Status: ' . $status);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Date Created: ' . $date_created);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Reason: ' . $reason);

        // Save the PDF document
        $pdfFileName = '../requisitions/' . 'requisition_' . time() . '.pdf'; // Unique file name
        $pdf->Output($pdfFileName, 'F');

        // Prepare the SQL query to insert data into the 'requisition' table
        $sql = "INSERT INTO requisitions (requisition_name, description, quantity, category, amount, status, date_created, reason, user_id, document, document_hashcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $documentHash = md5_file($pdfFileName);
        $stmt->bind_param("ssssssssiss", $requisition_name, $description, $quantity, $category, $amount, $status, $date_created, $reason, $user_id, $pdfFileName, $documentHash);

        // Execute the query
        if ($stmt->execute()) {
            // Insertion successful
            $response = [
                'success' => true,
                'message' => 'Requisition added successfully.'
            ];
        } else {
            // Error case
            $errors[] = 'Error: ' . $stmt->error;
            $response = [
                'success' => false,
                'message' => 'Error: ' . $stmt->error
            ];
        }

        // Close the statement and the database connection
        $stmt->close();
    } else {
        // There are validation errors, so return an error response
        $response = [
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $errors
        ];
    }

    // Send JSON response back to the JavaScript
    echo json_encode($response);
}

