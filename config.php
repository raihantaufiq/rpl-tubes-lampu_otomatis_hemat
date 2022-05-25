<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_rpl";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
 
if(! $conn){
    die('Could not connect: ' . mysql_error());
}

?>