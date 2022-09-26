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
            $id_nilai_alternatif = htmlentities(strip_tags(trim($_POST["ID_nilai_alternatif"])));
            $id_nilai_alternatif = mysqli_real_escape_string($link, $id_nilai_alternatif);

            $query = "SELECT * FROM Penilaian WHERE ID_penilaian='$id_nilai_alternatif'";
            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_assoc($result);
            $id_nilai_alternatif = $data["ID_penilaian"];
            $nama_pariwisata = $data["nama_pariwisata"];
            
            $query = "SELECT * FROM Nilai_pariwisata WHERE ID_penilaian='$id_nilai_alternatif' ORDER BY ID_kriteria ASC";
            $result = mysqli_query($link, $query);
            $jml = mysqli_num_rows($result);
            $i=0; $j=1;
            $data = mysqli_fetch_assoc($result);
            foreach($result as $key => $value){
                $explode = explode(", ", $value["sub_kriteria"]);
                $size = sizeof($explode);
                if ($size > 1){
                    $sub_kriteriafasilitas = explode(", ", $value["sub_kriteria"]);
                }
                else {
                    $subkriteria = explode(", ", $value["sub_kriteria"]);
                    if ($subkriteria[$i]=="-"){
                        $sub_kriteriafasilitas = array();
                    }
                    else if ($subkriteria[$i]=="Kios Souvenir"){
                        $sub_kriteriafasilitas[$j] = $subkriteria[$i];
                        $j++;
                    }
                    else {
                       $sub_kriteria[$j] = $subkriteria[$i];
                        $j++; 
                    }
                    
                }
            }
        }
        else if ($_POST["submit"]=="Update") {
            $id_nilai_alternatif = htmlentities(strip_tags(trim($_POST["ID_nilai_alternatif"])));
            $nama_pariwisata = htmlentities(strip_tags(trim($_POST["nama_pariwisata"])));
            function proses_subkriteria($id_nilai_alternatif){
                if (isset($_POST["sub_kriteria"])){
                    $sub_kriteria = $_POST["sub_kriteria"];
                    reset($sub_kriteria);
                    foreach($sub_kriteria as $key => $value){
                        include("connection.php");
                        $subbkriteria = $_POST["sub_kriteria"][$key];
                        $query = "SELECT * FROM Konversi_nilai";
                        $hasil_query = mysqli_query($link, $query);
                        while($data = mysqli_fetch_array($hasil_query)){
                            if ($subbkriteria == $data['sub_kriteria']){
                                $id_kriteria = $data['ID_kriteria'];
                            }
                        }
                        $query = "UPDATE Nilai_pariwisata SET ID_kriteria='$id_kriteria', sub_kriteria='$subbkriteria' WHERE ID_penilaian='$id_nilai_alternatif' AND ID_kriteria='$id_kriteria'";
                        $hasil_query = mysqli_query($link, $query);
                    }
                }
            }
            function proses_fasilitas($id_nilai_alternatif){
                if (isset($_POST["sub_kriteria_fasilitas"])){
                    $sub_kriteriafasilitas = $_POST["sub_kriteria_fasilitas"];
                    $fasilitas = implode(", ", $sub_kriteriafasilitas);
                    include("connection.php");
                    $query = "SELECT * FROM Konversi_nilai";
                    $hasil_query = mysqli_query($link, $query);
                    while($data = mysqli_fetch_array($hasil_query)){
                        for ($x=0; $x<sizeof($sub_kriteriafasilitas); $x++){
                            if ($sub_kriteriafasilitas[$x] == $data['sub_kriteria']){
                                $id_kriteria = $data['ID_kriteria'];
                            }
                        }
                    }
                    $query = "UPDATE Nilai_pariwisata SET ID_kriteria='$id_kriteria', sub_kriteria='$fasilitas' WHERE ID_penilaian='$id_nilai_alternatif' AND ID_kriteria='$id_kriteria'";
                    $hasil_query = mysqli_query($link, $query);
                }
                else {
                    $fasilitas = "-";
                    include("connection.php");
                    $query = "SELECT * FROM Kriteria WHERE ket_kriteria = 'Fasilitas'";
                    $hasil_query = mysqli_query($link, $query);
                    while($data = mysqli_fetch_array($hasil_query)){
                        $id_kriteria = $data['ID_kriteria'];
                    }
                    $query = "UPDATE Nilai_pariwisata SET ID_kriteria='$id_kriteria', sub_kriteria='$fasilitas' WHERE ID_penilaian='$id_nilai_alternatif' AND ID_kriteria='$id_kriteria'";
                    $hasil_query = mysqli_query($link, $query);
                }
            }
        }

        $pesan_error = "";
        if (empty($id_nilai_alternatif)){
            $pesan_error .= "ID penilaian belum diisi <br>";
        }

        
        if (($pesan_error === "") AND ($_POST["submit"]=="Update")) {
            include("connection.php");
            $id_nilai_alternatif = mysqli_real_escape_string($link, $id_nilai_alternatif);
            $nama_pariwisata = mysqli_real_escape_string($link, $nama_pariwisata);

            $query = "SELECT * FROM Formulir ORDER BY ID_pariwisata ASC";
            $hasil_query = mysqli_query($link, $query);
            if (!$hasil_query) {
                die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
            while($data = mysqli_fetch_array($hasil_query)){
                if ($nama_pariwisata == $data['nama']) {
                    $id_pariwisata = $data['ID_pariwisata'];
                }
            }
        
            $query = "UPDATE Penilaian SET IDpariwisata = '$id_pariwisata', nama_pariwisata = '$nama_pariwisata' WHERE ID_penilaian='$id_nilai_alternatif'";
            $result = mysqli_query($link, $query);
    
            if ($result) {
                proses_subkriteria($id_nilai_alternatif);
                proses_fasilitas($id_nilai_alternatif);
                $pesan = "Penilaian bobot alternatif berhasil di update";
                $pesan = urlencode($pesan);
                header("Location: bobot_alternatif.php?pesan={$pesan}");
            }
            else {
                die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
            }
        }
    }
    else {
        header("Location: bobot_alternatif.php");
    }
?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Edit Nilai Alternatif</span>
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
                <div class="title1">Edit Penilaian Alternatif</div>
                <div class="overview-boxes1">
                    <div class="box12">
                        <div class="subbox12">
                            <div class="title2">Edit Penilaian Alternatif</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                        }
                                ?>
                            </div>
                            <form id="form_penilaian" action="edit_nilai_alternatif.php" method="post">
                                <table class="tabel2">
                                    <tr>
                                        <td>ID Nilai</td>
                                        <td><input type="text" name="ID_nilai_alternatif" id="ID_nilai_alternatif" value="<?php echo $id_nilai_alternatif ?>" readonly></td>
                                        <td>Nama Pariwisata</td>
                                        <td>
                                            <select name="nama_pariwisata" id="nama_pariwisata">
                                                <option>----Pilih Pariwisata----</option>
                                                <?php 
                                                    $query = "SELECT * FROM Formulir";
                                                    $pariwisata = mysqli_query($link, $query);
                                                    $datapariwisata = mysqli_fetch_array($pariwisata);
                                                    if (!$pariwisata) {
                                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                    }
                                                    foreach ($pariwisata as $key => $value){
                                                        if ($value['nama']==$nama_pariwisata) {
                                                            echo "<option value=\"{$value['nama']}\" selected>{$value['nama']}</option>";
                                                        }
                                                        else{
                                                            echo "<option value=\"{$value['nama']}\">{$value['nama']}</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $i=0; $j=1;
                                        $namakriteria = array();
                                        while($datakriteria = mysqli_fetch_array($hasil_query)){
                                            $hasil = $datakriteria['ket_kriteria'];
                                            $namakriteria[$i][$j] = $hasil;
                                            $j++;
                                        }
                                        for ($j=1; $j<=$jumlahdata; $j++) {
                                            echo "<tr>";
                                            echo "<td>".$namakriteria[$i][$j]."</td>";
                                            echo "<td>";
                                                $query = "SELECT * FROM Kriteria";
                                                $hasil_query = mysqli_query($link, $query);
                                                while($datakriteria=mysqli_fetch_array($hasil_query)){
                                                    if ($namakriteria[$i][$j]==$datakriteria['ket_kriteria']){
                                                        $id_kriteria = $datakriteria['ID_kriteria'];
                                                        break;
                                                    }
                                                }
                                                $cari = stripos($namakriteria[$i][$j], "fasilitas");
                                                if ($cari !== FALSE){
                                                    $query = "SELECT * FROM Konversi_nilai WHERE ID_kriteria='$id_kriteria'";
                                                    $subkriteria = mysqli_query($link, $query);
                                                    $datasubkriteria = mysqli_fetch_array($subkriteria);
                                                    if (!$subkriteria) {
                                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                    }
                                                    foreach ($subkriteria as $key => $value){
                                                        if (in_array($value['sub_kriteria'], $sub_kriteriafasilitas)){
                                    ?>
                                                            <input type="checkbox" name="sub_kriteria_fasilitas[]" value="<?php echo $value['sub_kriteria'] ?>" checked><?php echo $value['sub_kriteria']?>
                                                            <br>
                                    <?php
                                                        }
                                                        else {
                                                            echo "<input type=\"checkbox\" name=\"sub_kriteria_fasilitas[]\" value=\"{$value['sub_kriteria']}\">{$value['sub_kriteria']}";
                                                            echo "<br>";
                                                        }
                                                    }
                                                }
                                                else{
                                    ?>
                                                <select name="sub_kriteria[]" id="sub_kriteria">
                                                    <option>----Pilih----</option>
                                                    <?php 
                                                        $query = "SELECT * FROM Konversi_nilai WHERE ID_kriteria='$id_kriteria'";
                                                        $subkriteria = mysqli_query($link, $query);
                                                        $datasubkriteria = mysqli_fetch_array($subkriteria);
                                                        if (!$subkriteria) {
                                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                                        }
                                                        foreach ($subkriteria as $key => $value){
                                                            if (in_array($value['sub_kriteria'], $sub_kriteria)) {
                                                                echo "<option value=\"{$value['sub_kriteria']}\" selected>{$value['sub_kriteria']}</option>";
                                                            }
                                                            else{
                                                                echo "<option value=\"{$value['sub_kriteria']}\">{$value['sub_kriteria']}</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                    <?php
                                                }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    ?>
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