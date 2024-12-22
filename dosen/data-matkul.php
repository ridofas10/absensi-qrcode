<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

?>



<!-- page content -->
<div class="right_col" role="main">
    <pag class="">
        <div class="card mt-3">
            <div class="card-header text-white" style="background-color: #2a3f54;">
                Daftar Mata Kuliah
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hovered table-striped">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>QR Code</th>
                        </tr>
                        <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_matkul ORDER BY kode_matkul DESC");
            $no = 1;
            while ($data = mysqli_fetch_array($tampil)) :
            ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['kode_matkul'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['sks'] ?></td>
                            <td><?= $data['semester'] ?></td>
                            <td>
                                <a href="generate_qr.php?kode_matkul=<?= $data['kode_matkul'] ?>&nama=<?= urlencode($data['nama']) ?>"
                                    class="btn btn-success">Lihat QR Code</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>
</div>



</pag>
</div>
<!-- /page content -->
<?php 
include 'footer.php';

?>