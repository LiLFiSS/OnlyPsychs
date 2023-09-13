<?php
$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

if (isset($_POST['delete'])){
    $id = $_POST['delete_id'];

    echo "<div> ID IS: $id </div>";

    $sql = "UPDATE users SET status = 'inactive' WHERE UserID = '$id'";
    $result = mysqli_query($conn, $sql);

    if($result)
    {
        echo "<div class='alert alert-success mov' role='alert'> User Account Deleted! </div>";
        header("Location:users.php");
    }
    else
    {
        echo "<div class='alert alert-danger mov' role='alert'> Unable to Delete User Account! </div>";
    }
}

?>
