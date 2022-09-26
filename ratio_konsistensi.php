<!--Ratio Konsistensi-->
                <button class="collapsible">Ratio Konsistensi</button>
                    <div class="content">
                        <p>Sebelum memakai bobot dari masing-masing kriteria, harus dicek terlebih dahulu konsistensi dari matriks A. 
                            Apabila CR atau Consistency Ratio kurang dari 0.1 maka matriks A atau perbandingan dianggap konsisten dan bobot yang 
                            diperoleh dapat digunakan.
                        </p>
                        <br>
                        <h3>Nilai Eigen Maksimal = 
                            <?php
                                $jumlahlambda = 0;
                                for ($j=1; $j<=$jumlahdata; $j++){
                                    $jumlahlambda += $arraylambda[$i][$j];
                                }
                                $lambda_max = round($jumlahlambda/$jumlahdata, 3);
                                echo "$lambda_max";
                            ?>
                        </h3>
                        <br>
                        <h3>Konsistensi Index</h3>
                        <center>
                            <p>$CI = \dfrac{\lambda_{max} - n}{n - 1} = 
                                \dfrac {<?php echo $lambda_max ?>-<?php echo $jumlahdata ?>} {<?php echo $jumlahdata ?>-1} = $
                                <?php
                                    $CI = round(($lambda_max-$jumlahdata) / ($jumlahdata-1), 3);
                                    echo $CI;
                                ?>
                            </p>
                        </center>
                        <br>
                        <h3>Tabel Ratio Indeks</h3>
                        <table class="tabel5">
                            <tr>
                                <th>Ordo matriks</th>
                                <?php
                                    for ($x=1; $x<=15; $x++){
                                        echo "<td>";
                                        echo $x;
                                        echo "</td>";
                                    }
                                ?>
                            </tr>
                            <tr>
                                <th>Ratio Indeks</th>
                                <td>0</td>
                                <td>0</td>
                                <td>0.58</td>
                                <td>0.9</td>
                                <td>1.12</td>
                                <td>1.24</td>
                                <td>1.32</td>
                                <td>1.41</td>
                                <td>1.46</td>
                                <td>1.49</td>
                                <td>1.51</td>
                                <td>1.48</td>
                                <td>1.56</td>
                                <td>1.57</td>
                                <td>1.59</td>
                            </tr>
                        </table>
                        <br> 
                        <h3>Konsistensi Ratio</h3>
                        <center>
                                <?php
                                    if ($jumlahdata==1 or $jumlahdata==2){
                                        $RI = 0;
                                    }
                                    else if ($jumlahdata==3){
                                        $RI = 0.58;
                                    }
                                    else if ($jumlahdata==4){
                                        $RI = 0.9;
                                    }
                                    else if ($jumlahdata==5){
                                        $RI = 1.12;
                                    }
                                    else if ($jumlahdata==6){
                                        $RI = 1.24;
                                    }
                                    else if ($jumlahdata==7){
                                        $RI = 1.32;
                                    }
                                    else if ($jumlahdata==8){
                                        $RI = 1.41;
                                    }
                                    else if ($jumlahdata==9){
                                        $RI = 1.46;
                                    }
                                    else if ($jumlahdata==10){
                                        $RI = 1.49;
                                    }
                                    else if ($jumlahdata==11){
                                        $RI = 1.51;
                                    }
                                    else if ($jumlahdata==12){
                                        $RI = 1.48;
                                    }
                                    else if ($jumlahdata==13){
                                        $RI = 1.56;
                                    }
                                    else if ($jumlahdata==14){
                                        $RI = 1.57;
                                    }
                                    else {
                                        $RI = 1.59;
                                    }
                                    echo "<p>$ CR = \dfrac{CI}{RI} = \dfrac{ $CI }{ $RI } = $";
                                    $CR = round($CI / $RI, 3);
                                    echo $CR;
                                ?>
                            </p>
                        </center>
                        <p>
                            <?php
                                if ($CR < 0.1) {
                                    echo "Matriks perbandingan kriteria konsisten dan bobot yang telah diperoleh dapat digunakan.";
                                }
                                else{
                                    echo "Matriks perbandingan kriteria tidak konsisten, sehingga bobot tidak dapat digunakan.";
                                }
                            ?>
                        </p>
                        <br>
                    </div>