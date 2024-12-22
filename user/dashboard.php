<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

?>



<!-- page content -->
<div class="right_col" role="main">
    <pag class="">

        <h3 class="p-2" align="center">Sistem Absensi Digital Mahasiswa Fakultas Teknik UNISKA</h3>
        <!-- page content -->


        <div class="col" style="display: inline-block;">
            <div class="top_tiles">
                <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 ">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-camera"></i></div><br>
                        <div class="count">Mahasiswa
                        </div>
                        <h3>Silahkan Scan QR Code Untuk Absen</h3>
                        <p> <a href="scan_qr.php" class="small-box-footer">Scan Disini<i></i></a></P>
                    </div>
                </div>

                <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 ">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-desktop"></i></div><br>
                        <div class="count">ABSENSI</div>
                        <h3>Lihat Detail <br>Absensi Anda</h3>
                        <p> <a href="data_absen_user.php" class="small-box-footer">Lihat Data<i></i></a></P>
                    </div>
                </div>
                <!-- /.content -->
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