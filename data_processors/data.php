<?php
include "../include/autoload.php";
require "../include/PHPMailer-6.8.1/src/PHPMailer.php";
require "../include/PHPMailer-6.8.1/src/SMTP.php";
require "../include/PHPMailer-6.8.1/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);
    // Retrieve and sanitize form data
    $rfq_number = $_POST['rfq_number'];
    $requisition_id = $_POST['requisition_id'];
    $rfqTitle = $_POST["rfq_title"];
    $rfqDeadline = $_POST["rfq_deadline"];
    $issue_date = date("Y-m-d");
    $specifications = $_POST["specifications"];
    $preferred_language = $_POST["preferred_language"];
    $quotes_validity = $_POST["quotes_validity"];
    $quantity = $_POST["quantity"];
    $payment_terms = $_POST["payment_terms"];
    // Initialize $submission_methods as an empty string
    $submission_methods = "";

    // Check if each submission method is set and concatenate to the string
    if (isset($_POST["submission_method_system"])) {
        $submission_methods .= "System, ";
    }
    if (isset($_POST["submission_method_email"])) {
        $submission_methods .= "Email, ";
    }
    if (isset($_POST["submission_method_mail"])) {
        $submission_methods .= "Mail, ";
    }

    // Remove the trailing comma and space, if any
    $submission_methods = rtrim($submission_methods, ', ');// Assuming submission_methods is an array
    $warranties = $_POST["warranties"];
    $evaluation_criteria = $_POST["evaluation_criteria"];
    $terms_and_conditions = $_POST["terms_and_conditions"];
    $payment_conditions = $_POST["payment_conditions"];

    // Perform some basic validations (customize these as needed)
    $errors = [];

    if (empty($rfq_number)) {
        $errors['rfq_number'] = "RFQ Number is required.";
    } elseif (!preg_match("/^[A-Za-z0-9\-]+$/", $rfq_number)) {
        $errors['rfq_number'] = "RFQ Number must contain only letters, numbers, and hyphens.";
    }

    if (empty($rfqTitle)) {
        $errors['rfq_title'] = "RFQ Title is required.";
    } elseif (strlen($rfqTitle) > 255) {
        $errors['rfq_title'] = "RFQ Title cannot exceed 255 characters.";
    }

    if (empty($rfqDeadline)) {
        $errors['rfq_deadline'] = "RFQ Deadline is required.";
    } elseif (!strtotime($rfqDeadline)) {
        $errors['rfq_deadline'] = "Invalid date format for RFQ Deadline.";
    } elseif (strtotime($rfqDeadline) < strtotime(date("Y-m-d"))) {
        $errors['rfq_deadline'] = "RFQ Deadline must be a future date.";
    }

    if (!is_numeric($quantity) || $quantity <= 0) {
        $errors['quantity'] = "Quantity must be a positive number.";
    }

    // If there are validation errors, return an error response
    if (!empty($errors)) {
        $response = ['success' => false, 'errors' => $errors];
        echo json_encode($response);
        exit;
    }

    // Start a database transaction
    $conn->begin_transaction();

    // Prepare and execute the INSERT statement for request_for_quotations
    $insertSql = "INSERT INTO request_for_quotations (rfq_number, rfq_title, requisition_id, date_generated, deadline, product_details, preferred_language, quotes_validity, payment_terms, submission_methods, warranties, evaluation_criteria, terms_and_conditions, release_of_payment_conditions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ssisssssssssss", $rfq_number, $rfqTitle, $requisition_id, $issue_date, $rfqDeadline, $specifications, $preferred_language, $quotes_validity, $payment_terms, $submission_methods, $warranties, $evaluation_criteria, $terms_and_conditions, $payment_conditions);

    if ($insertStmt->execute()) {
        // Successfully inserted into the database

        // Prepare and execute the UPDATE statement for requisitions
        $updateSql = "UPDATE requisitions SET status = 'Initiated' WHERE requisition_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $requisition_id);

        if ($updateStmt->execute()) {
            // Both insert and update succeeded
            $conn->commit(); // Commit the transaction
            try {
                // Set the SMTP server settings
                $email = "tamperproofnewsagency@gmail.com";
                $full_name = "Tamper proof news agency";
                $mail->isSMTP();
                $mail->Host = 'smtp-relay.brevo.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'khumbokaunda18@gmail.com';
                $mail->Password = 'ZCL1kf3rd8DNA90I';
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption; 'ssl' is also possible
                $mail->Port = 587; // TCP port to connect to

                // Set the sender and recipient
                $mail->setFrom('tamperproofprocurementsystem@gmail.com', 'Tamper-proof Procurement System');
                $mail->addAddress($email, $full_name);

                // Add subject and message
                $mail->Subject = $rfqTitle;
                $mail->Body = '<h1>Hello ' . $full_name . '</h1><br>
                        <p>We are pleased to let the public receieve this request for quotations:</p>
                        <p>Deadline: ' . $rfqDeadline . '</p>
                        <p>The details for this RFQ can be found on this link: <a href="http://localhost/project_merge/app/public">http://localhost/project_merge/app/public</a> </p>
                        <p>If you have any questions or require assistance, please feel free to contact our support team at <a href="mailto:tamperproofprocurementsystem@gmail.com">tamperproofprocurementsystem@gmail.com</a>.</p>
                        <p>Yours Sincerely,</p>
                        <p>Khumbo Kaunda,</p>
                        <p>Tamper Proof Organization</p>

                        <p>Thank you for being part of our system.</p>';

// Set the email content type to HTML
                $mail->isHTML(true);

                // Enable HTML
                $mail->isHTML(true);

                // Send the email
                $mail->send();
            } catch (Exception $e) {
                echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }
            $response['success'] = true;
        } else {
            // Error occurred in the update statement
            $conn->rollback(); // Rollback the transaction
            $response['success'] = false;
        }

        $updateStmt->close();
    } else {
        // Error occurred in the insert statement
        $response['success'] = false;
    }

    $insertStmt->close();

    // Output the JSON response
    echo json_encode($response);

    // Close the database connection
    $conn->close();
}

