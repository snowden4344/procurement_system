<?php
include '../../../includes/session_config.php';
include '../../../db_connection.php';

$user_id = $_SESSION['id'];
$getUserFullNameQuery = "SELECT `firstname`, `lastname` FROM users WHERE id = ?";
// Execute the getUserFullNameQuery
$stmtFullName = $conn->prepare($getUserFullNameQuery);
$stmtFullName->bind_param("i", $user_id);
$stmtFullName->execute();
$stmtFullName->bind_result($firstname, $lastname);
$stmtFullName->fetch();
$stmtFullName->close();

$full_name = $firstname . " " . $lastname;


$countQuery = "SELECT (SELECT COUNT(*) FROM requisitions WHERE Status = 'Approved') AS approvedCount,
                      (SELECT COUNT(*) FROM request_for_quotations) AS rfq_count";

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
    <link rel="stylesheet" href="../../../src/css/bootstrap-5.3.1-dist/css/bootstrap.css">
    <!-- fontawesome css links -->
    <link rel="stylesheet" href="../../../src/css/fontawesome-free-6.4.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../../src/css/fontawesome-free-6.4.2-web/css/all.css">
    <!-- Datatable.JS css link -->
    <link rel="stylesheet" href="../../../src/js/DataTables/datatables.css">
    <!-- Font importation link -->
    <link rel="stylesheet" href="../../../src/css/fonts.css">
    <!-- sweeralert css link -->
    <link rel="stylesheet" href="../../../src/css/sweetalert2/sweetalert2.css">
    <!-- Custom css link -->
    <link rel="stylesheet" href="../../../src/css/style.css">

    <title>Procurements</title>
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
        <a href="../index.php" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-clipboard-list me-2"></i> Requisitions</p></a>
        <a href="#" class="bg-222 d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-credit-card me-2"></i> Procurements</p></a>
        <a href="../bidder_management/" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-briefcase me-2"></i> Bidder Management</p></a>
        <a href="../history" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-history me-2"></i> History</p></a>
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
            <h2 class="text-white fw-bold mb-4">Procurements <span class="badge bg-dark text-light small"><?php echo $rfq_count ?> New</span></h2>
            <!-- Shows recently stocked item -->

            <div class="overflow-x-scroll mb-3 mt-4">

                <div class="card me-2 card bg-111 text-light max-width">
                    <div class="card-header mb-0 row justify-content-between align-items-center">
                        <h6 class="col-7 mb-0">Current Procurements</h6>
                    </div>
                    <div class="card-body">
                        <table class="d-table table table-striped table-borderless custom_table small_font" id="rfq_table">
                            <thead>
                            <tr>
                                <th class="text-light">#</th>
                                <th class="text-light">Item</th>
                                <th class="text-light">Date Initiated</th>
                                <th class="text-light">Deadline</th>
                                <th class="text-light">Status</th>
                                <th class="text-light text-center">Applications</th>
                                <th class="text-light">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Query to retrieve the requisitions for a specific user based on User_id
                            $getRequisitionsQuery = "SELECT r.rfq_number, r.rfq_title, r.requisition_id, r.date_generated, r.deadline, r.product_details, q.status,
                                                     (SELECT COUNT(*) FROM quotations q WHERE q.rfq_number = r.rfq_number) AS quotationCount FROM request_for_quotations AS r
                                                     INNER JOIN requisitions AS q ON r.requisition_id = q.requisition_id  WHERE r.status = 'In Progress'";


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
                                        echo "<td class='text-light py-3 text-center'>" . $row['quotationCount'] . "</td>";
                                        echo "<td class='text-light py-3'><button class='btn btn-secondary btn-sm small_font approval_viewer' data-bs-target='#quotations_modal' data-bs-toggle='modal' onclick='fetchQuotationData(`" . $row['rfq_number'] . "`)'>View</button></td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
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
                                <form action="../../../data_processors/data.php" method="post" >
                                    <h6 class="text-center mt-3 fw-bold">RFQ Details</h6>
                                    <div class="row">
                                        <div class="form-group col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">RFQ Title</label>
                                            <input type="text" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light"  name ="rfq_title">
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">RFQ Number</label>
                                            <input type="text" id="rfq_number" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="rfq_number">
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">Issue Date</label>
                                            <input type="text"  id="issue_date" value="<?php echo date('d-m-Y'); ?>" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="issue_date">
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-6 col-12">
                                            <label class="d-block">RFQ Deadline</label>
                                            <input type="date" id="rfq_deadline" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="rfq_deadline">
                                        </div>
                                    </div>
                                    <h6 class="text-center mt-3 fw-bold">Contact Information</h6>
                                    <div class="row">
                                        <div class="form-group col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Name</label>
                                            <input type="text" value="<?php echo $company_name; ?>" id="contact_name"  class="px-1 col-xl-12 col-lg-12 col-md-12 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="contact_name">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Email</label>
                                            <input type="text" value="<?php echo $company_email; ?>" id="contact_email"  class="px-1 col-xl-12 col-lg-12 col-md-12 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="contact_email">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-12">
                                            <label class="d-block">Address</label>
                                            <input type="text" value="<?php echo $company_address; ?>" id="contact_address"  class="px-1 col-xl-12 col-lg-12 col-md-12 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="contact_address">
                                        </div>
                                    </div>
                                    <h6 class="text-center mt-3 fw-bold">Product Details</h6>
                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-6 col-12">
                                            <label for="description" class="d-block">Description</label>
                                            <textarea rows="4" id="description"  style="resize: none" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="description"></textarea>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Category</label>
                                            <input type="text"  id="category" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="Category">
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Quantity</label>
                                            <input type="text"  id="quantity" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="quantity">
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-12">
                                            <label class="d-block">Specifications</label>
                                            <textarea rows="4" style="resize: none" id="specifications" class="px-1 col-12 d-block rounded-1 my-2 py-3 border-0 text-light" name="specifications"></textarea>
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
                                        <div class="card-body">
                                            <table class="d-table table table-striped table-borderless custom_table small_font">
                                                <thead>
                                                <tr>
                                                    <th class="text-light">RFQ Number</th>
                                                    <th class="text-light">Bidder</th>
                                                    <th class="text-light">RFQ Title</th>
                                                    <th class="text-light">Price Per Item</th>
                                                    <th class="text-light">Price Per Unit</th>
                                                    <th class="text-light">Date Submitted</th>
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
<script src="../../../src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="../../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Datatable js link -->
<script src="../../../src/js/DataTables/datatables.js"></script>
<!-- Sweet alert js link-->
<script src="../../../src/js/sweetalert2/sweetalert2.all.js"></script>
<script src="../../../src/js/sweetalert2/sweetalert2.js"></script>
<!-- Approvers js -->
<script defer src="../../../src/js/procurement.js"></script>
<!-- Custom js link -->
<script src="../../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let nr_table = new DataTable('#new_requisitions');
    let nrq_table = new DataTable('#rfq_table');
    let s_table = new DataTable('#supplier_table');
</script>
</body>
</html>