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

$tanggal = date_format(date_create("now"),"Y-m-d");;
$tipe = "day";

if (isset($_POST['tfilter_waktu'])) {
    $tipe = $_POST['tfilter_waktu'];
}
if (isset($_POST['ttanggal'])) {
    $tanggal = $_POST['ttanggal'];
}

$data_filter_selected[0] = "";
$data_filter_selected[1] = "";
$data_filter_selected[2] = "";
$data_filter_selected[3] = "";

// ambil data untuk chart dari database
if ($tipe == "day") {
    // data sehari
    $laporan->getLaporan_day_perHour($tanggal);
    $data_label = null;
    $data_nilai = null;
    $data_labelx = "Waktu (Jam)";
    $data_filter_selected[0] = "selected";
    $data_penggunaan_listrik = "Data Penggunaan Listrik (1 Hari)";

    $tanggal_temp = date_create($tanggal);
    $data_tampilan_tanggal = "Tanggal : " . date_format($tanggal_temp, "d-m-Y");
    

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

        if ($x != 24) {
            $data_label .= '<td name="chart_label">'.$x.':00</td>';
        }else{
            $data_label .= '<td name="chart_label">0:00</td>';
        }
        $data_nilai .= '<td name="chart_value">'.$y.'</td>';
    }

}else if($tipe == "week"){
    // data seminggu
    $laporan->getLaporan_week_perDay($tanggal);
    $data_label = null;
    $data_nilai = null;
    $data_labelx = "Waktu (Hari)";
    $data_filter_selected[1] = "selected";
    $data_penggunaan_listrik = "Data Penggunaan Listrik (1 Minggu)";

    //tentukan hari senin di minggu ini
    $monday = date_create($tanggal);
    $monday_str = date_format($monday,"Y-m-d");
    while (date('l', strtotime($monday_str)) != "Monday") {
        date_modify($monday,"-1 day");
        $monday_str = date_format($monday,"Y-m-d");
    }
    //tentukan hari minggu
    $sunday = date_create($monday_str);
    date_modify($sunday,"+6 days");
    //masukkan
    $data_tampilan_tanggal = "Tanggal : " . date_format($monday,"d-m-Y") . " s/d " . date_format($sunday,"d-m-Y");

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

}else if ($tipe == "month") {
    //data sebulan
    $laporan->getLaporan_month_perDay($tanggal);
    $data_label = null;
    $data_nilai = null;
    $data_labelx = "Waktu (Tanggal)";
    $data_filter_selected[2] = "selected";
    $data_penggunaan_listrik = "Data Penggunaan Listrik (1 Bulan)";

    $tanggal_temp = date_create($tanggal);
    $data_tampilan_tanggal = "Bulan : " . date_format($tanggal_temp, "F Y");

    $label = [];
    $nilai = [];
    while (list($x, $y) = $laporan->getResult()) {
        array_push($label, $x);
        array_push($nilai, $y);
    }

    $count_days_in_month = date("t", strtotime($tanggal));
    $i=0;
    for ($x=1; $x<=$count_days_in_month; $x++){

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

}else if ($tipe == "year") {
    //data setahun
    $laporan->getLaporan_year_perMonth($tanggal);
    $data_label = null;
    $data_nilai = null;
    $data_labelx = "Waktu (Bulan)";
    $data_filter_selected[3] = "selected";
    $data_penggunaan_listrik = "Data Penggunaan Listrik (1 Tahun)";

    $tanggal_temp = date_create($tanggal);
    $data_tampilan_tanggal = "Tahun : " . date_format($tanggal_temp, "Y");

    $label = [];
    $nilai = [];
    while (list($x, $y) = $laporan->getResult()) {
        array_push($label, $x);
        array_push($nilai, $y);
    }

    $i=0;
    for ($x=1; $x<=12; $x++){

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
}
//

$laporan->close();

$tpl = new Template("templates/dashboard.html");
$tpl->replace("DATA_CHART_LABELS", $data_label);
$tpl->replace("DATA_CHART_VALUES", $data_nilai);
$tpl->replace("DATA_LABEL_X", $data_labelx);
$tpl->replace("DATA_PENGGUNAAN_LISTRIK", $data_penggunaan_listrik);
$tpl->replace("DATA_TANGGAL", $tanggal);
$tpl->replace("DATA_TAMPILAN_TANGGAL", $data_tampilan_tanggal);

$tpl->replace("DATA_FILTER_WAKTU_DAY", $data_filter_selected[0]);
$tpl->replace("DATA_FILTER_WAKTU_WEEK", $data_filter_selected[1]);
$tpl->replace("DATA_FILTER_WAKTU_MONTH", $data_filter_selected[2]);
$tpl->replace("DATA_FILTER_WAKTU_YEAR", $data_filter_selected[3]);
$tpl->write();


?>