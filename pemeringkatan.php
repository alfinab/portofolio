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
                                    echo "<th>Nilai Preferensi</th>";
                                    echo "<th>Rangking</th>";
                                ?>
                            </tr>
                            <?php
                                for ($j=1; $j<=$jumlahdatapenilaian; $j++) {
                                    echo "<tr>";
                                    echo "<th>".$arraynama[$i][$j]."</th>";
                                    echo "<td>";
                                        $total_preferensi = $arr_preferensi[$i][$j];
                                        echo round($total_preferensi, 3);
                                    echo "</td>";
                                    echo "<td>";
                                        $total = min($arr_preferensi);
                                        rsort($total);
                                        for ($z=0; $z<$jumlahdatapenilaian; $z++){
                                            if ($total_preferensi == $total[$z]){
                                                $ranking = $z + 1;
                                                echo $ranking;
                                                break;
                                            } 
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <br>
                    </div>