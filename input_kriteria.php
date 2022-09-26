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
        $id_kriteria = htmlentities(strip_tags(trim($_POST["ID_kriteria"])));
        $ket_kriteria = htmlentities(strip_tags(trim($_POST["ket_kriteria"])));
        $atribut = htmlentities(strip_tags(trim($_POST["atribut"])));

        $pesan_error = "";
        $id = mysqli_real_escape_string($link, $id_kriteria);
        $query = "SELECT * FROM Kriteria WHERE ket_kriteria='$ket_kriteria'";
        $hasil_query = mysqli_query($link, $query);
        $jumlah_data = mysqli_num_rows($hasil_query);
        //cek apakah ada data yang sama
        if ($jumlah_data >= 1) {
            $pesan_error .= "Nama kriteria yang sama sudah ada<br>";
        }
        //Pesan error saat nama kriteria belum diisi
        if (empty($ket_kriteria)) {
            $pesan_error .= "Nama kriteria belum diisi <br>";
        }
        //Pilihan atribut sudah dipilih atau belum
        $select_cost=""; $select_benefit="";
        switch($atribut) {
            case "Cost" : $select_cost = "selected"; break;
            case "Benefit" : $select_benefit = "selected"; break;
            default : $pesan_error .= "Atribut kriteria belum dipilih <br>";
        }
        //jika pesan error tidak ada maka input data ke dalam database
        if ($pesan_error === "") {
            $id_kriteria = mysqli_real_escape_string($link, $id_kriteria);
            $ket_kriteria = mysqli_real_escape_string($link, $ket_kriteria);
            $atribut = mysqli_real_escape_string($link, $atribut);

            $query = "INSERT INTO Kriteria VALUES ('$id_kriteria', '$ket_kriteria', '$atribut')";
            $result = mysqli_query($link, $query);

            if ($result){
                $pesan = "Kriteria berhasil ditambahkan!";
                $pesan = urlencode($pesan);
                header("Location:input_kriteria.php?pesan={$pesan}");
            }
            else {
                die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_error = "";
        $id_kriteria = "";
        $ket_kriteria = "";
        $select_cost = ""; $select_benefit = "";
    }
    //jika button "Nilai konversi sub kriteria" diklik maka diarahkan ke halaman yang seharusnya
    if (isset($_POST["nilaikonversi"])){
        header("Location: konversi_subkriteria.php");
    }
    //button hapus diklik
    if (isset($_POST["hapus"])) {
        $id_kriteria = htmlentities(strip_tags(trim($_POST["ID_kriteria"])));
        $id_kriteria = mysqli_real_escape_string($link, $id_kriteria);
        $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
        $hasil_query = mysqli_query($link, $query);
        if (!$hasil_query) {
            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
        while($data = mysqli_fetch_array($hasil_query)){
            if ($id_kriteria == $data['ID_kriteria']) {
                $ket_kriteria = $data['ket_kriteria'];
            }
        }
        $query = "DROP TABLE $ket_kriteria";
        $hasil_query = mysqli_query($link, $query);
        $query = "DELETE FROM Kriteria WHERE ID_kriteria='$id_kriteria'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            $pesan = "Kriteria '<b>$ket_kriteria</b>' sudah berhasil dihapus";
            $pesan = urlencode($pesan);
            header("Location:input_kriteria.php?pesan={$pesan}");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }
    //button edit diklik
    if (isset($_POST["edit"])) {
        $id_kriteria = htmlentities(strip_tags(trim($_POST["ID_kriteria"])));
        $id_kriteria = mysqli_real_escape_string($link, $id_kriteria);
        $query = "SELECT * FROM Kriteria WHERE ID='$id_kriteria'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            header("Location: edit_kriteria.php");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }
    //pembuatan ID kriteria otomatis
    $query = "SELECT max(ID_kriteria) as IDterbesar FROM Kriteria";
    $hasil_query = mysqli_query($link, $query);
    $data = mysqli_fetch_array($hasil_query);
    $id_kriteria = $data['IDterbesar'];
    $urutan = (int) substr($id_kriteria, 3, 3);
    $urutan++;
    $huruf = "KRI";
    $id_kriteria = $huruf . sprintf("%03s", $urutan);
    $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Input Kriteria</span>
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
                <div class="title1">Daftar Kriteria</div>
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
                                <th width="20%">ID</th>
                                <th width="20%">Nama Kriteria</th>
                                <th width="20%">Atribut</th>
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
                                    echo "<td>$data[ID_kriteria]</td>";
                                    echo "<td>$data[ket_kriteria]</td>";
                                    echo "<td>$data[atribut]</td>";
                                    echo "<td>";
                            ?>
                            <form action="edit_kriteria.php" method="post">
                                <input type="hidden" name="ID_kriteria" value="<?php echo "$data[ID_kriteria]"; ?>">
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
                            <form action="input_kriteria.php" method="post">
                                <input type="hidden" name="ID_kriteria" value="<?php echo "$data[ID_kriteria]"; ?>">
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
                            <div class="title2">Tambah Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_kriteria" action="input_kriteria.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID</td>
                                        <td><input type="text" name="ID_kriteria" id="ID_kriteria" value="<?php echo $id_kriteria ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Kriteria</td>
                                        <td><input type="text" name="ket_kriteria" id="ket_kriteria" value="<?php echo $ket_kriteria ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Atribut</td>
                                        <td>
                                            <select name="atribut" id="atribut">
                                                <option>---Pilih Atribut---</option>
                                                <option value="Cost" <?php echo $select_cost ?>>Cost</option>
                                                <option value="Benefit" <?php echo $select_benefit ?>>Benefit</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <b>Keterangan:</b>
                                <br>
                                <li>Benefit adalah atribut dari kriteria yang dapat memberikan keuntungan dalam pengambilan keputusan. Misal: Minat pengunjung.</li>
                                <li>Cost adalah atribut dari kriteria yang berkaitan dengan keuangan. Misal: Biaya pembangunan.</li>    
                                <br>
                                <input type="submit" name="tambah" value="Tambah" class="button">
                                <input type="submit" name="nilaikonversi" value="Konversi Nilai Sub Kriteria" class="btn">
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