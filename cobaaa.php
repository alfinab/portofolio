<?php
    include("connection.php");
    $query = "SELECT * FROM Penilaian ORDER BY ID_penilaian ASC";
?>
                        <table border="1">
                            <tr>
                                <th>ID</th>
                                <th>ID Pariwisata</th>
                                <th>Nama Pariwisata</th>
                                <th>Luas</th>
                                <th>Biaya</th>
                                <th>Minat Pengunjung</th>
                                <th>Fasilitas</th>
                                <th>Minat Masyarakat</th>
                                <th>Edit</th>
                                <th>Hapus</th>
                            </tr>
                            <?php
                                $hasil_query = mysqli_query($link, $query);

                                if (!$hasil_query) {
                                    die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
                                }

                                while ($data = mysqli_fetch_assoc($hasil_query)) {
                                    echo "<tr>";
                                    echo "<td>$data[ID_penilaian]</td>";
                                    echo "<td>$data[ID_pariwisata]</td>";
                                    echo "<td>$data[nama_pariwisata]</td>";
                                    echo "<td>$data[kriteria_luas]</td>";
                                    echo "<td>$data[kriteria_biaya]</td>";
                                    echo "<td>$data[kriteria_mp]</td>";
                                    echo "<td>$data[kriteria_fasilitas]</td>";
                                    echo "<td>$data[kriteria_mm]</td>";
                                    echo "<td>";
                            ?>
                            <form action="edit_nilai_alternatif.php" method="post">
                                <input type="hidden" name="ID_nilai_alternatif" value="<?php echo "$data[ID_penilaian]"; ?>">
                                <center>
                                    <button type="submit" name="submit" value="Edit">
                                        <i class='bx bx-edit-alt'></i>
                                    </button>
                                </center>
                            </form>
                            <?php
                                    echo "</td>";
                                    echo "<td>";
                            ?>
                            <form action="bobot_alternatif.php" method="post">
                                <input type="hidden" name="ID_nilai_alternatif" value="<?php echo "$data[ID_penilaian]"; ?>">
                                <center>
                                    <button type="submit" name="hapus">
                                        <i class='bx bxs-trash'></i>
                                    </button> 
                                </center>
                            </form>
                            <?php
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
<?php
    $query = "SELECT * FROM Penilaian";
    $hasil_query = mysqli_query($link, $query);
    if (!$hasil_query) {
        die ("Query Error : ".mysqli_errno($link)." - ".mysqli_error($link));
    }
    $jumlahdata2 = mysqli_num_rows($hasil_query);
    $i=0; $j=1;
    $databiaya = array();
    while($datapenilaian = mysqli_fetch_array($hasil_query)){
        $arraybiaya = $datapenilaian['kriteria_biaya'];
        $databiaya[$i][$j] = $arraybiaya;
        $j++;
    }
    print_r($databiaya);
?>