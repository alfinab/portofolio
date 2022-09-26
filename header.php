<?php
    ob_start();
    include("connection.php");
    $roles = $_SESSION["roles"];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Pendukung Keputusan</title>
        <link rel="stylesheet" href="style_header1.css">
        <link rel="stylesheet" href="style4.css">
        <link rel="stylesheet" href="style5.css">
        <link rel="stylesheet" href="style3.css">
        <link rel="stylesheet" href="style2.css">
        <!-- BoxIcons CDN Link -->
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
        <meta name="viewport" contents="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
            if ($roles=="Admin") {
        ?>
        <div class="sidebar">
            <div class="logo-details">
                <img src="logo.png">
                <span class="logo_name">Sistem Pendukung Keputusan</span>
            </div>
            <ul class="nav-links">
                <li>
                    <a href="index.php">
                        <i class='bx bx-grid-alt'></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>                
                <li>
                    <a href="input_kriteria.php">
                        <i class='bx bx-message-alt-edit'></i>
                        <span class="link_name">Input Kriteria</span>
                    </a>
                </li>
                <li>
                    <a href="bobot_kriteria.php">
                        <i class='bx bxs-file'></i>
                        <span class="link_name">Bobot Kriteria</span>
                    </a>
                </li>
                <li>
                    <a href="data_pariwisata.php">
                        <i class='bx bx-spreadsheet'></i>
                        <span class="link_name">Data Alternatif</span>
                    </a>
                </li>
                <li>
                    <a href="bobot_alternatif.php">
                        <i class='bx bxs-file'></i>
                        <span class="link_name">Bobot Alternatif</span>
                    </a>
                </li>
                <li>
                    <a href="hasil_akhir.php">
                        <i class='bx bx-task'></i>
                        <span class="link_name">Hasil Akhir</span>
                    </a>
                </li>
                <li>
                    <a href="user.php">
                        <i class='bx bx-user'></i>
                        <span class="link_name">User</span>
                    </a>
                </li>
            </ul>
            <script type="text/javascript">
                const currentLocation = location.href;
                const menuItem = document.querySelectorAll('a');
                const menuLength = menuItem.length
                for(i = 0; i < menuLength; i++){
                    if (menuItem[i].href === currentLocation){
                        menuItem[i].className = "active"
                    }
                }
            </script>
        </div>
        <!-- home content -->
        
        <?php
            }
            elseif ($roles=="Assisten Admin" or $roles=="Assisten Admin 2"){
        ?>
        <div class="sidebar">
            <div class="logo-details">
                <img src="logo.png">
                <span class="logo_name">Sistem Pendukung Keputusan</span>
            </div>
            <ul class="nav-links">
                <li>
                    <a href="index.php">
                        <i class='bx bx-grid-alt'></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="input_kriteria.php">
                        <i class='bx bx-message-alt-edit'></i>
                        <span class="link_name">Input Kriteria</span>
                    </a>
                </li>
                <li>
                    <a href="data_pariwisata.php">
                        <i class='bx bx-spreadsheet'></i>
                        <span class="link_name">Data Alternatif</span>
                    </a>
                </li>
                <li>
                    <a href="bobot_alternatif.php">
                        <i class='bx bxs-file'></i>
                        <span class="link_name">Bobot Alternatif</span>
                    </a>
                </li>
                <li>
                    <a href="hasil_akhir.php">
                        <i class='bx bx-task'></i>
                        <span class="link_name">Hasil Akhir</span>
                    </a>
                </li>
            </ul>
            <script type="text/javascript">
                const currentLocation = location.href;
                const menuItem = document.querySelectorAll('a');
                const menuLength = menuItem.length
                for(i = 0; i < menuLength; i++){
                    if (menuItem[i].href === currentLocation){
                        menuItem[i].className = "active"
                    }
                }
            </script>
        </div>

        <?php
            }
            else{
        ?>
        <div class="sidebar">
            <div class="logo-details">
                <img src="logo.png">
                <span class="logo_name">Sistem Pendukung Keputusan</span>
            </div>
            <ul class="nav-links">
                <li>
                    <a href="index.php">
                        <i class='bx bx-grid-alt'></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="input_kriteria.php">
                        <i class='bx bx-message-alt-edit'></i>
                        <span class="link_name">Input Kriteria</span>
                    </a>
                </li>
                <li>
                    <a href="data_pariwisata.php">
                        <i class='bx bx-spreadsheet'></i>
                        <span class="link_name">Data Alternatif</span>
                    </a>
                </li>
                <li>
                    <a href="bobot_alternatif.php">
                        <i class='bx bxs-file'></i>
                        <span class="link_name">Bobot Alternatif</span>
                    </a>
                </li>
                <li>
                    <a href="hasil_akhir.php">
                        <i class='bx bx-task'></i>
                        <span class="link_name">Hasil Akhir</span>
                    </a>
                </li>
            </ul>
            <script type="text/javascript">
                const currentLocation = location.href;
                const menuItem = document.querySelectorAll('a');
                const menuLength = menuItem.length
                for(i = 0; i < menuLength; i++){
                    if (menuItem[i].href === currentLocation){
                        menuItem[i].className = "active"
                    }
                }
            </script>
        </div>
        
        <?php
            }
        ?>