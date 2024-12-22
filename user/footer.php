 <!-- footer content -->
 <footer>
     <div class="pull-right">
         Ridofas Tri Sandi Fantiantoro
     </div>
     <div class="clearfix"></div>
 </footer>
 <!-- /footer content -->
 </div>
 </div>
 <script>
// Fungsi pencarian tabel
document.getElementById('search-input').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#table-matkul tbody tr');

    // Filter baris berdasarkan pencarian
    tableRows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });

    // Reset halaman ke 1 dan perbarui pagination dan tampilkan baris
    currentPage = 1;
    updatePagination();
    displayRows();
});

// Pagination untuk tabel menggunakan JavaScript
const rowsPerPage = 5; // Jumlah baris per halaman
let currentPage = 1; // Halaman saat ini

function getFilteredRows() {
    // Ambil semua baris tabel yang tidak disembunyikan
    const tableRows = document.querySelectorAll('#table-matkul tbody tr');
    return Array.from(tableRows).filter(row => row.style.display !== 'none');
}

function displayRows() {
    const filteredRows = getFilteredRows();
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    // Tampilkan baris sesuai dengan halaman yang aktif
    filteredRows.forEach((row, index) => {
        row.style.display = index >= start && index < end ? '' : 'none';
    });
}

function setupPagination() {
    const filteredRows = getFilteredRows();
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = ''; // Kosongkan pagination yang ada

    // Buat pagination untuk setiap halaman
    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        pageItem.className = `page-item ${i === currentPage ? 'active' : ''}`;
        pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        pageItem.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = i;
            updatePagination();
            displayRows();
        });
        pagination.appendChild(pageItem);
    }
}

function updatePagination() {
    const items = document.querySelectorAll('.page-item');
    items.forEach((item, index) => {
        item.classList.toggle('active', index + 1 === currentPage);
    });
}

// Panggil fungsi untuk menampilkan baris dan pagination
setupPagination();
displayRows();
 </script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
$(document).ready(function() {
    // Tangani event ketika ada perubahan pada input pencarian
    $('#search-input').on('keyup', function() {
        var searchQuery = $(this).val(); // Ambil nilai dari input pencarian

        // Kirim request AJAX ke server
        $.ajax({
            url: '', // Gunakan halaman yang sama
            method: 'GET',
            data: {
                search: searchQuery
            }, // Kirim query pencarian
            success: function(response) {
                // Ambil hanya bagian tbody dan perbarui dengan respons pencarian
                var rows = $(response).find('#table-body').html();
                $('#table-body').html(rows); // Update hanya bagian tabel tbody
            }
        });
    });
});
 </script>
 <!-- jQuery -->
 <script src="../assets/gentelella/vendors/jquery/dist/jquery.min.js"></script>
 <!-- Bootstrap -->
 <script src="../assets/gentelella/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <!-- FastClick -->
 <script src="../assets/gentelella/vendors/fastclick/lib/fastclick.js"></script>
 <!-- NProgress -->
 <script src="../assets/gentelella/vendors/nprogress/nprogress.js"></script>
 <!-- Chart.js -->
 <script src="../assets/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>
 <!-- jQuery Sparklines -->
 <script src="../assets/gentelella/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
 <!-- Flot -->
 <script src="../assets/gentelella/vendors/Flot/jquery.flot.js"></script>
 <script src="../assets/gentelella/vendors/Flot/jquery.flot.pie.js"></script>
 <script src="../assets/gentelella/vendors/Flot/jquery.flot.time.js"></script>
 <script src="../assets/gentelella/vendors/Flot/jquery.flot.stack.js"></script>
 <script src="../assets/gentelella/vendors/Flot/jquery.flot.resize.js"></script>
 <!-- Flot plugins -->
 <script src="../assets/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
 <script src="../assets/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
 <script src="../assets/gentelella/vendors/flot.curvedlines/curvedLines.js"></script>
 <!-- DateJS -->
 <script src="../assets/gentelella/vendors/DateJS/build/date.js"></script>
 <!-- bootstrap-daterangepicker -->
 <script src="../assets/gentelella/vendors/moment/min/moment.min.js"></script>
 <script src="../assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

 <!-- Custom Theme Scripts -->
 <script src="../assets/gentelella/build/js/custom.min.js"></script>
 </body>

 </html>