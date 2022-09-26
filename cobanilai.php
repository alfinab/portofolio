<?php
    session_start();
    if (!isset($_SESSION["username"])){
        header("Location: login.php");
    }

    include("connection.php");
    $roles = $_SESSION["roles"];

    include("header.php");
    if (isset($_GET["pesan"])) {
        $pesan = $_GET["pesan"];
    }

    if (isset($_POST["tambah"])){
        $id_nilai_kriteria = htmlentities(strip_tags(trim($_POST["ID_nilai_kriteria"])));
        $ket_kriteria1 = htmlentities(strip_tags(trim($_POST["ket_kriteria1"])));
        $ket_kriteria2 = htmlentities(strip_tags(trim($_POST["ket_kriteria2"])));
        $nilai = htmlentities(strip_tags(trim($_POST["nilai"])));

        $pesan_error = "";
        if (empty($id_nilai_kriteria)) {
            $pesan_error .= "ID belum diisi<br>";
        }

        $select1="";
        switch($ket_kriteria1) {
            case "Luas" : $select1 = "selected"; break;
            case "Biaya" : $select1 = "selected"; break;
            case "Minat Pengunjung" : $select1 = "selected"; break;
            case "Fasilitas" : $select1 = "selected"; break;
            case "Minat Masyarakat" : $select1 = "selected"; break;
        }
        $select2="";
        switch($ket_kriteria2) {
            case "Luas" : $select2 = "selected"; break;
            case "Biaya" : $select2 = "selected"; break;
            case "Minat Pengunjung" : $select2 = "selected"; break;
            case "Fasilitas" : $select2 = "selected"; break;
            case "Minat Masyarakat" : $select2 = "selected"; break;
        }

        $select_nilai1=""; $select_nilai2=""; $select_nilai3=""; $select_nilai4="";
        $select_nilai5=""; $select_nilai6=""; $select_nilai7=""; $select_nilai8=""; $select_nilai9="";
        switch($nilai) {
            case "1" : $select_nilai1 = "selected"; break;
            case "2" : $select_nilai2 = "selected"; break;
            case "3" : $select_nilai3 = "selected"; break;
            case "4" : $select_nilai4 = "selected"; break;
            case "5" : $select_nilai5 = "selected"; break;
            case "6" : $select_nilai6 = "selected"; break;
            case "7" : $select_nilai7 = "selected"; break;
            case "8" : $select_nilai8 = "selected"; break;
            case "9" : $select_nilai9 = "selected"; break;
        }

        if ($pesan_error === "") {
            $id_nilai_kriteria = mysqli_real_escape_string($link, $id_nilai_kriteria);
            $ket_kriteria1 = mysqli_real_escape_string($link, $ket_kriteria1);
            $ket_kriteria2 = mysqli_real_escape_string($link, $ket_kriteria2);
            $nilai = mysqli_real_escape_string($link, $nilai);
            
            $query = "INSERT INTO Penilaian_kriteria VALUES ('$id_nilai_kriteria', '$ket_kriteria1', '$ket_kriteria2', '$nilai')";
            $result = mysqli_query($link, $query);

            if ($result){
                $pesan = "Nilai perbandingan priteria berhasil ditambahkan!";
                $pesan = urlencode($pesan);
                header("Location: cobanilai.php?pesan={$pesan}");
            }
            else {
                die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_error = "";
        $id_nilai_kriteria = "";
        $nilai = "";
        $ket_kriteria1 = "";
        $ket_kriteria2 = "";
        $select1 = "";
        $select2 = "";
        $select_nilai1=""; $select_nilai2=""; $select_nilai3=""; $select_nilai4="";
        $select_nilai5=""; $select_nilai6=""; $select_nilai7=""; $select_nilai8=""; $select_nilai9="";
    }
    
    $query = "SELECT * FROM Penilaian_kriteria";
?>
        <!-- home content -->
            <div class="home-content">
                <div class="title1">Nilai Perbandingan Kriteria</div>
                <div>
                    <?php
                        if (isset($pesan)) {
                            echo "<div class=\"pesan\">$pesan</div>";
                        }
                    ?>
                </div>
                <div class="overview-boxes1">
                    <div class="box9">
                        <table class="tabel1">
                            <tr>
                                <th>Kriteria</th>
                                <th>Luas</th>
                                <th>Biaya</th>
                                <th>Minat Pengunjung</th>
                                <th>Fasilitas</th>
                                <th>Minat Masyarakat</th>
                            </tr>
                            <tr>
                                <th>Luas</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Biaya</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Minat Pengunjung</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Fasilitas</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Minat Masyarakat</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="box10">
                        <div>
                            <div class="title2">Tambah Nilai Perbandingan Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_nilai_kriteria" action="cobanilai.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID Nilai</td>
                                        <td><input type="text" name="ID_nilai_kriteria" id="ID_nilai_kriteria" value="<?php echo $id_nilai_kriteria ?>" placeholder="Contoh: KN01"></td>
                                    </tr>
                                    <tr>
                                        <td>Kriteria 1</td>
                                        <td>
                                            <select name="ket_kriteria1" id="ket_kriteria1">
                                                <option>----Pilih Kriteria 1----</option>
                                                <?php 
                                                    $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
                                                    $hasil_query = mysqli_query($link, $query);
                                                    if (!$hasil_query) {
                                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                    }
                    
                                                    while ($data = mysqli_fetch_assoc($hasil_query)) {
                                                ?>
                                                <option <?php echo $select1 ?>><?php echo $data['ket_kriteria'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai Perbandingan</td>
                                        <td>
                                            <select name="nilai" id="nilai">
                                                <option>----Pilih Nilai----</option>
                                                <option <?php echo $select_nilai1 ?>>1</option>
                                                <option <?php echo $select_nilai2 ?>>2</option>
                                                <option <?php echo $select_nilai3 ?>>3</option>
                                                <option <?php echo $select_nilai4 ?>>4</option>
                                                <option <?php echo $select_nilai5 ?>>5</option>
                                                <option <?php echo $select_nilai6 ?>>6</option>
                                                <option <?php echo $select_nilai7 ?>>7</option>
                                                <option <?php echo $select_nilai8 ?>>8</option>
                                                <option <?php echo $select_nilai9 ?>>9</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kriteria 2</td>
                                        <td>
                                            <select name="ket_kriteria2" id="ket_kriteria2">
                                                <option>----Pilih Kriteria 2----</option>
                                                <?php 
                                                    $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
                                                    $hasil_query = mysqli_query($link, $query);
                                                    if (!$hasil_query) {
                                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                    }
                    
                                                    while ($data = mysqli_fetch_assoc($hasil_query)) {
                                                ?>
                                                <option <?php echo $select2 ?>><?php echo $data['ket_kriteria'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <input type="submit" name="tambah" value="Tambah" class="button">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <script src="script.js"></script>
    </body>
</html>