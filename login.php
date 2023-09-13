<?php
if (isset($_POST["submit"])){
    $conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
    mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

    $email = $_POST['login-email'];
    $pass = $_POST['login-password'];

    $select = " SELECT * FROM users WHERE email = '$email' AND user_password = '$pass'";
    $result = mysqli_query($conn, $select) or die('query failed');

    if (mysqli_num_rows($result) != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $dbEmail = $row['email'];
            $dbPassword = $row['user_password'];
            $db_UserType = $row['user_type'];
            $db_UserStatus = $row['status'];
            $db_FirstName = $row['first_name'];
            $db_LastName = $row['last_name'];
            $db_UserID = $row['UserID'];
        }

        if ($email == $dbEmail && $pass == $dbPassword && $db_UserType == "admin" && $db_UserStatus == "active"){
            session_start();
            $_SESSION['admin_Email'] = $email;
            /*$nameC = $db_FirstName. " " . $db_LastName;*/
            $_SESSION['adminName'] = $db_FirstName;
            $_SESSION['adminLastName'] = $db_LastName;
            $_SESSION['admin_UID'] = $db_UserID;
            header("Location: admin-home.php");


        } elseif ($email == $dbEmail && $pass == $dbPassword && $db_UserType == "therapist" && $db_UserStatus == "active"){
            session_start();
            $_SESSION['therapist_FirstName'] = $db_FirstName;
            $_SESSION['therapist_LastName'] = $db_LastName;
            $_SESSION['therapist_Email'] = $dbEmail;
            $_SESSION['therapist_UID'] = $db_UserID;

            $TID = $_SESSION['therapist_UID'];

            $sql = " SELECT * FROM therapist WHERE UserID = '$TID' ";
            $query = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($query)){
                $dob = $rows['license_1'];
            }
            $DOB = $dob;
            if ($DOB == null || $DOB == ''){
                header('Location: create-profile-landing-page.php');
                mysqli_close($conn);
            } else{
                header('Location: therapist-home.php');
                mysqli_close($conn);
            }
        } elseif ($email == $dbEmail && $pass == $dbPassword && $db_UserType == "user" && $db_UserStatus == "active"){
            session_start();
            $_SESSION['user_FirstName'] = $db_FirstName;
            $_SESSION['user_Email'] = $dbEmail;
            $_SESSION['user_UID'] = $db_UserID;
            $_SESSION['user_LastName'] = $db_LastName;
            $UID = $_SESSION['user_UID'];

            $sql2 = " SELECT * FROM users WHERE UserID = '$UID' ";
            $query2 = mysqli_query($conn, $sql2);
            while ($rows2 = mysqli_fetch_array($query2)){
                $dob2 = $rows2['dob'];
            }

            $DOB2 = $dob2;
            if ($DOB2 == null || $DOB2 == ''){
                header('Location: user-landing-page.php');
                mysqli_close($conn);
            } else{
                header('Location: user-home.php');
                mysqli_close($conn);
            }
        } elseif ($email == $dbEmail && $pass == $dbPassword && $db_UserStatus == "inactive"){
            echo "<div class='alert alert-danger mov flex-column align-content-center' style='margin-bottom: -50px;' role='alert'>Your Account is Inactive! - Contact Us for Reactivation</div>";
        }

    } else{
        echo "<div class='alert alert-danger mov flex-column align-content-center' style='margin-bottom: -50px;' role='alert'>Incorrect Email or Password!</div>";
    }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <!-- Vendor CSS Files -->
    <link href="assets/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Template Main CSS File -->
    <link href="assets/assets/css/style.css" rel="stylesheet">

    <title>OnlyPsychs Login</title>

    <style>
        #footer .footer-top h4::after {
            background: #1844F2;
        }

        #footer .footer-top .footer-newsletter input[type="submit"] {
            background: #1844F2;

        }

        #footer .footer-top .social-links a {
            background: #3c4133;
        }

        #footer .footer-top .social-links a {
            background: #1a1a1a;
        }
    </style>

</head>
<body>
<!--Navbar Start-->
<nav>
    <div class="header">
        <div class="header-left">
            <a class="logo" href="#">
                <img alt="" height="45" src="assets/img/OnlyPsychs-logo-img-dark-blue.png" width="45"> <span><img src="assets/img/OnlyPsychs-logo-dark-blue.png" height="30"></span>
            </a>
        </div>
        <!--<ul>
            <li><a class="abt-btn" href="#">About</a></li>
            <li><a class="faq-btn" href="#">FAQ</a></li>
            <li><a class="get-started-btn" href="#">Get Started</a></li>
            <li><a class="login-btn" href="login.html">Login</a></li>
        </ul>-->
    </div>
</nav>
<!--Navbar End-->

<div class="bg-img"></div>

<!--Login Box - Main - Start-->
<div class="container d-flex" style="justify-content: center;">
    <div class="main_div">
        <div class="title">Login</div>
        <form action="" method="post" autocomplete="off">
            <div class="input_box">
                <input type="email" name="login-email" placeholder = "Email" required>
                <div class="icon"><i class="fas fa-user"></i></div>
            </div>
            <div class="input_box">
                <input type="password" name="login-password" placeholder="Password" required>
                <div class="icon"><i class="fas fa-lock"></i></div>
            </div>
            <div class="option_div">
                <div class="check_box">
                    <input type="checkbox">
                    <span>Remember me</span>
                </div>
                <div class="forget_div">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
            <div class="input_box button">
                <input type="submit" name="submit" value="Login">
            </div>
            <div class="sign_up">
                Not a member? <a href="register.php">Signup now</a>
            </div>
        </form>
    </div>
</div>


<!--Login box - Main - End-->

<!-- ======= Footer ======= -->
<footer id="footer" style="background-color: #1a1a1a">
    <div class="footer-top" style="background-color: #020618;">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-info">
                    <a href="landing-page.php"><img src="assets/img/OnlyPsychs_logo_blue_white_words.png" height="60"></a>
                    <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus. Scelerisque felis imperdiet proin fermentum leo. Amet volutpat consequat mauris nunc congue.</p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>Contact Us</h4>
                    <p>
                        A108 Adam Street <br>
                        Somewhere, SF 535022<br>
                        Trinidad <br>
                        <strong>Phone:</strong> +1 868 9594 555<br>
                        <strong>Email:</strong> onlypsychs@gmail.com<br>
                    </p>

                    <div class="social-links">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>

                </div>

                <div class="col-lg-3 col-md-6 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna veniam enim veniam illum dolore legam minim quorum culpa amet magna export quem marada parida nodela caramase seza.</p>
                    <form action="" method="post">
                        <input type="email" name="email"><input type="submit" value="Subscribe">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>OnlyPsychs</span></strong>. All Rights Reserved
        </div>
        <div class="credits">

            Designed by <a href="https://twitter.com/elonmusk">Kaizha Brathwaite - 84109</a>
        </div>
    </div>
</footer><!-- End Footer -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
