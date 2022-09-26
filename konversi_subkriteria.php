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
        $id = htmlentities(strip_tags(trim($_POST["ID"])));
        $ket_kriteria = htmlentities(strip_tags(trim($_POST["ket_kriteria"])));
        $sub_kriteria = htmlentities(strip_tags(trim($_POST["sub_kriteria"])));
        $nilai = htmlentities(strip_tags(trim($_POST["nilai"])));

        $pesan_error = "";
        $id = mysqli_real_escape_string($link, $id);
        $query = "SELECT * FROM Konversi_nilai WHERE sub_kriteria='$sub_kriteria'";
        $hasil_query = mysqli_query($link, $query);
        $jumlah_data = mysqli_num_rows($hasil_query);
        if ($jumlah_data >= 1) {
            $pesan_error .= "Sub kriteria yang sama sudah ada<br>";
        }

        if ($ket_kriteria==="---Pilih Kriteria---") {
            $pesan_error .= "Nama kriteria belum dipilih <br>";
        }

        if (empty($sub_kriteria)) {
            $pesan_error .= "Sub kriteria belum diisi <br>";
        }

        if (empty($nilai)) {
            $pesan_error .= "Nilai Konversi belum diisi <br>";
        }

        if ($pesan_error === "") {
            $id = mysqli_real_escape_string($link, $id);
            $ket_kriteria = mysqli_real_escape_string($link, $ket_kriteria);
            $sub_kriteria = mysqli_real_escape_string($link, $sub_kriteria);
            $nilai = mysqli_real_escape_string($link, $nilai);

            $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
            $hasil_query = mysqli_query($link, $query);
            if (!$hasil_query) {
                die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
            while($data = mysqli_fetch_array($hasil_query)){
                if ($ket_kriteria == $data['ket_kriteria']) {
                    $id_kriteria = $data['ID_kriteria'];
                }
            }
            $query = "INSERT INTO Konversi_nilai VALUES ('$id', '$id_kriteria', '$sub_kriteria', '$nilai')";
            $result = mysqli_query($link, $query);

            if ($result){
                $pesan = "Konversi Nilai Sub Kriteria berhasil ditambahkan!";
                $pesan = urlencode($pesan);
                header("Location:konversi_subkriteria.php?pesan={$pesan}");
            }
            else {
                die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_error = "";
        $id = "";
        $ket_kriteria = "";
        $sub_kriteria = "";
        $nilai = "";
    }
    
    if (isset($_POST["hapus"])) {
        $id = htmlentities(strip_tags(trim($_POST["ID"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "DELETE FROM Konversi_nilai WHERE ID='$id'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            $pesan = "Konversi Nilai Sub Kriteria dengan ID '<b>$id</b>' sudah berhasil dihapus!";
            $pesan = urlencode($pesan);
            header("Location:konversi_subkriteria.php?pesan={$pesan}");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }

    if (isset($_POST["edit"])) {
        $id = htmlentities(strip_tags(trim($_POST["ID"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "SELECT * FROM Konversi_nilai WHERE ID='$id'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            header("Location: edit_konversi_subkriteria.php");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }
    
    $query = "SELECT max(ID) as IDterbesar FROM Konversi_nilai";
    $hasil_query = mysqli_query($link, $query);
    $data = mysqli_fetch_array($hasil_query);
    $id = $data['IDterbesar'];
    $urutan = (int) substr($id, 3, 3);
    $urutan++;
    $huruf = "SK";
    $id = $huruf . sprintf("%03s", $urutan);
    $query = "SELECT * FROM Konversi_nilai ORDER BY ID ASC";
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
        <?php
            if ($roles=="Admin") {
        ?>
            <div class="home-content">
                <div class="title1">Konversi Nilai Sub Kriteria</div>
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
                                <th width="20%">ID Nilai</th>
                                <th width="20%">ID Kriteria</th>
                                <th width="20%">Sub Kriteria</th>
                                <th width="20%">Nilai</th>
                                <th width="10%">Edit</th>
                                <th width="10%">Hapus</th>
                            </tr>
                            <?php
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID]</td>";
                                    echo "<td>$data[ID_kriteria]</td>";
                                    echo "<td>$data[sub_kriteria]</td>";
                                    echo "<td>$data[nilai]</td>";
                                    echo "<td>";
                            ?>
                            <form action="edit_subkriteria.php" method="post">
                                <input type="hidden" name="ID" value="<?php echo "$data[ID]"; ?>">
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
                            <form action="konversi_subkriteria.php" method="post">
                                <input type="hidden" name="ID" value="<?php echo "$data[ID]"; ?>">
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
                    
                    <div class="box10">
                        <div>
                            <div class="title2">Tambah Konversi Nilai Sub Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_kriteria" action="konversi_subkriteria.php" method="post">
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
                                                    foreach ($hasil_query as $key => $value){
                                                        if ($value['ket_kriteria']==$ket_kriteria){
                                                            echo "<option value=\"{$value['ket_kriteria']}\" selected>{$value['ket_kriteria']}</option>";
                                                        }
                                                        else{
                                                            echo "<option value=\"{$value['ket_kriteria']}\">{$value['ket_kriteria']}</option>";
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
                                <b>Keterangan pengisian nilai konversi:</b>
                                <br>
                                <li>1 = Sangat tidak penting</li>
                                <li>2 = Tidak penting</li>
                                <li>3 = Netral</li>
                                <li>4 = Penting</li>
                                <li>5 = Sangat Penting</li>
                                <br>
                                <input type="submit" name="tambah" value="Tambah" class="button">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            }
            else{
        ?>
            <div class="home-content">
                <div class="title1">Daftar Kriteria</div>
                <div>
                    <?php
                        if (isset($pesan)) {
                            echo "<div class=\"pesan\">$pesan</div>";
                        }
                    ?>
                </div>
                <div class="overview-boxes1">
                    <div class="box11">
                        <table class="tabel1">
                            <tr>
                                <th width="20%">ID</th>
                                <th width="20%">Nama Kriteria</th>
                                <th width="20%">Atribut</th>
                            </tr>
                            <?php
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID_kriteria]</td>";
                                    echo "<td>$data[ket_kriteria]</td>";
                                    echo "<td>$data[atribut]</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </section>
        <script src="script.js"></script>
    </body>
</html>
<?php
    ob_end_flush();
?>