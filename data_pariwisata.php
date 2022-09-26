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
        $id_pariwisata = htmlentities(strip_tags(trim($_POST["ID_pariwisata"])));
        $nama_pariwisata = htmlentities(strip_tags(trim($_POST["nama"])));
        $jenis_wisata = htmlentities(strip_tags(trim($_POST["jenis_wisata"])));

        $id_pariwisata = mysqli_real_escape_string($link, $id_pariwisata);
        $query = "SELECT * FROM Formulir WHERE nama='$nama_pariwisata'";
        $hasil_query = mysqli_query($link, $query);

        $pesan_error = "";
        $jumlah_data = mysqli_num_rows($hasil_query);
        if ($jumlah_data >= 1) {
            $pesan_error .= "Nama pariwisata yang sama sudah digunakan<br>";
        }

        if (empty($nama_pariwisata)) {
            $pesan_error .= "Nama pariwisata belum diisi <br>";
        }
        
        $select_alam=""; $select_buatan=""; $select_sejarah=""; $select_edukasi=""; $select_religi="";
        switch($jenis_wisata) {
            case "Wisata Alam" : $select_alam = "selected"; break;
            case "Wisata Buatan" : $select_buatan = "selected"; break;
            case "Wisata Edukasi dan Agro" : $select_edukasi = "selected"; break;
            case "Wisata Sejarah" : $select_sejarah = "selected"; break;
            case "Wisata Religi" : $select_religi = "selected"; break;
            default : $pesan_error .= "Jenis wisata belum diisi <br>"; break;
        }

        if ($pesan_error === "") {
            $id_pariwisata = mysqli_real_escape_string($link, $id_pariwisata);
            $nama_pariwisata = mysqli_real_escape_string($link, $nama_pariwisata);
            $alamat = mysqli_real_escape_string($link, $alamat);
            $jenis_wisata = mysqli_real_escape_string($link, $jenis_wisata);
            $deskripsi = mysqli_real_escape_string($link, $deskripsi);
            
            $query = "INSERT INTO Formulir VALUES ('$id_pariwisata', '$nama_pariwisata', '$jenis_wisata')";
            $result = mysqli_query($link, $query);

            if ($result){
                $pesan = "Data pariwisata berhasil ditambahkan!";
                $pesan = urlencode($pesan);
                header("Location: data_pariwisata.php?pesan={$pesan}");
            }
            else {
                die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_error = "";
        $id_pariwisata = "";
        $nama_pariwisata = "";
        $select_alam = ""; $select_buatan = ""; $select_sejarah = ""; $select_edukasi = ""; $select_religi = "";
    }

    if (isset($_POST["hapus"])) {
        $id_pariwisata = htmlentities(strip_tags(trim($_POST["ID_pariwisata"])));
        $id_pariwisata = mysqli_real_escape_string($link, $id_pariwisata);
        $query = "DELETE FROM Formulir WHERE ID_pariwisata='$id_pariwisata'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            $pesan = "Data pariwisata sudah berhasil dihapus";
            $pesan = urlencode($pesan);
            header("Location: data_pariwisata.php?pesan={$pesan}");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }

    if (isset($_POST["edit"])) {
        $id_pariwisata = htmlentities(strip_tags(trim($_POST["ID_pariwisata"])));
        $id_pariwisata = mysqli_real_escape_string($link, $id_pariwisata);
        $query = "SELECT * FROM Formulir WHERE ID_pariwisata='$id_pariwisata'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            header("Location: edit_pariwisata.php");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }
    
    $query = "SELECT max(ID_pariwisata) as IDterbesar FROM Formulir";
    $hasil_query = mysqli_query($link, $query);
    $data = mysqli_fetch_array($hasil_query);
    $id_pariwisata = $data['IDterbesar'];
    $urutan = (int) substr($id_pariwisata, 3, 3);
    $urutan++;
    $huruf = "ALT";
    $id_pariwisata = $huruf . sprintf("%03s", $urutan);
    $query = "SELECT * FROM Formulir ORDER BY ID_pariwisata ASC";
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Data Pariwisata</span>
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
            if ($roles=="Admin" or $roles=="Assisten Admin" or $roles=="Assisten Admin 2") {
        ?>
            <div class="home-content">
                <div class="title1">Daftar Pariwisata</div>
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
                                <th>ID</th>
                                <th>Nama Pariwisataa</th>
                                <th>Jenis Wisata</th>
                                <th>Edit</th>
                                <th>Hapus</th>
                            </tr>
                            <?php
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID_pariwisata]</td>";
                                    echo "<td>$data[nama]</td>";
                                    echo "<td>$data[jenis_wisata]</td>";
                                    echo "<td>";
                            ?>
                            <form action="edit_pariwisata.php" method="post">
                                <input type="hidden" name="ID_pariwisata" value="<?php echo "$data[ID_pariwisata]"; ?>">
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
                            <form action="data_pariwisata.php" method="post">
                                <input type="hidden" name="ID_pariwisata" value="<?php echo "$data[ID_pariwisata]"; ?>">
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
                            <div class="title2">Tambah Data Pariwisata</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_pariwisata" action="data_pariwisata.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID</td>
                                        <td><input type="text" name="ID_pariwisata" id="ID_pariwisata" value="<?php echo $id_pariwisata ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pariwisata</td>
                                        <td><input type="text" name="nama" id="nama" value="<?php echo $nama_pariwisata ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Wisata</td>
                                        <td>
                                            <select name="jenis_wisata" id="jenis_wisata">
                                                <option>---Pilih Jenis Wisata---</option>
                                                <option value="Wisata Alam" <?php echo $select_alam ?>>Wisata Alam</option>
                                                <option value="Wisata Buatan" <?php echo $select_buatan ?>>Wisata Buatan</option>
                                                <option value="Wisata Edukasi dan Agro" <?php echo $select_edukasi ?>>Wisata Edukasi dan Agro</option>
                                                <option value="Wisata Sejarah" <?php echo $select_sejarah ?>>Wisata Sejarah</option>
                                                <option value="Wisata Religi" <?php echo $select_religi ?>>Wisata Religi</option>
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

            <?php
                }
                else{
            ?>
            <div class="home-content">
                <div class="title1">Daftar Pariwisata</div>
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
                                <th>ID</th>
                                <th>Nama Pariwisataa</th>
                                <th>Jenis Wisata</th>
                            </tr>
                            <?php
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID_pariwisata]</td>";
                                    echo "<td>$data[nama]</td>";
                                    echo "<td>$data[jenis_wisata]</td>";
                            ?>
                            <?php
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </section>
        <script src="script.js"></script>
    </body>
</html>