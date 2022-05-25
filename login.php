<?php

    // start session
    session_start();
    include("config.php");
    include("includes/DB.class.php");
    include("includes/Template.class.php");

    //cek apakah ada cookie
    if (!isset($_COOKIE['message'])) {
        $data = "";
    }else {
        $data = $_COOKIE['message'];
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username != '' && $password != ''){

            // Buat query untuk mengecek apakah ada data user dengan username dan password yang dikirim dari form
            $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
            $query = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($query); // Ambil data dari hasil query
        
            if(mysqli_num_rows($query) < 1){
                // Buat sebuah cookie untuk menampung data pesan kesalahan
                setcookie("message", "Maaf, Username atau Password salah", time()+10);
                header("location: login.php");
            }
            else{
                echo $data['username'] . $data['password'];
        
                $_SESSION['username'] = $data['username']; // Set session username dan isi dari data username
                // $_SESSION['nama'] = $data['nama_mhs']; // Set session nama dan isi dari data nama
        
                // setcookie("message", "", time()-60); //delete cookie message
                header("location: index.php"); // redirect ke halaman welcome.php
            }
        }
        else{
            setcookie("message", "Username atau Password kosong", time()+10);
            header("location: login.php"); // redirect kembali ke halaman login.php
        }

    }

    $tpl = new Template("templates/login.html");
    $tpl->replace("DATA_PESAN_ERROR", $data);
    $tpl->write();

?>