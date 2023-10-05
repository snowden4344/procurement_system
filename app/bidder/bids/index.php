<?php
    include '../../../db_connection.php';
    include '../../../includes/session_config.php';
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
    <!-- Custom css link -->
    <link rel="stylesheet" href="../../../src/css/style.css">

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
        <a href="../" class="d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-comment-dollar me-2"></i> RFQs</p></a>
        <a href="#" class="bg-222 d-block link-hover py-3 text-white text-decoration-none d-flex "><p class="col-1 d-xl-block d-lg-block d-md-block d-none mb-0"></p><p class="col-xl-11 col-lg-11 col-md-11 col-12 text-xl-start text-md-start text-lg-start text-center mb-0"><i class="fa fa-hand-holding-dollar me-2"></i> Bids</p></a>
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
            <h2 class="text-white fw-bold mb-4">Bidder Dashboard</h2>
            <div class="overflow-x-scroll">

                <div class="card me-2 card bg-111 text-light max-width">
                    <div class="card-header mb-0 row justify-content-between align-items-center">
                        <h6 class="col-7 mb-0">Current Bids</h6>
                    </div>
                    <div class="card-body">
                        <table class="d-table table table-striped table-borderless custom_table small_font" id="awards">
                            <thead>
                            <tr>
                                <th class="text-light">RFQ Number</th>
                                <th class="text-light">RFQ Title</th>
                                <th class="text-light">Date Applied</th>
                                <th class="text-light">Deadline</th>
                                <th class="text-light">Contract Award Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            // Get the user ID from the session
                            $user_id = $_SESSION['id'];

                            // SQL query to retrieve the data
                            $sql = "SELECT
                                            rfq.rfq_number,
                                            rfq.rfq_title,
                                            q.date_created,
                                            rfq.deadline,
                                            CASE
                                                WHEN ca.id IS NOT NULL THEN
                                                    CASE
                                                        WHEN ca.bidder_id = ? THEN 'Awarded to you'
                                                        ELSE 'Awarded to other bidder'
                                                    END
                                                ELSE 'Not yet processed'
                                            END AS contract_award_status
                                        FROM quotations q
                                        LEFT JOIN contract_awards ca ON q.rfq_number = ca.rfq_number
                                        JOIN request_for_quotations rfq ON q.rfq_number = rfq.rfq_number
                                        WHERE q.bidder_id = ?";

                            // Prepare and bind the parameters
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ii", $user_id, $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Check if there are results
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Output table rows
                                    echo "<tr>";
                                    echo "<td class='text-light py-3'>" . $row['rfq_number'] . "</td>";
                                    echo "<td class='text-light py-3'>" . $row['rfq_title'] . "</td>";
                                    echo "<td class='text-light py-3'>" . $row['date_created'] . "</td>";
                                    echo "<td class='text-light py-3'>" . $row['deadline'] . "</td>";
                                    echo "<td class='text-light py-3'>" . $row['contract_award_status'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                // Handle case when no data is found
//                                echo "<tr>
//                                        <td class='text-light py-3'></td>
//                                        <td class='text-light py-3'></td>
//                                        <td class='text-light py-3'></td>
//                                        <td class='text-light py-3'></td>
//                                        <td class='text-light py-3'></td>
//                                      </tr>";
                            }

                            // Close the database connection
                            $stmt->close();
                            $conn->close();
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal" id="quotation_modal" tabindex="-1" role="dialog" aria-labelledby="new_requisition_modal_Label" aria-hidden="true" >
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content bg-111">
                        <div class="card text-light bg-111 my-3 py-3">
                            <div class="card-header mb-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold">RFQ Application</h5>
                                    <h2><i class="fa fa-times-circle" data-bs-dismiss="modal"></i></h2>
                                </div>
                                <hr class="border-white">
                            </div>
                            <div class="card-body mt-0 pt-0">
                                <h6 class="fw-bold text-center">RFQ Details</h6>
                                <div class="d-flex flex-wrap justify-content-between small_font">
                                    <p class="col-xl-4 col-lg-4 col-md-6 col-12"><b>RFQ Title:</b> <span id="rfq_title">Office Furniture Procurement</span></p>
                                    <p class="col-xl-3 col-lg-3 col-md-6 col-12"><b>RFQ Number:</b> <span id="rfq_number">RFQ-102-1003</span></p>
                                    <p class="col-xl-2 col-lg-2 col-md-6 col-12"><b>Issued:</b> <span id="issue_date">23-06-23</span></p>
                                    <p class="col-xl-2 col-lg-2 col-md-6 col-12"><b>Due:</b> <span id="due_date">20-09-23</span></p>
                                </div>
                                <hr class="border-white">
                                <h6 class="fw-bold text-center">Contact Info</h6>
                                <div class="d-flex flex-wrap justify-content-between small_font">
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex"><b>Company Name:</b> <span id="company_name">Sonwabile Tactical Company</span></p>
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex"><b>Company Phone Number:</b> <span id="phone_number">+265 993 039 281</span></p>
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex flex-wrap"><b class="col-xl-4 col-lg-4 col-md-3 col-12">Company Address:</b> <span id="physical_address">Sonwabile Tactical Company, Private Bag 1082, Limbe</span></p>
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex"><b>Company Email:</b> <span id="email" class="ms-1">sonwatac@gmail.com</span></p>
                                </div>
                                <hr class="border-white">
                                <h6 class="fw-bold text-center">Product Details</h6>
                                <div class="d-flex flex-wrap small_font">
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex flex-wrap"><b class="col-xl-3 col-lg-3 col-md-3 col-12">Description:</b> <span id="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti, odit!</span></p>
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex flex-wrap"><b class="col-xl-3 col-lg-4 col-md-4 col-12">Specifications:</b> <span id="product_details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti, odit!</span></p>
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex"><b>Quantity:</b> <span id="quantity" class="ms-1">1</span></p>
                                    <p class="col-xl-6 col-lg-6 col-md-6 col-12 d-flex"><b>Category:</b> <span id="category" class="ms-1">Hardware</span></p>
                                </div>
                                <hr class="border-white">
                                <h6 class="fw-bold text-center">Quotations</h6>
                                <form action="../../../data_processors/bid_processor.php" class="small_font" method="POST">
                                    <div class="d-flex flex-wrap">
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="d-block">Price Per Item</label>
                                            <input type="text" name="price_per_item" class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-3 border-0 text-light">
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="d-block">Price Per Unit</label>
                                            <input type="text" name="price_per_unit" class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-3 border-0 text-light">
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="d-block">Expected Delivery Date</label>
                                            <input type="date" name="expected_delivery_date" class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-3 border-0 text-light">
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="d-block">Open To Negotiations</label>
                                            <input type="text" name="open_to_negotiations" class="col-xl-11 col-lg-11 col-md-11 col-12 d-block rounded-1 my-2 py-3 border-0 text-light">
                                            <input type="hidden" value="<?php echo '18s9aa92' ?>" name="o_check">
                                        </div>
                                    </div>
                                    <div class="buttons row align-items-center justify-content-between mx-auto my-3">
                                        <p class="col-xl-5 col-lg-6 col-12 pb-0"><input type="checkbox" class="form-check-input" id="agree"> I agree with the <b>terms and conditions</b></p>
                                        <button type="submit" class="btn btn-dark bg-purple text-light py-3 col-xl-3 col-lg-4 col-12" name="rfq_number" id="submit">Submit</button>
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
<script src="../../../src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="../../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Datatable js link -->
<script src="../../../src/js/DataTables/datatables.js"></script>
<!-- Bidders js -->
<script defer src="../../../src/js/bidder.js"></script>
<!-- Custom js link -->
<script src="../../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let rfq_table = new DataTable('#awards');
</script>
</body>
</html>