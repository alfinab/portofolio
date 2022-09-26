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
            $id_kriteria = htmlentities(strip_tags(trim($_POST["ID_kriteria"])));
            $id_kriteria = mysqli_real_escape_string($link, $id_kriteria);
            $query = "SELECT * FROM Kriteria WHERE ID_kriteria='$id_kriteria'";
            $result = mysqli_query($link, $query);

            if (!$result) {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }

            $data = mysqli_fetch_assoc($result);

            $id_kriteria = $data["ID_kriteria"];
            $ket_kriteria = $data["ket_kriteria"];
            $atribut = $data["atribut"];

            mysqli_free_result($result);
        }
        else if ($_POST["submit"]=="Update") {
            $id_kriteria = htmlentities(strip_tags(trim($_POST["ID_kriteria"])));
            $ket_kriteria = htmlentities(strip_tags(trim($_POST["ket_kriteria"])));
            $atribut = htmlentities(strip_tags(trim($_POST["atribut"])));
        }

        $pesan_error1="";
        if (empty($ket_kriteria)) {
            $pesan_error1 .= "Keterangan kriteria belum diisi <br>";
        }
        $select_cost=""; $select_benefit="";
        switch($atribut) {
            case "Cost" : $select_cost = "selected"; break;
            case "Benefit" : $select_benefit = "selected"; break;
        }
    
        if (($pesan_error1 === "") AND ($_POST["submit"]=="Update")) {
            include("connection.php");
            $id_kriteria = mysqli_real_escape_string($link, $id_kriteria);
            $ket_kriteria = mysqli_real_escape_string($link, $ket_kriteria);
            $atribut = mysqli_real_escape_string($link, $atribut);
        
            $query = "UPDATE Kriteria SET ID_kriteria = '$id_kriteria', ket_kriteria = '$ket_kriteria', atribut = '$atribut' WHERE ID_kriteria = '$id_kriteria'";

            $result = mysqli_query($link, $query);
    
            if ($result) {
                $pesan = "Kriteria sudah berhasil di update";
                $pesan = urlencode($pesan);
                header("Location: input_kriteria.php?pesan={$pesan}");
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
                    <span class="dashboard">Edit Kriteria</span>
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
                <div class="title1">Edit Kriteria</div>
                <div class="overview-boxes1">
                    <div class="box10">
                        <div>
                            <div class="title2">Edit Kriteria</div>
                            <div>
                                <?php
                                    if ($pesan_error1 !== ""){
                                        echo "<div class=\"error\">$pesan_error1</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_edit_kriteria" action="edit_kriteria.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID</td>
                                        <td><input type="text" name="ID_kriteria" id="id_kriteria" value="<?php echo $id_kriteria; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Kriteria</td>
                                        <td><input type="text" name="ket_kriteria" id="ket_kriteria" value="<?php echo $ket_kriteria; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Atribut</td>
                                        <td>
                                            <select name="atribut" id="atribut">
                                                <option></option>
                                                <option value="Cost" <?php echo $select_cost ?>>Cost</option>
                                                <option value="Benefit" <?php echo $select_benefit ?>>Benefit</option>
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