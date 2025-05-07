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
            <a href="{{ url('/dashboard') }}" class="list-group-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ url('/dashboard/users') }}" class="list-group-item"><i class="fas fa-users"></i> Data User</a>
            <a href="{{ url('/dashboard/category-items') }}" class="list-group-item"><i class="fas fa-tags"></i> Data Kategori</a>
            <a href="{{ url('/dashboard/items') }}" class="list-group-item active"><i class="fas fa-tags"></i> Data Barang</a>
            <a href="{{ url('/dashboard/peminjaman') }}" class="list-group-item"><i class="fas fa-arrow-circle-down"></i> Data Peminjaman</a>
            <a href="{{ url('/dashboard/pengembalian') }}" class="list-group-item"><i class="fas fa-arrow-circle-up"></i> Data Pengembalian</a>
            <a href="#" id="logoutButton" class="list-group-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Top Bar -->
    <nav id="topbar" class="navbar navbar-expand navbar-light">
        <button id="sidebarToggle" class="btn btn-link toggle-sidebar">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Content -->
    <div id="content-wrapper">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <button class="btn btn-sm btn-primary shadow-sm" id="btn-add-items"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang</button>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">Daftar Barang</h6>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" id="exportDropdown" data-bs-toggle="dropdown">
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
                                            <th>Gambar</th>
                                            <th>Nama</th>
                                            <th>Kode Barang</th>
                                            <th>Kategori</th>
                                            <th>Stock</th>
                                            <th>Status</th>
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

    <!-- Modal Detail Barang -->
    <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="itemDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-4 text-center">
                        <img id="detail-image" src="" alt="Gambar Barang" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-md-8">
                        <p><strong>Nama:</strong> <span id="detail-item-name"></span></p>
                        <p><strong>Kode:</strong> <span id="detail-code"></span></p>
                        <p><strong>Kategori:</strong> <span id="detail-category"></span></p>
                        <p><strong>Stock:</strong> <span id="detail-stock"></span></p>
                        <p><strong>Status:</strong> <span id="detail-status"></span></p>
                        <p><strong>Kondisi:</strong> <span id="detail-kondisi"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/';
        }

        document.getElementById('logoutButton').addEventListener('click', function(e) {
            e.preventDefault();
            // Remove token from localStorage
            localStorage.removeItem('token');
            // Redirect to login page
            window.location.href = '/'; // Sesuaikan dengan URL login Anda  
        });

        function editItem(id) {
            window.location.href = '/dashboard/items/edit/' + id;
        }

        $(document).on('click', '.btn-delete-item', function() {
            const itemId = $(this).data('id');
            const button = $(this);
            deleteItem(itemId, button);
        });

        function deleteItem(id, buttonElement) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Barang akan dihapus secara permanen!",
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
                        url: 'http://127.0.0.1:8000/api/items/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                buttonElement.closest('tr').remove();
                                Swal.fire('Deleted!', response.message, 'success');
                            } else {
                                alert('Failed to delete!');
                            }
                        },
                        error: function() {
                            alert('Failed to delete item!');
                        }
                    });
                }
            });
        }

        function showItemDetail(item) {
            $('#detail-item-name').text(item.item_name);
            $('#detail-code').text(item.code_items);
            $('#detail-category').text(item.id_category.category_name);
            $('#detail-stock').text(item.stock);
            $('#detail-status').text(item.status);
            $('#detail-image').attr('src', item.item_image);
            $('#detail-kondisi').text(item.item_condition);
            $('#itemDetailModal').modal('show');
        }

        $(document).ready(function() {
            $('#btn-add-items').on('click', function() {
                window.location.href = '/dashboard/items/create';
            });

            function getAllItems() {
                $.ajax({
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    url: 'http://127.0.0.1:8000/api/items',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            let index = 1;
                            data.forEach(function(item) {
                                let badgeClass = item.status === 'used' ? 'bg-danger' : 'bg-success';
                                $('#data-table').append(`
                                    <tr>
                                        <td>${index++}</td>
                                        <td><img src="${item.item_image}" style="max-width:60px;"></td>
                                        <td>${item.item_name}</td>
                                        <td>${item.code_items}</td>
                                        <td>${item.id_category.category_name}</td>
                                        <td>${item.stock}</td>
                                        <td><span class="badge ${badgeClass}">${item.status}</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-detail" data-item='${JSON.stringify(item)}'><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-primary btn-sm" onclick="editItem(${item.id_items})"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm btn-delete-item" data-id="${item.id_items}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `);
                            });

                            // bind detail button
                            $('.btn-detail').on('click', function() {
                                const item = $(this).data('item');
                                showItemDetail(item);
                            });
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    }
                });
            }

            getAllItems();
        });

        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar-wrapper').classList.toggle('active');
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar-wrapper').classList.remove('active');
            }
        });
    </script>
</body>

</html>