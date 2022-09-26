<!--Matriks Perbandingan Nilai kriteria-->
                <button class="collapsible">Matriks Perbandingan Nilai Kriteria</button>
                    <div class="content">
                        <br>
                        <table class="tabel5">
                            <tr>
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
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th>Kriteria</th>";
                                        }else{
                                            echo "<th>".$namakriteria[$i][$j]."</th>";
                                        }
                                    }
                                    
                                    $query = "SELECT * FROM Penilaian_kriteria";
                                    $hasil_query = mysqli_query($link, $query);
                                    if (!$hasil_query) {
                                        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                    }
                                    $jumlahdatanilai = mysqli_num_rows($hasil_query);
                                ?>
                            </tr>
                            <?php
                                $totalkolom = array(); $nilai = array();
                                $k=1;
                                for ($j=1; $j<=$jumlahdata; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$namakriteria[$i][$j]."</th>";
                                    for ($m=1; $m<=$jumlahdata; $m++){
                                        echo "<td>";
                                            $query = "SELECT * FROM Penilaian_kriteria";
                                            $hasil_query = mysqli_query($link, $query);
                                            while ($data = mysqli_fetch_assoc($hasil_query)) {
                                                if ($data['kriteria_1'] == $namakriteria[$i][$j] AND $data['kriteria_2'] == $namakriteria[$i][$m]) {
                                                    $a = $data['nilai'];
                                                    echo $a;
                                                    $nilai[$j][$m] = $a;
                                                }
                                                else if ($data['kriteria_1'] == $namakriteria[$i][$m] AND $data['kriteria_2'] == $namakriteria[$i][$j]) {
                                                    $a = round(1 / $data['nilai'], 3);
                                                    echo $a;
                                                    $nilai[$j][$m] = $a;
                                                }
                                            }
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                echo "<th>TOTAL</th>";
                                for ($j=1; $j<=$jumlahdata; $j++){
                                    $total_kolom = 0;
                                    for ($m=1; $m<=$jumlahdata; $m++){
                                        $total_kolom += $nilai[$m][$j];
                                    }
                                    $totalkolom[$i][$j] = $total_kolom;
                                    echo "<th>".$total_kolom."</th>";
                                }
                                echo "</tr>";
                            ?>
                        </table>
                        <br>
                    </div>