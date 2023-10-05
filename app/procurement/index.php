<?php
include '../../includes/session_config.php';
include '../../db_connection.php';
$user_id = $_SESSION['id'];
$getUserFullNameQuery = "SELECT `firstname`, `lastname` FROM users WHERE id = ?";
$countQuery = "SELECT (SELECT COUNT(*) FROM requisitions WHERE Status = 'Approved') AS approvedCount,
                      (SELECT COUNT(*) FROM request_for_quotations) AS rfq_count";

// Execute the getUserFullNameQuery
$stmtFullName = $conn->prepare($getUserFullNameQuery);
$stmtFullName->bind_param("i", $user_id);
$stmtFullName->execute();
$stmtFullName->bind_result($firstname, $lastname);
$stmtFullName->fetch();
$stmtFullName->close();

$full_name = $firstname . " " . $lastname;

$stmt = $conn->prepare($countQuery);
//$stmt->bind_param("sss", $user_username, $user_username, $user_username);
$stmt->execute();
$stmt->bind_result( $approvedCount, $rfq_count);
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

    <title>Procurement Dashboard</title>
</head>
<body class="bg-black">
<!-- Sidebar: Visible on computer, collapses on tab and phone screen -->
<div class="sidebar col-xl-2 col-lg-2 col-md-4 col-12 bg-111 h-100 bottom-0 position-fixed top-0 shadow_custom" id="sidebar">
    <div class="logo py-3 col-12 px-0 bg-box">
        <h1 class="text-center mb-0"><i class="fa fa-box text-white"></i></h1>
    </div>
    <!-- Space creator -->
    <hr class="col-10 mx-auto py-3 ">
    <ul class="mt-5 pt-5 px-0">
        <a href="#" class="bg-222 d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-clipboard-list me-2"></i> Requisitions</p></a>
        <a href="procurements/" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-credit-card me-2"></i> Procurements</p></a>
        <a href="bidder_management/" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-briefcase me-2"></i> Bidder Management</p></a>
        <a href="history/" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-history me-2"></i> History</p></a>
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
                <p class="text-white fw-bold"><i class="fa fa-user text-white"></i> <?php echo $full_name ?></p>
                <div class="other col-xl-2 col-lg-2 col-md-2 col-2 d-flex justify-content-end">
                    <p><i class="fa fa-bell text-white"></i></p>
                </div>
            </div>
        </div>
        <!-- Page's main purpose here -->
        <div class="bidder_dashboard col-11 mx-auto my-3">
            <h2 class="text-white fw-bold mb-4">Requisitions <span class="badge bg-dark text-light small"><?php echo $approvedCount ?> New</span></h2>
            <!-- Shows recently stocked item -->
            <div class="mx-0 col-12 mb-3">


                <div class="col-12 overflow-x-scroll">
                    <div class="card bg-111 pe-0 text-light max-width">
                        <div class="card-header mb-0 row justify-content-between align-items-center">
                            <h6 class="col-7 mb-0">New Requisitions</h6>
                        </div>
                        <div class="card-body">
                            <table class="d-table table table-striped table-borderless custom_table small_font" id="new_requisitions">
                                <thead>
                                <tr>
                                    <th class="text-light">#</th>
                                    <th class="text-light">Requisition Name</th>
                                    <th class="text-light">Full Name</th>
                                    <th class="text-light">Department</th>
                                    <th class="text-light">Date</th>
                                    <th class="text-light">Status</th>
                                    <th class="text-light">Document</th>
                                    <th class="text-light">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Query to retrieve the requisitions for a specific user based on User_id
                                $getRequisitionsQuery = "SELECT r.requisition_id, r.requisition_name, r.date_created, r.status, r.document, u.firstname, u.lastname, u.department
                                                         FROM requisitions AS r
                                                         INNER JOIN users AS u ON r.user_id = u.id WHERE r.status = 'Approved'";

                                $stmt = $conn->prepare($getRequisitionsQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                function determine_color($status_receieved) : string{
                                    if ($status_receieved == "Approved")
                                        return "success";
                                    elseif ($status_receieved == "Pending")
                                        return "secondary";
                                    return "danger";
                                }
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-light py-3'><small>" . $row['requisition_id'] . "</small></td>";
                                        echo "<td class='text-light py-3'><small>" . $row['requisition_name'] . "</small></td>";
                                        echo "<td class='text-light py-3'><small>" . $row['firstname'] . " " . $row['lastname'] . "</small></td>";
                                        echo "<td class='text-light py-3'><small>" . $row['department'] . "</small></td>";
                                        echo "<td class='text-light py-3'><small>" . $row['date_created'] . "</small></td>";
                                        echo "<td class='text-light py-3'><small class='text-bg-". determine_color($row['status']) ." py-1 px-2 rounded-5'>" . $row['status'] . "</small></td>";
                                        echo "<td class='text-light py-3'><a href='" . $row['document'] . "' download class='text-decoration-none small_font text-bg-light p-1 rounded-2'>Download</a></td>";
                                        echo "<td class='text-light py-3'><button class='btn btn-secondary btn-sm small_font approval_viewer' data-bs-target='#rfq_modal' data-bs-toggle='modal' onclick='fetchData(" . $row['requisition_id'] . ")'>Initiate</button></td>";
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



            <div class="modal" id="rfq_modal" tabindex="-1" role="dialog" aria-labelledby="rfq_modal_Label" aria-hidden="true" >
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content bg-111">
                        <div class="card text-light bg-111 my-3 py-3">
                            <div class="card-header mb-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold">RFQ Application</h5>
                                    <h2><i class="fa fa-times-circle" data-bs-dismiss="modal"></i></h2>
                                </div>
                                <hr class="border-white">
                            </div>
                            <?php
                                $rfq_number = "";
                                $issue_date = "";
                                $company_name = "";
                                $company_email = "";
                                $company_address = "";
                                $amount = "";
                                $quantity = "";
                                $description = "";
                                $category = "";
                                $get_contact_info = "SELECT * FROM contact_details";
                                $stmt = $conn->prepare($get_contact_info);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0){
                                    $row = $result->fetch_assoc();
                                    $company_name = $row['company_name'];
                                    $company_email = $row['email'];
                                    $company_address = $row['physical_address'];
                                }

                            ?>
                            <div class="card-body mt-0 pt-0">
                                <form action="#" method="post" id="rfq_form" data-parsley-validate="">
                                    <h6 class="text-center mt-3 fw-bold">RFQ Details</h6>
                                    <div class="row">
                                        <div class="form-group pb-2 mb-3 col-xl-4 col-lg-6 col-12">
                                            <label class="d-block">RFQ Title</label>
                                            <input type="text" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light"  name ="rfq_title" data-parsley-required="true">
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-4 col-lg-6 col-12">
                                            <label class="d-block">RFQ Number</label>
                                            <input type="text" id="rfq_number" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="rfq_number" data-parsley-required="true">
                                        </div>
                                        <div class="form-group pb-2 mb-3 d-none col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Issue Date</label>
                                            <input type="text"  id="issue_date" value="<?php echo date('d-m-Y'); ?>" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="issue_date">
                                        </div>
                                        <div class="form-group pb-2 mb-3 d-none col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Requisition ID</label>
                                            <input type="text"  id="requisition_id" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="requisition_id">
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-4 col-lg-6 col-12">
                                            <label class="d-block">RFQ Deadline</label>
                                            <input type="date" id="rfq_deadline" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="rfq_deadline" data-parsley-required="true">
                                        </div>
                                    </div>
                                    <h6 class="text-center mt-3 fw-bold d-none">Contact Information</h6>
                                    <div class="row">
                                        <div class="form-group pb-2 mb-3 d-none col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Name</label>
                                            <input type="hidden" value="<?php echo $company_name; ?>" id="contact_name"  class="px-1 col-xl-12 col-lg-12 col-md-12 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="contact_name">
                                        </div>
                                        <div class="form-group pb-2 mb-3 d-none col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Email</label>
                                            <input type="hidden" value="<?php echo $company_email; ?>" id="contact_email"  class="px-1 col-xl-12 col-lg-12 col-md-12 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="contact_email">
                                        </div>
                                        <div class="form-group pb-2 mb-3 d-none col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Address</label>
                                            <input type="hidden" value="<?php echo $company_address; ?>" id="contact_address"  class="px-1 col-xl-12 col-lg-12 col-md-12 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="contact_address">
                                        </div>
                                    </div>
                                    <h6 class="text-center fw-bold">Product Details</h6>
                                    <div class="row">

                                        <div class="form-group pb-2 mb-3 col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Preferred Language</label>
                                            <select class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="preferred_language">
                                                <option value="english">English</option>
                                                <option value="spanish">Spanish</option>
                                                <option value="french">French</option>
                                                <!-- Add more language options as needed -->
                                            </select>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Quotes Validity</label>
                                            <input type="date" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="quotes_validity" data-parsley-required="true">
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Quantity</label>
                                            <input type="number"  id="quantity" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="quantity" data-parsley-required="true">
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Payment Terms</label>
                                            <select class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="payment_terms">
                                                <option value="net_30">Net 30 Days</option>
                                                <option value="net_60">Net 60 Days</option>
                                                <option value="net_90">Net 90 Days</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Category</label>
                                            <select id="category" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="Category">
                                                <option value="hardware">Hardware</option>
                                                <option value="electronics">Electronics</option>
                                                <option value="electronics">Stationary</option>
                                                <option value="furniture">Furniture</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Submission Methods</label>
                                            <div class="form-control bg-222 border-0 text-light">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="emailCheckbox" name="submission_method_email" value="Email">
                                                    <label class="form-check-label" for="emailCheckbox">Email</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="faxCheckbox" name="submission_method_mail" value="Mail">
                                                    <label class="form-check-label" for="faxCheckbox">Mail</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="onlinePortalCheckbox" name="submission_method_system" value="System">
                                                    <label class="form-check-label" for="onlinePortalCheckbox">System</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Warranties</label>
                                            <textarea class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="warranties" data-parsley-required="true"></textarea>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Evaluation Criteria</label>
                                            <textarea class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="evaluation_criteria" data-parsley-required="true"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Terms and Conditions</label>
                                            <textarea class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="terms_and_conditions" data-parsley-required="true"></textarea>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Conditions for Release of Payment</label>
                                            <textarea class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="payment_conditions" data-parsley-required="true"></textarea>
                                        </div>
                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label for="description" class="d-block">Description</label>
                                            <textarea rows="4" id="description"  style="resize: none" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="description" data-parsley-required="true"></textarea>
                                        </div>

                                        <div class="form-group pb-2 mb-3 col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Specifications</label>
                                            <textarea rows="4" style="resize: none" id="specifications" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="specifications" data-parsley-required="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-5 d-flex justify-content-between mt-3">
                                        <button type="submit" class="btn bg-purple text-light px-3" name="requisition_id" id="create_requisition">Create</button>
                                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="quotations_modal" tabindex="-1" role="dialog" aria-labelledby="quotations_modal_Label" aria-hidden="true" >
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content bg-111">
                        <div class="card text-light bg-111 my-3 py-3">
                            <div class="card-header mb-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold">Bidder Applications</h5>
                                    <h2><i class="fa fa-times-circle" data-bs-dismiss="modal"></i></h2>
                                </div>
                                <hr class="border-white">
                            </div>

                            <div class="card-body mt-0 pt-0">
                                <div class="overflow-x-scroll">

                                    <div class="card me-2 card bg-111 text-light max-width">
                                        <div class="card-header my-3">
                                            <h6 class="col-7 mb-0">Quotations for <span id="rfq_title">something here</span></h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="d-table table table-striped table-borderless custom_table small_font">
                                                <thead>
                                                <tr>
                                                    <th class="text-light">RFQ Number</th>
                                                    <th class="text-light">Bidder</th>
                                                    <th class="text-light">RFQ Title</th>
                                                    <th class="text-light">Price Per Item</th>
                                                    <th class="text-light">Price Per Unit</th>
                                                    <th class="text-light">Negotiable</th>
                                                    <th class="text-light">Expected Delivery Date</th>
                                                    <th class="text-light text-center">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="quotation_tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
<!-- Approvers js -->
<script defer src="../../src/js/procurement.js"></script>
<!-- Custom js link -->
<script src="../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let nr_table = new DataTable('#new_requisitions');
    let nrq_table = new DataTable('#rfq_table');
    let s_table = new DataTable('#supplier_table');
</script>
</body>
</html>