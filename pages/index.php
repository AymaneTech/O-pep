<?php
include("../models/signup.md.php");
include("../includes/header.php");
?>
<body>
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-4 mt-2">Sign up</p>

                                <form action="../models/signup.md.php" method="post" class="mx-1 mx-md-4">

                                    <div class="d-flex flex-row align-items-center mb-3 gap-1">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Your First Name</label>
                                            <input name="first_name" type="text" id="form3Example1c" class="form-control" />

                                        </div>
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <label class="form-label" for="form3Example1c">Your Last Name</label>
                                            <input name="last_name" type="text" id="form3Example1c" class="form-control" />

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example3c">Your Email</label>
                                            <input name="email" type="email" id="form3Example3c" class="form-control" />

                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example3c">Your adress</label>
                                            <input name="adress" type="text" id="form3Example3c" class="form-control" />

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4c">Password</label>
                                            <input name="pwd" type="password" id="form3Example4c" class="form-control" />

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4cd">Repeat your
                                                password</label>
                                            <input name="pwd2" type="password" id="form3Example4cd" class="form-control" />

                                        </div>
                                    </div>
                                    <p class="error"><?php echo isset($_GET['error_msg']) ? $_GET['error_msg'] : ""; ?></p>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <label class="form-check-label" for="form2Example3">
                                            Already have an account <a class="login-link" href="./login.php">Sign In</a>
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" name="register" class="button btn-lg">Register</button>
                                    </div>

                                </form>
                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                <img src="./assets/images/image3.jpg" class="img-fluid" alt="Sample image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

</html>