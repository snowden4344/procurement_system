<?php
    include '../../db_connection.php';
    include '../../includes/session_config.php';
    $countQuery = "SELECT (SELECT COUNT(*) FROM request_for_quotations) AS rfq_count";

    $stmt = $conn->prepare($countQuery);
    //$stmt->bind_param("sss", $user_username, $user_username, $user_username);
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
    <!-- Bootstrap css link -->
    <link rel="stylesheet" href="../../src/css/bootstrap-5.3.1-dist/css/bootstrap.css">
    <!-- fontawesome css links -->
    <link rel="stylesheet" href="../../src/css/fontawesome-free-6.4.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../src/css/fontawesome-free-6.4.2-web/css/all.css">
    <!-- Datatable.JS css link -->
    <link rel="stylesheet" href="../../src/js/DataTables/datatables.css">
    <!-- Font importation link -->
    <link rel="stylesheet" href="../../src/css/fonts.css">
    <!-- Sweet alert css link -->
    <link rel="stylesheet" href="../../src/css/sweetalert2/sweetalert2.css">
    <!-- Custom css link -->
    <link rel="stylesheet" href="../../src/css/style.css">

    <title>Bidder Dashboard</title>
</head>
<body class="bg-black">
<!-- Sidebar: Visible on computer, collapses on tab and phone screen -->
<div class="sidebar col-xl-2 col-lg-2 col-md-4 col-12 bg-111 h-100 bottom-0 position-fixed top-0 bottom-0 shadow_custom" id="sidebar">
    <div class="logo py-3 col-12 px-0 bg-box">
        <h1 class="text-center mb-0"><i class="fa fa-box text-white"></i></h1>
    </div>
    <!-- Space creator -->
    <hr class="col-10 mx-auto py-3 ">
    <ul class="mt-5 pt-5 px-0">
        <a href="#" class="bg-222 d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-comment-dollar me-2"></i> RFQs</p></a>
        <a href="bids" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-hand-holding-dollar me-2"></i> Bids</p></a>
        <a href="#" class="d-block link-hover py-3 mt-5 text-white text-decoration-none d-flex"><p class="col-1 d-xl-block d-lg-block d-md-block d-none"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-sign-out me-2"></i> Log out</p></a>
    </ul>
</div>
<!-- Main content, split in two. Left part is a spacer. Takes the same width as the sidebar. Right side is the actual content -->
<div class="main_part d-flex py-3 justify-content-between">
    <!-- Hamburger menu, hidden up until medium size screen. Collapses or expands sidebar -->
    <h3 class="position-absolute d-xl-none d-lg-none d-inline" id="hamburger"><i class="fa fa-navicon mx-2 text-white"></i></h3>
    <!-- Adds Space for aesthetics -->
    <div class="spacer col-xl-2 col-lg-2">
    </div>
    <!-- Main content starts here -->
    <div class="actual_content col-xl-10 col-lg-10 col-12">
        <!-- Section that shows username, notifications and messages -->
        <div class="top_tools d-flex col-11 mb-5 mx-auto">
            <!-- Adds Space for aesthetics -->
            <div class="spacer col-xl-8 col-lg-7 col-md-8 col-3"></div>
            <div class="actual_tools col-xl-4 col-lg-5 col-md-4 col-9 justify-content-end d-flex align-items-center">
                <p class="text-white fw-bold"><i class="fa fa-user text-white"></i> Chimwemwe Banda</p>
                <div class="other col-xl-2 col-lg-2 col-md-2 col-2 d-flex justify-content-end">
                    <p><i class="fa fa-bell text-white"></i></p>
                </div>
            </div>
        </div>
        <!-- Page's main purpose here -->
        <div class="bidder_dashboard col-11 mx-auto my-3">
            <h2 class="text-white fw-bold mb-5">Requests for quotations <span class="badge bg-dark text-light small"><?php echo $rfq_count ?> New</span></h2>
            <!-- Shows recently stocked item -->
            <div class="mx-0 col-12 mb-3">
                <div class="col-12 overflow-x-scroll">
                    <div class="card bg-111 pe-0 text-light max-width">
                        <div class="card-header mb-0 row justify-content-between align-items-center">
                            <h6 class="fw-bold my-2">New Requests for Quotations</h6>
                        </div>
                        <div class="card-body">
                            <table class="d-table table table-striped table-borderless custom_table small_font" id="rfq_table">
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
                                    // Query to retrieve the requisitions for a specific user based on User_id
                                    $getRequisitionsQuery = "SELECT r.rfq_number, r.rfq_title, r.requisition_id, r.date_generated, r.deadline, r.product_details, q.status
                                                             FROM request_for_quotations AS r INNER JOIN  requisitions as q ON r.requisition_id = q.requisition_id WHERE r.status = 'In Progress'";

                                    $stmt = $conn->prepare($getRequisitionsQuery);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td class='text-light py-3'>" . $row['rfq_number'] . "</td>";
                                            echo "<td class='text-light py-3'>" . $row['rfq_title'] . "</td>";
                                            echo "<td class='text-light py-3'>" . $row['date_generated'] . "</td>";
                                            echo "<td class='text-light py-3'>" . $row['deadline'] . "</td>";
                                            echo "<td class='text-light py-3'>" . $row['status'] . "</td>";
                                            echo "<td class='text-light py-3'><button class='btn btn-secondary btn-sm small_font quotation_viewer' data-bs-target='#quotation_modal' data-bs-toggle='modal' data-rfq-number='" . $row['rfq_number'] . "' onclick='fetchInfo(`" . $row['rfq_number'] . "`)'>Apply</button></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="quotation_modal" tabindex="-1" role="dialog" aria-labelledby="new_requisition_modal_Label" aria-hidden="true" >
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content bg-111 text-light">
                        <div class="mx-auto px-2">
                            <div class="py-3 mb-0 d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"></h4>
                                <h2 class="mb-0"><i class="fa fa-times-circle" data-bs-dismiss="modal"></i></h2>
                            </div>
                            <hr class="border-light">
                            <div class="company_details bg-111 px-1 py-3 mb-3 rounded-2">
                                <h4 class="fw-bold my-3 px-2">Company Details</h4>
                                <div class="details row mx-0 mb-3">
                                    <div class="card bg-222 border-0 text-light">
                                        <div class="card-body row mx-0 rounded-1">
                                            <div class="mb-3 col-xl-3 col-lg-4 col-12">
                                                <h6 class="fw-bold">Company Name</h6>
                                                <p class="text-white-50" id="company_name">Tamper Proof Organization</p>
                                            </div>
                                            <div class="mb-3 col-xl-3 col-lg-4 col-12">
                                                <h6 class="fw-bold">Email</h6>
                                                <p class="text-white-50" id="company_email">tamperproofprocurementsystem@gmail.com</p>
                                            </div>
                                            <div class="mb-3 col-xl-3 col-lg-4 col-12">
                                                <h6 class="fw-bold">Phone Number</h6>
                                                <p class="text-white-50" id="company_phone_number">0889201938</p>
                                            </div>
                                            <div class="mb-3 col-xl-3 col-lg-4 col-12">
                                                <h6 class="fw-bold">Address</h6>
                                                <p class="text-white-50" id="company_address">Tamper Proof Organization, PO Box 2023, Limbe</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <hr class="bg-light">
                            <div class="rfq_details bg-111 px-1 py-3 mb-3 rounded-2">
                                <h4 class="fw-bold my-3 px-2">RFQ Details</h4>
                                <div class="details bg-222 row mx-0 mb-3 align-items-center">
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Title</h6>
                                            <p class="text-white-50" id="rfq_title">Request for quotations - Products</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Issue Date</h6>
                                            <p class="text-white-50" id="issue_date">22-06-2023</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Submission Deadline</h6>
                                            <p class="text-white-50" id="due_date">22-06-2023</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Reference Number</h6>
                                            <p class="text-white-50" id="rfq_number">RFQ-21</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
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
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Payment terms</h6>
                                            <p class="text-white-50 small" id="payment_terms">100% within 30 days upon acceptance of the products specified and receipt of invoice</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Evaluation Criteria</h6>
                                            <p class="text-white-50 small" id="evaluation_criteria">100% within 30 days upon acceptance of the products specified and receipt of invoice</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Warranties</h6>
                                            <p class="text-white-50 small" id="warranties">100% within 30 days upon acceptance of the products specified and receipt of invoice</p>
                                            <!--                                        <ul class="list-unstyled">-->
                                            <!--                                            <li class="text-white-50 small py-1"><span class="col-1">1.</span> <span class="col-10">All goods provided shall have a minimum of one (1) year warranty</span></li>-->
                                            <!--                                            <li class="text-white-50 small py-1"><span class="col-1">2.</span> <span class="col-10">All installed components should have a minimum of three (3) months warranty against installation defects</span></li>-->
                                            <!--                                        </ul>-->
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Conditions for Release of Payment</h6>
                                            <p class="text-white-50 small" id="conditions">Delivery of Goods as per Purchase Order or Contract deliverables.</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Preferred Language</h6>
                                            <p class="text-white-50" id="preferred_language">English</p>
                                        </div>
                                    </div>
                                    <div class="card mb-2 bg-222 border-0 text-light col-xl-3 col-lg-4 col-12">
                                        <div class="card-body rounded-1">
                                            <h6 class="fw-bold">Quotes Validity</h6>
                                            <p class="text-white-50" id="quotes_validity">60 Days</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="bg-light">
                            <div class="company_details bg-111 px-1 py-3 mb-3 rounded-2">
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
                            <hr class="bg-light">
                            <div class="company_details bg-111 px-1 py-3 mb-3 rounded-2">
                                <h4 class="fw-bold my-3 px-2">Supplier Quotations</h4>
                                <form action="#" class="small" data-parsley-validate id="quotation-form">
                                    <div class="row px-2">
                                        <div class="form-group pb-3 mb-2  col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Price Per Item</label>
                                            <input type="number" class="col-xl-11 col-lg-11 col-12 d-block rounded-1 my-2 py-4 border-0 text-light"
                                                   data-parsley-required="true" data-parsley-type="number" id="price-per-item">
                                        </div>
                                        <div class="form-group pb-3 mb-2  col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Price Per Unit</label>
                                            <input type="number" class="col-xl-11 col-lg-11 col-12 d-block rounded-1 my-2 py-4 border-0 text-light"
                                                   data-parsley-required="true" data-parsley-type="number" id="price-per-unit">
                                        </div>
                                        <div class="form-group pb-3 mb-2  col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Expected Delivery Date</label>
                                            <input type="date" class="col-xl-11 col-lg-11 col-12 d-block rounded-1 my-2 py-4 border-0 text-light"
                                                   data-parsley-required="true" id="expected-delivery-date">
                                        </div>
                                    </div>
                                    <div class="buttons row align-items-center justify-content-evenly mx-auto my-3">
                                        <button type="submit" id="submit-quotation" class="btn btn-dark bg-purple text-light py-3 mb-2 col-xl-3 col-lg-4 col-12 border-0" data-id="<?php echo $_SESSION['id'] ?>">Submit</button>
                                        <button type="button" class="btn btn-dark text-light py-3 mb-2 col-xl-3 col-lg-4 col-12 border-0" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Bootstrap js link -->
<script src="../../src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Datatable js link -->
<script src="../../src/js/DataTables/datatables.js"></script>
<!-- Purify Js link -->
<script src="../../src/js/purify/purify.js"></script>
<!-- Parsely Js link -->
<script src="../../src/js/parsely.js"></script>
<!-- Sweet alert js link-->
<script src="../../src/js/sweetalert2/sweetalert2.all.js"></script>
<script src="../../src/js/sweetalert2/sweetalert2.js"></script>
<!-- Bidders js -->
<script defer src="../../src/js/bidder.js"></script>
<!-- Custom js link -->
<script src="../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let rfq_table = new DataTable('#rfq_table');
</script>
</body>
</html>