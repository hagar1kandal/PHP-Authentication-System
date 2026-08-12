
<?php 

//inisialise session
session_start();

//unset all session vars
$_SESSION=[];

//destroy session
session_destroy();

//redirect to home page
header("Location:index.php");
?>
