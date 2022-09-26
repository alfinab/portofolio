<?php
    session_start();
    if (!isset($_SESSION["username"])){
        header("Location: login.php");
    }

    include("connection.php");
    $pengguna = $_SESSION["roles"];

    include("header.php");
    if (isset($_GET["pesan"])) {
        $pesan = $_GET["pesan"];
    }

    if (isset($_POST["tambah"])){
        $id = htmlentities(strip_tags(trim($_POST["ID"])));
        $username = htmlentities(strip_tags(trim($_POST["username"])));
        $roles = htmlentities(strip_tags(trim($_POST["roles"])));
        $password = htmlentities(strip_tags(trim($_POST["password"])));

        $pesan_error = "";

        $username = mysqli_real_escape_string($link, $username);
        $query = "SELECT * FROM Pengguna WHERE username='$username'";
        $hasil_query = mysqli_query($link, $query);

        $jumlah_data = mysqli_num_rows($hasil_query);
        if ($jumlah_data >= 1) {
            $pesan_error .= "Username yang sama sudah digunakan<br>";
        }

        if (empty($username)) {
            $pesan_error .= "Username belum diisi <br>";
        }
        if (empty($roles)) {
            $pesan_error .= "Roles belum diisi <br>";
        }
        if (empty($password)) {
            $pesan_error .= "Password belum diisi <br>";
        }

        if ($pesan_error === "") {
            $id = mysqli_real_escape_string($link, $id);
            $username = mysqli_real_escape_string($link, $username);
            $roles = mysqli_real_escape_string($link, $roles);
            $password = mysqli_real_escape_string($link, $password);
            
            $query = "INSERT INTO Pengguna VALUES ('$username', '$password', '$id', '$roles')";
            $result = mysqli_query($link, $query);

            if ($result){
                $pesan = "Pengguna berhasil ditambahkan! Silakan mencoba untuk login ke sistem!";
                $pesan = urlencode($pesan);
                header("Location: user.php?pesan={$pesan}");
            }
            else {
                die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_error = "";
        $id = "";
        $username = "";
        $roles = "";
        $password = "";
    }

    if (isset($_POST["hapus"])) {
        $id = htmlentities(strip_tags(trim($_POST["ID"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "DELETE FROM Pengguna WHERE ID='$id'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            $pesan = "Pengguna sudah berhasil dihapus";
            $pesan = urlencode($pesan);
            header("Location: user.php?pesan={$pesan}");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }

    if (isset($_POST["edit"])) {
        $id = htmlentities(strip_tags(trim($_POST["ID"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "SELECT * FROM Pengguna WHERE ID='$id'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            header("Location: edit_user.php");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }
    $query = "SELECT max(ID) as IDterbesar FROM Pengguna";
    $hasil_query = mysqli_query($link, $query);
    $data = mysqli_fetch_array($hasil_query);
    $id = $data['IDterbesar'];
    $urutan = (int) substr($id, 4, 3);
    $urutan++;
    $huruf = "USER";
    $id = $huruf . sprintf("%03s", $urutan);
    $query = "SELECT * FROM Pengguna ORDER BY ID ASC";
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Data User</span>
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
                                    <span class="admin_name"><?php echo "$pengguna" ?></span>
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
                <div class="title1">Daftar Pengguna</div>
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
                                    <th width="20%">Username</th>
                                    <th width="20%">Password</th>
                                    <th width="20%">Roles</th>
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
                                        echo "<td>$data[username]</td>";
                                        echo "<td>$data[password]</td>";
                                        echo "<td>$data[roles]</td>";
                                        echo "<td>";
                                ?>
                                <form action="edit_user.php" method="post">
                                    <input type="hidden" name="ID" value="<?php echo $data['ID']; ?>">
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
                                <form action="user.php" method="post">
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
                                <div class="title2">Tambah Pengguna</div>
                                <div>
                                    <?php
                                        if ($pesan_error !== ""){
                                            echo "<div class=\"error\">$pesan_error</div>";
                                        }
                                    ?>
                                </div>
                                <form id="form_pengguna" action="user.php" method="post">
                                    <table class="tabel2">
                                        <tr>
                                            <td>ID</td>
                                            <td><input type="text" name="ID" id="id" value="<?php echo $id ?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><input type="text" name="username" id="username" value="<?php echo $username ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Roles</td>
                                            <td><input type="text" name="roles" id="roles" value="<?php echo $roles ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Password</td>
                                            <td><input type="password" name="password" id="password" value="<?php echo $password ?>"></td>
                                        </tr>
                                    </table>
                                    <input type="submit" name="tambah" value="Tambah" class="button">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="script.js"></script>
    </body>
</html>