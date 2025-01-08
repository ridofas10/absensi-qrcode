<?php
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

$nidnLogin = $_SESSION['nidn']; // NIDN dosen yang login
$idDosenLogin = $_SESSION['id']; // ID Dosen yang login

// Query untuk menghitung jumlah mata kuliah berdasarkan id_dosen yang sedang login
$sql = mysqli_query($koneksi, "SELECT * FROM tbl_matkul WHERE dosen_id = '$idDosenLogin'");
$jumlahdata_matkul = mysqli_num_rows($sql);

// Query untuk menghitung jumlah absensi berdasarkan nidn yang ada di dalam kode_matkul JSON
$sql3 = mysqli_query($koneksi, "SELECT * FROM tbl_absen WHERE JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nidn')) = '$nidnLogin'");
$jumlahdata_mahasiswa = mysqli_num_rows($sql3);
?>




<!-- page content -->
<div class="right_col" role="main">
    <pag class="">

        <h3 class="p-2" align="center">Sistem Absensi Digital Mahasiswa Fakultas Teknik UNISKA</h3>
        <!-- page content -->
        <div class="">
            <div class="col" style="display: inline-block;">
                <div class="top_tiles">
                    <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-book"></i></div><br>
                            <div class="count"><?= $jumlahdata_matkul; ?></div>
                            <h3>Total Mata Kuliah</h3>
                            <p> <a href="data-matkul.php" class="small-box-footer">Lihat Data<i></i></a></P>
                        </div>
                    </div>

                    <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-users"></i></div><br>
                            <div class="count"><?= $jumlahdata_mahasiswa; ?></div>
                            <h3>Total Mahasiswa Absen</h3>
                            <p> <a href="rekap_absen.php" class="small-box-footer">Lihat Data<i></i></a></P>
                        </div>
                    </div>
                    <!-- /.content -->
                </div>
            </div>
        </div>
        <!-- /.content -->

</div>
</div>
</pag>
</div>
<!-- /page content -->
<?php 
include 'footer.php';

?>