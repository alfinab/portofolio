<!--Matriks Keputusan Normalisasi Berbobot-->
<button type="button" class="collapsible">Matriks Keputusan Normalisasi Berbobot</button>
                    <div class="content">
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
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
                                        $e = $elemen_normalisasi[$j][$k];
                                        $f = $arraybobot[$i][$k];
                                        $norm_bobot = round($e*$f, 3);
                                        $elemen_norm_bobot[$j][$k] = $norm_bobot;
                                        echo $norm_bobot;
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>