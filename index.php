
<?php
//include "include/loginrestrict.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap css link -->
    <link rel="stylesheet" href="src/css/bootstrap-5.3.1-dist/css/bootstrap.css">
    <!-- fontawesome css links -->
    <link rel="stylesheet" href="src/css/fontawesome-free-6.4.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="src/css/fontawesome-free-6.4.2-web/css/all.css">
    <!-- Datatable.JS css link -->
    <link rel="stylesheet" href="src/js/DataTables/datatables.css">
    <!-- Font importation link -->
    <link rel="stylesheet" href="src/css/fonts.css">
    <!-- Sweet alert css link -->
    <link rel="stylesheet" href="src/css/sweetalert2/sweetalert2.css">
    <!-- Custom css link -->
    <link rel="stylesheet" href="src/css/style.css">
<!--    <link rel="stylesheet" href="src/css/login.css">-->

    <title>Log In</title>
</head>
<body class="bg-black">
<div class="card col-xl-5 col-lg-6 col-md-8 col-11 bg-111 border-0 mx-auto mt-5 py-3 mb-3" id="login">
    <div class="card-body">
        <form action="#" method="POST" class="text-light py-3" id="loginForm" data-parsley-validate>
            <h4 class="text-center">Procurement System Login</h4>
            <hr class="col-3 mx-auto border-white border-3 mb-0">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-11 col-12 mx-auto mt-5 pt-5">
                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php } ?>
                <div class="form-group mb-3 pb-2">
                    <label class="mb-3">Username</label>
                    <input type="text" class="form-control py-3 border-0 text-light" id="uname" name="username" required data-parsley-required="true" data-parsley-length="[8, 16]" data-parsley-error-message="Invalid username length">
                </div>
                <div class="form-group">
                    <label class="mb-3">Password</label>
                    <div class="input-group d-flex align-items-stretch">
                        <input type="password" class="form-control py-3 col-10 rounded-0 rounded-start-1 border-0 text-light" id="pswd" name="password" data-parsley-required="true" data-parsley-length="[8, 16]" data-parsley-error-message="Invalid password length">
                        <div class="input-group-append col-2">
                            <button type="button" class="btn btn-dark bg-333 col-12 rounded-0 rounded-end-1 toggle-password py-3" id="togglePassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="buttons col-xl-10 col-lg-10 col-md-10 col-sm-11 col-12 mx-auto mb-3">
                <button type="submit" class="btn btn-dark bg-purple text-light py-3 col-12 mt-5" id="sbmt">Login</button>
            </div>
            <p class="text-end col-xl-10 col-lg-10 col-md-10 col-sm-11 col-12 mx-auto"><a href="#" class="text-light text-decoration-none">Forgot Password?</a></p>
        </form>
    </div>
</div>

<!-- Bootstrap js link -->
<script src="src/css/bootstrap-5.3.1-dist/js/bootstrap.js"></script>
<!-- Jquery js link-->
<script src="src/js/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>
<!-- Purify Js link -->
<script src="src/js/purify/purify.js"></script>
<!-- Parsely Js link -->
<script src="src/js/parsely.js"></script>
<!-- Sweet alert js link-->
<script src="src/js/sweetalert2/sweetalert2.all.js"></script>
<script src="src/js/sweetalert2/sweetalert2.js"></script>
<!-- Custom js link -->
<script src="src/js/script.js"></script>
<script src="src/js/login.js"></script>
<script>
    // Initiate and Configure Parsley to use custom error container
    // $('#login_form').parsley({
    //     errorsContainer: function (el) {
    //         // Find the closest error-container div in the parent
    //         return el.$element.parent().find('.error-container');
    //     }
    // });
</script>
</body>
</html>

<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <link rel="stylesheet" href="src/css/bootstrap-5.3.1-dist/css/bootstrap.css">-->
<!--    <link rel="stylesheet" href="src/css/fontawesome-free-6.4.2-web/css/fontawesome.css">-->
<!--    <link rel="stylesheet" href="src/css/fontawesome-free-6.4.2-web/css/all.css">-->
<!--    <link rel="stylesheet" href="src/css/fonts.css">-->
<!--    <link rel="stylesheet" href="src/css/style.css">-->
<!--    <title>Login Form</title>-->
<!--</head>-->
<!--<body>-->
<!--<div class="container-fluid">-->
<!--    <form action = "include/formhandler.php" class="mx-auto" method="POST">-->
<!--        <h6 class="text-center">procurement system Login</h6>-->
<!--        -->
<!--        <div class="mb-3 mt-5">-->
<!--            <label for="exampleInputEmail1" class="form-label">Username</label>-->
<!--            <input type="text" class="form-control" id="username" name="username" required>-->
<!--        </div>-->
<!--        <div class="mb-3">-->
<!--            <label for="exampleInputPassword1" class="form-label">Password</label>-->
<!--            <input type="password" class="form-control" id="password" name="password" required>-->
<!--            <div id="emailHelp" class="form-text mt-3">Forget password ?</div>-->
<!--        </div>-->
<!---->
<!--        <button type="submit" class="btn btn-primary mt-5">Login</button>-->
<!--    </form>-->
<!--</div>-->
<!---->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"-->
<!--        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"-->
<!--        crossorigin="anonymous"></script>-->
<!--</body>-->
<!--</html>-->
