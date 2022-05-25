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
$tipe = "week";

// if (isset($_POST['btn-filter-waktu'])) {
//     $tipe = $_GET['tfilter_waktu'];
//     if ($laporan->update($tipe, $_POST) > 0) {
//         echo "<script>
//             alert('Data berhasil diubah!');
//             document.location.href = 'spek_lampu.php';
//         </script>";
//     } else {
//         echo "<script>
//             alert('Data gagal diubah!');
//             document.location.href = 'spek_lampu.php';
//         </script>";
//     }
// }

// ambil data untuk chart dari database
if ($tipe == "day") {
    // data sehari
    $laporan->getLaporan_day_perHour($tanggal);
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

}else if($tipe == "week"){
    // data seminggu
    $laporan->getLaporan_week_perDay($tanggal);
    $data_label = null;
    $data_nilai = null;

    $label = [];
    $nilai = [];
    while (list($x, $y) = $laporan->getResult()) {
        array_push($label, $x);
        array_push($nilai, $y);
    }

    $i=0;
    $name_of_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    for ($x=0; $x<7; $x++){

        $y = 0;
        if ($i < count($label)){
            if ($label[$i] == $name_of_days[$x]) {
                $y = $nilai[$i];
                $i ++;
            }
        }

        $data_label .= '<td name="chart_label">'.$name_of_days[$x].'</td>';
        $data_nilai .= '<td name="chart_value">'.$y.'</td>';
    }

}
//

$laporan->close();

$tpl = new Template("templates/dashboard.html");
$tpl->replace("DATA_CHART_LABELS", $data_label);
$tpl->replace("DATA_CHART_VALUES", $data_nilai);
$tpl->write();
  
?>