<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'school');

if (isset($_POST['delete_data_btn'])) {
    $sql = "TRUNCATE TABLE excel";
    $query_run = mysqli_query($con, $sql) or die("bad query");
    $msg = true;
}
if (isset($msg)) {
    $_SESSION['message'] = "U can Imported a new Excelfile Now";
    header('Location: index.php');
    exit(0);
} else {
    $_SESSION['message'] = "Not Deleted";
    header('Location: index.php');
    exit(0);
}
