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
            $id_pariwisata = htmlentities(strip_tags(trim($_POST["ID_pariwisata"])));
            $id_pariwisata = mysqli_real_escape_string($link, $id_pariwisata);
            $query = "SELECT * FROM Formulir WHERE ID_pariwisata='$id_pariwisata'";
            $result = mysqli_query($link, $query);

            if (!$result) {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }   

            $data = mysqli_fetch_assoc($result);

            $id_pariwisata = $data["ID_pariwisata"];
            $nama_pariwisata = $data["nama"];
            $jenis_wisata = $data["jenis_wisata"];

            mysqli_free_result($result);
        }
        else if ($_POST["submit"]=="Update") {
            $id_pariwisata = htmlentities(strip_tags(trim($_POST["ID_pariwisata"])));
            $nama_pariwisata = htmlentities(strip_tags(trim($_POST["nama"])));
            $jenis_wisata = htmlentities(strip_tags(trim($_POST["jenis_wisata"])));
        }

        $pesan_error = "";
        if (empty($id_pariwisata)){
            $pesan_error .= "ID pariwisata belum diisi <br>";
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
    
        if (($pesan_error === "") AND ($_POST["submit"]=="Update")) {
            include("connection.php");
            $id_pariwisata = mysqli_real_escape_string($link, $id_pariwisata);
            $nama_pariwisata = mysqli_real_escape_string($link, $nama_pariwisata);
            $jenis_wisata = mysqli_real_escape_string($link, $jenis_wisata);
        
            $query = "UPDATE Formulir SET ID_pariwisata = '$id_pariwisata', nama = '$nama_pariwisata', jenis_wisata = '$jenis_wisata' WHERE ID_pariwisata = '$id_pariwisata'";
            $result = mysqli_query($link, $query);
            if ($result) {
                $pesan = "Data pariwisata sudah berhasil di update";
                $pesan = urlencode($pesan);
                header("Location: data_pariwisata.php?pesan={$pesan}");
            }
            else {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
        }
    }
    else {
        header("Location: data_pariwisata.php");
    }

    $query = "SELECT * FROM Formulir ORDER BY ID_pariwisata ASC";
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Edit Data Pariwisata</span>
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
                <div class="title1">Edit Data Pariwisata</div>
                <div class="overview-boxes1">
                    <div class="box10">
                        <div>
                            <div class="title2">Edit Data Pariwisata</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                        }
                                ?>
                            </div>
                            <form id="form_edit_pariwisata" action="edit_pariwisata.php" method="post">
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