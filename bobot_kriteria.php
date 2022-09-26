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
        $query1 = "SELECT * FROM Penilaian_kriteria";
        $hasil_query1 = mysqli_query($link, $query1);
        while($data1 = mysqli_fetch_array($hasil_query1)){
            if ($ket_kriteria1===$data1['kriteria_1'] AND $ket_kriteria2===$data1['kriteria_2']){
                $pesan_error .= "Nama Kriteria 1 dan Kriteria 2 yang sama sudah ada pada data!";
            }
        }

        if ($ket_kriteria1==="---Pilih Kriteria 1---") {
            $pesan_error .= "Nama kriteria 1 belum dipilih<br>";
        }

        if ($ket_kriteria2==="---Pilih Kriteria 2---") {
            $pesan_error .= "Nama kriteria 2 belum dipilih<br>";
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
            default : $pesan_error = "Nilai perbandingan belum dipilih<br>"; break;
        }
        
        if ($pesan_error === "") {
            $id_nilai_kriteria = mysqli_real_escape_string($link, $id_nilai_kriteria);
            $ket_kriteria1 = mysqli_real_escape_string($link, $ket_kriteria1);
            $ket_kriteria2 = mysqli_real_escape_string($link, $ket_kriteria2);
            $nilai = mysqli_real_escape_string($link, $nilai);
            
            $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
            $hasil_query = mysqli_query($link, $query);
            if (!$hasil_query) {
                die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
            while($data = mysqli_fetch_array($hasil_query)){
                if ($ket_kriteria1 == $data['ket_kriteria']) {
                    $id_kriteria1 = $data['ID_kriteria'];
                }
            }

            $query = "INSERT INTO Penilaian_kriteria VALUES ('$id_nilai_kriteria', '$id_kriteria1', '$ket_kriteria1', '$ket_kriteria2', '$nilai')";
            $result = mysqli_query($link, $query);
            if ($result){
                $pesan = "Nilai perbandingan kriteria berhasil ditambahkan!";
                $pesan = urlencode($pesan);
                header("Location: bobot_kriteria.php?pesan={$pesan}");
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
        $select_nilai1=""; $select_nilai2=""; $select_nilai3=""; $select_nilai4="";
        $select_nilai5=""; $select_nilai6=""; $select_nilai7=""; $select_nilai8=""; $select_nilai9="";
    }

    if (isset($_POST["hapus"])) {
        $id_nilai_kriteria = htmlentities(strip_tags(trim($_POST["ID_nilai_kriteria"])));
        $id_nilai_kriteria = mysqli_real_escape_string($link, $id_nilai_kriteria);
        $query = "DELETE FROM Penilaian_kriteria WHERE ID_nilai_kriteria='$id_nilai_kriteria'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            $pesan = "Penilaian kriteria sudah berhasil dihapus";
            $pesan = urlencode($pesan);
            header("Location: bobot_kriteria.php?pesan={$pesan}");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }

    if (isset($_POST["edit"])) {
        $id_nilai_kriteria = htmlentities(strip_tags(trim($_POST["ID_nilai_kriteria"])));
        $id_nilai_kriteria = mysqli_real_escape_string($link, $id_nilai_kriteria);
        $query = "SELECT * FROM Penilaian_kriteria WHERE ID_nilai_kriteria='$id_nilai_kriteria'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            header("Location: edit_nilai_kriteria.php");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }

    $query = "SELECT max(ID_nilai_kriteria) as IDterbesar FROM Penilaian_kriteria";
    $hasil_query = mysqli_query($link, $query);
    $data = mysqli_fetch_array($hasil_query);
    $id_nilai_kriteria = $data['IDterbesar'];
    $urutan = (int) substr($id_nilai_kriteria, 3, 3);
    $urutan++;
    $huruf = "KN";
    $id_nilai_kriteria = $huruf . sprintf("%03s", $urutan);
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Bobot Kriteria</span>
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
                <div class="title1">Nilai Perbandingan Kriteria</div>
                <div>
                    <?php
                        if (isset($pesan)) {
                            echo "<div class=\"pesan\">$pesan</div>";
                        }
                    ?>
                </div>

                <div class="overview-boxes1">
                    <div class="box11">
                        <div class="subbox11">
                            <div class="title2">Tambah Nilai Perbandingan Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                        }
                                ?>
                            </div>
                            <form id="form_nilai_kriteria" action="bobot_kriteria.php" method="post">
                                <table class="tabel6">
                                    <tr>
                                        <td>ID Nilai</td>
                                        <td><input type="text" name="ID_nilai_kriteria" id="ID_nilai_kriteria" value="<?php echo $id_nilai_kriteria ?>" readonly></td>
                                        <td>
                                            <select name="ket_kriteria1" id="ket_kriteria1">
                                                <option>---Pilih Kriteria 1---</option>
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
                                                <option>---Pilih Nilai---</option>
                                                <option value="1" <?php echo $select_nilai1 ?>>1 - sama penting dengan</option>
                                                <option value="2" <?php echo $select_nilai2 ?>>2 - mendekati sedikit lebih penting dari</option>
                                                <option value="3" <?php echo $select_nilai3 ?>>3 - sedikit lebih penting dari</option>
                                                <option value="4" <?php echo $select_nilai4 ?>>4 - mendekati lebih penting dari</option>
                                                <option value="5" <?php echo $select_nilai5 ?>>5 - lebih penting dari</option>
                                                <option value="6" <?php echo $select_nilai6 ?>>6 - mendekati sangat penting dari</option>
                                                <option value="7" <?php echo $select_nilai7 ?>>7 - sangat penting dari</option>
                                                <option value="8" <?php echo $select_nilai8 ?>>8 - mendekati mutlak sangat penting dari</option>
                                                <option value="9" <?php echo $select_nilai9 ?>>9 - mutlak sangat penting dari</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="ket_kriteria2" id="ket_kriteria2">
                                                <option>---Pilih Kriteria 2---</option>
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
                                <input type="submit" name="tambah" value="Tambah" class="button">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="overview-boxes1">
                    <div class="box11">
                        <table class="tabel1">
                            <tr>
                                <th width="20%">ID Nilai</th>
                                <th width="20%">Kriteria 1</th>
                                <th width="20%">Nilai Perbandingan</th>
                                <th width="20%">Kriteria 2</th>
                                <th width="10%">Edit</th>
                                <th width="10%">Hapus</th>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian_kriteria ORDER BY ID_nilai_kriteria ASC";
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID_nilai_kriteria]</td>";
                                    echo "<td>$data[kriteria_1]</td>";
                                    echo "<td>$data[nilai]</td>";
                                    echo "<td>$data[kriteria_2]</td>";
                                    echo "<td>";
                            ?>
                            <form action="edit_nilai_kriteria.php" method="post">
                                <input type="hidden" name="ID_nilai_kriteria" value="<?php echo "$data[ID_nilai_kriteria]"; ?>">
                                <center>
                                    <button type="submit" name="submit" value="Edit">
                                        <i class='bx bx-edit-alt'></i>
                                    </button>
                                </center>
                            </form>
                            <?php
                                    echo "</td>";
                                    echo "<td>";
                            ?>
                            <form action="bobot_kriteria.php" method="post">
                                <input type="hidden" name="ID_nilai_kriteria" value="<?php echo "$data[ID_nilai_kriteria]"; ?>">
                                <center>    
                                    <button type="submit" name="hapus">
                                        <i class='bx bxs-trash'></i>
                                    </button> 
                                </center>
                            </form>
                            <?php
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>

                <div class="overview-boxes1">
                    <div class="box11">
                    <table class="tabel5">
                            <tr>
                                <?php
                                    $query = "SELECT * FROM Kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                    $i=0; $j=1;
                                    $namakriteria = array();
                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                        $hasil = $datakriteria['ket_kriteria'];
                                        $namakriteria[$i][$j] = $hasil;
                                        $j++;
                                    }
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th>Kriteria</th>";
                                        }else{
                                            echo "<th>".$namakriteria[$i][$j]."</th>";
                                        }
                                    }
                                    
                                    $query = "SELECT * FROM Penilaian_kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdatanilai = mysqli_num_rows($hasil_query);
                                ?>
                            </tr>
                            <?php
                                $totalkolom = array();
                                $k=1;
                                for ($j=1; $j<=$jumlahdata; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$namakriteria[$i][$j]."</th>";
                                    for ($m=1; $m<=$jumlahdata; $m++){
                                        echo "<td>";
                                            $query = "SELECT * FROM Penilaian_kriteria";
                                            $hasil_query = mysqli_query($link, $query);
                                            while ($data = mysqli_fetch_assoc($hasil_query)) {
                                                if ($data['kriteria_1'] == $namakriteria[$i][$j] AND $data['kriteria_2'] == $namakriteria[$i][$m]) {
                                                    $a = $data['nilai'];
                                                    echo $a;
                                                }
                                                else if ($data['kriteria_1'] == $namakriteria[$i][$m] AND $data['kriteria_2'] == $namakriteria[$i][$j]) {
                                                    $a = round(1 / $data['nilai'], 3);
                                                    echo $a;
                                                }
                                            }
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <script src="script.js"></script>
    </body>
</html>