<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

include("config.php");
include("includes/DB.class.php");
include("includes/Laporan.class.php");
include("includes/Template.class.php");

$laporan = new Laporan($db_host, $db_user, $db_pass, $db_name);
$laporan->open();

$tanggal = "2022-5-12";
$laporan->getLaporan_oneDay_perHour($tanggal);

// ambil data untuk chart dari database
$data_label = null;
$data_nilai = null;

$label = [];
$nilai = [];
while (list($x, $y) = $laporan->getResult()) {
    array_push($label, $x);
    array_push($nilai, $y);
}

$i=0;
for ($x=1; $x<=24; $x++){

    $y = 0;
    if ($i < count($label)){
        if ($label[$i] == $x) {
            $y = $nilai[$i];
            $i ++;
        }
    }

    $data_label .= '<td name="chart_label">'.$x.'</td>';
    $data_nilai .= '<td name="chart_value">'.$y.'</td>';
}
//

$laporan->close();

$tpl = new Template("templates/dashboard.html");
$tpl->replace("DATA_CHART_LABELS", $data_label);
$tpl->replace("DATA_CHART_VALUES", $data_nilai);
$tpl->write();
  
?>