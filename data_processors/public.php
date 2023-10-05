<?php
include "../db_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the rfq_number from the AJAX request
    $rfqNumber = $_POST['rfq_number'];

    // Perform database query to fetch data based on rfq_number
    $sqlContactDetails = "SELECT * FROM contact_details";
    $stmtContactDetails = $conn->prepare($sqlContactDetails);
    $stmtContactDetails->execute();
    $resultContactDetails = $stmtContactDetails->get_result();
    $rowContactDetails = $resultContactDetails->fetch_assoc();

    $sqlRFQ = "SELECT rq.rfq_title, rq.date_generated, rq.deadline, rq.rfq_number, rq.preferred_language, 
               rq.quotes_validity, rq.payment_terms, rq.submission_methods, rq.warranties, 
               rq.evaluation_criteria, rq.release_of_payment_conditions
        FROM request_for_quotations rq
        JOIN requisitions rd ON rq.requisition_id = rd.requisition_id
        WHERE rq.rfq_number = ?";
    $stmtRFQ = $conn->prepare($sqlRFQ);
    $stmtRFQ->bind_param("s", $rfqNumber);
    $stmtRFQ->execute();
    $resultRFQ = $stmtRFQ->get_result();
    $rowRFQ = $resultRFQ->fetch_assoc();



    $response = [];

// Fetch data from the contact_details table
    if ($stmtContactDetails->execute()) {
        $resultContactDetails = $stmtContactDetails->get_result();
        $rowContactDetails = $resultContactDetails->fetch_assoc();

        // Fetch data from the request_for_quotations and requisitions tables
        if ($stmtRFQ->execute()) {
            $resultRFQ = $stmtRFQ->get_result();
            $rowRFQ = $resultRFQ->fetch_assoc();

            // Check if data from both queries is available
            if ($rowContactDetails && $rowRFQ) {
                $response['success'] = true;
                $response['data']['company_name'] = $rowContactDetails['company_name'];
                $response['data']['company_email'] = $rowContactDetails['email'];
                $response['data']['company_phone_number'] = $rowContactDetails['phone_number'];
                $response['data']['rfq_title'] = $rowRFQ['rfq_title'];
                $response['data']['issue_date'] = $rowRFQ['date_generated'];
                $response['data']['due_date'] = $rowRFQ['deadline'];
                $response['data']['rfq_number'] = $rowRFQ['rfq_number'];
                $response['data']['preferred_language'] = $rowRFQ['preferred_language'];
                $response['data']['quotes_validity'] = $rowRFQ['quotes_validity'];
                $response['data']['payment_terms'] = $rowRFQ['payment_terms'];
                $response['data']['submission_methods'] = $rowRFQ['submission_methods'];
                $response['data']['warranties'] = $rowRFQ['warranties'];
                $response['data']['evaluation_criteria'] = $rowRFQ['evaluation_criteria'];
                $response['data']['conditions'] = $rowRFQ['release_of_payment_conditions'];
            } else {
                $response['success'] = false;
                $response['message'] = "Data not found.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Error fetching data from the database.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error fetching contact details from the database.";
    }

// Return the JSON response
    echo json_encode($response);
}
