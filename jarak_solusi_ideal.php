<!--Jarak Solusi Ideal-->
<button type="button" class="collapsible">Jarak Solusi Ideal</button>
                    <div class="content">
                        <br>
                        <table class="tabel1">
                            <tr>
                                <?php
                                    echo "<th></th>";
                                    echo "<th>Ideal Positif</th>";
                                    echo "<th>Ideal Negatif</th>";
                                    echo "<th>Preferensi</th>";
                                ?>
                            </tr>
                            <?php
                                
                                for ($j=1; $j<=$jumlahdatapenilaian; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$arraynama[$i][$j]."</th>";
                                    echo "<td>";
                                        $sum = 0;
                                        for ($k=1; $k<=$jumlahdata; $k++){
                                            $normbobot = $elemen_norm_bobot[$j][$k];
                                            $idealpositif = $ideal_positif[$k];
                                            $norm_ideal = pow($normbobot-$idealpositif, 2);
                                            $sum += $norm_ideal;
                                        }
                                        $jarak_positif = round(sqrt($sum), 3);
                                        echo $jarak_positif;
                                    echo "</td>";
                                    echo "<td>";
                                        $sum = 0;
                                        for ($k=1; $k<=$jumlahdata; $k++){
                                            $normbobot = $elemen_norm_bobot[$j][$k];
                                            $idealnegatif = $ideal_negatif[$k];
                                            $norm_ideal = pow($normbobot-$idealnegatif, 2);
                                            $sum += $norm_ideal;
                                        }
                                        $jarak_negatif = round(sqrt($sum), 3);
                                        echo $jarak_negatif;
                                    echo "</td>";
                                    echo "<td>";
                                        $preferensi = round($jarak_negatif / ($jarak_positif + $jarak_negatif), 3);
                                        echo $preferensi;
                                        $arr_preferensi[$i][$j] = $preferensi;
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>