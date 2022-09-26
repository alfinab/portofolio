<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $link = mysqli_connect($dbhost, $dbuser, $dbpass);

    if (!$link) {
        die ("Koneksi dengan database gagal : ".mysqli_connect_errno()." - ".mysqli_connect_error());
    }

    $query = "DROP DATABASE IF EXISTS SPK_Pariwisata";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Database <b>'SPK_Pariwisata'</b> berhasil dihapus! <br>";
    }

    //buat database SPK_Pariwisata jika belum ada
    $query = "CREATE DATABASE IF NOT EXISTS SPK_Pariwisata";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Database <b>'SPK_Pariwisata'</b> berhasil dibuat! <br>";
    }

    //pilih database SPK_Pariwisata
    $result = mysqli_select_db($link, "SPK_Pariwisata");

    if (!$result) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link)); 
    }
    else {
        echo "Database 'SPK_Pariwisata' berhasil dipilih! <br>";
    }

    //buat Tabel Pengguna
    $query = "DROP TABLE IF EXISTS Pengguna";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Pengguna'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Pengguna (username VARCHAR(50) NOT NULL, password CHAR(40) NOT NULL, ID CHAR(8) NOT NULL, roles VARCHAR(50) NOT NULL, PRIMARY KEY (ID))";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Pengguna'</b> berhasil dibuat! <br>";
    }

    //buat username dan password untuk admin
    $username = "admin1234";
    $password = "1234567890";
    $id = "USER001";
    $roles = "Admin";

    $query = "INSERT INTO Pengguna VALUES ('$username', '$password', '$id', '$roles')";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Tabel <b>'Pengguna'</b> berhasil diisi!<br>";
    }

    //buat tabel kriteria
    $query = "DROP TABLE IF EXISTS Kriteria";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Kriteria'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Kriteria (ID_kriteria CHAR(8) NOT NULL, ket_kriteria VARCHAR(50) NOT NULL, atribut VARCHAR(50) NOT NULL, PRIMARY KEY (ID_kriteria))";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Kriteria'</b> berhasil dibuat! <br>";
    }

    $query = "DROP TABLE IF EXISTS Penilaian_Kriteria";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Penilaian_Kriteria'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Penilaian_Kriteria (ID_nilai_kriteria CHAR(8) NOT NULL, ID_kriteria1 CHAR(8) NOT NULL, kriteria_1 VARCHAR(50) NOT NULL, kriteria_2 VARCHAR(50) NOT NULL, nilai FLOAT NOT NULL, PRIMARY KEY (ID_nilai_kriteria), FOREIGN KEY (ID_kriteria1) REFERENCES Kriteria (ID_kriteria) ON DELETE CASCADE)";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Penilaian_Kriteria'</b> berhasil dibuat! <br>";
    }

    //buat tabel formulir
    $query = "DROP TABLE IF EXISTS Formulir";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Formulir'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Formulir (ID_pariwisata CHAR(8) NOT NULL, nama VARCHAR(50) NOT NULL, jenis_wisata VARCHAR(50) NOT NULL, PRIMARY KEY (ID_pariwisata))";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Formulir'</b> berhasil dibuat! <br>";
    }
    
    //buat tabel penilaian
    $query = "DROP TABLE IF EXISTS Penilaian";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Penilaian'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Penilaian (ID_penilaian CHAR(8) NOT NULL, nama_pariwisata VARCHAR(50) NOT NULL, IDpariwisata CHAR(8) NOT NULL, PRIMARY KEY (ID_penilaian), FOREIGN KEY (IDpariwisata) REFERENCES Formulir (ID_pariwisata) ON DELETE CASCADE)";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Penilaian'</b> berhasil dibuat! <br>";
    }

    //buat tabel konversi nilai
    $query = "DROP TABLE IF EXISTS Konversi_nilai";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Konversi_nilai'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Konversi_nilai (ID CHAR(8) NOT NULL, ID_kriteria VARCHAR(50) NOT NULL, sub_kriteria VARCHAR(100) NOT NULL, nilai CHAR(8) NOT NULL, PRIMARY KEY (ID), FOREIGN KEY (ID_kriteria) REFERENCES Kriteria (ID_kriteria) ON DELETE CASCADE)";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Konversi_nilai'</b> berhasil dibuat! <br>";
    }

    //buat tabel nilai pariwisata
    $query = "DROP TABLE IF EXISTS Nilai_pariwisata";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Nilai_pariwisata'</b> berhasil dihapus! <br>";
    }

    $query = "CREATE TABLE Nilai_pariwisata (ID_penilaian CHAR(8) NOT NULL, ID_kriteria VARCHAR(100) NOT NULL, sub_kriteria VARCHAR(100) NOT NULL, FOREIGN KEY (ID_penilaian) REFERENCES Penilaian (ID_penilaian) ON DELETE CASCADE)";
    $hasil_query = mysqli_query($link, $query);

    if (!$hasil_query) {
        die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    else {
        echo "Table <b>'Nilai_pariwisata'</b> berhasil dibuat! <br>";
    }
?>