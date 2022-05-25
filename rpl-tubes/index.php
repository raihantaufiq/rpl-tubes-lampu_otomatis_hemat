<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

include("config.php");
include("includes/DB.class.php");
include("includes/Laporan.class.php");

$laporan = new Laporan($db_host, $db_user, $db_pass, $db_name);
$laporan->open();
$laporan->getLaporan();

$data = null;


$laporan->close();

$tpl = new Template("templates/dashboard.html");
$tpl->replace("DATA_LAPORAN", $data);
$tpl->write();
  
?>