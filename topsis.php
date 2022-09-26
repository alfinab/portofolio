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
            <div class="home-content">
                <div class="title1">Olah Data TOPSIS</div>
                <div class="overview-boxes1">
                <div class="box9">
                        <table class="tabel1">
                            <tr>
                                <th width="20%">ID</th>
                                <th width="20%">Nama Kriteria</th>
                                <th width="20%">Atribut</th>
                                <th width="10%">Bobot</th>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Kriteria ORDER BY ID_kriteria ASC";
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID_kriteria]</td>";
                                    echo "<td>$data[ket_kriteria]</td>";
                                    echo "<td>$data[atribut]</td>";
                                    echo "<td>";
                                    if ($data["ket_kriteria"]=="Luas"){
                                        $bobot_luas = 3;
                                        echo $bobot_luas;
                                    }
                                    elseif ($data["ket_kriteria"]=="Biaya"){
                                        $bobot_biaya = 5;
                                        echo $bobot_biaya;
                                    }
                                    elseif ($data["ket_kriteria"]=="Minat Pengunjung"){
                                        $bobot_mp = 4;
                                        echo $bobot_mp;
                                    }
                                    elseif ($data["ket_kriteria"]=="Fasilitas"){
                                        $bobot_fasilitas = 3;
                                        echo $bobot_fasilitas;
                                    }
                                    else {
                                        $bobot_mm = 3;
                                        echo $bobot_mm;
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>

                <div class="overview-boxes1">
                    <!--Matriks Keputusan-->
                <button type="button" class="collapsible">Matriks Keputusan</button>
                    <div class="content">
                        <p>
                            Matriks keputusan merupakan matriks yang setiap elemen-elemennya diperoleh dari nilai-nilai alternatif yang 
                            telah diinputkan. Setelah semua nilai terisi, masing-masing elemen dikuadratkan dan dijumlahkan setiap kolomnya. 
                            Hasil matriks keputusan dapat dilihat pada tabel di bawah ini.
                        </p>
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    $query = "SELECT * FROM Kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                    $i=0; $j=1;
                                    $dataarray = array();
                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                        $hasil = $datakriteria['ket_kriteria'];
                                        $dataarray[$i][$j] = $hasil;
                                        $j++;
                                    }
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th></th>";
                                        }else{
                                            echo "<th>".$dataarray[$i][$j]."</th>";
                                        }
                                    }
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }
                                $jumlahdata2 = mysqli_num_rows($hasil_query);
                                $i=0; $j=1;
                                $dataarray2 = array(); $dataluas = array(); $databiaya = array();
                                $datamp = array(); $datafasilitas = array(); $datamm = array();
                                while($datapenilaian = mysqli_fetch_array($hasil_query)){
                                    $hasil2 = $datapenilaian['nama_pariwisata'];
                                    $arrayluas = $datapenilaian['kriteria_luas'];
                                    $arraybiaya = $datapenilaian['kriteria_biaya'];
                                    $arraymp = $datapenilaian['kriteria_mp'];
                                    $arrayfasilitas = $datapenilaian['kriteria_fasilitas'];
                                    $arraymm = $datapenilaian['kriteria_mm'];
                                    $dataarray2[$i][$j] = $hasil2;
                                    $dataluas[$i][$j] = $arrayluas;
                                    $databiaya[$i][$j] = $arraybiaya;
                                    $datamp[$i][$j] = $arraymp;
                                    $datafasilitas[$i][$j] = $arrayfasilitas;
                                    $datamm[$i][$j] = $arraymm;
                                    $j++;
                                }
                                $totalkolom1 = 0; $totalkolom2 = 0; $totalkolom3 = 0; $totalkolom4 = 0; $totalkolom5 = 0;
                                for ($j=1; $j<=$jumlahdata2; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$dataarray2[$i][$j]."</th>";
                                    echo "<td>";
                                    $d = $dataluas[$i][$j];
                                    echo $d;
                                    $totalkolom1 += pow($d,2);
                                    echo "</td>";
                                    echo "<td>";
                                    $e = $databiaya[$i][$j];
                                    $totalkolom2 += pow($e,2);
                                    echo $e;
                                    echo "</td>";
                                    echo "<td>";
                                    $f = $datamp[$i][$j];
                                    echo $f;
                                    $totalkolom3 += pow($f,2);
                                    echo "</td>";
                                    echo "<td>";
                                    $g = $datafasilitas[$i][$j];
                                    echo $g;
                                    $totalkolom4 += pow($g,2);
                                    echo "</td>";
                                    echo "<td>";
                                    $h = $datamm[$i][$j];
                                    echo $h;
                                    $totalkolom5 += pow($h,2);
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                            <tr>
                                <th>Jumlah kuadrat</th>
                                <th><?php echo $totalkolom1 ?></th>
                                <th><?php echo $totalkolom2 ?></th>
                                <th><?php echo $totalkolom3 ?></th>
                                <th><?php echo $totalkolom4 ?></th>
                                <th><?php echo $totalkolom5 ?></th>
                            </tr>
                        </table>
                        <br>
                    </div>

                    <!--Matriks Normalisasi-->
                    <button type="button" class="collapsible">Matriks Normalisasi</button>
                    <div class="content">
                        <p>Matriks Normalisasi merupakan matriks yang elemen-elemenya diperoleh dari masing-masing elemen matriks keputusan 
                            dibagi dengan akar kuadrat dari jumlah kolom yang sudah dikuadratkan pada tabel matriks keputusan. Hasil matriks
                            normalisasi dapat dilihat pada tabel di bawah ini.
                        </p>
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    $query = "SELECT * FROM Kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                    $i=0; $j=1;
                                    $dataarray = array();
                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                        $hasil = $datakriteria['ID_kriteria'];
                                        $dataarray[$i][$j] = $hasil;
                                        $j++;
                                    }
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th></th>";
                                        }else{
                                            echo "<th>".$dataarray[$i][$j]."</th>";
                                        }
                                    }
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }
                                $jumlahdata2 = mysqli_num_rows($hasil_query);
                                $i=0; $j=1;
                                $dataarray2 = array(); $dataluas = array(); $databiaya = array();
                                $datamp = array(); $datafasilitas = array(); $datamm = array();
                                while($datapenilaian = mysqli_fetch_array($hasil_query)){
                                    $hasil2 = $datapenilaian['ID_pariwisata'];
                                    $arrayluas = $datapenilaian['kriteria_luas'];
                                    $arraybiaya = $datapenilaian['kriteria_biaya'];
                                    $arraymp = $datapenilaian['kriteria_mp'];
                                    $arrayfasilitas = $datapenilaian['kriteria_fasilitas'];
                                    $arraymm = $datapenilaian['kriteria_mm'];
                                    $dataarray2[$i][$j] = $hasil2;
                                    $dataluas[$i][$j] = $arrayluas;
                                    $databiaya[$i][$j] = $arraybiaya;
                                    $datamp[$i][$j] = $arraymp;
                                    $datafasilitas[$i][$j] = $arrayfasilitas;
                                    $datamm[$i][$j] = $arraymm;
                                    $j++;
                                }
                                $norm_bobot_luas = array(); $norm_bobot_biaya = array(); $norm_bobot_mp = array();
                                $norm_bobot_fasilitas = array(); $norm_bobot_mm = array();
                                for ($j=1; $j<=$jumlahdata2; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$dataarray2[$i][$j]."</th>";
                                    echo "<td>";
                                        $d = $dataluas[$i][$j];
                                        $akarluas = sqrt($totalkolom1);
                                        $normluas = round($d / $akarluas, 3);
                                        echo $normluas;
                                        $norm_bobot = $normluas * $bobot_luas;
                                        $norm_bobot_luas[$i][$j] = $norm_bobot;
                                    echo "</td>";
                                    echo "<td>";
                                        $e = $databiaya[$i][$j];
                                        $akarbiaya = sqrt($totalkolom2);
                                        $normbiaya = round($e / $akarbiaya, 3);
                                        echo $normbiaya;
                                        $norm_bobot = $normbiaya * $bobot_biaya;
                                        $norm_bobot_biaya[$i][$j] = $norm_bobot;
                                    echo "</td>";
                                    echo "<td>";
                                        $f = $datamp[$i][$j];
                                        $akarmp = sqrt($totalkolom3);
                                        $normmp = round($f / $akarmp, 3);
                                        echo $normmp;
                                        $norm_bobot = $normmp * $bobot_mp;
                                        $norm_bobot_mp[$i][$j] = $norm_bobot;
                                    echo "</td>";
                                    echo "<td>";
                                        $g = $datafasilitas[$i][$j];
                                        $akarfasilitas = sqrt($totalkolom4);
                                        $normfasilitas = round($g / $akarfasilitas, 3);
                                        echo $normfasilitas;
                                        $norm_bobot = $normfasilitas * $bobot_fasilitas;
                                        $norm_bobot_fasilitas[$i][$j] = $norm_bobot;
                                    echo "</td>";
                                    echo "<td>";
                                        $h = $datamm[$i][$j];
                                        $akarmm = sqrt($totalkolom5);
                                        $normmm = round($h / $akarmm, 3);
                                        echo $normmm;
                                        $norm_bobot = $normmm * $bobot_mm;
                                        $norm_bobot_mm[$i][$j] = $norm_bobot;
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>

                    <!--Matriks Keputusan Normalisasi Berbobot-->
                    <button type="button" class="collapsible">Matriks Keputusan Normalisasi Berbobot</button>
                    <div class="content">
                        <p>Matriks keputusan normalisasi berbobot merupakan matriks yang isi elemen-elemennya diperoleh dari perkalian 
                            masing-masing elemen matriks normalisasi dengan bobot yang telah diperoleh pada proses AHP.
                        </p>
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    $query = "SELECT * FROM Kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                    $i=0; $j=1;
                                    $dataarray = array();
                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                        $hasil = $datakriteria['ID_kriteria'];
                                        $dataarray[$i][$j] = $hasil;
                                        $j++;
                                    }
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th></th>";
                                        }else{
                                            echo "<th>".$dataarray[$i][$j]."</th>";
                                        }
                                    }
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }
                                $jumlahdata2 = mysqli_num_rows($hasil_query);
                                $i=0; $j=1;
                                for ($j=1; $j<=$jumlahdata2; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$dataarray2[$i][$j]."</th>";
                                    echo "<td>";
                                    echo round($norm_bobot_luas[$i][$j], 3);
                                    echo "</td>";
                                    echo "<td>";
                                    echo round($norm_bobot_biaya[$i][$j], 3);
                                    echo "</td>";
                                    echo "<td>";
                                    echo round($norm_bobot_mp[$i][$j], 3);
                                    echo "</td>";
                                    echo "<td>";
                                    echo round($norm_bobot_fasilitas[$i][$j], 3);
                                    echo "</td>";
                                    echo "<td>";
                                    echo round($norm_bobot_mm[$i][$j], 3);
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>

                    <!--Solusi Ideal Positif dan Negatif-->
<button type="button" class="collapsible">Solusi Ideal Positif dan Negatif</button>
                    <div class="content">
                        <p>Solusi ideal positif diperoleh dari nilai maksimal dari kolom matriks normalisasi berbobot setiap kriteria jika 
                            atribut dari kriteria adalah benefit, serta nilai minimal jika atribut dari kriteria adalah cost.
                        </p>
                        <p>
                            Sedangkan solusi ideal negatif diperoleh dari nilai maksimal dari kolom matriks normalisasi berbobot setiap kriteria jika 
                            atribut dari kriteria adalah cost, serta nilai minimal jika atribut dari kriteria adalah benefit.
                        </p>
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    $query = "SELECT * FROM Kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                    $i=0; $j=1;
                                    $dataarray3 = array();
                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                        $hasil = $datakriteria['ID_kriteria'];
                                        $hasil3 = $datakriteria['atribut'];
                                        $dataarray[$i][$j] = $hasil;
                                        $dataarray3[$i][$j] = $hasil3;
                                        $j++;
                                    }
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th></th>";
                                        }else{
                                            echo "<th>".$dataarray[$i][$j]."</th>";
                                        }
                                    }
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }
                                $jumlahdata2 = mysqli_num_rows($hasil_query);
                                $i=0; $j=1;
                                for ($j=1; $j<=2; $j++) {
                                    echo "<tr>";
                                    if ($i == 0 and $j == 1) {
                                        echo "<th>Positif</th>";
                                    }
                                    if ($i == 0 and $j == 2) {
                                        echo "<th>Negatif</th>";
                                    }
                                    echo "<td>";
                                    if ($i == 0 and $j == 1) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K01"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_luas);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_positif[$y][$z] = $min;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_luas);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_positif[$y][$z] = $max;
                                                }
                                            }
                                        }
                                    }
                                    if ($i == 0 and $j == 2) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K01"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_luas);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_negatif[$y][$z] = $max;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_luas);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_negatif[$y][$z] = $min;
                                                }
                                            }
                                        }
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    if ($i == 0 and $j == 1) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K02"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_biaya);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_positif[$y][$z] = $min;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_biaya);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_positif[$y][$z] = $max;
                                                }
                                            }
                                        }
                                    }
                                    if ($i == 0 and $j == 2) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K02"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_biaya);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_negatif[$y][$z] = $max;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_biaya);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_negatif[$y][$z] = $min;
                                                }
                                            }
                                        }
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    if ($i == 0 and $j == 1) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K03"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_mp);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_positif[$y][$z] = $min;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_mp);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_positif[$y][$z] = $max;
                                                }
                                            }
                                        }
                                    }
                                    if ($i == 0 and $j == 2) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K03"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_mp);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_negatif[$y][$z] = $max;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_mp);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_negatif[$y][$z] = $min;
                                                }
                                            }
                                        }
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    if ($i == 0 and $j == 1) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K04"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_fasilitas);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_positif[$y][$z] = $min;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_fasilitas);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_positif[$y][$z] = $max;
                                                }
                                            }
                                        }
                                    }
                                    if ($i == 0 and $j == 2) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K04"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_fasilitas);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_negatif[$y][$z] = $max;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_fasilitas);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_negatif[$y][$z] = $min;
                                                }
                                            }
                                        }
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    if ($i == 0 and $j == 1) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K05"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_mm);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_positif[$y][$z] = $min;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_mm);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_positif[$y][$z] = $max;
                                                }
                                            }
                                        }
                                    }
                                    if ($i == 0 and $j == 2) {
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($dataarray[$y][$z] == "K05"){
                                                if ($dataarray3[$y][$z] == "Cost") {
                                                    $data_norm_bobot = min($norm_bobot_mm);
                                                    $max = max($data_norm_bobot);
                                                    echo $max;
                                                    $ideal_negatif[$y][$z] = $max;
                                                }
                                                else {
                                                    $data_norm_bobot = min($norm_bobot_mm);
                                                    $min = min($data_norm_bobot);
                                                    echo $min;
                                                    $ideal_negatif[$y][$z] = $min;
                                                }
                                            }
                                        }
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>

                    <!--Jarak Solusi Ideal-->
<button type="button" class="collapsible">Jarak Solusi Ideal</button>
                    <div class="content">
                        <p>
                            Jarak solusi ideal merupakan jarak setiap alternatif dengan solusi ideal-positif dan ideal-negatif. <b>Jarak positif</b>
                            diperoleh dengan elemen kolom setiap kriteria matriks normalisasi berbobot dikurangi dengan solusi ideal positif 
                            yang bersesuaian, kemudian dikuadratkan setelah itu hasil masing-masing kuadrat dijumlahkan dan di akar kuadrat.
                        </p>
                        <p>
                            <b>Jarak negatif</b> diperoleh dengan elemen kolom setiap kriteria matriks normalisasi berbobot dikurangi dengan solusi ideal negatif 
                            yang bersesuaian, kemudian dikuadratkan setelah itu hasil masing-masing kuadrat dijumlahkan dan di akar kuadrat.
                        </p>
                        <p>
                            <b>Nilai preferensi</b> merupakan nilai kedekatan suatu alternatif dengan solusi ideal. Nilai preferensi diperoleh dengan membagi 
                            jarak negatif dengan jumlah dari jarak negatif dan jarak positif.
                        </p>
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    echo "<th></th>";
                                    echo "<th>Positif</th>";
                                    echo "<th>Negatif</th>";
                                    echo "<th>Preferensi</th>";
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }
                                $jumlahdata2 = mysqli_num_rows($hasil_query);
                                $i=0; $j=1;
                                for ($j=1; $j<=$jumlahdata2; $j++) {
                                    $aa = $norm_bobot_luas[$i][$j]; $bb = $norm_bobot_biaya[$i][$j]; $cc = $norm_bobot_mp[$i][$j];
                                    $dd = $norm_bobot_fasilitas[$i][$j]; $ee = $norm_bobot_mm[$i][$j];
                                    echo "<tr>";
                                    echo "<th>".$dataarray2[$i][$j]."</th>";
                                    echo "<td>";
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1; $sum=0;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($z == 1){
                                                $norm_ideal = pow($aa - $ideal_positif[$y][$z], 2);
                                            }
                                            if ($z == 2){
                                                $norm_ideal = pow($bb - $ideal_positif[$y][$z], 2);
                                            }
                                            if ($z == 3){
                                                $norm_ideal = pow($cc - $ideal_positif[$y][$z], 2);
                                            }
                                            if ($z == 4){
                                                $norm_ideal = pow($dd - $ideal_positif[$y][$z], 2);
                                            }
                                            if ($z == 5){
                                                $norm_ideal = pow($ee - $ideal_positif[$y][$z], 2);
                                            }
                                            $sum += $norm_ideal;
                                        }
                                        $jarak_positif = sqrt($sum);
                                        echo round($jarak_positif, 3);
                                    echo "</td>";
                                    echo "<td>";
                                        $query = "SELECT * FROM Kriteria";
                                        $hasil_query = mysqli_query($link, $query);
                                        if (!$hasil_query) {
                                            die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                        }
                                        $jumlahdata = mysqli_num_rows($hasil_query);
                                        $y=0; $z=1; $sum=0;
                                        for ($z=1; $z<=$jumlahdata; $z++){
                                            if ($z == 1){
                                                $norm_ideal = pow($aa - $ideal_negatif[$y][$z], 2);
                                            }
                                            if ($z == 2){
                                                $norm_ideal = pow($bb - $ideal_negatif[$y][$z], 2);
                                            }
                                            if ($z == 3){
                                                $norm_ideal = pow($cc - $ideal_negatif[$y][$z], 2);
                                            }
                                            if ($z == 4){
                                                $norm_ideal = pow($dd - $ideal_negatif[$y][$z], 2);
                                            }
                                            if ($z == 5){
                                                $norm_ideal = pow($ee - $ideal_negatif[$y][$z], 2);
                                            }
                                            $sum += $norm_ideal;
                                        }
                                        $jarak_negatif = sqrt($sum);
                                        echo round($jarak_negatif, 3);
                                    echo "</td>";
                                    echo "<td>";
                                        $preferensi = $jarak_negatif / ($jarak_positif + $jarak_negatif);
                                        echo round($preferensi, 3);
                                        $arr_preferensi[$i][$j] = $preferensi;
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>

                    <!--Pemeringkatan Alternatif-->
<button type="button" class="collapsible">Pemeringkatan Alternatif</button>
                    <div class="content">
                        <p>
                            Penentuan ranking dari setiap alternatif dilakuakan dengan melihat nilai preferensi. Alternatif dengan nilai preferensi 
                            tertinggi merupakan alternatif terbaik.
                        </p>
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    echo "<th>Alternatif</th>";
                                    echo "<th>Nilai Preferansi</th>";
                                    echo "<th>Rangking</th>";
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }
                                $jumlahdata2 = mysqli_num_rows($hasil_query);
                                $i=0; $j=1; $ranking=0; $z = 0;
                                for ($j=1; $j<=$jumlahdata2; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$dataarray2[$i][$j]."</th>";
                                    echo "<td>";
                                        $total_preferensi = $arr_preferensi[$i][$j];
                                        echo round($total_preferensi, 3);
                                    echo "</td>";
                                    echo "<td>";
                                        $total = min($arr_preferensi);
                                        rsort($total);
                                        for ($z=0; $z<$jumlahdata2; $z++){
                                            if ($total_preferensi == $total[$z]){
                                                $ranking = $z + 1;
                                                echo $ranking;
                                            } 
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>
                </div>
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