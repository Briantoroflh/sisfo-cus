<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <a href="{{ url('/dashboard/users') }}" class="list-group-item active">
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
            <a href="{{ url('/dashboard/pengembalian') }}" class="list-group-item">
                <i class="fas fa-arrow-circle-up"></i> Data Pengembalian
            </a>
            <a href="#" class="list-group-item">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
            <a href="#" class="list-group-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
        <!-- Content -->
    <div id="content-wrapper">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btn-add-user">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User
                </button>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">Daftar User</h6>
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
                                    <tbody id="data-table"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail User -->
    <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="detail-name"></span></p>
                    <p><strong>Email:</strong> <span id="detail-email"></span></p>
                    <p><strong>Role:</strong> <span id="detail-role"></span></p>
                    <p><strong>Kelas:</strong> <span id="detail-class"></span></p>
                    <p><strong>Jurusan:</strong> <span id="detail-major"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/';
        }

        function editUser(id) {
            window.location.href = '/dashboard/users/edit/' + id;
        }

        function deleteUser(id, buttonElement) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "User akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + token
                        },
                        url: 'http://127.0.0.1:8000/api/users/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                buttonElement.closest('tr').remove();
                                Swal.fire('Deleted!', response.message, 'success');
                            } else {
                                alert('Failed to delete!');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting user:', error);
                            alert('Failed to delete user!');
                        }
                    });
                }
            });
        }

        $(document).on('click', '.btn-delete-user', function() {
            const userId = $(this).data('id');
            const button = $(this);
            deleteUser(userId, button);
        });

        $(document).on('click', '.btn-view-user', function() {
            const user = $(this).data('user');
            $('#detail-name').text(user.name);
            $('#detail-email').text(user.email);
            $('#detail-role').text(user.role);
            $('#detail-class').text(user.class);
            $('#detail-major').text(user.major);
            $('#userDetailModal').modal('show');
        });

        $(document).ready(function() {
            $('#btn-add-user').on('click', function() {
                window.location.href = '/dashboard/users/create';
            });

            function getAllUsers() {
                $.ajax({
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    url: 'http://127.0.0.1:8000/api/users',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            let i = 1;
                            data.forEach(function(item) {
                                $('#data-table').append(`
                                    <tr>
                                        <td>${i++}</td>
                                        <td>${item.name}</td>
                                        <td>${item.email}</td>
                                        <td><span class="password-cell">*******</span></td>
                                        <td>${item.role}</td>
                                        <td>${item.class}</td>
                                        <td>${item.major}</td>
                                        <td class="action-buttons">
                                            <button class="btn btn-sm btn-info btn-view-user" data-user='${JSON.stringify(item)}'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" onclick="editUser(${item.id_user})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-delete-user" data-id="${item.id_user}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `);
                            });
                        }
                    }
                });
            }
            getAllUsers();
        });

        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar-wrapper').classList.toggle('active');
        });

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

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar-wrapper').classList.remove('active');
            }
        });
    </script>
</body>

</html>