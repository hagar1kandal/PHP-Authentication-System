
<?php
include "layout/session.php";

if ($_SESSION['role'] != "admin") {
    header("Location:index.php");
}

include "connection/config.php";
$databaseconn = getconnectiontodb();

$id= $_GET['id'];
$sql="DELETE FROM users where id =? ";
$stmt= $databaseconn->prepare($sql);
$stmt->execute([$id]);

header("Location:dashboard.php");
?>
 

