<?php
// Database connection details
//
//include 'db_connection.php';
//include "include\autoload.php";
//require "include\PHPMailer-6.8.1\src\PHPMailer.php";
//require "include\PHPMailer-6.8.1\src\SMTP.php";
//require "include\PHPMailer-6.8.1\src\Exception.php";
//
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//
//// Create a new PHPMailer instance
//    $mail = new PHPMailer(true);
//    $firstname = $_POST['firstname'];
//    $lastname = $_POST['lastname'];
//    $fullName = $firstname . " " . $lastname;
//    $email = $_POST['email'];
//    $department = $_POST['department'];
//    $phoneNumber = $_POST['phone'];
//    $role = $_POST['role'];
//
//    // Validate the data (more robust validation is advised)
//    if(empty($firstname) || empty($lastname) || empty($email) || empty($department) || empty($phoneNumber) || empty($role)) {
//        echo "All fields are required.";
//        exit();
//    }
//    function generateUsername($fullName, $phoneNumber, $email) {
//        // Concatenate the inputs and generate a unique username
//        $input = $fullName . $phoneNumber . $email;
//        $input = preg_replace("/[^a-zA-Z0-9]/", '', $input); // Remove non-alphanumeric characters
//        $input = str_shuffle($input); // Shuffle the characters
//        $username = substr($input, 0, 8); // Take the first 8 characters
//        return $username;
//    }
//
//    function generatePassword() {
//        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
//        $password = '';
//        $length = 8;
//
//        for ($i = 0; $i < $length; $i++) {
//            $password .= $characters[rand(0, strlen($characters) - 1)];
//        }
//
//        return $password;
//    }
//
//// Prepare the SQL query
//    $sql = "INSERT INTO users (`firstname`, `lastname`, `email`, `department`, `username`, `phone_number`, `role`, `password`,`date_created`) VALUES (?, ?, ?, ?, ?, ?, ?,?,NOW())";
//    $stmt = $conn->prepare($sql);
//    $username_generated = generateUsername($fullName, $phoneNumber, $email);
//    $password_generated = generatePassword();
//    // Hash the password before storing it in the database
//    $hashed_password = password_hash($password_generated, PASSWORD_DEFAULT);
//// Bind the parameters
//    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $department,$username_generated, $phoneNumber, $role, $hashed_password);
//
//// Execute the query
//    if ($stmt->execute()) {
//        echo "New user added successfully.";
//    } else {
//        echo "Error: " . $stmt->error;
//    }
//
//    try {
//        // Set the SMTP server settings
//        $mail->isSMTP();
//        $mail->Host = 'smtp-relay.brevo.com'; // Your SMTP server
//        $mail->SMTPAuth = true;
//        $mail->Username = 'khumbokaunda18@gmail.com';
//        $mail->Password = 'ZCL1kf3rd8DNA90I';
//        $mail->SMTPSecure = 'tls'; // Enable TLS encryption; 'ssl' is also possible
//        $mail->Port = 587; // TCP port to connect to
//
//        // Set the sender and recipient
//        $mail->setFrom('tamperproofprocurementsystem@gmail.com', 'Tamper-proof Procurement System');
//        $mail->addAddress($email, $fullName);
//
//        // Add subject and message
//        $mail->Subject = 'User Registration';
//        $mail->Body = '<h1>Hello '. $fullName . '</h1><br>
//              <p>Below are your sign in credentials</p>
//              <p>Username: '. $username_generated. '</p>
//              <p>Password: '. $password_generated. '</p>
//              <br>
//              <br>
//              <p><b>Do not share this with anyone</b></p>
//';
//        // Enable HTML
//        $mail->isHTML(true);
//
//        // Send the email
//        $mail->send();
//        echo 'Email sent successfully!';
//
//
//    } catch (Exception $e) {
//        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
//    }
//
//// Close the statement and the database connection
//    $stmt->close();
//    $conn->close();
//}

// Database connection details
include '../db_connection.php';

// Include PHPMailer and its dependencies
include "../include/autoload.php";
require "../include/PHPMailer-6.8.1/src/PHPMailer.php";
require "../include/PHPMailer-6.8.1/src/SMTP.php";
require "../include/PHPMailer-6.8.1/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Extract POST data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $phoneNumber = $_POST['phone'];
    $role = $_POST['role'];
    $fullName = $firstname . " " . $lastname;

// Validate the data
    if (empty($firstname) || empty($lastname) || empty($email) || empty($department) || empty($phoneNumber) || empty($role)) {
        echo "All fields are required.";
        exit();
    }

// Validate First Name and Last Name (Alphabetic characters and minimum length)
    if (!preg_match("/^[A-Za-z]+$/", $firstname) || !preg_match("/^[A-Za-z]+$/", $lastname) || strlen($firstname) < 2 || strlen($lastname) < 2) {
        echo "Invalid First Name or Last Name.";
        exit();
    }

// Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email Address.";
        exit();
    }

// Validate Department
    $allowedDepartments = array("IT", "Human Resources", "Accounting", "Procurement", "Stores");
    if (!in_array($department, $allowedDepartments)) {
        echo "Invalid Department.";
        exit();
    }

// Validate Phone Number (Numeric characters and minimum length)
    if (!preg_match("/^[0-9]+$/", $phoneNumber) || strlen($phoneNumber) < 10) {
        echo "Invalid Phone Number.";
        exit();
    }

// Validate Role (You can specify allowed role values)
    $allowedRoles = array("User", "Approver", "Stores", "Procurement", "Administrator");
    if (!in_array($role, $allowedRoles)) {
        echo "Invalid Role.";
        exit();
    }

    // Function to generate a unique username
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

    // Prepare the SQL query
    $sql = "INSERT INTO users (`firstname`, `lastname`, `email`, `department`, `username`, `phone_number`, `role`, `password`, `date_created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $username_generated = generateUsername($fullName, $phoneNumber, $email);
    $password_generated = generatePassword();

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password_generated, PASSWORD_DEFAULT);

    // Bind the parameters
    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $department, $username_generated, $phoneNumber, $role, $hashed_password);
    $response = array();

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "New user added successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . $stmt->error;
    }

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
        $mail->addAddress($email, $fullName);

        // Add subject and message
        $mail->Subject = 'Your Tamper-Proof Procurement System Credentials';
        $mail->Body = '<h1>Hello ' . $fullName . '</h1><br>
                        <p>We are pleased to provide you with your sign-in credentials for the Tamper-Proof Procurement System:</p>

                        <p><b>Username:</b> ' . $username_generated . '</p>
                        <p><b>Password:</b> ' . $password_generated . '</p>
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
//        echo 'Email sent successfully!';
    } catch (Exception $e) {
//        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
    echo json_encode($response);

// Close the statement and the database connection
    $stmt->close();
    $conn->close();
}






