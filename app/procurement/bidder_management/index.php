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

$b_servername = "localhost";
$b_username = "root";
$b_password = "";
$b_dbname = "internalprocurement";

// Create a new database connection
$b_conn = new mysqli($b_servername, $b_username, $b_password, $b_dbname);

// Check the database connection
if ($b_conn->connect_error) {
    die("Connection failed: " . $b_conn->connect_error);
}
// SQL query to count the number of users
$b_sql = "SELECT 
            SUM(CASE WHEN is_verified = 'Yes' THEN 1 ELSE 0 END) AS verified_count,
            SUM(CASE WHEN is_verified = 'No' THEN 1 ELSE 0 END) AS not_verified_count,
            SUM(CASE WHEN is_verified = 'Deleted' THEN 1 ELSE 0 END) AS deleted_count
          FROM bidders";
$b_result = $b_conn->query($b_sql);
$b_row = $b_result->fetch_assoc();

$verified_count = $b_row['verified_count'];
$not_verified_count = $b_row['not_verified_count'];
$deleted_count = $b_row['deleted_count'];

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
    <!-- Sweet alert css link -->
    <link rel="stylesheet" href="../../../src/css/sweetalert2/sweetalert2.css">
    <!-- Custom css link -->
    <link rel="stylesheet" href="../../../src/css/style.css">

    <title>Bidder Management</title>
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
        <a href="../" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-clipboard-list me-2"></i> Requisitions</p></a>
        <a href="../procurements" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-credit-card me-2"></i> Procurements</p></a>
        <a href="#" class="bg-222 d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-briefcase me-2"></i> Bidder Management</p></a>
        <a href="../history" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-history me-2"></i> History</p></a>
        <a href="#" class="d-block link-hover py-3 mt-5 text-white text-decoration-none d-flex"><p class="col-1 d-xl-block d-lg-block d-md-block d-none"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-sign-out me-2"></i> Log out</p></a></ul>
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
            <h2 class="text-white fw-bold mb-4">Bidder Management</h2>
            <!-- Shows recently stocked item -->
            <div class="col-12 mb-3">
                <span class="bg-111 p-2 rounded-top-1 text-secondary fw-bold">Summary</span>
                <div class="card bg-111 mb-3 border-0">
                    <div class="card-body d-flex flex-wrap justify-content-between">
                        <div class="py-2 col-xl-4 col-lg-4 col-md-5 col-12 border-end border-secondary">
                            <p class="text-secondary fw-bold">Total Bidders</p>
                            <h5 class="text-white"><?php echo $verified_count ?></h5>
                        </div>
                        <div class="py-2 col-xl-4 col-lg-4 col-md-5 col-12 border-end border-secondary ps-2">
                            <p class="text-secondary fw-bold">Removed Bidders</p>
                            <h5 class="text-white"><?php echo $deleted_count ?></h5>
                        </div>
                        <div class="py-2 col-xl-4 col-lg-4 col-md-5 col-12 ps-2">
                            <p class="text-secondary fw-bold">Registration requests</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="text-light col-3"><?php echo $not_verified_count ?></h5>
                                <div class="text-center col-6">
                                    <a href="registration_approvals" class="btn btn-secondary"><i class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="overflow-x-scroll mb-3">

                <div class="card card bg-111 text-light max-width">
                    <div class="card-header mb-0 row justify-content-between align-items-center">
                        <h6 class="col-7 mb-0">Current Bidders</h6>

                    </div>
                    <div class="card-body">
                        <table class="d-table table table-striped table-borderless overflow-hidden mt-5 custom_table small_font" id="supplier_table">
                            <thead>
                            <tr>
                                <th class="text-light">Tax ID</th>
                                <th class="text-light">Business Name</th>
                                <th class="text-light">Business Type</th>
                                <th class="text-light">Year of Establishment</th>
                                <th class="text-light text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php

                                $b_sql = "SELECT id, business_name, year_established, business_type, tax_id FROM bidders WHERE is_verified = 'Yes'";
                                $b_result = $b_conn->query($b_sql);

                                if ($b_result->num_rows > 0) {
                                    while ($b_row = $b_result->fetch_assoc()) {
                                        echo "<tr>
                                                <td class='text-light py-3'>" . $b_row['tax_id'] . "</td>
                                                <td class='text-light py-3'>" . $b_row['business_name'] . "</td>
                                                <td class='text-light py-3'>" . $b_row['business_type'] . "</td>
                                                <td class='text-light py-3'>" . $b_row['year_established'] . "</td>
                                                <td class='text-light py-3 text-center px-3'><button class='btn btn-danger delete_bidder' type='button' data-id='". $b_row['id'] ."'>Delete</button></td>
                                            </tr>";
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
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
<script defer src="../../../src/js/bidder_management.js"></script>
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