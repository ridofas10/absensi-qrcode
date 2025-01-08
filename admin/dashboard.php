<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

$sql = mysqli_query($koneksi, "SELECT * FROM tbl_matkul");
$sql3 = mysqli_query($koneksi, "SELECT * FROM tbl_mahasiswa");
$sql2 = mysqli_query($koneksi, "SELECT * FROM tbl_dosen");
$jumlahdata_matkul = mysqli_num_rows($sql);
$jumlahdata_mahasiswa = mysqli_num_rows($sql3);
$jumlahdata_dosen = mysqli_num_rows($sql2);

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
                            <div class="icon"><i class="fa fa-book"></i></div>
                            <div class="count"><?= $jumlahdata_matkul; ?></div>
                            <h3>Total Mata Kuliah</h3>
                            <p> <a href="matakuliah.php" class="small-box-footer">Lihat Data<i></i></a></P>
                        </div>
                    </div>

                    <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <div class="count"><?= $jumlahdata_mahasiswa; ?></div>
                            <h3>Total Mahasiswa</h3>
                            <p> <a href="mahasiswa.php" class="small-box-footer">Lihat Data<i></i></a></P>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-university"></i></div>
                            <div class="count"><?= $jumlahdata_dosen; ?></div>
                            <h3>Total Dosen</h3>
                            <p> <a href="tambah_dosen.php" class="small-box-footer">Lihat Data<i></i></a></P>
                        </div>
                    </div>
                    <!-- /.content -->
                </div>
            </div>
        </div>
    </pag>
</div>
<!-- /page content -->
<?php 
include 'footer.php';

?>