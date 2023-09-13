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

    <title>OnlyPsychs - Home</title>
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

<!-- ======= Hero Section ======= -->
<section id="hero" style="background-image: url(assets/img/hero-bg.jpg)">
    <div class="hero-container" data-aos="fade-up">
        <h1>Welcome back <?php echo  $firstName ?></h1>
        <h2>Let us assist you in finding the perfect therapist to address your individual mental health needs.</h2>
        <a href="get-started-page.php" class="btn-get-started scrollto">Get Started</a>
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container">

            <div class="row justify-content-end">
                <div class="col-lg-11">
                    <div class="row justify-content-end">

                        <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                            <div class="count-box py-5">
                                <i class="bi bi-emoji-wink"></i>
                                <span data-purecounter-start="0" data-purecounter-end="150" class="purecounter">0</span>
                                <p>Happy Clients</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                            <div class="count-box py-5">
                                <i class="bi bi-journal-richtext"></i>
                                <span data-purecounter-start="0" data-purecounter-end="30" class="purecounter">0</span>
                                <p>Licensed Therapists</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                            <div class="count-box pb-5 pt-0 pt-lg-5">
                                <i class="bi bi-clock"></i>
                                <span data-purecounter-start="0" data-purecounter-end="15" class="purecounter">0</span>
                                <p>Over Years Of Experience Each</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                            <div class="count-box pb-5 pt-0 pt-lg-5">
                                <i class="bi bi-star-fill"></i>
                                <span data-purecounter-start="0" data-purecounter-end="150" class="purecounter">0</span>
                                <p>Reviews</p>
                            </div>
                        </div

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-6 video-box align-self-baseline position-relative">
                    <img src="assets/assets/img/nature-bg.jpg" class="img-fluid" alt="">
                    <a href="https://www.youtube.com/watch?v=XrGgub71UJc" class="glightbox play-btn mb-4"></a>
                </div>

                <div class="col-lg-6 pt-3 pt-lg-0 content">
                    <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                    <p class="fst-italic">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-double"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                        <li><i class="bx bx-check-double"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                        <li><i class="bx bx-check-double"></i> Voluptate repellendus pariatur reprehenderit corporis sint.</li>
                        <li><i class="bx bx-check-double"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                    </ul>
                    <p>
                        Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum
                    </p>
                </div>

            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="fade-in">

            <div class="text-center">
                <h3>Call To Action</h3>
                <p> Take the first step towards improved well-being. Join now to discover the perfect therapist for you.</p>
                <a class="cta-btn" href="get-started-page.php">Get Started!</a>
            </div>

        </div>
    </section><!-- End Cta Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services ">
        <div class="container">

            <div class="section-title pt-5" data-aos="fade-up">
                <h2>Our Services</h2>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="icon-box" data-aos="fade-up">
                        <div class="icon"><i class="bi bi-emoji-frown" style="color: #ff689b;"></i></div>
                        <h4 class="title"><a href="">Depression</a></h4>
                        <p class="description">Our team of experienced therapists specializes in helping individuals overcome depression and regain a sense of balance and happiness in their lives.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="icon-box" data-aos="fade-up">
                        <div class="icon"><i class="bi bi-emoji-neutral" style="color: #e9bf06;"></i></div>
                        <h4 class="title"><a href="">Anxiety</a></h4>
                        <p class="description">We understand the challenges that anxiety can bring to your daily life, and our dedicated therapists are here to guide you towards a calmer and more peaceful state of mind.</p>
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-emoji-dizzy" style="color: #3fcdc7;"></i></div>
                        <h4 class="title"><a href="">ADHD (Attention-Deficit/Hyperactivity Disorder)</a></h4>
                        <p class="description">Living with ADHD can present unique challenges, but our specialized therapists are here to help. They offer personalized support and strategies to manage ADHD symptoms.</p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-emoji-angry" style="color:#41cf2e;"></i></div>
                        <h4 class="title"><a href="">PTSD (Post-Traumatic Stress Disorder)</a></h4>
                        <p class="description">Our compassionate therapists are experienced in helping individuals recover from the effects of traumatic experiences and find healing from PTSD.</p>
                    </div>
                </div>


            </div>

        </div>
    </section><!-- End Services Section -->

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
