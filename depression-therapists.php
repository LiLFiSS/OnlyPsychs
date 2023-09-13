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

    <title>OnlyPsychs - Therapists for Depression</title>
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

    <style>
        .breadcrumb-hero p a{
            color: #666699;
        }

        .breadcrumb-hero p a:hover{
            text-decoration: underline;
            color: #e67300;
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

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="breadcrumb-hero">
            <div class="container">
                <div class="breadcrumb-hero">
                    <h2>Help us find the <span class="" style="color: #666699">best therapist</span> for you</h2>
                    <p>Request an appointment with one of our therapists you believe is best suited to your mental health needs.</p>
                </div>
            </div>
        </div>
        <!--<div class="container">
            <ol>
                <li><a href="index.html">Home</a></li>
                <li>About</li>
            </ol>
        </div>-->
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about mt-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 align-self-baseline text-center">
                    <img src="assets/img/depression-img.jpg" class="img-fluid" style="height: 28rem" alt="">
                    <!--<a href="https://www.youtube.com/watch?v=XrGgub71UJc" class="glightbox play-btn mb-4"></a>-->
                </div>

                <div class="col-lg-6 pt-3 pt-lg-0 content">
                    <h3>Depression</h3>
                    <p class="fst-italic">
                        Depression can have a significant impact on daily life, causing persistent sadness, loss of interest, and a lack of energy or motivation. It may affect sleep patterns, appetite, and the ability to concentrate.
                    </p>

                    <p class="fst-italic">
                        Our therapists specializing in depression are here to offer compassionate support, evidence-based treatments, and strategies to help you regain a sense of joy, purpose, and well-being.
                    </p>

                    <p class="fst-italic">
                        We encourage you to explore the therapists available for each mental health
                        disorder and select the one that resonates with you the most. <br>
                        Remember, our goal is to match you with a therapist who best suits your needs,
                        ensuring a supportive and effective therapeutic journey.
                    </p>

                </div>

            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="breadcrumb-hero">
            <div class="container">
                <div class="breadcrumb-hero">
                    <h3>Based on your responses, <br> you are displaying symptoms of someone suffering with <span class="" style="color: #666699">Depression</span> </h3> <br>
                    <h3>Here's a list of all our therapists who specializes in <span class="" style="color: #666699">Depression</span></h3>
                    <p>Request an appointment with one of our therapists you believe is best suited to your mental health needs.</p>
                    <p>Think we got it wrong? Feel Free to request an appointment with any one of <a href="">our therapists</a> on the system for a consultation! </p>
                </div>
            </div>
        </div>
        <!--<div class="container">
            <ol>
                <li><a href="index.html">Home</a></li>
                <li>About</li>
            </ol>
        </div>-->
    </section><!-- End Breadcrumbs -->



    <!-- ======= Team Section ======= -->
    <section id="team" class="team mt-5">
        <div class="container">



            <div class="row">

                <?php
                $sql = " SELECT * FROM specializations WHERE disorder_name LIKE '%Depression%' ";
                $query = mysqli_query($conn, $sql);
                while ($rows = mysqli_fetch_array($query)){
                    $TID = $rows['TID'];
                    $disorder_string = $rows['disorder_name'];

                    $pieces = explode("," , "$disorder_string");
                    $first = $pieces[0];
                    $second = $pieces[1];

                    if ($first == "Depression"){
                        $specialization1 = $first;
                        $specialization2 = $second;
                    } else if ($second == 'Depression'){
                        $specialization1 = $second;
                        $specialization2 = $first;
                    }

                    $sql2 = " SELECT * FROM users WHERE UserID = '$TID' ";
                    $query2 = mysqli_query($conn, $sql2);
                    while ($fetch_therapists = mysqli_fetch_array($query2)){
                        $therapist_FName = $fetch_therapists['first_name'];
                        $therapist_LName = $fetch_therapists['last_name'];
                        $therapist_picture = $fetch_therapists['profile_picture'];

                        $select_details = "SELECT * FROM therapist where UserID = '$TID'";
                        $query3 = mysqli_query($conn, $select_details);

                        while ($get_details = mysqli_fetch_array($query3)){
                            $license1 = $get_details['license_1'];
                            $license2 = $get_details['license_2'];
                            $addy = $get_details['address'];
                            $city = $get_details['office_city'];
                            ?>
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <div class="member" data-aos="fade-up">
                                    <div class="member-img">
                                        <img src="assets/uploaded_img/<?php echo $therapist_picture; ?>" class="img-fluid" alt="">
                                        <div class="social">
                                            <a href="user-view-therapist-profile.php?id=<?php echo $TID ?>"><i class="bi bi-twitter"></i></a>
                                            <a href="user-view-therapist-profile.php?id=<?php echo $TID ?>"><i class="bi bi-facebook"></i></a>
                                            <a href="user-view-therapist-profile.php?id=<?php echo $TID ?>"><i class="bi bi-instagram"></i></a>
                                            <a href="user-view-therapist-profile.php?id=<?php echo $TID ?>"><i class="bi bi-linkedin"></i></a>
                                        </div>
                                    </div>
                                    <div class="member-info">
                                        <h4>Dr. <?php echo $therapist_FName ." ". $therapist_LName ?></h4>
                                        <span>Psychologist <?php echo $license1 .", ". $license2 ?></span>
                                        <p>
                                            Specializations <br> <?php echo $specialization1 ?> <br>
                                            <?php echo $specialization2 ?> <br>
                                            <!--Est sapiente occaecati et dolore. Omnis aut ut nesciunt explicabo qui.
                                            Eius nam deleniti ut omnis repudiandae perferendis qui. Neque non quidem sit
                                            sed pariatur quia modi ea occaecati. Incidunt ea non est corporis in.-->
                                        </p>
                                        <p class="">
                                            <a href="make-appointment.php?id=<?php echo $TID ?>" class="btn spc-btn">Schedule Appointment</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                }

                ?>

            </div>

        </div>
    </section><!-- End Team Section -->


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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
