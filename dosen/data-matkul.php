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
                        $id_pengguna = $_SESSION['id']; // Ambil id dari sesi
                        $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_matkul WHERE dosen_id = '$id_pengguna' ORDER BY kode_matkul DESC");
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
                                <form method="GET" action="generate_qr.php">
                                    <input type="hidden" name="kode_matkul" value="<?= $data['kode_matkul'] ?>">
                                    <input type="hidden" name="nama" value="<?= urlencode($data['nama']) ?>">
                                    <select name="pertemuan" class="form-select" required>
                                        <option value="">Pilih Pertemuan</option>
                                        <?php for ($i = 1; $i <= 16; $i++): ?>
                                        <option value="<?= $i ?>">Pertemuan <?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <button type="submit" class="btn btn-success mt-2">Lihat QR Code</button>
                                </form>
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