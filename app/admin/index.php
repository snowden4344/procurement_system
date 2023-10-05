
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

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
<!--        <link rel="stylesheet" href="src/css/login.css">-->

        <title>Administrator Dashboard</title>
    </head>
    <body class="bg-black">
        <!-- Sidebar: Visible on computer, collapses on tab and phone screen -->
        <div class="sidebar col-xl-2 col-lg-2 col-md-4 col-12 bg-111 h-100 top-0 bottom-0 position-fixed shadow_custom" id="sidebar">
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
                    <div class="actual_tools col-xl-4 col-lg-5 col-md-4 col-9 justify-content-between d-flex align-items-center">
                        <p class="text-white fw-bold"><i class="fa fa-user text-white"></i> Chimwemwe Banda</p>
                        <div class="other col-xl-2 col-lg-2 col-md-2 col-2 justify-content-between d-flex">
                            <p><i class="fa fa-bell text-white"></i></p>
                        </div>
                    </div>
                </div>
                <!-- Page's main purpose here -->
                <div class="inventory_management col-11 mx-auto my-3">
                    <h2 class="text-white fw-bold mb-4">Administrator Dashboard</h2>
                     <div class="card px-0 bg-black">
                        <div class="card-body px-0 text-light">
                            <div class="">
                                <div class="col-12">
                                    <div class="user_actions mb-3">

                                        <?php
                                       include '../../db_connection.php';

                                        // SQL query to count the number of users
                                        $sql = "SELECT COUNT(*) as user_count FROM users";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();
                                        $user_count = $row['user_count'];

                                        ?>

                                        <div class="col-12" >
                                            <div class="d-flex py-1 justify-content-between bg-111 rounded-1 px-2 align-items-center">
                                                <div class="">
                                                    <h1><?php echo $user_count; ?></h1>
                                                    <p>Internal System Users</p>
                                                </div>
                                                <h1><i class="fa fa-users mb-0"></i></h1> <!-- Changed "fa-user-group" to "fa-users" as "fa-user-group" is not a valid FontAwesome class -->
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                     </div>
                    <div class="card bg-111 p-3 text-light" id="inventory_card">
                        <div class="card-header d-flex align-items-center mb-3 px-0 justify-content-between">
                            <h4 class="text-light fw-bold">Users</h4>
                            <button class="btn btn-primary border-0 bg-purple text-light" data-bs-toggle="modal" data-bs-target="#add_user_modal">+ Add User</button>
                        </div>
                        <table class="table d-table rounded-2 overflow-hidden table-borderless table-striped" id="inventory_table">
                            <thead class="px-3">
                            <tr>
                                <th class="text-light py-3 px-3">User</th>
                                <th class="text-light py-3">Role</th>
                                <th class="text-light py-3">Department</th>
                                <th class="text-light py-3">Date Created</th>
                                <th class="text-light py-3">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // SQL query to retrieve data
                                    $sql = "SELECT id, Firstname, Lastname, Email, Department, Role, Date_created FROM users";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                <td class='d-flex py-3'>
                                                    <h2 class='text-light'><i class='fa fa-user-circle me-2'></i></h2>
                                                    <div class='small_font'>
                                                        <p class='mb-0 text-light fw-bold'>" . $row['Firstname'] . " " . $row['Lastname'] . "</p>
                                                        <small class='text-light text-opacity-50'>" . $row['Email'] . "</small>
                                                    </div>
                                                </td>
                                                <td class='text-light py-3'><small>" . $row['Role'] . "</small></td>
                                                <td class='text-light py-3'><small>" . $row['Department'] . "</small></td>
                                                <td class='text-light py-3'><small>" . $row['Date_created'] . "</small></td>
                                                <td class='text-light py-3 text-center px-3'><button class='btn btn-danger delete_user' type='button' data-id='". $row['id'] ."'>Delete</button></td>
                                            </tr>";
                                        }
                                    }
                                    // Close the database connection
                                    $conn->close();
                                ?>

                                </tbody>
                            </table>
                            
                    </div>
                </div>

                <!-- Add User Modal -->
                <div class="modal" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="add_user_modal_Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content bg-111">
                            <div class="card bg-111 text-light py-3">
                                <div class="card-header mb-0">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold">Add User</h5>
                                        <h2><i class="fa fa-times-circle" data-bs-dismiss="modal"></i></h2>
                                    </div>
                                    <hr class="border-white">
                                </div>
                                <div class="card-body">
                                    <form class="col-11 mx-auto" action="#" method="post" id="add_user_form" data-parsley-validate>
                                        <div class="row mb-3">
                                            <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 position-relative">
                                                <label class="my-3" for="firstname"> First Name</label>
                                                <input type="text" class="form-control text-light border-0 py-3" id="firstname" name="firstname" data-parsley-required="true" data-parsley-noSpaces="true">
                                                
                                            </div>

                                            <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 position-relative">
                                                <label class="my-3" for="lastname"> Last Name</label>
                                                <input type="text" class="form-control text-light border-0 py-3" id="lastname" name="lastname" data-parsley-required="true">
                                                
                                            </div>

                                            <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 position-relative">
                                                <label class="my-3" for="emailEdit">Email</label>
                                                <input type="email" class="form-control text-light border-0 py-3" id="email" name="email" data-parsley-required="true" data-parsley-type="email">
                                                
                                            </div>

                                            <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 position-relative">
                                                <label class="my-3" for="departmentEdit">Department</label>
                                                <select class="form-control text-light border-0 py-3" id="department" name="department" data-parsley-required="true">
                                                    <option value="IT">IT</option>
                                                    <option value="Human Resources">Human Resources</option>
                                                    <option value="Accounting">Accounting</option>
                                                    <option value="Procurement">Procurement</option>
                                                    <option value="Stores">Stores</option>
                                                </select>
                                                
                                            </div>

                                            <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 position-relative">
                                                <label class="my-3" for="phoneEdit">Phone Number</label>
                                                <input type="text" class="form-control text-light border-0 py-3" id="phone" name="phone" data-parsley-required="true" data-parsley-type="digits" data-parsley-length="[10,10]" data-parsley-error-message="Please enter a 10-digit phone number.">
                                                
                                            </div>

                                            <div class="form-group col-xl-6 col-lg-6 col-12 mb-3 position-relative">
                                                <label class="my-3" for="roleEdit">Role</label>
                                                <select class="form-control text-light border-0 py-3" id="role" name="role" data-parsley-required="true">
                                                    <option value="User">User</option>
                                                    <option value="Approver">Approver</option>
                                                    <option value="Stores">Stores</option>
                                                    <option value="Procurement">Procurement</option>
                                                    <option value="Administrator">Administrator</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group d-flex justify-content-end mt-2">
                                            <div class="col-6 d-flex justify-content-between">
                                                <button type="submit" class="btn bg-purple text-light px-3">Add</button>
                                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
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
    <!-- Bootstrap js link -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>

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
    <!-- Custom js link -->
    <script src="../../src/js/admin.js"></script>
    <script src="../../src/js/script.js"></script>
    <script>
        <!-- Initializing datatable js for inventory table -->
        let table = new DataTable('#inventory_table');
        // $(document).ready(function() {
        //     $('#add_user_form').parsley();
        // });
    </script>
    </body>
</html>