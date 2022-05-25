<?php

    session_start(); // Start sessionnya

    if (!isset($_SESSION['username'])) {
      header("location: index.php");
    }

    include("config.php");
    include("includes/Template.class.php");
    include("includes/DB.class.php");
    include("includes/Akun.class.php");

    $akun = new Akun($db_host, $db_user, $db_pass, $db_name);
    $akun->open();
    $akun->getAkun();

    $data = null;

    $row = $akun->getResult();
    $data .= '<img src="img/default_profile.jpg" class="w-1/5" alt="">
    <div class="flex flex-col mt-7 p-4 rounded-md border">
        <div class="flex flex-row mb-2">
            <p class="w-28">Username</p>
            <p class="mr-2">:</p>
            <p>' . $row['username'] . '</p>
        </div>

        <div class="flex flex-row">
            <p class="w-28">Password</p>
            <p class="mr-2">:</p>
            <p>' . $row['password'] . '</p>
        </div>
    </div>';



    $akun->close();

    $tpl = new Template("templates/info_akun.html");
    $tpl->replace("DATA_AKUN", $data);
    $tpl->write();
  

?>