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

    // UPDATE DATA LAMPU
    if (isset($_POST['btn-update'])) {
        $id_lampu = $_GET['id_ubah'];
        if ($lampu->update($id_lampu, $_POST) > 0) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'spek_lampu.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'spek_lampu.php';
            </script>";
        }
    }

    // REPLACE DATA LAMPU
    if (isset($_GET['id_ubah'])) {
        $id_lampu = $_GET['id_ubah'];
    
        if ($id_lampu > 0) {
            $lampu->getLampuUpdate($id_lampu);
            $row = $lampu->getResult();
            
            $lampu->getLampuUpdate($id_lampu);
            
            $dataLampu = [];
            $dataLampu[0] = $row['jenis'];
            $dataLampu[1] = $row['daya_lampu'];
            $dataLampu[2] = $row['masa_pakai'];
            $dataLampu[3] = $row['lumen'];
            $dataLampu[4] = $row['volt'];
            $dataLampu[5] = $row['warna_cahaya'];
        }
    }

    $lampu->close();

    $tpl = new Template("templates/ubah_lampu.html");
    $tpl->replace("DATA_JENIS", $dataLampu[0]);
    $tpl->replace("DATA_DAYA", $dataLampu[1]);
    $tpl->replace("DATA_MASA_PAKAI", $dataLampu[2]);
    $tpl->replace("DATA_LUMEN", $dataLampu[3]);
    $tpl->replace("DATA_VOLT", $dataLampu[4]);
    $tpl->replace("DATA_WARNA_CAHAYA", $dataLampu[5]);
    $tpl->write();



?>