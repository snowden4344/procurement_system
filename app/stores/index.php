<?php
require_once('db_connection.php');
$query = "SELECT * FROM stores";
$result =mysqli_query($conn,$query); 
if (!$result) {
  die("Database query failed: " . mysqli_error($conn));
}
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

// Count expected items
$expectedQuery = "SELECT COUNT(*) AS expected_count FROM stores WHERE status = 'Expected'";
$expectedResult = mysqli_query($conn, $expectedQuery);
if (!$expectedResult) {
  die("Database query failed for expected items: " . mysqli_error($conn));
}
$expectedRow = mysqli_fetch_assoc($expectedResult);
$expectedCount = $expectedRow['expected_count'];

// Count received items
$receivedQuery = "SELECT COUNT(*) AS received_count FROM stores WHERE status = 'Received'";
$receivedResult = mysqli_query($conn, $receivedQuery);
if (!$receivedResult) {
  die("Database query failed for received items: " . mysqli_error($conn));
}
$receivedRow = mysqli_fetch_assoc($receivedResult);
$receivedCount = $receivedRow['received_count'];

// Query for expected items
$expectedQuery = "SELECT * FROM stores WHERE status = 'Expected'";
$expectedResult = mysqli_query($conn, $expectedQuery);
if (!$expectedResult) {
    die("Database query failed for expected items: " . mysqli_error($conn));
}
$expectedRows = [];
while ($row = mysqli_fetch_assoc($expectedResult)) {
    $expectedRows[] = $row;
}

// Query for delivered items
$deliveredQuery = "SELECT * FROM stores WHERE status = 'Received'";
$deliveredResult = mysqli_query($conn, $deliveredQuery);
if (!$deliveredResult) {
    die("Database query failed for delivered items: " . mysqli_error($conn));
}
$deliveredRows = [];
while ($row = mysqli_fetch_assoc($deliveredResult)) {
    $deliveredRows[] = $row;
}


// Close the database connection
mysqli_close($conn);
?>


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
        <!-- Custom css link -->
        <link rel="stylesheet" href="../../src/css/style.css">


        

        <title>Stores Management</title>
    </head>
    <body class="bg-black">
        <!-- Sidebar: Visible on computer, collapses on tab and phone screen -->
        <div class="sidebar col-xl-2 col-lg-2 col-md-4 col-12 bg-111 bottom-0 h-100 position-fixed top-0 shadow_custom" id="sidebar">
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
                    <div class="actual_tools col-xl-4 col-lg-5 col-md-4 col-9">
                        <p class="text-white text-end fw-bold"><i class="fa fa-user text-white"></i> Chimwemwe Banda</p>
                    </div>
                </div>
                <!-- Page's main purpose here -->
                <div class="inventory_management col-11 mx-auto my-3">
                    <h2 class="text-white fw-bold mb-4">Stores</h2>
                    <!-- Shows recently stocked item -->
                    <span class="bg-111 p-2 rounded-top-1 text-secondary fw-bold small_font">Items Summary</span>
                    <div class="card bg-111 mb-3 border-0">
                        <div class="card-body row justify-content-between">
                        <div class="p-2 bg-secondary rounded-1 my-1 col-xl-5 col-lg-5 col-md-5 col-12">
                            <p class="text-light fw-bold">Received Items</p>
                            <h2 class="text-white"><?php echo $receivedCount; ?></h2>
                        </div>
                        <div class="p-2 col-xl-5 bg-dark rounded-1 my-1 col-lg-5 col-md-5 col-12">
                            <p class="text-light fw-bold">Expected Items</p>
                            <h2 class="text-white"><?php echo $expectedCount; ?></h2>
                        </div>

                        </div>
                    </div>
                    <h5 class="text-light">Expected Items</h5>
                    <div class="card bg-111 text-light mb-3 inventory_card" id="inventory_card">
                        <div class="card-body">
                            <!-- Table for items in inventory, organized by bootstrap and datatable.js -->
                            <table class="table d-table rounded-2 custom_table mt-5 small overflow-hidden table-borderless table-striped" id="expected_table">
                                <thead class="px-3">
                                <tr>                                                                     
                                    <th class="text-light py-3">Product ID</th>
                                    <th class="text-light py-3">Supplier</th>
                                    <th class="text-light py-3">Quantity</th>
                                    <th class="text-light py-3">Category</th> 
                                    <th class="text-light py-3">Date Procured</th>                                                                        
                                    <th class="text-light py-3 px-3">Status</th>
                                    <th class="text-light py-3 px-3 text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                <?php foreach ($expectedRows as $row) { ?>
                    <tr>
                        <td class="text-light py-3"><?php echo $row['rfq_number']; ?></td>
                        <td class="text-light py-3"><?php echo $row['Supplier']; ?></td>
                        <td class="text-light py-3"><?php echo $row['quantity']; ?></td>
                        <td class="text-light py-3"><?php echo $row['category']; ?></td>
                        <td class="text-light py-3"><?php echo $row['date_received']; ?></td>
                        <td class="text-light py-3"><?php echo $row['status']; ?></td>
                        <td class="text-light py-3 text-center"><button class="btn btn-sm btn-secondary verify-button" data-store-id="<?php echo $row['store_id']; ?>">Verify</button></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table for Delivered Items -->
    <h5 class="text-light mt-2 pt-3">Delivered Items</h5>
    <div class="card bg-111 text-light inventory_card">
        <div class="card-body">
            <table class="table d-table custom_table rounded-2 mt-5 small overflow-hidden table-borderless table-striped" id="delivered_table">
                <thead class="px-3">
                <tr>
                    <th class="text-light py-3 px-3">Stores ID</th>
                    <th class="text-light py-3">Location</th>
                    <th class="text-light py-3">Supplier</th>
                    <th class="text-light py-3">Quantity</th>
                    <th class="text-light py-3">Category</th>
                    <th class="text-light py-3">Date Procured</th>
                    <th class="text-light py-3">Date Delivered</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($deliveredRows as $row) { ?>
                    <tr>
                        <td class="text-light py-3"><?php echo $row['store_id']; ?></td>
                        <td class="text-light py-3"><?php echo $row['location']; ?></td>
                        <td class="text-light py-3"><?php echo $row['Supplier']; ?></td>
                        <td class="text-light py-3"><?php echo $row['quantity']; ?></td>
                        <td class="text-light py-3"><?php echo $row['category']; ?></td>
                        <td class="text-light py-3"><?php echo $row['date_received']; ?></td>
                        <td class="text-light py-3"><?php echo $row['date_delivered']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>

                            </table>
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
        <!-- Custom js link -->
        <script src="../../src/js/stores.js"></script>
        <!-- Custom js link -->
        <script src="../../src/js/script.js"></script>
        <script>
            //<!-- Initializing datatable js for inventory table -->
           let table = new DataTable('#expected_table');
           let delivered_table = new DataTable('#delivered_table');
        </script>
    </body>
</html>