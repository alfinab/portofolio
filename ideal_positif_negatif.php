<!--Solusi Ideal Positif dan Negatif-->
<button type="button" class="collapsible">Solusi Ideal Positif dan Negatif</button>
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
                                $query = "SELECT * FROM Kriteria";
                                $hasil_query = mysqli_query($link, $query);
                                $j=1;
                                while ($data = mysqli_fetch_array($hasil_query)){
                                    $atribut[$i][$j] = $data['atribut'];
                                    $j++;
                                }
                                for ($j=1; $j<=2; $j++) {
                                    echo "<tr>";
                                    if ($i == 0 and $j == 1) {
                                        echo "<th>Positif</th>";
                                        for ($k=1; $k<=$jumlahdata; $k++) {
                                            echo "<td>";
                                            for ($l=1; $l<=$jumlahdatapenilaian; $l++){
                                                $g = $elemen_norm_bobot[$l][$k];
                                                $arraynorm_bobot[$l] = $g;
                                            }
                                            //ideal positif
                                            if ($atribut[$i][$k]=="Cost"){
                                                $min = min($arraynorm_bobot);
                                                echo $min;
                                                $ideal_positif[$k] = $min; //array ideal positif
                                            }
                                            else {
                                                $max = max($arraynorm_bobot);
                                                echo $max;
                                                $ideal_positif[$k] = $max; //array ideal positif
                                            }echo "</td>";
                                        }
                                    }
                                    if ($i == 0 and $j == 2) {
                                        echo "<th>Negatif</th>";
                                        for ($k=1; $k<=$jumlahdata; $k++) {
                                            echo "<td>";
                                            for ($l=1; $l<=$jumlahdatapenilaian; $l++){
                                                $g = $elemen_norm_bobot[$l][$k];
                                                $arraynorm_bobot[$l] = $g;
                                            }
                                            //ideal negatif
                                            if ($atribut[$i][$k]=="Cost"){
                                                $max = max($arraynorm_bobot);
                                                echo $max;
                                                $ideal_negatif[$k] = $max; //array ideal negatif
                                            }
                                            else {
                                                $min = min($arraynorm_bobot);
                                                echo $min;
                                                $ideal_negatif[$k] = $min; //array ideal negatif
                                            }echo "</td>";
                                        }
                                    }
                                }
                                    echo "</tr>";
                            ?>
                        </table>
                        <br>
                    </div>