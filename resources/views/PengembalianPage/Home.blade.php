<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <span>Admin Panel</span>
        </div>
        <div class="list-group">
            <a href="{{ url('/dashboard') }}" class="list-group-item">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ url('/dashboard/users') }}" class="list-group-item">
                <i class="fas fa-users"></i> Data User
            </a>
            <a href="{{ url('/dashboard/category-items') }}" class="list-group-item">
                <i class="fas fa-tags"></i> Data Kategori
            </a>
            <a href="{{ url('/dashboard/items') }}" class="list-group-item">
                <i class="fas fa-tags"></i> Data Barang
            </a>
            <a href="{{ url('/dashboard/peminjaman') }}" class="list-group-item">
                <i class="fas fa-arrow-circle-down"></i> Data Peminjaman
            </a>
            <a href="{{ url('/dashboard/pengembalian') }}" class="list-group-item active">
                <i class="fas fa-arrow-circle-up"></i> Data Pengembalian
            </a>
            <a href="#" id="logoutButton" class="list-group-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <!-- Content -->
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan
                </a>
            </div>

            <!-- Content Row -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">Daftar Pengembalian</h6>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-download fa-sm"></i> Export
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Excel</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>PDF</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-csv me-2"></i>CSV</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody id="data-table">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const token = localStorage.getItem('token')
        if (!token) {
            window.location.href = '/'
        }

        document.getElementById('logoutButton').addEventListener('click', function(e) {
            e.preventDefault();
            // Remove token from localStorage
            localStorage.removeItem('token');
            // Redirect to login page
            window.location.href = '/'; // Sesuaikan dengan URL login Anda  
        });

        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar-wrapper').classList.toggle('active');
        });

        // Close sidebar on small screens when clicking outside
        document.addEventListener('click', function(event) {
            const sidebarWrapper = document.getElementById('sidebar-wrapper');
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 768 &&
                !sidebarWrapper.contains(event.target) &&
                !sidebarToggle.contains(event.target) &&
                sidebarWrapper.classList.contains('active')) {
                sidebarWrapper.classList.remove('active');
            }
        });

        // Responsive behavior on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar-wrapper').classList.remove('active');
            }
        });
    </script>
</body>

</html>