<?php
$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

session_start();

$admin_UID = $_SESSION['admin_UID'];
$firstName = $_SESSION['adminName'];

if (!isset($admin_UID)){
    header("Location: login.php");
}

$sql_pfp = "SELECT * FROM users WHERE UserID = '$admin_UID'";
$result2 = mysqli_query($conn, $sql_pfp);

while ($row21 = mysqli_fetch_array($result2)){
    $PFP = $row21['profile_picture'];
}

$PP = $PFP;

?>


<!DOCTYPE html>
<html lang="en">


<!-- patients23:17-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link href="assets/img/OnlyPsychs-dark-blue-icon.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Users</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
<!--    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">-->

    <link rel="stylesheet" href= "https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script src = "https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src = "https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>


    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="main-wrapper">
    <div class="header">
        <div class="header-left">
            <a class="logo" href="admin-home.php">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-photoshop-edit-x.png" height="30"></span>
            </a>
        </div>
        <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
        <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown d-none d-sm-block">
                <?php
                $notification_query = " SELECT * FROM logs WHERE status = 'active' ";
                $select_notifications = mysqli_query($conn, $notification_query) or die('query failed');
                $notifications_count = mysqli_num_rows($select_notifications);
                ?>
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right"><?php echo $notifications_count ?></span></a>
                <div class="dropdown-menu notifications">
                    <div class="topnav-dropdown-header">
                        <span>Notifications</span>
                    </div>
                    <div class="drop-scroll">
                        <ul class="notification-list">
                            <?php
                            $sql_2 = "SELECT * FROM logs WHERE status = 'active'";
                            $select_logs_2 = mysqli_query($conn, $sql_2) or die('query failed');
                            if (mysqli_num_rows($select_logs_2) > 0) {
                                while ($fetch_logs_2 = mysqli_fetch_assoc($select_logs_2)) {
                                    ?>
                                    <li class="notification-message">
                                        <a href="activities.php">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="John Doe" src="assets/uploaded_img/<?php echo $PP?>" class="img-fluid rounded-circle">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title"><?php echo $fetch_logs_2['log_user']; ?></span> <?php echo $fetch_logs_2['log_description'] ?><spanclass="noti-title"><?php echo $fetch_logs_2['task']; ?></span></p>
                                                    <p class="noti-time"><span class="notification-time"><?php echo $fetch_logs_2['log_time']; ?></span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo '<p>No Notifications To Show!</p>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="activities.php">View all Notifications</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                    <span class="user-img"><img class="rounded-circle" src="assets/uploaded_img/<?php echo $PP?>" width="40" alt="Admin">
                        <span class="status online"></span></span>
                    <span><?php echo $firstName?></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
        <div class="dropdown mobile-user-menu float-right">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile.html">My Profile</a>
                <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                <a class="dropdown-item" href="login.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div class="sidebar-menu" id="sidebar-menu">
                <ul>
                    <li class="menu-title">Main</li>
                    <li>
                        <a href="admin-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="therapists.php"><i class="fa fa-user-md"></i> <span>Therapists</span></a>
                    </li>
                    <li>
                        <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                    </li>
                    <li class="active">
                        <a href="users.php"><i class="fa fa-user"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Therapists Schedule</span></a>
                    </li>
                    <li>
                        <a href="reviews.php"><i class="fa fa-star"></i> <span>Reviews</span></a>
                    </li>
                    <li>
                        <a href="activities.php"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-envelope"></i> <span> Messages</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="compose.html">Compose Mail</a></li>
                            <li><a href="inbox.html">Inbox</a></li>
                            <li><a href="mail-view.html">Mail View</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="blog-details.html">Blog View</a></li>
                            <li><a href="add-blog.html">Add Blog</a></li>
                            <li><a href="edit-blog.html">Edit Blog</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="content">
            <div class="row" style="margin-bottom: -4px">
                <div class="col-4 ">
                    <h4 class="page-title">Users</h4>
<!--                    <div class="form-outline mb-4">-->
<!--                        <input type="text" class="form-control" id="datatable-search-input">-->
<!--                        <label class="form-label" for="datatable-search-input">Search</label>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-12">
                        <table id="datatable" class="table table-bordered table-striped mb-0" style="width: 95%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <!--<th>Address</th>-->
                                <th>Phone</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM users ";
                            $select_users = mysqli_query($conn, $sql) or die('query failed');
                            if (mysqli_num_rows($select_users) > 0){
                                while ($fetch_users = mysqli_fetch_assoc($select_users)){
                                    ?>
                                    <tr>
                                        <td><?php echo $fetch_users['UserID'] ?></td>
                                        <td><img width="28" height="28" src="assets/uploaded_img/<?php echo $fetch_users['profile_picture'] ?>" class="rounded-circle m-r-5" alt=""> <?php echo $fetch_users['first_name'] ?></td>
                                        <td><?php echo $fetch_users['last_name'];?></td>
                                        <!--<td>1545 Dorsey Ln NE, Leland, NC, 28451</td>-->
                                        <td><?php echo $fetch_users['phone_num']; ?></td>
                                        <td><?php echo $fetch_users['email']; ?></td>
                                        <td><?php echo $fetch_users['user_type']; ?></td>
                                        <td><?php echo $fetch_users['status']; ?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-user.php?id=<?php echo $fetch_users['UserID']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#delete_patient"><i class="fa fa-trash-o m-r-5 delete-btn"></i> Delete</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else{
                                echo '<p>No Users Added Yet</p>';
                            }

                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="notification-box">
            <div class="msg-sidebar notifications msg-noti">
                <div class="topnav-dropdown-header">
                    <span>Messages</span>
                </div>
                <div class="drop-scroll msg-list-scroll" id="msg_list">
                    <ul class="list-box">

                    </ul>
                </div>
                <!--<div class="topnav-dropdown-footer">
                    <a href="chat.html">See all messages</a>
                </div>-->
            </div>
        </div>
    </div>
    <div id="delete_patient" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="delete-user.php" method="post">
                    <div class="modal-body text-center">
                        <img src="assets/img/sent.png" alt="" width="50" height="46">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <h3>Are you sure want to delete this Patient?</h3>
                        <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/app.js"></script>

<script>
    (document |> $).ready(function () {

        $('.delete-btn').on('click', function () {

            $('#delete_patient').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_id').val(data[0]);

        });
    });
</script>

</body>


<!-- patients23:19-->
</html>