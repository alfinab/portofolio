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

    if (isset($_POST["submit"])){
        if ($_POST["submit"]=="Edit") {
            $id_nilai_kriteria = htmlentities(strip_tags(trim($_POST["ID_nilai_kriteria"])));
            $id_nilai_kriteria = mysqli_real_escape_string($link, $id_nilai_kriteria);
            $query = "SELECT * FROM Penilaian_kriteria WHERE ID_nilai_kriteria='$id_nilai_kriteria'";
            $result = mysqli_query($link, $query);

            if (!$result) {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }   

            $data = mysqli_fetch_assoc($result);

            $id_nilai_kriteria = $data["ID_nilai_kriteria"];
            $ket_kriteria1 = $data["kriteria_1"];
            $ket_kriteria2 = $data["kriteria_2"];
            $nilai = $data["nilai"];

            mysqli_free_result($result);
        }
        else if ($_POST["submit"]=="Update") {
            $id_nilai_kriteria = htmlentities(strip_tags(trim($_POST["ID_nilai_kriteria"])));
            $ket_kriteria1 = htmlentities(strip_tags(trim($_POST["ket_kriteria1"])));
            $ket_kriteria2 = htmlentities(strip_tags(trim($_POST["ket_kriteria2"])));
            $nilai = htmlentities(strip_tags(trim($_POST["nilai"])));
        }

        $pesan_error = "";
        if (empty($id_nilai_kriteria)) {
            $pesan_error .= "ID belum diisi<br>";
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
    
        if (($pesan_error === "") AND ($_POST["submit"]=="Update")) {
            include("connection.php");
            $id_nilai_kriteria = mysqli_real_escape_string($link, $id_nilai_kriteria);
            $ket_kriteria1 = mysqli_real_escape_string($link, $ket_kriteria1);
            $ket_kriteria2 = mysqli_real_escape_string($link, $ket_kriteria2);
            $nilai = mysqli_real_escape_string($link, $nilai);
        
            $query = "UPDATE Penilaian_kriteria SET ID_nilai_kriteria = '$id_nilai_kriteria', kriteria_1 = '$ket_kriteria1', kriteria_2 = '$ket_kriteria2', nilai = '$nilai' WHERE ID_nilai_kriteria = '$id_nilai_kriteria'";
            $result = mysqli_query($link, $query);
            if ($result) {
                $pesan = "Nilai perbandingan kriteria sudah berhasil di update";
                $pesan = urlencode($pesan);
                header("Location: bobot_kriteria.php?pesan={$pesan}");
            }
            else {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
        }
    }
    else {
        header("Location: bobot_kriteria.php");
    }
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Edit Nilai Kriteria</span>
                </div>
                <div class="title">
                    Sistem Pendukung Keputusan
                </div>
                <div>
                    <table>
                        <tr>
                            <td>
                                <div class="profile-details">
                                    <i class='bx bxs-user-account'></i>
                                    <span class="admin_name"><?php echo "$roles" ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="profile-details">
                                    <a href="logout.php">
                                        <i class='bx bx-log-out'></i>
                                    </a>
                                    <span class="admin_name">Log Out</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </nav>
            <div class="home-content">
                <div class="title1">Edit Nilai Perbandingan Kriteria</div>
                <div class="overview-boxes1">
                    <div class="box11">
                        <div class="subbox11">
                            <div class="title2">Edit Nilai Perbandingan Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                        }
                                ?>
                            </div>
                            <form id="form_edit_nilai_kriteria" action="edit_nilai_kriteria.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID Nilai</td>
                                        <td><input type="text" name="ID_nilai_kriteria" id="ID_nilai_kriteria" value="<?php echo $id_nilai_kriteria; ?>" readonly></td>
                                        <td>
                                            <select name="ket_kriteria1" id="ket_kriteria1">
                                                <option>----Pilih Kriteria 1----</option>
                                                <?php 
                                                    $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
                                                    $hasil_query = mysqli_query($link, $query);
                                                    if (!$hasil_query) {
                                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                    }
                                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                                    $i = 0; $j=1;
                                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                                        $hasil = $datakriteria['ket_kriteria'];
                                                        $dataarray[$i][$j] = $hasil;
                                                        $j++;
                                                    }
                                                    $row = 0;
                                                    for ($col = 1; $col <= $jumlahdata; $col++) {
                                                        if ($dataarray[$row][$col] == $ket_kriteria1) {
                                                            echo "<option selected>{$dataarray[$row][$col]}</option>";
                                                        }
                                                        else {
                                                            echo "<option>{$dataarray[$row][$col]}</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="nilai" id="nilai">
                                                <option>----Pilih Nilai----</option>
                                                <option value="1" <?php echo $select_nilai1 ?>>1 - sama penting dengan</option>
                                                <option value="2" <?php echo $select_nilai2 ?>>2 - mendekati sedikit lebih penting dari</option>
                                                <option value="3" <?php echo $select_nilai3 ?>>3 - sedikit lebih penting dari</option>
                                                <option value="4" <?php echo $select_nilai4 ?>>4 - mendekati lebih penting dari</option>
                                                <option value="5" <?php echo $select_nilai5 ?>>5 - lebih penting dari</option>
                                                <option value="6" <?php echo $select_nilai6 ?>>6 - mendekati sangat penting dari</option>
                                                <option value="7" <?php echo $select_nilai7 ?>>7 - sangat penting dari</option>
                                                <option value="8" <?php echo $select_nilai8 ?>>8 - mendekati mutlak dari</option>
                                                <option value="9" <?php echo $select_nilai9 ?>>9 - mutlak sangat penting dari</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="ket_kriteria2" id="ket_kriteria2">
                                                <option>----Pilih Kriteria 2----</option>
                                                <?php 
                                                    $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
                                                    $hasil_query = mysqli_query($link, $query);
                                                    if (!$hasil_query) {
                                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                    }
                                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                                    $i = 0; $j=1;
                                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                                        $hasil = $datakriteria['ket_kriteria'];
                                                        $dataarray[$i][$j] = $hasil;
                                                        $j++;
                                                    }
                                                    $row = 0;
                                                    for ($col = 1; $col <= $jumlahdata; $col++) {
                                                        if ($dataarray[$row][$col] == $ket_kriteria2) {
                                                            echo "<option selected>{$dataarray[$row][$col]}</option>";
                                                        }
                                                        else {
                                                            echo "<option>{$dataarray[$row][$col]}</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <input type="submit" name="submit" value="Update" class="button">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="script.js"></script>
    </body>
</html>