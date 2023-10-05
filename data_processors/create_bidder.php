<?php



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

// Step 2: Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // Retrieve data from the form
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $business_name = $_POST['business_name'];
    $business_phone_number = $_POST['business_phone_number'];
    $business_email = $_POST['business_email'];
    $tax_id = $_POST['tax_id'];
    $year_established = $_POST['year_established'];
    $business_type = $_POST['business_type'];
    $industry_type = $_POST['industry_type'];
    $bank_name = $_POST['bank_name'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $business_description = $_POST['business_description'];
    $business_address = $_POST['business_address'];
    $verification_status = 'No';


// Step 3: Insert data into the "bidders" table
    $sql = "INSERT INTO bidders (full_name, phone_number, email, business_name, is_verified, business_phone_number, business_email, year_established, business_type, tax_id, business_description, business_address, industry_type, bank_name, account_name, account_number, account_type)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//    $b_username = generateUsername($full_name, $phone_number, $email);
//    $password = generatePassword();
//    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssssssssssssss",  $full_name, $phone_number, $email, $business_name, $verification_status , $business_phone_number, $business_email, $year_established, $business_type, $tax_id, $business_description, $business_address, $industry_type, $bank_name, $account_name, $account_number, $account_type);

// Execute the SQL statement to insert data
    if ($stmt->execute()) {
        // Insertion successful
        $response = ["status" => "success", "message" => "Details submitted, pending verification."];
    } else {
        // Insertion failed
        $response = ["status" => "error", "message" => "Error inserting data: " . $stmt->error];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

//// Close the statement and database connection
//    $stmt->close();
//    $conn->close();
//
//

    $stmt->close();
}

// Step 4: Close the database connection
$conn->close();

