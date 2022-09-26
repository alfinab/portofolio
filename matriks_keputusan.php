<!--Matriks Keputusan-->
                <button type="button" class="collapsible">Matriks Keputusan</button>
                    <div class="content">
                        <p>
                            <h3>Konversi Nilai Alternatif</h3>
                                <?php
                                    $query = "SELECT * FROM Kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jml = mysqli_num_rows($hasil_query);
                                    $i=0; $j=1; $namakriteria = array(); $id = array();
                                    while($datakriteria = mysqli_fetch_array($hasil_query)){
                                        $namakriteria[$i][$j] = $datakriteria['ket_kriteria'];
                                        $id[$i][$j] = $datakriteria['ID_kriteria'];
                                        $j++;
                                    }
                                    echo "<table class=\"tabel5\">";
                                    for($j=1; $j<=$jml; $j++){
                                        echo "<tr>";
                                        echo "<th>".$namakriteria[$i][$j]."</th>";
                                        echo "<td>";
                                        $id_kriteria = $id[$i][$j];
                                        $query = "SELECT * FROM Konversi_nilai WHERE ID_kriteria='$id_kriteria'";
                                        $hasil_query = mysqli_query($link, $query);
                                        while ($data = mysqli_fetch_assoc($hasil_query)) {
                                            echo $data['sub_kriteria']." = ".$data['nilai'];
                                            echo "<br>";
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";     
                                ?>
                        </p>
                        <br>
                        <p>
                            Hasil matriks keputusan dapat dilihat pada tabel di bawah ini.
                        </p>
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
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th></th>";
                                        }else{
                                            echo "<th>".$namakriteria[$i][$j]."</th>";
                                        }
                                    }
                                ?>
                            </tr>
                            <?php
                                $query = "SELECT * FROM Penilaian";
                                $hasil_query = mysqli_query($link, $query);
                                $jumlahdatapenilaian = mysqli_num_rows($hasil_query);
                                $i=0; $j=1;
                                $arraynama = array(); $arrayidpenilaian = array();
                                while($datapenilaian = mysqli_fetch_array($hasil_query)){
                                    $nama = $datapenilaian['nama_pariwisata'];
                                    $idpenilaian = $datapenilaian['ID_penilaian'];
                                    $arraynama[$i][$j] = $nama; //buat array nama alternatif
                                    $arrayidpenilaian[$i][$j] = $idpenilaian;
                                    $j++;
                                }
                                
                                $ttl_kolom_keputusan = array(); $nilaikonversi = array();
                                for ($j=1; $j<=$jumlahdatapenilaian; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$arraynama[$i][$j]."</th>"; //tulis nama alternatif
                                    $idnilai = $arrayidpenilaian[$i][$j]; //ambil id penilaian
                                    $query = "SELECT * FROM Nilai_pariwisata WHERE ID_penilaian='$idnilai' ORDER BY ID_kriteria ASC";
                                    $hasil_query = mysqli_query($link, $query);
                                    $jumlahdata = mysqli_num_rows($hasil_query);
                                    $i=0; $k=1;
                                    $subkrit = array(); $arrayid_penilaian = array(); $idkrit = array();
                                    while($datanilai = mysqli_fetch_array($hasil_query)){
                                        $sub_kriteria = $datanilai['sub_kriteria'];
                                        $idkriteria = $datanilai['ID_kriteria'];
                                        $subkrit[$i][$k] = $sub_kriteria;
                                        $idkrit[$i][$k] = $idkriteria;
                                        $k++;
                                    }
                                    for ($k=1; $k<=$jumlahdata; $k++){
                                        echo "<td>";
                                        $explode = explode(", ", $subkrit[$i][$k]); //konversi sub kriteria ke dalam sebuah array
                                        $a=0;
                                        for ($x=0; $x<sizeof($explode); $x++){
                                            $subkriteria = $explode[$x]; //ambil string sub kriteria ke-x
                                            $query = "SELECT * FROM Konversi_nilai WHERE sub_kriteria='$subkriteria'";
                                            $result = mysqli_query($link, $query);
                                            while ($datakonversi = mysqli_fetch_array($result)){
                                                $a += $datakonversi['nilai']; //ambil nilai konversi sub kriteria ke-x
                                            }
                                            if ($sub_kriteria==="-"){
                                                $nilaikonversi[$j][$k] = 0;
                                            }
                                            else {
                                            $nilaikonversi[$j][$k] = $a; //masukkan nilai konversi ke array
                                            }
                                        }
                                        echo $a;
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                echo "<th>JUMLAH KUADRAT</th>";
                                for ($j=1; $j<=$jumlahdata; $j++){
                                    $ttl_kolom = 0;
                                    for ($m=1; $m<=$jumlahdatapenilaian; $m++){
                                        $ttl_kolom += $nilaikonversi[$m][$j] ** 2;
                                    }
                                    $ttl_kolom_keputusan[$i][$j] = $ttl_kolom;
                                    echo "<th>".$ttl_kolom."</th>";
                                }
                                echo "</tr>";
                            ?>
                        </table>
                        <br>
                    </div>