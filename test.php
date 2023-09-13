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
<body>
<div class="page-wrapper">
    <div class="content">
        <div class="row" style="margin-bottom: -4px">
            <div class="col-4 ">
                <h4 class="page-title">Users</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="grid-basic" class="table table-condensed table-hover table-striped">
                        <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric">ID</th>
                            <th data-column-id="sender">Sender</th>
                            <th data-column-id="received" data-order="desc">Received</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>10238</td>
                            <td>eduardo@pingpong.com</td>
                            <td>14.10.2013</td>
                        </tr>
                        ...
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

<script>
    $(document).ready(function() {
        $('#grid-data').DataTable({
            pageLength: 10,
            filter: true,
            deferRender: true,
            scrollY: 200,
            scrollCollapse: true,
            scroller: true,
            "searching": true,
        });
    });
</script>

<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
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
</html>