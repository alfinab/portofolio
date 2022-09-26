<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "SPK_Pariwisata";
    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(!$link) {
        die ("Koneksi dengan database gagal: ".mysqli_connect_errno()." - ".mysqli_connect_error());
    }
?>