<?php

include "../include/autoload.php";
require "../include/PHPMailer-6.8.1/src/PHPMailer.php";
require "../include/PHPMailer-6.8.1/src/SMTP.php";
require "../include/PHPMailer-6.8.1/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Step 1: Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internalprocurement";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $bidder_id = $_GET['bidder_id'];

    // Define the SQL query to retrieve bidder data
    $sql = "SELECT * FROM bidders WHERE id = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in preparing the SQL statement.");
    }

    // Bind the bidder_id parameter to the SQL statement
    $stmt->bind_param("i", $bidder_id);

    // Execute the SQL statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there is a result
    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $bidder_data = $result->fetch_assoc();

        // Return the bidder data as JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $bidder_data]);
    } else {
        // Return an error message if no data is found
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Bidder not found']);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bidder_id = $_POST['bidder_id'];
    $approval_type = $_POST['approval_type'];
    $mail = new PHPMailer(true);

        function generateUsername($fullName, $phoneNumber, $email): string
    {
        $input = $fullName . $phoneNumber . $email;
        $input = preg_replace("/[^a-zA-Z0-9]/", '', $input);
        $input = str_shuffle($input);
        return substr($input, 0, 8);
    }

// Function to generate a random password
    function generatePassword(): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
        $password = '';
        $length = 8;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }
    $updateSql = "";
    $stmt = $conn->prepare('SELECT * FROM bidders');

    if($approval_type === 'Yes'){
        $get_info = "SELECT full_name, phone_number, email FROM bidders WHERE id = ?";
        $get_stmt = $conn->prepare($get_info);
        $get_stmt->bind_param("i", $bidder_id);

        if($get_stmt->execute()){
            $result = $get_stmt->get_result();
            if($result->num_rows > 0){
                $bidder_info = $result->fetch_assoc();
                $full_name = $bidder_info['full_name'];
                $phone_number = $bidder_info['phone_number'];
                $email = $bidder_info['email'];

                $b_username = generateUsername($full_name, $phone_number, $email);
                $password = generatePassword();
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $updateSql = "UPDATE bidders SET is_verified = 'Yes', b_username = ?, password = ? WHERE id = ?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("ssi", $b_username, $hashed_password, $bidder_id);

                $response = [];

                if ($stmt->execute()) {
                    // Successfully updated the is_verified field
                    $response['success'] = true;
                    $response['message'] = "Bidder status updated successfully.";

                    try {
                        // Set the SMTP server settings
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
                        $mail->Subject = 'Your Tamper-Proof Procurement System Credentials';
                        $mail->Body = '<h1>Hello ' . $full_name . '</h1><br>
                        <p>We are pleased to provide you with your sign-in credentials for the Tamper-Proof Procurement System:</p>

                        <p><b>Username:</b> ' . $b_username . '</p>
                        <p><b>Password:</b> ' . $password . '</p>
                        <p>Please keep this information confidential and do not share it with anyone.</p>
                        <p>If you have any questions or require assistance, please feel free to contact our support team at <a href="mailto:tamperproofprocurementsystem@gmail.com">tamperproofprocurementsystem@gmail.com</a>.</p>
                        <p>Yours Sincerely,</p>
                        <p>Khumbo Kaunda,</p>
                        <p>Tamper Proof Organization</p>

                        <p>Thank you for choosing our system.</p>';

// Set the email content type to HTML
                        $mail->isHTML(true);

                        // Enable HTML
                        $mail->isHTML(true);

                        // Send the email
                        $mail->send();
                    } catch (Exception $e) {
                        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                    }

                } else {
                    // Error occurred
                    $response['success'] = false;
                    $response['message'] = "Error updating bidder approval status.";
                }
                // Output the JSON response
                echo json_encode($response);
            }
        }

    }
    elseif ($approval_type === 'No'){
        $updateSql = "UPDATE bidders SET is_verified = 'Deleted' WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $bidder_id);

        $response = [];

        if ($stmt->execute()) {
            // Successfully updated the is_verified field
            $response['success'] = true;
            $response['message'] = "Bidder status updated successfully.";



        } else {
            // Error occurred
            $response['success'] = false;
            $response['message'] = "Error updating bidder approval status.";
        }
        // Output the JSON response
        echo json_encode($response);
    }

    $stmt->close();


}
