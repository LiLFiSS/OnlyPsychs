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


//Therapist Info

$TID = $_GET['id'];
$get_therapist = "SELECT * FROM users WHERE UserID = '$TID'";
$therapist_result = mysqli_query($conn, $get_therapist);

while ($row21 = mysqli_fetch_array($therapist_result)){
    $TPFP = $row21['profile_picture'];
    $Tgender = $row21['gender'];
    $Tdob = $row21['dob'];
    $Tphone_num = $row21['phone_num'];
    $TuserID = $row21['UserID'];
    $TFName = $row21['first_name'];
    $TLName = $row21['last_name'];
    $therapist_Email = $row21['email'];
}

$TPP = $TPFP;
$TGender = $Tgender;
$DOB = $Tdob;
$PhoneNumber = $Tphone_num;
/*$TUserID = $TuserID;*/

$sql_t = " SELECT * FROM therapist WHERE UserID = '$TID' ";
$query = mysqli_query($conn, $sql_t);

while ($fetch_Therapist = mysqli_fetch_array($query)){
    $address = $fetch_Therapist['address'];
    $city = $fetch_Therapist['office_city'];
    $country = $fetch_Therapist['office_country'];
    $license1 = $fetch_Therapist['license_1'];
    $license2 = $fetch_Therapist['license_2'];
    $license_num1 = $fetch_Therapist['license_num_1'];
    $license_num2 = $fetch_Therapist['license_num_2'];
    $bio = $fetch_Therapist['biography'];

    $edu_name1 = $fetch_Therapist['institution_name_1'];
    $edu_degree1 = $fetch_Therapist['degree_1'];
    $edu_sy1 = $fetch_Therapist['start_year_1'];
    $edu_ey1 = $fetch_Therapist['end_year_1'];

    $edu_name2 = $fetch_Therapist['institution_name_2'];
    $edu_degree2 = $fetch_Therapist['degree_2'];
    $edu_sy2 = $fetch_Therapist['start_year_2'];
    $edu_ey2 = $fetch_Therapist['end_year_2'];

    $edu_name3 = $fetch_Therapist['institution_3'];
    $edu_degree3 = $fetch_Therapist['degree_3'];
    $edu_sy3 = $fetch_Therapist['start_year_3'];
    $edu_ey3 = $fetch_Therapist['end_year_3'];

    $exp_jd1 = $fetch_Therapist['job_title_1'];
    $exp_sy1 = $fetch_Therapist['experience_start_year_1'];
    $exp_ey1 = $fetch_Therapist['experience_end_year_2'];

    $exp_jd2 = $fetch_Therapist['job_title_2'];
    $exp_sy2 = $fetch_Therapist['experience_start_year_2'];
    $exp_ey2 = $fetch_Therapist['experience_end_year_2'];

    $exp_jd3 = $fetch_Therapist['job_title_3'];
    $exp_sy3 = $fetch_Therapist['exp_start_year_3'];
    $exp_ey3 = $fetch_Therapist['exp_end_year_3'];

    if ($license2 != '' || $license2 != null){
        $license1 = $license1 .",";
    }

}


$Office_Address = $address;
$Office_City = $city;
$Office_Country = $country;
$Therapist_License1 = $license1;
$Therapist_License2 = $license2;
$License_Num1 = $license_num1;
$License_Num2 = $license_num2;

$Bio = $bio;

/*--------EDUCATION--------*/

$EDU_name1 = $edu_name1;
$EDU_Degree1 = $edu_degree1;
$EDU_SY1 = $edu_sy1;
$EDU_EY1 = $edu_ey1;

$EDU_name2 = $edu_name2;
$EDU_Degree2 = $edu_degree2;
$EDU_SY2 = $edu_sy2;
$EDU_EY2 = $edu_ey2;

$EDU_name3 = $edu_name3;
$EDU_Degree3 = $edu_degree3;
$EDU_SY3 = $edu_sy3;
$EDU_EY3 = $edu_ey3;

/*--------EXPERIENCE--------*/

$EXP_JD1 = $exp_jd1;
$EXP_SY1 = $exp_sy1;
$EXP_EY1 = $exp_ey1;

$EXP_JD2 = $exp_jd2;
$EXP_SY2 = $exp_sy2;
$EXP_EY2 = $exp_ey2;

$EXP_JD3 = $exp_jd3;
$EXP_SY3 = $exp_sy3;
$EXP_EY3 = $exp_ey3;

$find_case = "SELECT * FROM cases WHERE therapist_id = '$TID' AND patient_id = '$UserID'";
$case_query = mysqli_query($conn, $find_case);

if (mysqli_num_rows($case_query) > 0){
    $user_found = 1;
} else {
    $user_found = 0;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OnlyPsychs - <?php echo $TFName ." ". $TLName ."'s Profile" ?></title>
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

        .bar-chart > .legend > .item.text-right:before {
            right: 0;
            left: auto;
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


    <section>
        <div class="container">
            <div class="row ">
                <div class="col-sm-7 col-6 mt-4">
                    <h4 class="page-title"><?php echo $TFName ." ". $TLName?>'s Profile</h4>
                </div>

                <!--<div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="edit-profile-therapist.php" class="btn btn-rounded" style="background-color: #5D3FD3; color: #fff;"><i class="fa fa-plus"></i> Edit Profile</a>
                </div>-->
            </div>
            <div class="card-box profile-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#"><img class="avatar" src="assets/uploaded_img/<?php echo $TPFP?>" alt=""></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">Dr. <?php echo $TFName ." ". $TLName; ?></h3>
                                            <small class="text-muted">Psychologist <?php echo $Therapist_License1 ." ". $Therapist_License2; ?></small>
                                            <!--<div class="staff-id">Employee ID : TR-000<?php /*echo $therapist_UID; */?></div>-->

                                            <!--<div class="staff-msg review-btn"><a href="user-leaves-review.php?id=<?php /*echo $TuserID*/?>" class="btn btn-success">Leave a Review</a></div>
                                            <input type="text" id="user-found" value="<?php /*echo $user_found */?>">-->

                                            <!--<div class="staff-msg"><a href="user-leaves-review.php?id=<?php /*echo $TID */?>" class="btn btn-success">Leave a Review</a></div>-->

                                            <?php
                                            if ($user_found == 1){
                                                $test = $TID;
                                                echo '<div class="staff-msg"><a href="user-leaves-review.php?id='.$test.'" class="btn btn-success">Leave a Review</a></div>';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Contact Number:</span>
                                                <span class="text"><a href="#"><?php echo $PhoneNumber; ?></a></span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text"><a href="#"><?php echo $therapist_Email ?></a></span>
                                            </li>
                                            <li>
                                                <span class="title">Birthday:</span>
                                                <span class="text"><?php echo $DOB; ?></span>
                                            </li>
                                            <li>
                                                <span class="title">Address:</span>
                                                <span class="text"><?php echo $Office_Address .", ". $Office_City .", ". $Office_Country ; ?></span>
                                            </li>
                                            <li>
                                                <span class="title">Gender:</span>
                                                <span class="text"><?php echo $TGender; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-toggle="tab">Reviews</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="about-cont">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h3 class="card-title">Biography</h3>
                                    <div class="experience-box">
                                        <div class="bio-box">
                                            <?php echo $Bio; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-box">
                                    <h3 class="card-title">Education Information</h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name"><?php echo $EDU_name3; ?></a>
                                                        <div><?php echo $EDU_Degree3; ?></div>
                                                        <span class="time"><?php echo $EDU_SY3 ." - ". $EDU_EY3?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="edu-list-2">
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name"><?php echo $EDU_name2; ?></a>
                                                        <div><?php echo $EDU_Degree2; ?></div>
                                                        <span class="time"><?php echo $EDU_SY2 ." - ". $EDU_EY2 ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="edu-list-3">
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name"><?php echo $EDU_name1; ?></a>
                                                        <div><?php echo $EDU_Degree1; ?></div>
                                                        <span class="time"><?php echo $EDU_SY1 ." - ". $EDU_EY1 ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-box">
                                    <h3 class="card-title">Experience</h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <li class="exp-list-1">
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#" class="name"><?php echo $EXP_JD3; ?></a>
                                                        <span class="time"><?php echo $EXP_SY3 ." - ". $EXP_EY3. " (Present)" ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="exp-list-2">
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#" class="name"><?php echo $EXP_JD2; ?></a>
                                                        <span class="time"><?php echo $EXP_SY2 ." - ". $EXP_EY2 ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="exp-list-2">
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name"><?php echo $EXP_JD1; ?></a>
                                                        <span class="time"><?php echo $EXP_SY1 ." - ". $EXP_EY1 ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-box mb-0">
                                    <h3 class="card-title">License Information</h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <p style="color: #616161;"><?php echo $License_Num1 ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="lic-list">
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <p style="color: #616161;"><?php echo $License_Num2 ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bottom-tab2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h3 class="card-title">Specializations</h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <?php
                                            $sql = " SELECT * FROM specializations WHERE TID = '$TID' ";
                                            $query = mysqli_query($conn, $sql);
                                            while ($rows = mysqli_fetch_array($query)){
                                                $DisorderName = $rows['disorder_name'];

                                                $pieces = explode("," , "$DisorderName");
                                                $first = $pieces[0];
                                                $second = $pieces[1];

                                                ?>
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <p style="color: #616161;"><?php echo $first; ?></p>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <p style="color: #616161;"><?php echo $second; ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bottom-tab3">
                        <div class="tab-pane" id="bottom-tab3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="activity">
                                        <div class="activity-box">
                                            <ul class="activity-list">
                                                <?php

                                                $reviews = "SELECT * FROM reviews WHERE TID = '$TID'";
                                                $review_query = mysqli_query($conn, $reviews);

                                                if (mysqli_num_rows($review_query) > 0){
                                                    while ($fetch_reviews = mysqli_fetch_array($review_query)){
                                                        $CID = $fetch_reviews['CID'];
                                                        $content = $fetch_reviews['post_content'];
                                                        $time_posted = $fetch_reviews['submit_date'];

                                                        $find_user = "SELECT * FROM users WHERE UserID = '$CID'";
                                                        $user_query = mysqli_query($conn, $find_user);

                                                        while ($fetch_user = mysqli_fetch_array($user_query)){
                                                            $client_fName = $fetch_user['first_name'];
                                                            $client_LName = $fetch_user['last_name'];
                                                            $client_picture = $fetch_user['profile_picture'];
                                                            ?>
                                                            <li>
                                                                <div class="activity-user">
                                                                    <a href="#" title="<?php echo $client_fName .''. $client_LName?>" data-toggle="tooltip" class="avatar">
                                                                        <img alt="user" src="assets/uploaded_img/<?php echo $client_picture ?>" class="img-fluid rounded-circle">
                                                                    </a>
                                                                </div>
                                                                <div class="activity-content">
                                                                    <div class="timeline-content">
                                                                        <a href="" class="name"><?php echo $client_fName ." ". $client_LName ?></a>
                                                                        <p><?php echo $content ?></p>
                                                                        <span class="time"><?php echo $time_posted ?></span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }  else {
                                                    echo "<p>No Reviews Yet</p>";
                                                }

                                                ?>

                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-info">
                    <a href="landing-page.php"><img src="assets/img/OnlyPsychs-white-green-wrds.png" height="60"></a>
                    <p>Cras fermentum odio eu feugiat lide par naso tierra.
                        Justo eget nada terra videa magna derita valies darta
                        donna mare fermentum iaculis eu non diam phasellus.
                        Scelerisque felis imperdiet proin fermentum leo.
                        Amet volutpat consequat mauris nunc congue.</p>
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

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/app.js"></script>

<!-- Template Main JS File -->
<script src="assets/assets/js/main.js"></script>

</body>

</html>
