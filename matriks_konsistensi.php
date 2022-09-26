<!--Matriks konsistensi-->
<button class="collapsible">Matriks Konsistensi Kriteria</button>
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
                                <th>Lambda(λ)</th>
                            </tr>
                            <?php
                                $arraylambda = array();
                                for ($j=1; $j<=$jumlahdata; $j++) {
                                    $total_baris_kons = 0;
                                    echo "<tr>";
                                    echo "<th>".$namakriteria[$i][$j]."</th>";
                                    for ($m=1; $m<=$jumlahdata; $m++){
                                        echo "<td>";
                                            $query = "SELECT * FROM Penilaian_kriteria";
                                            $hasil_query = mysqli_query($link, $query);
                                            while ($data = mysqli_fetch_assoc($hasil_query)) {
                                                if ($data['kriteria_1'] == $namakriteria[$i][$j] AND $data['kriteria_2'] == $namakriteria[$i][$m]) {
                                                    $a = $data['nilai'];
                                                    $c = round($a*$arraybobot[$i][$m], 3);
                                                    echo $c;
                                                    $total_baris_kons += $c;
                                                }
                                                else if ($data['kriteria_1'] == $namakriteria[$i][$m] AND $data['kriteria_2'] == $namakriteria[$i][$j]) {
                                                    $a = round(1 / $data['nilai'], 3);
                                                    $c = round($a*$arraybobot[$i][$m], 3);
                                                    echo $c;
                                                    $total_baris_kons += $c;
                                                }
                                            }
                                        echo "</td>";
                                    }
                                    echo "<th>".$total_baris_kons."</th>";
                                    $lambda = round($total_baris_kons/$arraybobot[$i][$j], 3);
                                    $arraylambda[$i][$j] = $lambda;
                                    echo "<th>".$lambda."</th>";
                                    echo "</tr>";
                                }
                                    
                            ?>
                        </table>
                        <br>
                    </div>