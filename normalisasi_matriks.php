<!--Normalisasi Matriks Perbandingan Kriteria-->
                <button class="collapsible">Normalisasi Matriks Perbandingan Kriteria</button>
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
                                    for ($j=0; $j<=$jumlahdata; $j++) {
                                        if ($i==0 AND $j==0) {
                                            echo "<th>Kriteria</th>";
                                        }else{
                                            echo "<th>".$namakriteria[$i][$j]."</th>";
                                        }
                                    }
                                ?>
                                <th>Total</th>
                                <th>Bobot</th>
                            </tr>
                            <?php
                                $arraybobot = array();
                                for ($j=1; $j<=$jumlahdata; $j++) {
                                    $total_baris = 0;
                                    echo "<tr>";
                                    echo "<th>".$namakriteria[$i][$j]."</th>";
                                    for ($m=1; $m<=$jumlahdata; $m++){
                                        echo "<td>";
                                            $query = "SELECT * FROM Penilaian_kriteria";
                                            $hasil_query = mysqli_query($link, $query);
                                            while ($data = mysqli_fetch_assoc($hasil_query)) {
                                                if ($data['kriteria_1'] == $namakriteria[$i][$j] AND $data['kriteria_2'] == $namakriteria[$i][$m]) {
                                                    $a = $data['nilai'];
                                                    $b = round($a/$totalkolom[$i][$m], 3);
                                                    echo $b;
                                                    $total_baris += $b;
                                                }
                                                else if ($data['kriteria_1'] == $namakriteria[$i][$m] AND $data['kriteria_2'] == $namakriteria[$i][$j]) {
                                                    $a = round(1 / $data['nilai'], 3);
                                                    $b = round($a/$totalkolom[$i][$m], 3);
                                                    echo $b;
                                                    $total_baris += $b;
                                                }
                                            }
                                        echo "</td>";
                                    }
                                    echo "<th>".$total_baris."</th>";
                                    $bobot = round($total_baris/$jumlahdata, 3);
                                    $arraybobot[$i][$j] = $bobot;
                                    echo "<th>".$bobot."</th>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>