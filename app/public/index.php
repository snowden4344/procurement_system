<?php
include '../../db_connection.php';
$countQuery = "SELECT (SELECT COUNT(*) FROM request_for_quotations WHERE status = 'In Progress') AS rfq_count";
$stmt = $conn->prepare($countQuery);
$stmt->execute();
$stmt->bind_result( $rfq_count);
$stmt->fetch();
$stmt->close();



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../src/css/bootstrap-5.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../src/css/fontawesome-free-6.4.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../src/css/fontawesome-free-6.4.2-web/css/all.css">
    <!-- Datatable.JS css link -->
    <link rel="stylesheet" href="../../src/js/DataTables/datatables.css">
    <link rel="stylesheet" href="../../src/css/fonts.css">
    <link rel="stylesheet" href="../../src/css/style.css">

    <title>Request for quotations</title>
</head>
<body class="bg-222 text-light">
<header class="col-12 mb-4 sticky-top mb-0">
    <nav class="d-xl-flex d-lg-flex d-md-flex d-block px-2 shadow py-2 justify-content-between align-items-center bg-222 nav col-12">
        <div class="nav-log text-center col-xl-1 col-lg-1 col-md-2 mb-0">
            <h1 class="fa fa-box"></h1>
            <p class="small_font mb-0"><small>Tamper Proof</small></p>
        </div>
        <ul class="col-xl-4 col-lg-4 col-md-6 list-unstyled mb-0 d-flex align-items-center justify-content-between text-light">
            <li><a href="#" class="text-decoration-none text-light">Requests For Quotations</a></li>
            <li><a href="#" class="btn bg-purple text-light rounded-5 py-2 px-4 text-decoration-none">Register</a></li>
        </ul>
    </nav>
</header>
<main class="col-12">
    <div class="col-11 mx-auto">

        <div class="company_details bg-333 px-1 py-3 mb-3 rounded-2">
            <div class="details row mx-0 mb-3">
                <div class="card bg-333 border-0 text-light">
                    <div class="card-body row justify-content-between py-0">
                       <div class="row mx-0 bg-222 col-xl-7 my-2 col-lg-8 justify-content-between align-items-center rounded-1 py-3 py-4">
                           <div class="col-1 text-center">
                               <h1 class="display-4 text-white-50"><i class="fa fa-box"></i></h1>
                           </div>
                           <div class="col-10">
                               <h6 class=" text-white-50 mb-3 d-flex justify-content-start"><span class="me-3"><i class="fa fa-user-group"></i></span><span class="col-11">Tamper Proof Organization</span></h6>
                               <h6 class=" text-white-50 mb-3 d-flex justify-content-start"><span class="me-3"><i class="fa fa-phone"></i></span><span class="col-11">0889201938</span></h6>
                               <h6 class=" text-white-50 mb-3 d-flex justify-content-start"><span class="me-3"><i class="fa fa-envelope"></i></span><span class="col-11">tamperproofprocurementsystem@gmail.com</span></h6>
                               <h6 class=" text-white-50 mb-3 d-flex justify-content-start"><span class="me-3"><i class="fa fa-address-card"></i></span><span class="col-11">Tamper Proof Organization, PO Box 2023, Limbe</span></h6>

                           </div>
                       </div>
                        <div class="col-xl-4 col-lg-3 my-2 mx-0 bg-222 rounded-1 py-3">
                            <h1 class="display-1 text-center"><?php echo $rfq_count ?></h1>
                            <p class="text-center">New Requests for quotations</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="rfqs bg-333 rounded-1 mb-3 px-3 py-3 overflow-x-scroll">
            <div class="card bg-222 text-light max-width">
                <div class="card-header mb-0 row justify-content-between align-items-center">
                    <h6 class="col-7">New Requests for Quotations</h6>
                </div>
                <div class="card-body">
                    <table class="d-table table table-striped table-borderless public_rfq_table small" id="rfq_table">
                        <thead>
                        <tr>
                            <th class="text-light">RFQ Number</th>
                            <th class="text-light">Title</th>
                            <th class="text-light">Issue Date</th>
                            <th class="text-light">Due Date</th>
                            <th class="text-light">Category</th>
                            <th class="text-light">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // SQL query to retrieve data from the "requests_for_quotations" table
                        $sql = "SELECT rfq.rfq_number, rfq.rfq_title, rfq.date_generated, rfq.deadline, req.category
                                FROM request_for_quotations rfq
                                INNER JOIN requisitions req ON rfq.requisition_id = req.requisition_id WHERE rfq.status = 'In Progress'";
                        $result = $conn->query($sql);

                        // Check if there are any rows in the result set
                        if ($result->num_rows > 0) {
                            // Loop through the result set and generate table rows
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="text-light py-3">' . $row['rfq_number'] . '</td>';
                                echo '<td class="text-light py-3">' . $row['rfq_title'] . '</td>';
                                echo '<td class="text-light py-3">' . $row['date_generated'] . '</td>';
                                echo '<td class="text-light py-3">' . $row['deadline'] . '</td>';
                                echo '<td class="text-light py-3">' . $row['category'] . '</td>';
                                echo '<td class="text-light py-3"><span class="badge bg-light text-dark" data-bs-target="#rfq_modal" data-bs-toggle="modal" onclick="fetchInfo(`'. $row['rfq_number'] .'`)">View</span></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "No data available";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal" id="rfq_modal" tabindex="-1" role="dialog" aria-labelledby="rfq_modal_Label" aria-hidden="true" >
            <div class="modal-dialog modal-xl modal-fullscreen col-12" role="document">
                <div class="modal-content bg-111">
                    <div class="col-11 mx-auto">
                        <div class="py-3 mb-0 d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"></h4>
                            <h2 class="mb-0"><i class="fa fa-times-circle" data-bs-dismiss="modal"></i></h2>
                        </div>
                        <hr class="border-light">
                        <div class="company_details bg-333 px-1 py-3 mb-3 rounded-2">
                            <h4 class="fw-bold my-3 px-2">Company Details</h4>
                            <div class="details row mx-0 mb-3">
                                <div class="card bg-333 border-0 text-light">
                                    <div class="card-body row mx-0 bg-222 rounded-1">
                                        <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                                            <h6 class="fw-bold">Company Name</h6>
                                            <p class="text-white-50" id="company_name">Tamper Proof Organization</p>
                                        </div>
                                        <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                                            <h6 class="fw-bold">Email</h6>
                                            <p class="text-white-50" id="company_email">tamperproofprocurementsystem@gmail.com</p>
                                        </div>
                                        <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                                            <h6 class="fw-bold">Phone Number</h6>
                                            <p class="text-white-50" id="company_phone_number">0889201938</p>
                                        </div>
                                        <div class="mb-3 col-xl-3 col-lg-4 col-md-6 col-12">
                                            <h6 class="fw-bold">Address</h6>
                                            <p class="text-white-50" id="company_address">Tamper Proof Organization, PO Box 2023, Limbe</p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="rfq_details bg-333 px-1 py-3 mb-3 rounded-2">
                            <h4 class="fw-bold my-3 px-2">RFQ Details</h4>
                            <div class="details row mx-0 mb-3 align-items-center">
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Title</h6>
                                        <p class="text-white-50" id="rfq_title">Request for quotations - Products</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Issue Date</h6>
                                        <p class="text-white-50" id="issue_date">22-06-2023</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Submission Deadline</h6>
                                        <p class="text-white-50" id="due_date">22-06-2023</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Reference Number</h6>
                                        <p class="text-white-50" id="rfq_number">RFQ-21</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Submission Methods</h6>
                                        <ul class="list-unstyled d-flex justify-content-between">
                                            <li class="text-center bg-dark py-1 col-3 rounded-1">
                                                <i class="fa fa-network-wired"></i>
                                                <p class="mb-0 small_font"><small>System</small></p>
                                            </li>
                                            <li class="text-center bg-dark py-1 col-3 rounded-1">
                                                <i class="fa fa-envelope-open-text"></i>
                                                <p class="mb-0 small_font"><small>Mail</small></p>
                                            </li>
                                            <li class="text-center bg-dark py-1 col-3 rounded-1">
                                                <i class="fa fa-square-envelope"></i>
                                                <p class="mb-0 small_font"><small>Email</small></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Payment terms</h6>
                                        <p class="text-white-50 small" id="payment_terms">100% within 30 days upon acceptance of the products specified and receipt of invoice</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Evaluation Criteria</h6>
                                        <p class="text-white-50 small" id="evaluation_criteria">100% within 30 days upon acceptance of the products specified and receipt of invoice</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Warranties</h6>
                                        <p class="text-white-50 small" id="warranties">100% within 30 days upon acceptance of the products specified and receipt of invoice</p>
                                        <!--                                        <ul class="list-unstyled">-->
<!--                                            <li class="text-white-50 small py-1"><span class="col-1">1.</span> <span class="col-10">All goods provided shall have a minimum of one (1) year warranty</span></li>-->
<!--                                            <li class="text-white-50 small py-1"><span class="col-1">2.</span> <span class="col-10">All installed components should have a minimum of three (3) months warranty against installation defects</span></li>-->
<!--                                        </ul>-->
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Conditions for Release of Payment</h6>
                                        <p class="text-white-50 small" id="conditions">Delivery of Goods as per Purchase Order or Contract deliverables.</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Preferred Language</h6>
                                        <p class="text-white-50" id="preferred_language">English</p>
                                    </div>
                                </div>
                                <div class="card mb-2 bg-333 border-0 text-light col-xl-3 col-lg-4 col-md-6 col-12">
                                    <div class="card-body bg-222 rounded-1">
                                        <h6 class="fw-bold">Quotes Validity</h6>
                                        <p class="text-white-50" id="quotes_validity">60 Days</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="company_details bg-333 px-1 py-3 mb-3 rounded-2">
                            <h4 class="fw-bold my-3 px-2">Terms</h4>
                            <ol class="bg-222 py-3 rounded-1">
                                <li class="mb-3 small text-justify">
                                    Goods / Services proposed by Tamper Proof Organization shall be reviewed for completeness and compliance with the minimum specifications described in the Terms of Reference (TOR) or Scope of Work (SOW) provided by Tamper Proof Organization, along with any other annexes detailing the organization's requirements.
                                </li>
                                <li class="mb-3 small text-justify">
                                    The quotation that fully complies with the specifications and requirements outlined in the TOR evaluation criteria and offers the lowest price will be selected by Tamper Proof Organization. Any quotation that does not meet these requirements will be rejected.
                                </li>
                                <li class="mb-3 small text-justify">
                                    In case of any discrepancy between the unit price and the total price (calculated by multiplying the unit price and quantity), Tamper Proof Organization will re-compute the total price based on the unit price, and the corrected total price will prevail. If Tamper Proof Organization does not accept the final price after re-computation and correction of errors, the quotation will be rejected.
                                </li>
                                <li class="mb-3 small text-justify">
                                    Any Purchase Order issued by Tamper Proof Organization will be subject to the General Terms and Conditions attached hereto.
                                </li>
                                <li class="mb-3 small text-justify">
                                    Tamper Proof Organization should be aware that the organization is not obligated to accept any quotation, award a contract or Purchase Order, or cover any costs associated with the preparation and submission of a quotation, regardless of the selection process's outcome.
                                </li>
                                <li class="mb-3 small text-justify">
                                    Tamper Proof Organization retains the right to accept or reject any proposal, deem any or all proposals as non-responsive, and terminate the solicitation process or reject all proposals at any time before awarding a contract. The organization is not obliged to award the contract to the lowest-priced offer.
                                </li>
                                <li class="mb-3 small text-justify">
                                    The contract may be awarded to Tamper Proof Organization, whose proposal is determined to be in the best interests of the organization, based on the evaluation method specified in the Data Sheet and considering the general principles governing Tamper Proof Organization's procurement activities.
                                </li>
                                <li class="mb-3 small text-justify">
                                    At the time of awarding the Contract or Purchase Order, Tamper Proof Organization reserves the right to vary the quantity of services and/or goods by up to a maximum of 20%.
                                </li>
                                <li class="mb-3 small text-justify">
                                    Tamper Proof Organization maintains a zero-tolerance policy regarding fraud and corrupt practices. The organization is committed to preventing, identifying, and addressing any such acts or practices against Tamper Proof Organization and third parties involved in its activities.
                                </li>
                            </ol>
                        </div>
                        <div class="company_details bg-333 px-1 py-3 mb-3 rounded-2">
                            <h4 class="fw-bold my-3 px-2">Supplier Quotations</h4>
                            <form action="#" class="small">
                                <div class="row px-2">
                                    <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
                                        <label class="d-block">Price Per Item</label>
                                        <input type="text" disabled class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-4 border-0 text-light">
                                    </div>
                                    <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
                                        <label class="d-block">Price Per Unit</label>
                                        <input type="text" disabled class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-4 border-0 text-light">
                                    </div>
                                    <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
                                        <label class="d-block">Expected Delivery Date</label>
                                        <input type="date" disabled class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-4 border-0 text-light">
                                    </div>
                                </div>
                                <div class="buttons row align-items-center justify-content-evenly mx-auto my-3">
                                    <a href="register" type="button" class="btn btn-dark bg-purple text-light py-3 col-xl-3 col-lg-4 col-12 border-0">Register to send quotations</a>
                                    <button type="button" class="btn btn-dark text-light py-3 col-xl-3 col-lg-4 col-12 border-0" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>




    </div>
</main>
<script src="../../src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Datatable js link -->
<script src="../../src/js/DataTables/datatables.js"></script>

<script src="../../src/js/public.js"></script>
<script src="../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let table = new DataTable('#rfq_table');
</script>
</body>
</html>