<?php
    include '../../../db_connection.php';
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

    <title>Bidder Dashboard</title>
</head>
<body class="bg-black">
<header class="col-12 mb-4 sticky-top mb-0">
    <nav class="d-xl-flex d-lg-flex d-md-flex d-block px-2 shadow py-2 justify-content-between align-items-center bg-111 mb-3 nav col-12">
        <div class="nav-log text-center col-xl-1 col-lg-1 col-md-2 mb-0">
            <h1 class="fa fa-box text-light"></h1>
            <p class="small_font mb-0 text-light"><small>Tamper Proof</small></p>
        </div>
        <ul class="col-xl-4 col-lg-4 col-md-6 list-unstyled mb-0 d-flex align-items-center justify-content-between text-light">
            <li><a href="#" class="text-decoration-none text-light">Requests For Quotations</a></li>
            <li><a href="#" class="btn bg-purple text-light rounded-5 py-2 px-4 text-decoration-none">Register</a></li>
        </ul>
    </nav>
</header>
<div class="card col-11 bg-111 reg_form border-0 mx-auto mt-5 py-3 my-3" id="login">
    <div class="card-body">
        <form action="#" method="POST" class="text-light py-3" id="registration_form" data-parsley-validate>
            <h4 class="text-center">Procurement System Supplier Registration</h4>
            <hr class="col-5 mx-auto border-white border-3 mb-0">
            <div class="col-xl-11 col-lg-11 col-md-10 col-sm-11 col-12 mx-auto pt-5">
                <p class="text-center text-light fw-bold">Contact Person Details</p>
                <div class="row">
                    <div class="form-group col-xl-4 col-lg-4 col-12 mb-3">
                        <label class="mb-3">Full Name</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="fname" name="full_name" data-parsley-required="true" data-parsley-length="[5, 50]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-4 col-lg-4 col-12 mb-3">
                        <label class="mb-3">Phone Number</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="pnumber" name="phone_number" data-parsley-required="true" data-parsley-length="[10, 16]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-4 col-lg-4 col-12 mb-3">
                        <label class="mb-3">Email</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="pemail" name="email" data-parsley-required="true" data-parsley-length="[5, 50]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                </div>
                <p class="text-center text-light fw-bold">Payment Details</p>
                <div class="row">
                    <div class="form-group col-xl-3 col-lg-3 col-12 mb-3">
                        <label class="mb-3">Bank Name</label>
                        <select class="form-control py-3 border-0 text-light" id="bankname" name="bank_name" data-parsley-required="true">
                            <option value="Reserve Bank of Malawi">Reserve Bank of Malawi</option>
                            <option value="National Bank of Malawi">National Bank of Malawi</option>
                            <option value="Standard Bank Malawi">Standard Bank Malawi</option>
                            <option value="First Capital Bank Malawi">First Capital Bank Malawi</option>
                            <option value="FDH Bank">FDH Bank</option>
                            <option value="Nedbank Malawi">Nedbank Malawi</option>
                            <option value="MyBucks Banking Corporation">MyBucks Banking Corporation</option>
                            <option value="CDH Investment Bank">CDH Investment Bank</option>
                            <option value="NBS Bank">NBS Bank</option>
                            <option value="Opportunity International Bank of Malawi (OIBM)">Opportunity International Bank of Malawi (OIBM)</option>
                            <option value="Ecobank Malawi">Ecobank Malawi</option>
                            <option value="New Finance Bank">New Finance Bank</option>
                            <option value="United General Insurance (UGI) Bank">United General Insurance (UGI) Bank</option>
                            <option value="Agricultural Development and Marketing Corporation (ADMARC) Bank">Agricultural Development and Marketing Corporation (ADMARC) Bank</option>
                            <!-- Add more banks as needed -->
                        </select>
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-3 col-lg-3 col-12 mb-3">
                        <label class="mb-3">Account Name</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="accountname" name="account_name" data-parsley-required="true">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-3 col-lg-3 col-12 mb-3">
                        <label class="mb-3">Account Number</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="accountnumber" name="account_number" data-parsley-required="true">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-3 col-lg-3 col-12 mb-3">
                        <label class="mb-3">Account Type</label>
                        <select class="form-control py-3 border-0 text-light" id="accounttype" name="account_type" data-parsley-required="true">
                            <option value="current">Current</option>
                            <option value="savings">Savings</option>
                            <!-- Add more account type options as needed -->
                        </select>
                        <div class="error-container position-relative py-2"></div>
                    </div>
                </div>
                <p class="text-center text-light fw-bold">Business Details</p>
                <div class="row">
                    <div class="form-group col-xl-4 col-lg-4 col-12 mb-3">
                        <label class="mb-3">Business Name</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="bname" name="business_name" data-parsley-required="true" data-parsley-length="[3, 50]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-4 col-lg-4 col-12 mb-3">
                        <label class="mb-3">Business Phone Number</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="bnumber" name="business_phone_number" data-parsley-required="true" data-parsley-length="[10, 16]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-4 col-lg-4 col-12 mb-3">
                        <label class="mb-3">Business Email</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="bemail" name="business_email" data-parsley-required="true" data-parsley-length="[5, 50]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                        <label class="mb-3">Tax ID</label>
                        <input type="text" class="form-control py-3 border-0 text-light" id="taid" name="tax_id" data-parsley-required="true" data-parsley-length="[5, 15]">
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                        <label class="mb-3">Year Established</label>
                        <select class="form-control py-3 border-0 text-light" id="yoe" name="year_established" data-parsley-required="true">
                            <option value="">Select Year</option>
                            <?php
                            // Generate options for years from 1964 to the current year (2023)
                            $currentYear = date("Y");
                            for ($year = 1964; $year <= $currentYear; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                        <div class="error-container position-relative py-2"></div>
                    </div>

                    <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                        <label class="mb-3">Industry Type</label>
                        <select class="form-control py-3 border-0 text-light" id="itype" name="industry_type" data-parsley-required="true">
                            <option value="">Select Industry Type</option>
                            <option value="Technology">Technology</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="Finance">Finance</option>
                            <option value="Retail">Retail</option>
                            <!-- Add more industry types as needed -->
                        </select>
                        <div class="error-container position-relative py-2"></div>
                    </div>

                    <div class="form-group col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                        <label class="mb-3">Business Type</label>
                        <select class="form-control py-3 border-0 text-light" id="btype" name="business_type" data-parsley-required="true">
                            <option value="">Select Business Type</option>
                            <option value="Small Business">Small Business</option>
                            <option value="Corporation">Corporation</option>
                            <option value="Startup">Startup</option>
                            <option value="Sole Proprietorship">Sole Proprietorship</option>
                            <option value="Partnership">Partnership</option>
                            <!-- Add more business types as needed -->
                        </select>
                        <div class="error-container position-relative py-2"></div>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-xl-7 col-lg-7 col-12 mb-3">
                        <label class="mb-3">Business Description</label>
                        <textarea id="bdis" class="form-control py-3 border-0 text-light" rows="5" name="business_description" data-parsley-required="true"></textarea>
                        <div class="error-container position-relative py-2"></div>
                    </div>
                    <div class="form-group col-xl-5 col-lg-5 col-12">
                        <label class="mb-3">Business Address</label>
                        <textarea id="badd" class="form-control py-3 border-0 text-light" rows="5" name="business_address" data-parsley-required="true"></textarea>
                        <div class="error-container position-relative py-2"></div>
                    </div>
                </div>
                <div class="buttons row align-items-center justify-content-between mx-auto mb-3">
                    <div class="form-group col-xl-5 col-lg-6 col-12 pb-0">
                        <p class="mb-0"><input type="checkbox" required class="form-check-input" id="agree" data-parsley-required="true"> I agree with the <b>terms and conditions</b></p>
                    </div>
                    <button type="submit" class="btn btn-dark bg-purple text-light py-3 col-xl-3 col-lg-4 col-12" id="submit">Register</button>
                </div>
            </div>

        </form>
    </div>
</div>
<!-- Bootstrap js link -->
<script src="../../../src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="../../../src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Datatable js link -->
<script src="../../../src/js/DataTables/datatables.js"></script>
<!-- Purify Js link -->
<script src="../../../src/js/purify/purify.js"></script>
<!-- Parsely Js link -->
<script src="../../../src/js/parsely.js"></script>
<!-- Sweet alert js link-->
<script src="../../../src/js/sweetalert2/sweetalert2.all.js"></script>
<script src="../../../src/js/sweetalert2/sweetalert2.js"></script>
<!-- Bidders js -->
<script defer src="../../../src/js/registration.js"></script>
<!-- Custom js link -->
<script src="../../../src/js/script.js"></script>
<script>
    <!-- Initializing datatable js for inventory table -->
    let rfq_table = new DataTable('#rfq_table');
</script>
</body>
</html>