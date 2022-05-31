<?php

    session_start(); // Start sessionnya

    if (!isset($_SESSION['username'])) {
      header("location: index.php");
    }

    include("config.php");
    include("includes/Template.class.php");
    include("includes/DB.class.php");
    include("includes/Lampu.class.php");

    $lampu = new Lampu($db_host, $db_user, $db_pass, $db_name);
    $lampu->open();
    $lampu->getLampu();

    $data = null;

    $row = $lampu->getResult();
    $data .= '<div class="flex flex-col items-center"><div class="flex flex-col mt-2 p-14 rounded-3xl space-y-4 border">
    <div class="flex flex-row">
        <p class="w-28">Jenis</p>
        <p class="mr-2">:</p>
        <p>' . $row['jenis'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Daya Lampu</p>
        <p class="mr-2">:</p>
        <p>' . $row['daya_lampu'] . ' watt</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Masa Pakai</p>
        <p class="mr-2">:</p>
        <p>' . $row['masa_pakai'] . ' jam</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Lumen</p>
        <p class="mr-2">:</p>
        <p>' . $row['lumen'] . ' lm</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Tegangan</p>
        <p class="mr-2">:</p>
        <p>' . $row['tegangan'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Warna Cahaya</p>
        <p class="mr-2">:</p>
        <p>' . $row['warna_cahaya'] . '</p>
    </div>
</div>
<a href="ubah_lampu.php?id_ubah=' . $row['id_lampu'] . '" class="mt-6 w-4/5">
<button type="button" class="bg-violet-600 w-full px-4 py-2 rounded-md text-white hover:bg-violet-800 duration-150 delay-75">Ubah</button>
</a>
</div>
';



    $lampu->close();

    $tpl = new Template("templates/spek_lampu.html");
    $tpl->replace("DATA_LAMPU", $data);
    $tpl->write();
  

?>