<?php
include '../../includes/session_config.php';
include '../../db_connection.php';

$user_id = $_SESSION['id'];
$getUserFullNameQuery = "SELECT `firstname`, `lastname` FROM users WHERE id = ?";
$stmt = $conn->prepare($getUserFullNameQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name); // Bind the result variables

$user_fullname = "";

if ($stmt->fetch()) {
    // You don't need to use get_result() here, as you are fetching a single row
    $user_fullname = $first_name . " " . $last_name;
}

$stmt->close(); // Close the statement

$countQuery = "SELECT
                    (SELECT COUNT(*) FROM requisitions WHERE Status = 'Pending') AS pendingCount,
                    (SELECT COUNT(*) FROM requisitions WHERE Status = 'Approved') AS approvedCount,
                    (SELECT COUNT(*) FROM requisitions WHERE Status = 'Declined') AS declinedCount";

$stmt = $conn->prepare($countQuery);
//$stmt->bind_param("sss", $user_username, $user_username, $user_username);
$stmt->execute();
$stmt->bind_result($pendingCount, $approvedCount, $declinedCount);
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

    <title>Approver Dashboard</title>
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
        <a href="#" class="bg-222 d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-home-alt me-2"></i> Dashboard</p></a>
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
                <p class="text-white fw-bold"><i class="fa fa-user text-white"></i> <?php echo $user_fullname; ?></p>
                <div class="other col-xl-2 col-lg-2 col-md-2 col-2 d-flex justify-content-end">
                    <p><i class="fa fa-bell text-white"></i></p>
                </div>
            </div>
        </div>
        <!-- Page's main purpose here -->
        <div class="bidder_dashboard col-11 mx-auto my-3">
            <h2 class="text-white fw-bold mb-4">Approver Dashboard</h2>
            <!-- Shows recently stocked item -->
            <div class="mx-0 col-12 mb-3">
                <div class="row align-items-start mb-3">
                    <div class="col-12 mx-0 px-0 row wrapping">
                        <div class="card col-xl-4 col-lg-4 col-md-6 col-12 bg-black border-0 me-0 mx-0">
                            <div class="col-12 card-body mb-2 text-center text-light bg-success rounded-1 py-4">
                                <h1 class="mb-0"><?php echo $approvedCount; ?></h1>
                                <p class="mb-0 small_font"><small>Approved</small></p>
                            </div>
                        </div>
                        <div class="card col-xl-4 col-lg-4 col-md-6 col-12 bg-black border-0 me-0 mx-0">
                            <div class="col-12 card-body mb-2 text-center text-light bg-111 rounded-1 py-4">
                                <h1 class="mb-0"><?php echo $pendingCount; ?></h1>
                                <p class="mb-0 small_font"><small>Pending</small></p>
                            </div>
                        </div>
                        <div class="card col-xl-4 col-lg-4 col-md-6 col-12 bg-black border-0 me-0 mx-0">
                            <div class="col-12 card-body mb-2 text-center text-light bg-danger rounded-1 py-4">
                                <h1 class="mb-0"><?php echo $declinedCount; ?></h1>
                                <p class="mb-0 small_font"><small>Declined</small></p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 overflow-x-scroll mb-3">
                    <h5 class="text-light fw-bold my-3">Unprocessed Requisitions</h5>
                    <div class="card bg-111 text-light inventory_card">
                        <div class="card-body">
                            <!-- Table for items in inventory, organized by bootstrap and datatable.js -->
                            <table class="table rounded-2 mt-5 overflow-hidden small_font table-borderless table-striped custom_table" id="requisition_table">
                                <thead class="px-3">
                                <tr>
                                    <th class="text-light py-3 px-3">#</th>
                                    <th class="text-light py-3 px-3">Requisition Name</th>
                                    <th class="text-light py-3 px-3">Name</th>
                                    <th class="text-light py-3 px-3">Department</th>
                                    <th class="text-light py-3">Date Created</th>
                                    <th class="text-light py-3">Status</th>
                                    <th class="text-light py-3">Document</th>
                                    <th class="text-light py-3">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Query to retrieve the requisitions for a specific user based on User_id
                                $getRequisitionsQuery = "SELECT r.requisition_id, r.requisition_name, r.date_created, r.status, r.document, u.firstname, u.lastname, u.department
                                                         FROM requisitions AS r
                                                         INNER JOIN users AS u ON r.user_id = u.id WHERE r.status = 'Pending'";

                                $stmt = $conn->prepare($getRequisitionsQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                function determine_color($status_received): string {
                                    return ($status_received == "Approved") ? "success" : (($status_received == "Pending") ? "secondary" : "danger");
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
                                        echo "<td class='text-light py-3'><button class='btn btn-secondary btn-sm small_font approval_viewer' data-bs-target='#approval_modal' data-bs-toggle='modal' onclick='fetchData(" . $row['requisition_id'] . ")'>View</button></td>";
                                        echo "</tr>";
                                    }
                                }
//                                $conn->close();
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 overflow-x-scroll mt-4">
                    <h5 class="text-light fw-bold my-3">Processed Requisitions</h5>
                    <div class="card bg-111 text-light inventory_card">
                        <div class="card-body">
                            <!-- Table for items in inventory, organized by bootstrap and datatable.js -->
                            <table class="table rounded-2 mt-5 overflow-hidden small_font table-borderless table-striped custom_table" id="approved_requisition_table">
                                <thead class="px-3">
                                <tr>
                                    <th class="text-light py-3 px-3">#</th>
                                    <th class="text-light py-3 px-3">Requisition Name</th>
                                    <th class="text-light py-3 px-3">Name</th>
                                    <th class="text-light py-3 px-3">Department</th>
                                    <th class="text-light py-3">Date Created</th>
                                    <th class="text-light py-3">Status</th>
                                    <th class="text-light py-3">Document</th>
<!--                                    <th class="text-light py-3">Action</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Query to retrieve the requisitions for a specific user based on User_id
                                $getRequisitionsQuery = "SELECT r.requisition_id, r.requisition_name, r.date_created, r.status, r.document, u.firstname, u.lastname, u.department
                                                         FROM requisitions AS r
                                                         INNER JOIN users AS u ON r.user_id = u.id WHERE r.status = 'Approved' OR r.status = 'Declined' order by r.date_created desc";

                                $stmt = $conn->prepare($getRequisitionsQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();


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
//                                        echo "<td class='text-light py-3'><button class='btn btn-secondary btn-sm small_font approval_viewer' data-bs-target='#approval_modal' data-bs-toggle='modal' onclick='fetchData(" . $row['requisition_id'] . ")'>View</button></td>";
                                        echo "</tr>";
                                    }
                                }
                                $conn->close();
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal" id="approval_modal" tabindex="-1" role="dialog" aria-labelledby="approval_modal_Label" aria-hidden="true" >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content bg-111">
                        <div class="card bg-111 py-3 text-light">
                            <div class="card-header mb-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold text-light mb-0 ">Approve Requisition</h5>
                                    <h2 class="mb-0"><i class="fa fa-times-circle text-light" data-bs-dismiss="modal"></i></h2>
                                </div>
                                <hr class="border-white">
                            </div>
                            <div class="card-body col-11 mx-auto">
                                <div class="pb-4">
                                    <h6 class="text-center fw-bold">User Details</h6>
                                    <ul class="list-unstyled row mb-3">
                                        <li class="col-xl-6 col-lg-6 col-md-6 col-12 py-2"><b>Name: </b> <span id="full_name"></span></li>
                                        <li class="col-xl-6 col-lg-6 col-md-6 col-12 py-2"><b>Department: </b> <span id="department"></span></li>
                                    </ul>
                                    <hr class="border-white">
                                </div>
                                <div class="pb-4">
                                    <h6 class="text-center fw-bold">Requisition Details</h6>
                                    <ul class="list-unstyled mb-3">
                                        <li class="py-3 row"><b class="col-xl-4 col-lg-5 col-12">Date Created: </b> <span class="col-xl-7 col-lg-7 col-12" id="date_created"></span></li>
                                        <li class="py-3 row"><b class="col-xl-4 col-lg-5 col-12">Product Requested: </b> <span class="col-xl-7 col-lg-7 col-12" id="description"></span></li>
                                        <li class="py-3 row"><b class="col-xl-4 col-lg-5 col-12">Reason For Request: </b> <span class="col-xl-7 col-lg-7 col-12" id="reason"></span></li>
                                    </ul>
                                    <hr class="border-white">
                                </div>
                                <div class="pb-4">
                                    <h6 class="text-center fw-bold">Product Details</h6>
                                    <table class="d-table table custom_table table-borderless">
                                        <thead>
                                        <tr>
                                            <th class="text-light text-center">Quantity</th>
                                            <th class="text-light text-center">Estimated Amount</th>
                                            <th class="text-light text-center">Category</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-light text-center" id="quantity"></td>
                                            <td class="text-light text-center" id="amount"></td>
                                            <td class="text-light text-center" id="category"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr class="border-white">
                                </div>
                                <div class="pb-4">
                                    <h6 class="text-center fw-bold">Approvals</h6>
                                    <form action="#">
                                        <p class="fw-bold text-center py-3">Do you approve this requisition?</p>
                                        <div class="form-group text-center">
                                            <button type="button" role="button" class="btn text-light bg-purple approve_decision" data-approval-type="Yes" id="approve">Yes</button>
                                            <button type="button" role="button" class="btn text-light bg-222 approve_decision" data-approval-type="No" id="deny">No</button>
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
</div>

<!-- Bootstrap js link -->
<script src="../../src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Datatable js link -->
<script src="../../src/js/DataTables/datatables.js"></script>
<!-- Sweet alert js link-->
<script src="../../src/js/sweetalert2/sweetalert2.all.js"></script>
<script src="../../src/js/sweetalert2/sweetalert2.js"></script>
<!-- Approvers js -->
<script src="../../src/js/approver.js"></script>
<!-- Custom js link -->
<script src="../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let table = new DataTable('#requisition_table');
    let other_table = new DataTable('#approved_requisition_table');
</script>
</body>
</html>