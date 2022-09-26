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
            $query = "SELECT * FROM Pengguna WHERE ID='$id'";
            $result = mysqli_query($link, $query);

            if (!$result) {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }

            $data = mysqli_fetch_assoc($result);

            $id = $data["ID"];
            $username = $data["username"];
            $password = $data["password"];
            $roles = $data["roles"];

            mysqli_free_result($result);
        }
        else if ($_POST["submit"]=="Update") {
            $id = htmlentities(strip_tags(trim($_POST["ID"])));
            $username = htmlentities(strip_tags(trim($_POST["username"])));
            $roles = htmlentities(strip_tags(trim($_POST["roles"])));
            $password = htmlentities(strip_tags(trim($_POST["password"])));
        }

        $pesan_error1="";
  
        if (empty($username)) {
            $pesan_error1 .= "Username belum diisi <br>";
        }
        if (empty($roles)) {
            $pesan_error1 .= "Roles belum diisi <br>";
        }
        if (empty($password)) {
            $pesan_error1 .= "Password belum diisi <br>";
        }
    
        if (($pesan_error1 === "") AND ($_POST["submit"]=="Update")) {
            include("connection.php");
            $id = mysqli_real_escape_string($link, $id);
            $username = mysqli_real_escape_string($link, $username);
            $roles = mysqli_real_escape_string($link, $roles);
            $password = mysqli_real_escape_string($link, $password);
        
            $query = "UPDATE Pengguna SET username = '$username', password = '$password', ID = '$id', roles = '$roles' WHERE ID = '$id'";

            $result = mysqli_query($link, $query);
    
            if ($result) {
                $pesan = "Pengguna sudah berhasil di update";
                $pesan = urlencode($pesan);
                header("Location: user.php?pesan={$pesan}");
            }
            else {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
        }
    }
    else {
        header("Location: user.php");
    }

    $query = "SELECT * FROM Pengguna ORDER BY Username ASC";
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Edit Data User</span>
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
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </div>

                        <div class="box10">
                            <div>
                                <div class="title2">Edit Pengguna</div>
                                <div>
                                    <?php
                                        if ($pesan_error1 !== ""){
                                            echo "<div class=\"error\">$pesan_error1</div>";
                                        }
                                    ?>
                                </div>
                                <form id="form_edit" action="edit_user.php" method="post">
                                    <table class="tabel2">
                                        <tr>
                                            <td>ID</td>
                                            <td><input type="text" name="ID" id="id" value="<?php echo $id; ?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><input type="text" name="username" id="username" value="<?php echo $username; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Roles</td>
                                            <td><input type="text" name="roles" id="roles" value="<?php echo $roles; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Password</td>
                                            <td><input type="password" name="password" id="password_edit" value="<?php echo $password; ?>"></td>
                                        </tr>
                                    </table>
                                    <input type="submit" name="submit" value="Update" class="button">
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