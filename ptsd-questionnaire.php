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

if (isset($_POST['submit'])){
    date_default_timezone_set('America/Port_of_Spain');

    $question_1 = $_POST['question-1'];
    $question_2 = $_POST['question-2'];
    $question_3 = $_POST['question-3'];

    $type = "PTSD";
    $completion_date = date("Y/m/d h:i:sa");

    $sql = " INSERT INTO questionnaire (Questionnaire_Type, UserID, Question_1, Question_2, Question_3, Completion_Date) 
                VALUES ('$type', '$UserID', '$question_1', '$question_2', '$question_3', '$completion_date') ";
    $query = mysqli_query($conn, $sql);
    echo "<div class='alert alert-success mov-2' role='alert'> Submitted! Redirecting Please Wait... </div>";
    if ($question_1 == 'Yes' && $question_2 == 'Yes' && $question_3 == 'Yes'){
        header( "refresh:4;url=ptsd-therapists.php");

    } else {
        header( "refresh:4;url=general-consultation.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OnlyPsychs - Get Started - PTSD Questions</title>
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
    <link href="assets/css/style.css" rel="stylesheet">

    <style>

        .btn-success{
            --bs-btn-active-bg: #198754;
            --bs-btn-active-border-color:#198754
            --bs-btn-border-color:#94c045;
        }

        .btn-success{
            background-color: #94c045;
            border-color: #94c045;
            color: #fff;
        }

        .thanks{
            background-color: #646c55;
            color: #fff;
            border: 1px solid #646c55;
            padding: 5px;
            border-radius: 6px
        }



    </style>



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
    <div class="container-fluid smaller mov2">
        <div class="form-header text-center mt-5">
            <h1>Help us find the <span style="color: #94c045; ">best therapist</span> for you</h1>
        </div>
        <div class="desc mb-5">
            <p class="text-justify text-center">
                We will now ask you a series of screening questions from the PCL-5,
                which is a recognized assessment tool for PTSD (Post-Traumatic Stress Disorder) based on the DSM-5 criteria.
                These questions are designed to evaluate the presence and severity of symptoms associated with PTSD.
                Please answer each question with a simple 'yes' or 'no' based on your experiences in the past month.
            </p>
        </div>

        <div class="row">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <form method="post" class="" onsubmit=" return submitValidation()">

                    <!-- ======================= Question 1 ======================= -->

                    <div class="question-1-depression" id="question-1-d" style="padding: 3rem 4rem; box-shadow: 5px 5px 12px -1px rgba(0,0,0,0.75); border-radius: 3px; background-color: #f2f2f2;">
                        <h4 class="text-center mt-2">Have you had any repeated, disturbing, and unwanted memories of a stressful experience?</h4>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="question-1" value="Yes" id="btnradio1" autocomplete="off">
                                <label class="btn btn-success btn-yes col-12 weePrime"  for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check" name="question-1" value="No" id="btnradio2" autocomplete="off">
                                <label class="btn btn-success btn-no col-12 weeDouble" for="btnradio2">No</label>
                            </div>
                            <div>
                                <p class="mt-4 px-2 py-2 thanks">
                                    <i class="bi bi-info-circle" style="color: #fff"></i>
                                    Thank you in advance for taking the time to complete this <br>
                                    questionnaire and contributing to your therapeutic journey.
                                </p>
                            </div>
                            <div style="display: flex; width: 100%; justify-content: flex-end">
                                <button type="button" onclick="showQuestion2()" class="btn btn-success" style="">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- ======================= Question 2 ======================= -->


                    <div class="question-2-depression" id="question-2-d" style="padding: 3rem 4rem; box-shadow: 5px 5px 12px -1px rgba(0,0,0,0.75); border-radius: 3px; background-color: #f2f2f2;">
                        <h4 class="text-center mt-2">Have you had any repeated, disturbing dreams of a stressful experience?</h4>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="question-2" value="Yes" id="q2-yes" autocomplete="off">
                                <label class="btn btn-success btn-yes col-12 weePrime" for="q2-yes">Yes</label>

                                <input type="radio" class="btn-check" name="question-2" value="No" id="q2-no" autocomplete="off">
                                <label class="btn btn-success btn-no col-12 weeDouble" for="q2-no">No</label>
                            </div>
                            <div>
                                <p class="mt-4 px-2 py-2 thanks">
                                    <i class="bi bi-info-circle" style="color: #fff"></i>
                                    Thank you in advance for taking the time to complete this <br>
                                    questionnaire and contributing to your therapeutic journey.
                                </p>
                            </div>

                            <div style=" width: 100%; display: flex; justify-content: space-between" class="mt-4">
                                <button type="button" onclick="showQuestion1()" class="btn btn-success">Previous</button>
                                <button type="button" onclick="showQuestion3()" class="btn btn-success" >Next</button>
                            </div>
                        </div>
                    </div>


                    <!-- ======================= Question 3 ======================= -->

                    <div class="question-3-depression" id="question-3-d" style="padding: 3rem 4rem; box-shadow: 5px 5px 12px -1px rgba(0,0,0,0.75); border-radius: 3px; background-color: #f2f2f2;">
                        <h4 class="text-center mt-2">Have you had any sudden and unwanted memories of a stressful experience that felt like it was happening again?</h4>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="question-3" value="Yes" id="q3-yes" autocomplete="off">
                                <label class="btn btn-success btn-yes col-12 weePrime" for="q3-yes">Yes</label>

                                <input type="radio" class="btn-check" name="question-3" value="No" id="q3-no" autocomplete="off">
                                <label class="btn btn-success btn-no col-12 weeDouble" for="q3-no">No</label>
                            </div>

                            <div>
                                <p class="mt-4 px-2 py-2 thanks">
                                    <i class="bi bi-info-circle" style="color: #fff"></i>
                                    Thank you in advance for taking the time to complete this <br>
                                    questionnaire and contributing to your therapeutic journey.
                                </p>
                            </div>

                            <div style=" width: 100%; display: flex; justify-content: space-between" class="mt-4">
                                <button type="button" onclick="showQuestion2()" class="btn btn-success">Previous</button>
                                <button type="submit" class="btn btn-success" name="submit" >Submit</button>
                            </div>
                        </div>
                    </div>


                    <script>
                        let q1 = document.getElementById("question-1-d");
                        let q2 = document.getElementById("question-2-d");
                        let q3 = document.getElementById("question-3-d");

                        let yesbtn1 = document.getElementById("btnradio1");
                        let nobtn1 = document.getElementById("btnradio2");

                        let yesbtn2 = document.getElementById("q2-yes");
                        let nobtn2 = document.getElementById("q2-no");

                        let yesbtn3 = document.getElementById("q3-yes");
                        let nobtn3 = document.getElementById("q3-no");

                        function showQuestion1(){
                            q1.style.display = "revert";
                            q2.style.display = "none";
                            q3.style.display = "none";
                        }

                        function showQuestion2() {

                            if (yesbtn1.checked === false && nobtn1.checked === false){
                                alert('Please select an option to proceed')
                                q2.style.display = "none";
                                q3.style.display = "none";
                            } else {
                                q1.style.display = "none";
                                q2.style.display = "revert";
                                q3.style.display = "none";
                            }
                        }

                        function showQuestion3() {
                            if (yesbtn2.checked === false && nobtn2.checked === false){
                                alert('Please select an option to proceed!');
                                q1.style.display = "none";
                                q3.style.display = "none";
                            } else {
                                q1.style.display = "none";
                                q2.style.display = "none";
                                q3.style.display = "revert";
                            }
                        }

                        function submitValidation(){
                            if (yesbtn3.checked === false && nobtn3.checked === false){
                                alert('Please select and option to proceed!');
                                return false;
                            }
                        }

                        document.addEventListener('submit', (e) =>{
                            /*e.preventDefault();*/
                        });
                    </script>

                </form>
            </div>
            <!-- ======================= Question 1 ======================= -->

        </div>
    </div>


    <!-- ============ Testimonials ============ -->
    <section id="testimonials" class="testimonials">
        <div class="container">

            <div class="section-title">
                <h2>Testimonials</h2>
                <p>What are they saying about us</p>
            </div>

            <div class="slides-1 swiper" data-aos="fade-up">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="assets/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                            <h3>Saul Goodman</h3>
                            <h4>Ceo &amp; Founder</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="assets/assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                            <h3>Sara Wilsson</h3>
                            <h4>Designer</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="assets/assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                            <h3>Jena Karlis</h3>
                            <h4>Store Owner</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="assets/assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                            <h3>Matt Brandon</h3>
                            <h4>Freelancer</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="assets/assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                            <h3>John Larson</h3>
                            <h4>Entrepreneur</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section> <!-- ============ End Testimonials ============ -->
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
    function ($) {
        "use strict";

        $(window).on('load', function() {
            var pre_loader = $('#preloader');
            pre_loader.fadeOut('slow', function(){
                $(this).remove();
            });
        });
    };
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
