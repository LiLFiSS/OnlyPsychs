<?php

session_start();

$UserID = $_SESSION['user_UID'];

if (!isset($_SESSION['user_UID'])){
    header("Location: login.php");
}

$email = $_SESSION['user_Email'];
$firstName = $_SESSION['user_FirstName'];
$lastName = $_SESSION['user_LastName'];

$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

$sql_pfp = "SELECT * FROM users WHERE UserID = '$UserID'";
$result2 = mysqli_query($conn, $sql_pfp);

while ($row = mysqli_fetch_array($result2)){
    $PFP = $row['profile_picture'];
}

$PP = $PFP;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OnlyPsychs - Get Started</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/assets/img/favicon.png" rel="icon">
    <link href="assets/img/Final2.ico" rel="shortcut icon" type="image/x-icon">
    <link href="assets/assets/img/apple-touch-icon.png" rel="apple-touch-icon">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Template Main CSS File -->
    <link href="assets/assets/css/style.css" rel="stylesheet">



</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <!--<h1 class="text-light"><a href="index.html">Serenity</a></h1>-->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="user-home.php"><img src="assets/img/OnlyPsychs-logo-green.png" alt="" class="img-fluid"><span class="logo-wrds" style="margin-left: 5px;"><img src="assets/img/OnlyPsychs-black-green-wrds.png" height="45"></span></a>
            <!--<img alt="" height="45" src="assets/img/OnlyPsycs-logo.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="active" href="user-home.php">Home</a></li>
                <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="user-about.php">About</a></li>
                        <li><a href="user-view-therapists.php">Our Therapists</a></li>
                        <!--<li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                            <ul>
                                <li><a href="#">Deep Drop Down 1</a></li>
                                <li><a href="#">Deep Drop Down 2</a></li>
                                <li><a href="#">Deep Drop Down 3</a></li>
                                <li><a href="#">Deep Drop Down 4</a></li>
                                <li><a href="#">Deep Drop Down 5</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </li>
                <li><a href="user-services.php">Services</a></li>
                <li><a href="user-faq.php">FAQ</a></li>
                <li><a href="user-contact.php">Contact</a></li>



                <li class="dropdown profile-view-2">
                    <a href="#">
                        <img alt="pfp" class="rounded-circle" height="35" src="assets/uploaded_img/<?php echo $PP; ?>">
                        <span><?php echo $firstName ?></span> <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul>
                        <li><a href="user-profile.php">My Profile</a></li>
                        <?php
                        $notification_query = " SELECT * FROM notifications WHERE receiverID = '$UserID' AND status = 'active' ";
                        $select_notifications = mysqli_query($conn, $notification_query) or die('query failed');
                        $notifications_count = mysqli_num_rows($select_notifications);
                        ?>
                        <li><a href="">Notifications <span style="background-color: red; color: #fff; padding: 1px 6px; border-radius: 8px"><?php echo $notifications_count ?></span> </a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->



<main id="main">
    <div class="container pb-5">
        <div class="form-header text-center pt-3">
            <h1>Help us find the <span style="color: #94c045; ">best therapist</span> for you</h1>
        </div>
        <div class="desc">
            <p class="text-center" style="/*background-color: lightskyblue;*/ padding: 0 200px">
                To assist us in finding the most appropriate therapist for your needs,
                we kindly request your cooperation in answering the following prompts.
                This questionnaire will provide us with essential background information and
                insights into the specific issues you wish to address in therapy.
            </p>
        </div>

        <div class="f">
            <!-- ======================= Question 1 ======================= -->
            <form method="post" class="" style="padding: 0 14rem">
                <div class="question-1" id="question-1" style="padding: 2rem 5rem; box-shadow: 5px 5px 12px -1px rgba(0,0,0,0.75); border-radius: 3px; background-color: #f2f2f2;">
                    <h4 class="text-center mt-2">Are you familiar with the specific type of therapy you're seeking?</h4>
                    <div class="d-flex flex-column btn-grp" style="padding: 10px 3rem">
                        <a type="button" class="btn mt-1 yes-btn" onclick="showQuestion2()">Yes</a>
                        <a type="button" class="btn mt-2 no-btn" onclick="showQuestion3()">No</a>
                        <div>
                            <p class="mt-sm-4" style="border: 1px solid #94c045; padding: 5px; border-radius: 6px">
                                <i class="bi bi-info-circle" style="color: #94c045"></i>
                                Thank you in advance for taking the time to complete
                                this questionnaire and contributing to your therapeutic journey.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ======================= Question 1 ALT 1 ======================= -->

                <div class="question-2" id="question-2" style="padding: 2rem 5rem; box-shadow: 5px 5px 12px -1px rgba(0,0,0,0.75); border-radius: 3px; background-color: #f2f2f2;">
                    <h4 class="text-center mt-2">Which specific areas would you like to address in therapy?</h4>
                    <div class="d-flex flex-column btn-grp" style="padding: 10px 3rem">
                        <a href="show-depression-therapists.php" class="btn mt-1 dep-btn" >Depression</a>
                        <a href="show-anxiety-therapists.php" class="btn mt-2 anx-btn" >Anxiety</a>
                        <a href="show-adhd-therapists.php" class="btn mt-2 adhd-btn" >ADHD</a>
                        <a href="show-ptsd-therapists.php" class="btn mt-2 ptsd-btn" >PTSD</a>
                        <div>
                            <p class="mt-sm-4" style="border: 1px solid #94c045; padding: 5px; border-radius: 6px">
                                <i class="bi bi-info-circle" style="color: #94c045"></i>
                                Thank you in advance for taking the time to complete
                                this questionnaire and contributing to your therapeutic journey.
                            </p>
                        </div>
                        <div class="bk-btn" id="bk-btn1">
                            <button type="button" onclick="showQuestion1()" class="btn" style="background-color: #94c045; color: #fff; margin-left: 85%; margin-top: 10px" value="">Back</button>
                        </div>
                    </div>
                </div>

                <!-- ======================= Question 1 ALT 2 ======================= -->

                <div class="question-3" id="question-3" style="padding: 2rem 5rem; box-shadow: 5px 5px 12px -1px rgba(0,0,0,0.75); border-radius: 3px; background-color: #f2f2f2;">
                    <h4 class="text-center mt-2">Which mental health disorder do you suspect you may be experiencing? Please select one of the following</h4>
                    <div class="d-flex flex-column btn-grp" style="padding: 10px 3rem">
                        <a href="depression-questionnaire.php" class="btn mt-1 dep-btn" >Depression</a>
                        <a href="anxiety-questionnaire.php" class="btn mt-2 anx-btn" >Anxiety</a>
                        <a href="adhd-questionnaire.php" class="btn mt-2 adhd-btn" >ADHD</a>
                        <a href="ptsd-questionnaire.php" class="btn mt-2 ptsd-btn">PTSD</a>
                        <a href="general-consultation.php" class="btn mt-2 other-btn">Not Sure...</a>
                        <div>
                            <p class="mt-sm-4" style="border: 1px solid #94c045; padding: 5px; border-radius: 6px">
                                <i class="bi bi-info-circle" style="color: #94c045"></i>
                                Thank you in advance for taking the time to complete
                                this questionnaire and contributing to your therapeutic journey.
                            </p>
                        </div>
                        <div class="bk-btn" id="bk-btn2">
                            <button type="button" onclick="showQuestion1()" class="btn" style="background-color: #94c045; color: #fff; margin-left: 85%; margin-top: 10px" value="">Back</button>
                        </div>
                    </div>
                </div>


                <script>
                    let q1 = document.getElementById("question-1");
                    let q2 = document.getElementById("question-2");
                    let q3 = document.getElementById("question-3");

                    function showQuestion1() {
                        q1.style.display = "revert";
                        q2.style.display = "none";
                        q3.style.display = "none";
                    }

                    function showQuestion2() {
                        q2.style.display = "revert";
                        q1.style.display = "none";
                    }

                    function showQuestion3() {
                        q3.style.display = "revert";
                        q1.style.display = "none";
                    }
                </script>

            </form>
        </div>
    </div>


    <!-- ============ Testimonials ============ -->
    <!-- ============ End Testimonials ============ -->
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-info">
                    <a href="landing-page.php"><img src="assets/img/OnlyPsychs-white-green-wrds.png" height="60"></a>
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


<!--<div id="preloader"></div>-->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script>
    (function ($) {
        "use strict";

        $(window).on('load', function() {
            var pre_loader = $('#preloader');
            pre_loader.fadeOut('slow', function(){
                $(this).remove();
            });
        });
    });
</script>

<!-- Vendor JS Files -->
<script src="assets/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/assets/vendor/aos/aos.js"></script>
<script src="assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/assets/js/main.js"></script>

</body>

</html>
