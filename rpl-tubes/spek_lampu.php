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
    $data .= '<div class="flex flex-col mt-2 px-8 py-10 rounded-md space-y-2 border">
    <div class="flex flex-row">
        <p class="w-28">Jenis</p>
        <p class="mr-2">:</p>
        <p>' . $row['jenis'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Daya Lampu</p>
        <p class="mr-2">:</p>
        <p>' . $row['daya_lampu'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Masa Pakai</p>
        <p class="mr-2">:</p>
        <p>' . $row['masa_pakai'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Lumen</p>
        <p class="mr-2">:</p>
        <p>' . $row['lumen'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Volt</p>
        <p class="mr-2">:</p>
        <p>' . $row['volt'] . '</p>
    </div>

    <div class="flex flex-row">
        <p class="w-28">Warna Cahaya</p>
        <p class="mr-2">:</p>
        <p>' . $row['warna_cahaya'] . '</p>
    </div>
</div>
<a href="#" class="mt-6 w-1/5">
<button type="button" class="bg-violet-500 w-full px-4 py-2 rounded-md text-white hover:bg-violet-700 duration-150 delay-75">Ubah</button>
</a>
';



    $lampu->close();

    $tpl = new Template("templates/spek_lampu.html");
    $tpl->replace("DATA_LAMPU", $data);
    $tpl->write();
  

?>