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
            $id = htmlentities(strip_tags(trim($_POST["ID"])));
            $id = mysqli_real_escape_string($link, $id);
            $query = "SELECT * FROM Konversi_nilai WHERE ID='$id'";
            $result = mysqli_query($link, $query);

            if (!$result) {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }

            $data = mysqli_fetch_assoc($result);

            $id = $data["ID"];
            $id_kriteria = $data["ID_kriteria"];
            $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
            $hasil_query = mysqli_query($link, $query);
            while($datakriteria = mysqli_fetch_array($hasil_query)){
                if ($id_kriteria == $datakriteria['ID_kriteria']) {
                    $ket_kriteria = $datakriteria["ket_kriteria"];
                }
            }
            $sub_kriteria = $data["sub_kriteria"];
            $nilai = $data["nilai"];

            mysqli_free_result($result);
        }
        else if ($_POST["submit"]=="Update") {
            $id = htmlentities(strip_tags(trim($_POST["ID"])));
            $ket_kriteria = htmlentities(strip_tags(trim($_POST["ket_kriteria"])));
            $sub_kriteria = htmlentities(strip_tags(trim($_POST["sub_kriteria"])));
            $nilai = htmlentities(strip_tags(trim($_POST["nilai"])));
        }

        $pesan_error="";
        if (empty($ket_kriteria)) {
            $pesan_error .= "Keterangan kriteria belum diisi <br>";
        }
    
        if (($pesan_error === "") AND ($_POST["submit"]=="Update")) {
            include("connection.php");
            $id = mysqli_real_escape_string($link, $id);
            $ket_kriteria = mysqli_real_escape_string($link, $ket_kriteria);
            $sub_kriteria = mysqli_real_escape_string($link, $sub_kriteria);
            $nilai = mysqli_real_escape_string($link, $nilai);

            $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
            $hasil_query = mysqli_query($link, $query);
            if (!$hasil_query) {
                die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
            while($datakriteria = mysqli_fetch_array($hasil_query)){
                if ($ket_kriteria == $datakriteria['ket_kriteria']) {
                    $id_kriteria = $datakriteria['ID_kriteria'];
                }
            }

            $query = "UPDATE Konversi_nilai SET ID = '$id', ID_kriteria = '$id_kriteria', sub_kriteria = '$sub_kriteria', nilai = '$nilai' WHERE ID = '$id'";

            $result = mysqli_query($link, $query);
    
            if ($result) {
                $pesan = "Konversi nilai sub kriteria sudah berhasil di update";
                $pesan = urlencode($pesan);
                header("Location: konversi_subkriteria.php?pesan={$pesan}");
            }
            else {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
        }
    }
    else {
        header("Location: input_kriteria.php");
    }
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Konversi Nilai Sub Kriteria</span>
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
                <div class="title1">Edit Konversi Nilai Sub Kriteria</div>
                <div>
                    <?php
                        if (isset($pesan)) {
                            echo "<div class=\"pesan\">$pesan</div>";
                        }
                    ?>
                </div>
                <div class="overview-boxes1">
                    
                    <div class="box10">
                        <div>
                            <div class="title2">Edit Nilai Konversi Sub Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_kriteria" action="edit_subkriteria.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID</td>
                                        <td><input type="text" name="ID" id="ID" value="<?php echo $id ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Kriteria</td>
                                        <td>
                                            <select name="ket_kriteria" id="ket_kriteria">
                                                <option>---Pilih Kriteria---</option>
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
                                                        if ($dataarray[$row][$col] == $ket_kriteria) {
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
                                    <tr>
                                        <td>Sub Kriteria</td>
                                        <td><input type="text" name="sub_kriteria" id="sub_kriteria" value="<?php echo $sub_kriteria ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Nilai Konversi</td>
                                        <td><input type="text" name="nilai" id="nilai" value="<?php echo $nilai ?>"></td>
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
<?php
    ob_end_flush();
?>