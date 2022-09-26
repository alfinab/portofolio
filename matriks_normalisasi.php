<!--Matriks Normalisasi-->
                <button type="button" class="collapsible">Matriks Normalisasi</button>
                    <div class="content">
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
                                for ($j=1; $j<=$jumlahdatapenilaian; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$arraynama[$i][$j]."</th>";
                                    for ($k=1; $k<=$jumlahdata; $k++){
                                        echo "<td>";
                                        $c = $nilaikonversi[$j][$k];
                                        $d = $ttl_kolom_keputusan[$i][$k];
                                        $normalisasi = round($c/sqrt($d), 3);
                                        $elemen_normalisasi[$j][$k] = $normalisasi;
                                        echo $normalisasi;
                                    }
                                    echo "</td>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>