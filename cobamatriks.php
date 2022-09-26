<?php
    include("connection.php");
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
    print_r($dataarray);
    echo "<br>";
    $query = "SELECT * FROM Penilaian_kriteria";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    echo "<table border='1'>";
    echo "<tr>";
    for ($j=0; $j<=$jumlahdata; $j++) {
        if ($i==0 AND $j==0) {
            echo "<th>Kriteria</th>";
        }else{
            echo "<th>".$dataarray[$i][$j]."</th>";
        }
    }
    echo "</tr>";
    $c = 0;
    for ($j=1; $j<=$jumlahdata; $j++) {
        echo "<tr>";
        echo "<th>".$dataarray[$i][$j]."</th>";
        echo "<td>";
        
        for ($m=1; $m<=$jumlahdata; $m++) {
            if ($dataarray[$i][$j] == "Luas" AND $dataarray[$i][$m] == "Luas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        echo $a;
                        $c = $c + $a;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Biaya" AND $dataarray[$i][$m] == "Luas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        echo $a;
                        $c = $c + $a;
                    }
                    else if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Biaya") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                        $c = $c + $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Pengunjung" AND $dataarray[$i][$m] == "Luas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        echo $a;
                        $c = $c + $a;
                    }
                    else if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b; 
                        $c = $c + $b;                      
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Fasilitas" AND $dataarray[$i][$m] == "Luas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        echo $a;
                        $c = $c + $a;
                    }
                    else if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Fasilitas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                        $c = $c + $b;                       
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Masyarakat" AND $dataarray[$i][$m] == "Luas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        echo $a;
                        $c = $c + $a;
                    }
                    else if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;  
                        $c = $c + $b;                     
                    }
                }
            }
        }
        
        echo "</td>";
        echo "<td>";
        for ($m=1; $m<=$jumlahdata; $m++) {
            if ($dataarray[$i][$j] == "Luas" AND $dataarray[$i][$m] == "Biaya"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Biaya") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Biaya" AND $dataarray[$i][$m] == "Biaya"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Biaya") {
                        echo $data['nilai'];
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Pengunjung" AND $dataarray[$i][$m] == "Biaya"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Biaya") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Fasilitas" AND $dataarray[$i][$m] == "Biaya"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Biaya") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Fasilitas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Masyarakat" AND $dataarray[$i][$m] == "Biaya"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Biaya") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;                       
                    }
                }
            }
        }
        echo "</td>";
        echo "<td>";
        for ($m=1; $m<=$jumlahdata; $m++) {
            if ($dataarray[$i][$j] == "Luas" AND $dataarray[$i][$m] == "Minat Pengunjung"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Biaya" AND $dataarray[$i][$m] == "Minat Pengunjung"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Biaya") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Pengunjung" AND $dataarray[$i][$m] == "Minat Pengunjung"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        echo $data['nilai'];
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Fasilitas" AND $dataarray[$i][$m] == "Minat Pengunjung"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Fasilitas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Masyarakat" AND $dataarray[$i][$m] == "Minat Pengunjung"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
        }
        echo "</td>";
        echo "<td>";
        for ($m=1; $m<=$jumlahdata; $m++) {
            if ($dataarray[$i][$j] == "Luas" AND $dataarray[$i][$m] == "Fasilitas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Fasilitas") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Biaya" AND $dataarray[$i][$m] == "Fasilitas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0;
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Fasilitas") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Biaya") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Pengunjung" AND $dataarray[$i][$m] == "Fasilitas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Fasilitas") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Fasilitas" AND $dataarray[$i][$m] == "Fasilitas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Fasilitas") {
                        echo $data['nilai'];
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Masyarakat" AND $dataarray[$i][$m] == "Fasilitas"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Fasilitas") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
        }
        echo "</td>";
        echo "<td>";
        for ($m=1; $m<=$jumlahdata; $m++) {
            if ($dataarray[$i][$j] == "Luas" AND $dataarray[$i][$m] == "Minat Masyarakat"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Luas" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Luas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Biaya" AND $dataarray[$i][$m] == "Minat Masyarakat"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Biaya" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Biaya") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Pengunjung" AND $dataarray[$i][$m] == "Minat Masyarakat"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Pengunjung" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Minat Pengunjung") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Fasilitas" AND $dataarray[$i][$m] == "Minat Masyarakat"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Fasilitas" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        echo $data['nilai'];
                    }
                    else if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Fasilitas") {
                        $a = $data['nilai'];
                        $b = 1 / $a;
                        echo $b;
                    }
                }
            }
            else if ($dataarray[$i][$j] == "Minat Masyarakat" AND $dataarray[$i][$m] == "Minat Masyarakat"){
                $query = "SELECT * FROM Penilaian_kriteria";
                $hasil_query = mysqli_query($link, $query);
                if (!$hasil_query) {
                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                }
                $a = 0; $b = 0; 
                while ($data = mysqli_fetch_assoc($hasil_query)) {
                    if ($data['kriteria_1'] == "Minat Masyarakat" AND $data['kriteria_2'] == "Minat Masyarakat") {
                        echo $data['nilai'];
                    }
                }
            }
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<th>Total</th>";
    echo "<th>$c</th>";
    echo "</tr>";
    echo "</table>";
?>