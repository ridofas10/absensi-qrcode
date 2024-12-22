<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';
?>

<!-- page content -->
<div class="right_col" role="main">
    <pag class="">
        <h1>Scan QR Code</h1>
        <p>Arahkan kamera ke QR Code</p>

        <!-- Tampilan video untuk kamera -->
        <video id="preview" width="100%" height="300" style="border: 1px solid black;"></video>

        <!-- Tombol untuk mengganti kamera -->
        <button id="toggleCamera" class="btn btn-primary mt-3">Ganti Kamera</button>

        <!-- Tambahkan library Instascan -->
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

        <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            mirror: false
        });
        let cameras = [];
        let activeCameraIndex = 0;

        scanner.addListener('scan', function(content) {
            // Parsing JSON dari QR Code
            try {
                const qrData = JSON.parse(content);

                // Validasi waktu kadaluarsa
                const currentTime = Math.floor(Date.now() / 1000); // Waktu sekarang dalam detik
                if (currentTime - qrData.timestamp > 300) {
                    alert('QR Code kadaluarsa. Silakan minta QR Code baru.');
                    return;
                }

                // Mengirim data ke proses_absen.php
                fetch('proses_absen.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            qr_code: content
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.href = 'data_absen_user.php';
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan: ' + error.message);
                        console.error('Kesalahan:', error);
                    });

            } catch (e) {
                alert('QR Code tidak valid.');
                console.error('Error parsing QR Code:', e);
            }
        });

        Instascan.Camera.getCameras().then(function(availableCameras) {
            if (availableCameras.length > 0) {
                cameras = availableCameras;
                scanner.start(cameras[activeCameraIndex]);
            } else {
                alert('Tidak ada kamera yang terdeteksi.');
            }
        }).catch(function(e) {
            console.error(e);
        });

        document.getElementById('toggleCamera').addEventListener('click', function() {
            if (cameras.length > 1) {
                activeCameraIndex = (activeCameraIndex + 1) % cameras.length;
                scanner.start(cameras[activeCameraIndex]);
            } else {
                alert('Hanya satu kamera yang tersedia.');
            }
        });
        </script>
    </pag>
</div>
<?php 
include 'footer.php';
?>