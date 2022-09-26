<?php
    session_start();
    if (!isset($_SESSION["username"])){
        header("Location: login.php");
    }

    include("connection.php");
    $roles = $_SESSION["roles"];

    include("header.php");

    $query = "SELECT * FROM Pengguna";
    $result = mysqli_query($link, $query);
    $pengguna = mysqli_num_rows($result);

    $query = "SELECT * FROM Formulir";
    $result = mysqli_query($link, $query);
    $pariwisata = mysqli_num_rows($result);

    $query = "SELECT * FROM Kriteria";
    $result = mysqli_query($link, $query);
    $kriteria = mysqli_num_rows($result);
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Dashboard</span>
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
                <div class="overview-boxes">
                    <div class="box1">
                        <div class="left-side">
                            <i class='bx bxs-user-check'></i>
                            <div class="box-topic1">Total Pengguna</div>
                            <div class="number"><?php echo "$pengguna" ?></div>
                        </div>
                    </div>
                    <div class="box2">
                        <div class="">
                            <i class='bx bxs-tree'></i>
                            <div class="box-topic1">Total Pariwisata</div>
                            <div class="number"><?php echo "$pariwisata" ?></div>
                        </div>
                    </div>
                    <div class="box3">
                        <div class="">
                            <i class='bx bxs-file'></i>
                            <div class="box-topic1">Total Kriteria</div>
                            <div class="number"><?php echo "$kriteria" ?></div>
                        </div>
                    </div>
                </div>

                <div class="overview-boxes">
                    <div class="box4">
                        <div>
                            <div class="title">Sistem Pendukung Keputusan</div>
                            <div class="box-topic2">
                                Sistem Pendukung Keputusan (SPK) adalah suatu sistem berbasis komputer yang terdiri dari 
                                prosedur-prosedur dalam pemrosesan data dan pertimbangannya untuk membantu manajer dalam mengambil keputusan.
                            </div>
                            <div class="box-topic2">
                                Pada website ini, Sistem Pendukung Keputusan ini akan digunakan untuk memilih Pariwisata di Kabupaten Tulungagung 
                                yang akan diprioritaskan untuk kegiatan pembangunan fasilitas atau renovasi di sekitar lokasi wisata. SPK ini menggunakan
                                metode AHP(Analytic Hierarchy Process) dan TOPSIS(Technique for Order of Preference by Similarity to Ideal Solution).
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overview-boxes">
                    <div class="box5">
                        <div>
                            <div class="title">Metode AHP dan TOPSIS</div>
                            <ul><li class="font">AHP(Analytic Hierarchy Process)</li></ul>
                            <div class="box-topic3">AHP merupakan metode pengambilan keputusan yang menyusun masalah kompleks dalam bentuk hierarki sederhana dan mengevaluasi faktor kuantitatif dan kualitatif secara sistematis. Metode AHP dalam SPK sering digunakan untuk menentukan bobot yang konsisten dari setiap kriteria.</div>
                            </br>
                            <ul><li class="font">TOPSIS(Technique for Order of Preference by Similarity to Ideal Solution)</li></ul>
                            <div class="box-topic3">Metode TOPSIS merupakan metode SPK yang didasarkan pada konsep bahwa alternatif yang dipilih harus mendekati solusi ideal positif dan terjauh dari solusi ideal negatif. Dimana solusi ideal positif terdiri dari nilai kinerja terbaik dari setiap kriteria, sedangkan solusi ideal negatif terdiri dari nilai kinerja terburuk dari setiap kriteria.</div>
                        </div>
                    </div>
                </div>

                <div class="overview-boxes">
                    <div class="box5">
                        <div>
                            <div class="title">Prosedur SPK</div>
                            <div class="box-topic2">
                                Prosedur sistem akan memberikan penjelasan mengenai langkah-langkah yang harus dilakukan saat ingin menggunakan Website Sistem Pendukung Keputusan ini.
                            </div>
                            <ul><li class="font">Metode AHP</li></ul>
                            <div class="box-topic3">
                                Berikut adalah langkah-langkah metode AHP :
                                <ol>
                                    <li>
                                        Menyusun hierarki berupa mendefinisikan masalah, menentukan tujuan atau solusi yang ingin dicapai, serta menentukan kriteria.
                                    </li>
                                    <li>
                                        Membuat matriks perbandingan kriteria berpasangan.
                                    </li>
                                    <li>
                                        Membuat normalisasi matriks perbandingan kriteria.
                                    </li>
                                    <li>
                                        Menghitung bobot priotitas dari masing-masing kriteria.
                                    </li>
                                    <li>
                                        Membuat matriks konsistensi.
                                    </li>
                                    <li>
                                        Mencari nilai eigen maksimal.
                                    </li>
                                    <li>
                                        Menghitung Consistency Ratio(CR) dari matriks berbandingan kriteria berpasangan.
                                        <p>
                                            dimana RI adalah Random Indeks yang dapat diperoleh dari tabel berikut. 
                                            <h3>Tabel Ratio Indeks</h3>
                                            <table class="tabel5">
                                                <tr>
                                                    <th>Ordo matriks</th>
                                                    <?php
                                                        for ($x=1; $x<=15; $x++){
                                                            echo "<td>";
                                                            echo $x;
                                                            echo "</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <th>Random Indeks</th>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0.58</td>
                                                    <td>0.9</td>
                                                    <td>1.12</td>
                                                    <td>1.24</td>
                                                    <td>1.32</td>
                                                    <td>1.41</td>
                                                    <td>1.46</td>
                                                    <td>1.49</td>
                                                    <td>1.51</td>
                                                    <td>1.48</td>
                                                    <td>1.56</td>
                                                    <td>1.57</td>
                                                    <td>1.59</td>
                                                </tr>
                                            </table>
                                            Jika CR < 0.1 maka matriks perbandingan kriteria dianggap konsisten dan bobot yang telah diperoleh dapat digunakan pada 
                                            perhitungan selanjutnya.
                                        </p>
                                    </li>  
                                </ol>
                            </div>
                            </br>
                            <ul><li class="font">Metode TOPSIS</li></ul>
                            <div class="box-topic3">
                                Berikut adalah langkah-langkah metode TOPSIS :
                                <ol>
                                    <li>
                                        Membuat matriks keputusan dimana setiap elemen matriks diperoleh dari nilai alternatif yang telah diinputkan.
                                    </li>
                                    <li>
                                        Membuat matriks normalisasi dari matrik keputusan. 
                                    </li>
                                    <li>
                                        Membuat matriks keputusan ternormalisasi berbobot.
                                    </li>
                                    <li>
                                        Hitung solusi ideal positif dan ideal negatif.
                                    </li>
                                    <li>
                                        Menentukan jarak setiap alternatif dengan solusi ideal-positif dan ideal-negatif.
                                    </li>
                                    <li>
                                        Menentukan nilai preferensi untuk setiap alternatif.
                                    </li>
                                    <li>
                                        Tentukan ranking dari setiap alternatif dengan melihat nilai preferensi. Alternatif dengan nilai preferensi tertinggi merupakan alternatif terbaik.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="script.js"></script>
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