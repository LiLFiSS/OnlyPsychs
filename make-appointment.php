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

$sql_pfp = " SELECT * FROM users WHERE UserID = '$UserID' ";
$result2 = mysqli_query($conn, $sql_pfp);

while ($row = mysqli_fetch_array($result2)){
    $PFP = $row['profile_picture'];
}

$PP = $PFP;

//Getting Therapist Information

$TID = $_GET['id'];
$sql = "SELECT * FROM users WHERE UserID = '$TID'";
$result = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($result)){
    $TFName = $rows['first_name'];
    $TLName = $rows['last_name'];
    $phone_Num = $rows['phone_num'];
    $Temail = $rows['email'];
}

$sql2 = "SELECT * FROM therapist WHERE UserID = '$TID'";
$query = mysqli_query($conn, $sql2);

while ($fetch_therapist = mysqli_fetch_array($query)){
    $license_1 = $fetch_therapist['license_1'];
    $license_2 = $fetch_therapist['license_2'];
    $addy = $fetch_therapist['address'];
    $city = $fetch_therapist['office_city'];
    $country = $fetch_therapist['office_country'];

}

$TName = $TFName ." ". $TLName;

$TPhone_Num = $phone_Num;
$TEmail = $Temail;
$Office_Address = $addy ." ". $city ." ". $country;

if ($license_2 != '' || $license_2 != null){
    $license = $license_1 .", ". $license_2;
} else {
    $license  = $license_1;
}

//IF SUBMIT - Set Appointment

if (isset($_POST['submit'])){
    $app_date = $_POST['app_date'];
    $app_time = $_POST['apt-time'];
    $app_status = "Pending";
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    date_default_timezone_set('America/Port_of_Spain');
    $time = date("Y/m/d h:i:sa");

    $find_pending = "SELECT * FROM appointments WHERE PatientID = '$UserID' AND Status = 'Pending'";
    $find_query = mysqli_query($conn, $find_pending);
    if (mysqli_num_rows($find_query) > 0){
        echo "<div class='alert alert-danger mov-2' role='alert'> Please wait for your last sent appointment! to be approved before setting a new one! </div>";
    } else {
        if ($app_time == 'Time'){
            echo "<div class='alert alert-danger mov-2' role='alert'> Please select a valid time from the list! </div>";
        } else {
            $validate_app = "SELECT * FROM appointments WHERE AppDate = '$app_date' AND AppTime = '$app_time'";
            $validate_query = mysqli_query($conn, $validate_app);

            if (mysqli_num_rows($validate_query) > 0){
                echo "<div class='alert alert-danger mov-2' role='alert'> Appointment slot taken! Please select another day/time </div>";
            } else {
                $set_app = "INSERT INTO appointments (PatientID, TherapistID, AppDate, AppTime, CreationDate, Status, msg_subject, msg) 
                    VALUES ('$UserID', '$TID', '$app_date', '$app_time','$time', '$app_status', '$subject', '$message')";
                $app_query = mysqli_query($conn, $set_app);
                echo "<div class='alert alert-success mov-2' role='alert'> Appointment set! Please wait... </div>";
                header( "refresh:15;url=appointment-review.php");
            }
        }
    }


}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OnlyPsychs - Schedule Appointment</title>
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


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

        form input, select{
            /*border-radius: 0;*/
            height: 44px;
        }

        button[type=submit] {
            background: #94c045;
            border: 0;
            padding: 10px 24px;
            color: #fff;
            transition: 0.4s;
            border-radius: 50px;
        }

        button[type=submit]:hover {
            background: #aacd6b;
        }

        .mov-2{
            margin-top: 72px;
            margin-bottom: -60px;
            text-align: center;
        }

        /* CSS to gray out disabled dates */
        .disabled-date {
            color: #999999;
            pointer-events: none;
        }

        .flatpickr-calendar{
            background-color: #e9f1da;
        }

        .flatpickr-day{
            color: #000000;
        }

        .flatpickr-day.today{
            color: #5D3FD3;
        }

        .flatpickr-weekdays {
            background-color: #e0e0e0; /* Change the weekdays background color */
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
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="breadcrumb-hero">
                <div class="container">
                    <div class="breadcrumb-hero">
                        <h2>Request Appointment</h2>
                        <p> Request an appointment with a therapist of your choosing. Please complete the form below </p>
                    </div>
                </div>
            </div>
            <div class="container">
                <ol>
                    <li><a href="">View Therapist</a></li>
                    <li>Schedule Appointment</li>
                </ol>
            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div>
                    <iframe style="border:0; width: 100%; height: 270px;" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=<?php echo $city?>)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="row mt-5">

                    <div class="col-lg-4" data-aos="fade-right">
                        <div class="info">
                            <div class="user">
                                <i class="bi bi-person"></i>
                                <h4><?php echo $TName ?></h4>
                                <p><?php echo $license ?></p>
                            </div>

                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Location:</h4>
                                <p><?php echo $Office_Address ?></p>
                            </div>

                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p><?php echo $TEmail  ?></p>
                            </div>

                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>Call:</h4>
                                <p>+1 <?php echo $TPhone_Num ?></p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">

                        <form method="post" name="App_FORM" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="user-name" class="form-control" id="name" style="border-radius: 0" placeholder="Your Name" value="<?php echo $firstName ." ". $lastName ?>" disabled>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="user-email" id="email" style="border-radius: 0" placeholder="Your Email" value="<?php echo $email?>" disabled>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <input type="date" name="app_date" class="form-control" id="app_date" style="border-radius: 0" placeholder="Date" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <select id="inputState" name="apt-time" class="form-select" style="border-radius: 0"  required>
                                        <option>Time</option>
                                        <option>9:00 AM</option>
                                        <option>10:00 AM</option>
                                        <option>11:15 AM</option>
                                        <option>2:30 PM</option>
                                        <option>3:45 PM</option>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject" style="border-radius: 0" placeholder="Subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea type="text" class="form-control" id="message" name="message" rows="5" style="border-radius: 0" placeholder="Message" required></textarea>
                            </div>

                            <div class="text-center mt-2"><button type="submit" name="submit">Create Appointment</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
</main><!-- End #main -->

<!--<script>-->
<!--    let todayDate = new Date();-->
<!--    let month = todayDate.getMonth() + 1;-->
<!--    let year = todayDate.getUTCFullYear();-->
<!--    let tdate = todayDate.getDate();-->
<!--    if (month < 10) {-->
<!--        month = "0" + month-->
<!--    }-->
<!--    if (tdate < 10) {-->
<!--        tdate = "0" + tdate;-->
<!--    }-->
<!--    let maxDate = year + "-" + month + "-" + tdate;-->
<!--    document.getElementById("app_date").setAttribute("min", maxDate);-->
<!--</script>-->

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#app_date", {
            disable: [
                function(date) {
                    // 0 represents Sunday, 6 represents Saturday
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            minDate: 'today',
            dateFormat: 'm-d-Y'
        });
    });
</script>






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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous"
        referrerpolicy="no-referrer">
</script>

<!-- Template Main JS File -->
<script src="assets/assets/js/main.js"></script>

</body>

</html>
