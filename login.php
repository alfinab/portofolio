<?php
    if (isset($_GET["pesan"])) {
        $pesan = $_GET["pesan"];
    }
    
    if (isset($_POST["submit"])) {
        $username = htmlentities(strip_tags(trim($_POST["username"])));
        $password = htmlentities(strip_tags(trim($_POST["password"])));

        $pesan_error = "";

        if (empty($username)) {
            $pesan_error .= "Username belum diisi<br>";
        }

        if (empty($password)) {
            $pesan_error .= "Password belum diisi<br>";
        }

        include("connection.php");

        $username = mysqli_real_escape_string($link, $username);
        $password = mysqli_real_escape_string($link, $password);
        $password_sha1 = $password;

        $query = "SELECT * FROM Pengguna WHERE username = '$username' AND password = '$password_sha1'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) == 0 and !empty($username) and !empty($password)) {
            $pesan_error .= "Username dan/atau password tidak sesuai";
        }

        $user_data = mysqli_fetch_assoc($result);

        if ($pesan_error === "") {
            session_start();
            $_SESSION["username"] = $user_data['username'];
            $_SESSION["roles"] = $user_data['roles'];
            $roles = $_SESSION["roles"];
            header("location: index.php");
        }
    }
    else {
        $pesan_error = "";
        $username = "";
        $password = "";
    }
?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewreport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <title>Log In</title>
    </head>
    <body>
        <div class="container">
            <div class="form-container">
                <div class="signin">
                    <form action="login.php" method="post" class="sign-in-form">
                        <h2 class="title">Sign In</h2>
                        <?php
                            if (isset($pesan)) {
                                echo "<div class=\"pesan\">$pesan</div>";
                            }

                            if ($pesan_error !== "") {
                                echo "<div class=\"error\">$pesan_error</div>";
                            }
                        ?>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Username" name="username" id="username" value="<?php echo $username ?>">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Password" name="password" id="password" value="<?php echo $password ?>">
                        </div>
                        <input type="submit" name="submit" value="Login" class="btn solid">
                    </form>
                </div>
            </div>
            <div class="panel-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>Sistem Pendukung Keputusan</h3>
                        <h4>Pengembangan Lokasi Wisata Kabupaten Tulungagung</h4>
                    </div>
                    <img src="login.svg" class="image" alt="">
                </div>
            </div>
        </div>
    </body>
</html>

