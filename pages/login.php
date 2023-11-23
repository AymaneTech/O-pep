<?php include('../includes/header.php') ?>

<body>
    <section class="vh-100 d-flex align-items-center">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <!-- <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="../assets/images/bg-2.jpg" class="img-fluid" alt="Sample image">
                </div> -->
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 text-white">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-center">
                        <p class="lead fw-normal mb-0 me-3 py-3">Sign in with</p>
                    </div>
                    <form action="../models/login.md.php" method="post">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Email address</label>
                            <input name="email" type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Password</label>
                            <input name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                        </div>
                        <?php
                        session_start();
                        if (isset($_GET["incorrectPwd"])) {
                        ?>
                            <p class="d-flex justify-content-center text-danger"><?= $_GET["incorrectPwd"]; ?></p>
                        <?php
                        }
                        ?>
                        <div class="text-center text-lg-center mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg" name="login-btn" style="padding-left: 2.5rem; padding-right: 2.5rem;" name="login">Login</button>
                    </form>
                    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="./signup.php" class="link-danger">Register</a></p>
                </div>
            </div>
        </div>

    </section>
</body>

</html>