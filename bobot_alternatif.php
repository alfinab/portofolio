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
        $id_nilai_alternatif = htmlentities(strip_tags(trim($_POST["ID_nilai_alternatif"])));
        $nama_pariwisata = htmlentities(strip_tags(trim($_POST["nama_pariwisata"])));
        $pesan_error = "";
        if (isset($_POST["sub_kriteria"])){
            $sub_kriteria = $_POST["sub_kriteria"];
            reset($sub_kriteria);
            $Y = 0; $i = 0; $j = 1;
            $id_kriteria = array(); $kriteria = ""; $idkriteria = "";
            foreach($sub_kriteria as $key => $value){
                $Y = $Y + 1;
                $X = 0;
                $subbkriteria = $_POST["sub_kriteria"][$key];
                if ($subbkriteria==="----Pilih----") {
                    $query = "SELECT * FROM Kriteria";
                    $hasil_query = mysqli_query($link, $query);
                    $jumlahkriteria = mysqli_num_rows($hasil_query);
                    while($data = mysqli_fetch_array($hasil_query)){
                        if ($data["ket_kriteria"] <> "Fasilitas"){
                            $id_kriteria[$i][$j] = $data['ID_kriteria'];
                            $j++;
                        }
                    }
                    for ($k=0; $k<$jumlahkriteria; $k++){
                        if ($X = $Y){
                            $idkriteria = $id_kriteria[$i][$Y];
                        }
                        else {
                            $X++;
                        }
                    }
                    
                    $query1 = "SELECT * FROM Kriteria WHERE id_kriteria = '$idkriteria'";
                    $hasil_query1 = mysqli_query($link, $query1);
                    $data1 = mysqli_fetch_array($hasil_query1);
                    $kriteria = $data1['ket_kriteria'];
                    $pesan_error .= "Pilihan kriteria '$kriteria' belum dipilih<br>";
                    
                }
            }
        }
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
                    $query = "INSERT INTO Nilai_pariwisata VALUES ('$id_nilai_alternatif', '$id_kriteria', '$subbkriteria')";
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
                $query = "INSERT INTO Nilai_pariwisata VALUES ('$id_nilai_alternatif', '$id_kriteria', '$fasilitas')";
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
                $query = "INSERT INTO Nilai_pariwisata VALUES ('$id_nilai_alternatif', '$id_kriteria', '$fasilitas')";
                $hasil_query = mysqli_query($link, $query);
            }
        }

        $id_nilai_alternatif = mysqli_real_escape_string($link, $id_nilai_alternatif);
        $query = "SELECT * FROM Penilaian WHERE ID_penilaian='$id_nilai_alternatif'";
        $hasil_query = mysqli_query($link, $query);

        $jumlah_data = mysqli_num_rows($hasil_query);
        if ($jumlah_data >= 1) {
            $pesan_error .= "ID kriteria yang sama sudah digunakan<br>";
        }

        if ($pesan_error === "") {
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
            $query = "INSERT INTO Penilaian VALUES ('$id_nilai_alternatif','$nama_pariwisata', '$id_pariwisata')";
            $result = mysqli_query($link, $query);

            if ($result){
                proses_subkriteria($id_nilai_alternatif);
                proses_fasilitas($id_nilai_alternatif);
                $pesan = "Penilaian bobot alternatif berhasil ditambahkan!";
                $pesan = urlencode($pesan);
                header("Location: bobot_alternatif.php?pesan={$pesan}");
            }
            else {
                die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
            }
        }
    }
    else {
        $pesan_error = "";
        $id_nilai_alternatif = "";
        $id_pariwisata = "";
        $sub_kriteria = "";
        $sub_kriteriafasilitas = "";
        $sub = "";
        
    }

    if (isset($_POST["hapus"])) {
        $id_nilai_alternatif = htmlentities(strip_tags(trim($_POST["ID_nilai_alternatif"])));
        $id_nilai_alternatif = mysqli_real_escape_string($link, $id_nilai_alternatif);
        $query = "DELETE FROM Penilaian WHERE ID_penilaian='$id_nilai_alternatif'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            $pesan = "Penilaian bobot alternatif sudah berhasil dihapus";
            $pesan = urlencode($pesan);
            header("Location: bobot_alternatif.php?pesan={$pesan}");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }

    if (isset($_POST["edit"])) {
        $id_nilai_alternatif = htmlentities(strip_tags(trim($_POST["ID_penilaian"])));
        $id_nilai_alternatif = mysqli_real_escape_string($link, $id_nilai_alternatif);
        $query = "SELECT * FROM Penilaian WHERE ID_penilaian='$id_nilai_alternatif'";
        $hasil_query = mysqli_query($link, $query);

        if ($hasil_query) {
            header("Location: edit_nilai_alternatif.php");
        }
        else {
            die ("Query gagal dijalankan : ".mysqli_errno($link)." - ".mysqli_error($link));
        }
    }
    $query = "SELECT max(ID_penilaian) as IDterbesar FROM Penilaian";
    $hasil_query = mysqli_query($link, $query);
    $data = mysqli_fetch_array($hasil_query);
    $id_nilai_alternatif = $data['IDterbesar'];
    $urutan = (int) substr($id_nilai_alternatif, 3, 3);
    $urutan++;
    $huruf = "PAL";
    $id_nilai_alternatif = $huruf . sprintf("%03s", $urutan);


?>
        <!-- home content -->
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu'></i>
                    <span class="dashboard">Bobot Alternatif</span>
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
                <div class="title1">Penilaian Bobot Alternatif</div>
                <div>
                    <?php
                        if (isset($pesan)) {
                            echo "<div class=\"pesan\">$pesan</div>";
                        }
                    ?>
                </div>

                <div class="overview-boxes1">
                    <div class="box12">
                        <div class="subbox12">
                            <div class="title2">Tambah Penilaian Alternatif</div>
                            <div>
                                <?php
                                    if ($pesan_error !== ""){
                                        echo "<div class=\"error\">$pesan_error</div>";
                                    }
                                ?>
                            </div>
                            <form id="form_penilaian" action="bobot_alternatif.php" method="post">
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
                                        $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
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
                                                $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
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
                                                        if ($value['sub_kriteria']==$sub_kriteriafasilitas){
                                                            echo "<input type=\"checkbox\" name=\"sub_kriteria_fasilitas[]\" value=\"{$value['sub_kriteria']}\" checked>{$value['sub_kriteria']}";
                                                            echo "<br>";
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
                                                            if ($value['sub_kriteria']==$sub_kriteria) {
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
                                <input type="submit" name="tambah" value="Tambah" class="button">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="overview-boxes1">
                    <div class="box11">
                        <div class="subbox11">
                            <table class="tabel1">
                                <tr>
                                    <th>ID Nilai</th>
                                    <th>Nama Pariwisata</th>
                                    <?php
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $i=0; $j=1;
                                        $namakriteria = array();
                                        while($datakriteria = mysqli_fetch_array($hasil_query)){
                                            $hasil = $datakriteria['ket_kriteria'];
                                            $namakriteria[$i][$j] = $hasil;
                                            $j++;
                                        }
                                        for ($j=1; $j<=$jumlahdata; $j++) {
                                            echo "<th>".$namakriteria[$i][$j]."</th>";
                                        }
                                    ?>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                                <?php
                                    $query = "SELECT * FROM Penilaian ORDER BY ID_penilaian ASC";
                                    $hasil_query = mysqli_query($link, $query);
                                    while ($data = mysqli_fetch_assoc($hasil_query)) {
                                        echo "<tr>";
                                        echo "<td>$data[ID_penilaian]</td>";
                                        echo "<td>$data[nama_pariwisata]</td>";
                                        $subbkriteria = mysqli_query($link, "SELECT * FROM Nilai_pariwisata WHERE ID_penilaian='$data[ID_penilaian]' ORDER BY ID_kriteria ASC");
                                        while ($subkrit=mysqli_fetch_assoc($subbkriteria)){
                                            echo "<td>$subkrit[sub_kriteria]</td>";
                                        }
                                        echo "<td>";
                                ?>
                                <form action="edit_nilai_alternatif.php" method="post">
                                    <input type="hidden" name="ID_nilai_alternatif" value="<?php echo "$data[ID_penilaian]"; ?>">
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
                                <form action="bobot_alternatif.php" method="post">
                                    <input type="hidden" name="ID_nilai_alternatif" value="<?php echo "$data[ID_penilaian]"; ?>">
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
                    </div>
                </div>
            </div>

            <?php
                }
                else{
            ?>
            <div class="home-content">
                <div class="title1">Penilaian Bobot Alternatif</div>
                <div>
                    <?php
                        if (isset($pesan)) {
                            echo "<div class=\"pesan\">$pesan</div>";
                        }
                    ?>
                </div>
                <div class="overview-boxes1">
                    <div class="box11">
                        <div class="subbox11">
                            <table class="tabel1">
                                <tr>
                                    <th>ID Nilai</th>
                                    <th>Nama Pariwisata</th>
                                    <?php
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $i=0; $j=1;
                                        $namakriteria = array();
                                        while($datakriteria = mysqli_fetch_array($hasil_query)){
                                            $hasil = $datakriteria['ket_kriteria'];
                                            $namakriteria[$i][$j] = $hasil;
                                            $j++;
                                        }
                                        for ($j=1; $j<=$jumlahdata; $j++) {
                                            echo "<th>".$namakriteria[$i][$j]."</th>";
                                        }
                                    ?>
                                </tr>
                                <?php
                                    $query = "SELECT * FROM Penilaian ORDER BY ID_penilaian ASC";
                                    $hasil_query = mysqli_query($link, $query);

                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }

                                    while ($data = mysqli_fetch_assoc($hasil_query)) {
                                        echo "<tr>";
                                        echo "<td>$data[ID_penilaian]</td>";
                                        echo "<td>$data[nama_pariwisata]</td>";
                                        $subbkriteria = mysqli_query($link, "SELECT * FROM Nilai_pariwisata WHERE ID_penilaian='$data[ID_penilaian]' ORDER BY ID_kriteria ASC");
                                        while ($subkrit=mysqli_fetch_assoc($subbkriteria)){
                                            echo "<td>$subkrit[sub_kriteria]</td>";
                                        }
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
            </div>
        </section>
        <script src="script.js"></script>
    </body>
</html>