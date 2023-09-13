<?php
$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');

$nameRegex = "/^[A-Z]'?[- a-zA-Z-À-ÿ]*$/";
$emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
$phoneNumRegex = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/";
$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

$flag = true;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["first-name"])){
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>First Name Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($nameRegex, $_POST["first-name"]) == 0) ){
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>First Name contains illegal characters!</div>";
            $flag = false;

            $firstName = "";
        }
        else{
            $firstName = $_POST["first-name"];
        }
    }

//    Last Name Validation

    if (empty($_POST["last-name"])){
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Last Name Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($nameRegex, $_POST["last-name"]) == 0) ){
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Last Name contains illegal characters!</div>";
            $flag = false;

            $lastName = "";
        }
        else{
            $lastName = $_POST['last-name'];
        }
    }

//    Email Validation

    if (empty($_POST["email"])){
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Email Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($emailRegex, $_POST["email"]) == 0) ){
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Email Format Illegal!</div>";
            $flag = false;

            $email = "";
        }
        else{
            $email = $_POST['email'];
        }
    }

//    Phone Number Validation

    if (empty($_POST["phone-number"])){
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Phone Number Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($phoneNumRegex, $_POST["phone-number"]) == 0) ){
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Phone Number Format Illegal!</div>";
            $flag = false;

            $phoneNumber = "";
        }
        else{
            $phoneNumber = $_POST['phone-number'];
        }
    }

    //    Password Validation

    if (empty($_POST["password"])){
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Password Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($passwordPattern, $_POST["password"]) == 0) ){
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Password must have at least 8 characters with at least 1 number, symbol, uppercase and lowercase letter!</div>";
            $flag = false;

            $pass = "";
        }
        else{
            $pass = $_POST['password'];
        }
    }

    //    Confirm Password Validation

    if (empty($_POST["confirm-password"])){
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Confirm Your Password!</div>";
        $flag = false;
    } else {
        if ($_POST["confirm-password"] != $_POST["password"]){
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Passwords don't match!</div>";
            $flag = false;

            $confirm_password = "";
        }
        else{
            $confirm_password = $_POST['confirm-password'];
        }
    }


    $gender = $_POST['gender'];

    $dob = $_POST['dob'];

    $userType = "user";
    $status = "active";

    $profile_picture = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'assets/uploaded_img/'.$profile_picture;


    if ($flag){

        $select = " SELECT * FROM users WHERE email = '$email' AND user_password = '$pass' ";

        $result = mysqli_query($conn, $select) or die('query failed');

        if (mysqli_num_rows($result) == 0) {
            if ($image_size <= 20000000){
                move_uploaded_file($image_tmp_name, $image_folder);
                $sql = " INSERT INTO users(first_name, last_name, phone_num, gender, email, user_password, username,  user_type, status, profile_picture, dob)
                        values ('$firstName', '$lastName', '$phoneNumber', '$gender', '$email', '$pass', '', '$userType', '$status', '$profile_picture', '$dob')";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div class='alert alert-success mov flex-column align-content-center' role='alert'>Account Created Successfully! Redirecting to Login...</div>";
                    header( "refresh:9;url=login.php");
                } else {
                    echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Account Creation Error!</div>";
                    echo $message[] = "Account Creation Error!";
                    mysqli_close($conn);
                }
            } else {
                echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Image Size Too Large!</div>";
            }
        } else {
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Account Already Exists!</div>";
        }
    }
}


//if (isset($_POST['submit'])) {
//    $lastName = $_POST['last-name'];
//    $gender = $_POST['gender'];
//
//    $email = $_POST['email'];
//    $username = $_POST['username'];
//
//    $phoneNumber = $_POST['phone-number'];
//
//    $pass = $_POST['password'];
//    $confirm_password = $_POST['confirm-password'];
//
//    $userType = "user";
//    $status = "active";
//
//    $profile_picture = $_FILES['image']['name'];
//    $image_size = $_FILES['image']['size'];
//    $image_tmp_name = $_FILES['image']['tmp_name'];
//    $image_folder = 'assets/uploaded_img/'.$profile_picture;
//
//    $select = " SELECT * FROM users WHERE email = '$email' AND user_password = '$pass' ";
//
//    $result = mysqli_query($conn, $select) or die('query failed');
//
//    if (mysqli_num_rows($result) == 0) {
//            if ($image_size <= 20000000){
//                move_uploaded_file($image_tmp_name, $image_folder);
//
//                $sql = " INSERT INTO users(first_name, last_name, phone_num, gender, email, user_password, username,  user_type, status, profile_picture, dob)
//                        values ('$firstName', '$lastName', '$phoneNumber', '$gender', '$email', '$pass', '$username', '$userType', '$status', '$profile_picture', null)";
//
//                $result = mysqli_query($conn, $sql);
//                if ($result) {
//                    echo "<div class='alert alert-success mov flex-column align-content-center' role='alert'>Account Created Successfully!</div>";
//                    /*echo $message[] = "Account Created Successfully!";*/
//                    header('refresh:5; location:login.php');
//                } else {
//                    echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Account Creation Error!</div>";
//                    echo $message[] = "Account Creation Error!";
//                    mysqli_close($conn);
//                }
//            }
//            else {
//                echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Image Size Too Large!</div>";
//            }
//
//    }
//    else {
//        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Account Already Exists!</div>";
//        /*echo $message[] = "Account Already Exists!";*/
//    }
//}

?>

<!DOCTYPE html>

<html lang="en" dir="ltr" xmlns:a="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="assets/css/register-style.css">

    <!-- Template Main CSS File -->
    <link href="assets/assets/css/style.css" rel="stylesheet">
    <title>OnlyPsychs Register</title>

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
<?php
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
?>

<div class="header">
    <div class="header-left">
        <a class="logo" href="#">
            <img alt="" height="47" src="assets/img/OnlyPsychs-logo-img-dark-blue.png" width="47"> <span><img
                    src="assets/img/OnlyPsychs-logo-dark-blue.png " height="33"></span>
        </a>
    </div>
</div>

<div class="bg-img"></div>

<div class="container mt-lg-5 d-flex mb-lg-5" style="justify-content: center">
    <div class="container-reg">
        <div class="title">Registration</div>
        <div class="content">
            <form action="" name="registration" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                <div class="user-details">

                    <div class="input-box first-name-field">
                        <span class="details">First Name</span>
                        <input type="text" class="first-name" name="first-name" placeholder="Enter your first name" value="<?php echo $firstName?>" required>
                    </div>


                    <div class="input-box last-name-field">
                        <span class="details">Last Name</span>
                        <input type="text" name="last-name" class="last-name" placeholder="Enter your last name" value="<?php echo $lastName?>" required>
                    </div>

                    <div class="input-box username-field">
                        <span class="details">Date of Birth</span>
                        <input type="date" name="dob" class="username" placeholder="" value="<?php echo $dob?>" required>
                    </div>

                    <div class="input-box email-field">
                        <span class="details">Email</span>
                        <input type="email" name="email" class="email" placeholder="Eg. someone@example.com" value="<?php echo $email?>" required>
                    </div>


                    <div class="input-box phone-number-field">
                        <span class="details">Phone Number</span>
                        <input type="text" name="phone-number" class="phone-number" placeholder="Eg. (111)222-3333" value="<?php echo $phoneNumber?>" required>
                    </div>


                    <div class="input-box pp-field">
                        <span class="details">Choose Your Profile Picture</span>
                        <div class="picture-upload">
                            <input type="file" accept="image/jpeg, image/jpg, image/png" name="image" id="image" class="profile-picture" value="" required>
                        </div>
                    </div>


                    <div class="input-box password-field">
                        <span class="details">Password</span>
                        <input type="password" class="create-password" name="password" placeholder="Enter your password" value="<?php echo $pass?>" required>
                        <i class='bx bx-hide show-hide' ></i>
                    </div>


                    <div class="input-box confirm-password">
                        <span class="details">Confirm Password</span>
                        <input type="password" name="confirm-password" class="confirm-password" placeholder="Confirm password" value="<?php echo $confirm_password?>"  required>
                        <i class='bx bx-hide show-hide' ></i>
                    </div>


                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" value="Male" id="dot-1" <?php if ($gender === "Male")echo 'checked="checked"';?> required>
                    <input type="radio" name="gender" value="Female" id="dot-2" <?php if ($gender === "Female")echo 'checked="checked"';?> required>
                    <input type="radio" name="gender" value="Other" id="dot-3" <?php if ($gender === "Other")echo 'checked="checked"';?> required>
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Other</span>
                        </label>
                    </div>
                </div>

                <div class="terms-and-conditions">
                    <label>
                        <input type="checkbox" name="terms" required> I agree to the <a href="#" style="color: #1844f2;">OnlyPsychs Terms</a>
                    </label>
                </div>

                <div class="button">
                    <input type="submit" name="submit" value="Register">
                </div>
                <div class="login">
                    Already a member? <a style="color: #1844f2;" href="login.php">Login Now</a>
                </div>
            </form>
        </div>
    </div>
</div>

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


<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>
