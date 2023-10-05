<?php
include '../../includes/session_config.php';
include '../../db_connection.php';
$user_id = $_SESSION['id'];
$getUserFullNameQuery = "SELECT `firstname`, `lastname` FROM users WHERE id = ?";
$stmt = $conn->prepare($getUserFullNameQuery);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name); // Bind the result variables

$user_fullname = "";

if ($stmt->fetch()) {
    // You don't need to use get_result() here, as you are fetching a single row
    $user_fullname = $first_name . " " . $last_name;
    $_SESSION['fullname'] = $user_fullname;
}

$stmt->close(); // Close the statement

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
        <!-- Font importation link -->
        <link rel="stylesheet" href="../../src/css/fonts.css">
        <!-- Datatable.JS css link -->
        <link rel="stylesheet" href="../../src/js/DataTables/datatables.css">
        <!-- Sweet alert css link -->
        <link rel="stylesheet" href="../../src/css/sweetalert2/sweetalert2.css">
        <!-- Custom css link -->
        <link rel="stylesheet" href="../../src/css/style.css">

        <title>Dashboard</title>
    </head>
    <body class="bg-black">
        <!-- Sidebar: Visible on computer, collapses on tab and phone screen -->
        <div class="sidebar col-xl-2 col-lg-2 col-md-4 col-12 bg-111 h-100 position-fixed top-0 bottom-0 shadow_custom" id="sidebar">
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
            <h3 class="position-fixed d-xl-none d-lg-none d-inline p-1 bg-box rounded-1 top-0 mt-2 mx-2 text-center" id="hamburger"><i class="fa fa-navicon mx-2 text-white"></i></h3>
            <!-- Adds Space for aesthetics -->
            <div class="spacer col-xl-2 col-lg-2">
            </div>
            <!-- Main content starts here -->
            <div class="actual_content col-xl-10 col-lg-10 col-12">
                <!-- Section that shows username, notifications and messages -->
                <div class="top_tools d-flex col-11 mb-5 mx-auto">
                    <!-- Adds Space for aesthetics -->
                    <div class="spacer col-xl-8 col-lg-7 col-md-8 col-3"></div>
                    <div class="actual_tools col-xl-4 col-lg-5 col-md-4 col-9 justify-content-between d-flex align-items-center">
                        <p class="text-white fw-bold"><i class="fa fa-user text-white"></i> <?php echo $user_fullname ?></p>
                        <div class="other col-xl-2 col-lg-2 col-md-2 col-2 justify-content-end d-flex">
                            <p><a href="notifications.html" class="text-decoration-none"><i class="fa fa-bell text-white"></i></a></p>
                        </div>
                    </div>
                </div>
                <!-- Page's main purpose here -->
                <div class="dashboard col-11 mx-auto my-3">
                    <h2 class="text-white fw-bold mb-4">Dashboard</h2>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <span class="p-2 rounded-top-1 bg-primary-subtle text-dark">Requisition Summary</span>
                            <div class="req_summary row mb-3 justify-content-between align-items-center flex-wrap">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                <?php

                                 //Now, let's count pending, approved, and declined requisitions for this user in a single query
                                $countQuery = "SELECT
                                    (SELECT COUNT(*) FROM requisitions WHERE user_id = ? AND Status = 'Pending') AS pendingCount,
                                    (SELECT COUNT(*) FROM requisitions WHERE user_id = ? AND Status = 'Approved') AS approvedCount,
                                    (SELECT COUNT(*) FROM requisitions WHERE user_id = ? AND Status = 'Declined') AS declinedCount";

                                $stmt = $conn->prepare($countQuery);
                                $stmt->bind_param("iii", $user_id, $user_id, $user_id);
                                $stmt->execute();
                                $stmt->bind_result($pendingCount, $approvedCount, $declinedCount);
                                $stmt->fetch();
                                $stmt->close();

//                                 Now $pendingCount contains the count of pending requisitions,
//                                 $approvedCount contains the count of approved requisitions,
//                                 and $declinedCount contains the count of declined requisitions for the user

                            // Close the database connection
//                            $conn->close();
                            ?>
                                    <div class="card bg-primary-subtle border-0 col-12">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="words">
                                                <h2><?php echo $approvedCount; ?></h2>
                                                <p>Approved</p>
                                            </div>
                                            <h1><i class="fa fa-check-circle text-success"></i></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                    <div class="card col-12">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="words">
                                                <h2><?php echo $pendingCount; ?></h2>
                                                <p>Pending</p>
                                            </div>
                                            <h1><i class="fa fa-clock"></i></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                    <div class="card bg-333 text-light col-12">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="words">
                                                <h2><?php echo $declinedCount; ?></h2>
                                                <p>Declined</p>
                                            </div>
                                            <h1><i class="fa fa-times-circle text-danger"></i></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="card bg-111 text-light inventory_card">
                    <div class="card-header d-flex align-items-center py-3 justify-content-between">
                        <h4 class="text-light fw-bold">Requisitions</h4>
                        <button class="btn btn-primary border-0 bg-purple text-light" data-bs-toggle="modal" data-bs-target="#new_requisition_modal">+ New Requisition</button>
                    </div>
                    <div class="card-body">
                        <!-- Table for items in inventory, organized by bootstrap and datatable.js -->
                        <table class="table rounded-2 mt-5 overflow-hidden table-borderless table-striped custom_table" id="requisition_table">
                            <thead class="px-3">
                            <tr>
                                <th class="text-light py-3 px-3">#</th>
                                <th class="text-light py-3 px-3">Requisition Name</th>
                                <th class="text-light py-3">Date Created</th>
                                <th class="text-light py-3">Status</th>
                                <th class="text-light py-3">Document</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
//
//                            // Query to retrieve the requisitions for a specific user based on User_id
                            $getRequisitionsQuery = "SELECT requisition_id, requisition_name, date_created, status, document FROM requisitions WHERE user_id = ?";
                            $stmt = $conn->prepare($getRequisitionsQuery);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            function determine_color($status_received): string {
                                return ($status_received == "Approved") ? "success" : (($status_received == "Pending") ? "secondary" : (($status_received == "Initiated") ? "primary" : "danger"));
                            }

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='text-light py-3'><small>" . $row['requisition_id'] . "</small></td>";
                                    echo "<td class='text-light py-3'><small>" . $row['requisition_name'] . "</small></td>";
                                    echo "<td class='text-light py-3'><small>" . $row['date_created'] . "</small></td>";
                                    echo "<td class='text-light py-3'><small class='text-bg-". determine_color($row['status']) ." py-1 px-2 rounded-5'>" . $row['status'] . "</small></td>";
                                    echo "<td class='text-light py-3'><a href='" . $row['document'] . "' download class='text-decoration-none small_font text-bg-light p-1 rounded-2'>Download</a></td>";
                                    echo "</tr>";
                                }
                            }
                            // else {
//                                echo "<tr><td colspan='5' class='text-light text-center'>No requisitions found.</td></tr>";
//                            }
//
//                            // Close the database connection
                            $conn->close();
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <div class="modal" id="new_requisition_modal" tabindex="-1" role="dialog" aria-labelledby="new_requisition_modal_Label" aria-hidden="true" >
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content bg-111">
                                <div class="card col-11 bg-111 border-0 mx-auto mt-5 py-3 mb-3">
                                    <div class="card-header mb-0">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="fw-bold text-light mb-0 ">Add New Requisition</h5>
                                            <h2 class="mb-0"><i class="fa fa-times-circle text-light" data-bs-dismiss="modal"></i></h2>
                                        </div>
                                        <hr class="border-white">
                                    </div>
                                    <div class="card-body">
                                        <form action="#" method="POST" class="form text-light" id="requisition_form" data-parsley-validate>
                                            <p class="text-center fw-bold">Product details</p>
                                            <hr class="border-light">
                                            <div class="mx-auto row justify-content-between flex-wrap">

                                                <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 pb-3">
                                                    <label for="description" class="mb-2">Describe the product</label>
                                                    <textarea id="description" class="form-control py-3 border-0 rounded-2 text-light" rows="6" name="description" data-parsley-required="true"></textarea>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 pb-3">
                                                    <label for="reason" class="mb-2">Why is the product needed</label>
                                                    <textarea id="reason" class="form-control py-3 border-0 rounded-2 text-light" rows="6" name="reason" data-parsley-required="true"></textarea>
                                                </div>
                                                <div class="form-group col-xl-4 col-lg-4 col-12 mb-3 pb-3">
                                                    <label for="category" class="mb-2">Category</label>
                                                    <select id="category" class="form-control py-3 text-light border-0 bg-222" name="category" data-parsley-required="true">
                                                        <option value="Hardware">Hardware</option>
                                                        <option value="Electronics">Electronics</option>
                                                        <option value="Furniture">Furniture</option>
                                                        <option value="Stationery">Stationery</option>
                                                        <option value="Appliances">Appliances</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-xl-4 col-lg-4 col-12 mb-3 pb-3">
                                                    <label for="quantity" class="mb-2">Quantity</label>
                                                    <input id="quantity" type="number" class="form-control py-3 text-light border-0 bg-222" name="quantity" data-parsley-required="true">
                                                </div>
                                                <div class="form-group col-xl-4 col-lg-4 col-12 mb-3 pb-3">
                                                    <label for="amount" class="mb-2">Estimated Amount</label>
                                                    <input id="amount" type="number" class="form-control py-3 text-light border-0 bg-222" name="amount" data-parsley-required="true">
                                                </div>

                                                <div class="buttons text-end">
                                                    <button class="btn btn-secondary px-4 py-2" type="button" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn bg-purple text-light px-4 py-2" type="submit">Save</button>
                                                </div>
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

        <!-- Datatable js link -->
        <script src="../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
        <script src="../../src/js/DataTables/datatables.js"></script>

        <!-- Purify Js link -->
        <script src="../../src/js/purify/purify.js"></script>
        <!-- Parsely Js link -->
        <script src="../../src/js/parsely.js"></script>

        <!-- Sweet alert js link-->
        <script src="../../src/js/sweetalert2/sweetalert2.all.js"></script>
        <script src="../../src/js/sweetalert2/sweetalert2.js"></script>
        <!-- Custom js link -->
        <script src="../../src/js/user.js"></script>
        <script src="../../src/js/script.js"></script>
        <script>
            <!-- Initializing datatable js for inventory table -->
            let table = new DataTable('#requisition_table');
        </script>
    </body>
</html>