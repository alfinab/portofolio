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
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Hasil Akhir</span>
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
                <div class="title1">Olah Data AHP</div>
                <?php
                    $query = "SELECT * FROM Penilaian_kriteria";
                    $hasil_query = mysqli_query($link, $query);
                    $jumlahdatanilai = mysqli_num_rows($hasil_query);

                    if ($jumlahdatanilai<>0){
                ?>
                <div class="overview-boxes1">
                    <?php
                        include("matriks_perbandingan.php");
                        include("normalisasi_matriks.php");
                        include("matriks_konsistensi.php");
                        include("ratio_konsistensi.php");
                    ?>
                </div>
                <?php } ?>
                <div class="title1">Olah Data TOPSIS</div>
                <?php
                    $query = "SELECT * FROM Penilaian";
                    $hasil_query = mysqli_query($link, $query);
                    $jumlahdatapenilaian = mysqli_num_rows($hasil_query);

                    if ($jumlahdatapenilaian<>0){
                ?>
                <div class="overview-boxes1">
                    <?php
                        include("matriks_keputusan.php");
                        include("matriks_normalisasi.php");
                        include("normalisasi_berbobot.php");
                        include("ideal_positif_negatif.php");
                        include("jarak_solusi_ideal.php");
                        include("pemeringkatan.php");
                    ?>
                </div>
                <?php } ?>
            </div>
        </section>
        <script src="script.js"></script>
        <script src="script2.js"></script>
        <script>
            MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']]
                }
            };
        </script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
    </body>
</html>