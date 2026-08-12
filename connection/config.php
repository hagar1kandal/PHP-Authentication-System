<?php

function  getconnectiontodb(){

$servername= "localhost";
$username= "root";
$password="";
$database="form";
$charset="utf8mb4";

$dsn= "mysql:host=$servername;dbname=$database;charset=$charset";

$options=[
PDO::ATTR_ERRMODE               =>PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE    =>PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES      =>false,
];

try {
    $connection= new PDO($dsn,$username,$password,$options);
    return  $connection;
} catch (\PDOException $e) {
    die("Error:Failed to connect to database -". $e->getMessage());
}

}


?>

