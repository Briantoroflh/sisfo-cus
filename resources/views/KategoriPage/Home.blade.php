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
    <style>
        /* Sidebar styles */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            position: fixed;
            z-index: 999;
            left: 0;
            background-color: #343a40;
            color: white;
            overflow-y: auto;
            transition: all 0.3s;
        }

        #sidebar-wrapper.active {
            margin-left: -250px;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: rgba(255, 255, 255, 0.7);
            border: none;
            padding: 0.8rem 1.5rem;
            transition: all 0.3s;
        }

        #sidebar-wrapper .list-group-item:hover,
        #sidebar-wrapper .list-group-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper .list-group-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Topbar styles */
        #topbar {
            height: 60px;
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            position: fixed;
            top: 0;
            right: 0;
            left: 250px;
            z-index: 998;
            transition: all 0.3s;
        }

        #sidebar-wrapper.active~#topbar {
            left: 0;
        }

        .toggle-sidebar {
            color: #4e73df;
            font-size: 1.2rem;
        }

        .img-profile {
            height: 2rem;
            width: 2rem;
        }

        /* Content wrapper styles */
        #content-wrapper {
            margin-left: 250px;
            padding-top: 60px;
            min-height: 100vh;
            padding-bottom: 80px;
            position: relative;
            transition: all 0.3s;
        }

        #sidebar-wrapper.active~#content-wrapper {
            margin-left: 0;
        }

        /* Table styles */
        .table th {
            font-weight: 600;
            background-color: #f8f9fc;
        }

        /* Action buttons */
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            margin-right: 5px;
        }

        /* Modal styles */
        .modal-header {
            background-color: #4e73df;
            color: white;
            border-bottom: 0;
        }

        .modal-footer {
            border-top: 0;
        }

        /* Add button in card header */
        .btn-add {
            background-color: #4e73df;
            color: white;
        }

        .btn-add:hover {
            background-color: #3a5fc8;
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }

            #sidebar-wrapper.active {
                margin-left: 0;
            }

            #topbar,
            #content-wrapper {
                left: 0;
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <span>Admin Panel</span>
        </div>
        <a href="{{ url('/dashboard') }}" class="list-group-item">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ url('/dashboard/users') }}" class="list-group-item">
            <i class="fas fa-users"></i> Data User
        </a>
        <a href="{{ url('/dashboard/category-items') }}" class="list-group-item active">
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
    <!-- Content -->
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btnAddCategory" data-bs-toggle="modal" data-bs-target="#modalCategory">
                    <i class="fas fa-plus fa-sm me-1"></i> Tambah Kategori
                </button>
            </div>

            <!-- Content Row -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">Daftar Kategori</h6>
                            <div class="d-flex">
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
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody id="data-table">
                                        <!-- Data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit Category -->
    <div class="modal fade" id="modalCategory" tabindex="-1" aria-labelledby="modalCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoryLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoryId">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="categoryName" placeholder="Masukkan nama kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSaveCategory">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
                    <input type="hidden" id="deleteId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const token = localStorage.getItem('token')
        if (!token) {
            window.location.href = '/'
        }

        $(document).ready(function() {
            // Load all categories
            loadCategories();

            // Add Category button click
            $('#btnAddCategory').click(function() {
                $('#modalCategoryLabel').text('Tambah Kategori');
                $('#categoryId').val('');
                $('#categoryName').val('');
            });

            // Save Category button click
            $('#btnSaveCategory').click(function() {
                const categoryId = $('#categoryId').val();
                const categoryName = $('#categoryName').val();

                if (categoryName.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Nama kategori tidak boleh kosong!'
                    });
                    return;
                }

                // If categoryId exists, update category, otherwise create new one
                if (categoryId) {
                    updateCategory(categoryId, categoryName);
                } else {
                    createCategory(categoryName);
                }
            });

            // Confirm Delete button click
            $('#btnConfirmDelete').click(function() {
                const categoryId = $('#deleteId').val();
                if (categoryId) {
                    deleteCategory(categoryId);
                }
            });
        });

        // Load all categories
        function loadCategories() {
            $('#data-table').empty();

            $.ajax({
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                url: "http://127.0.0.1:8000/api/category-items",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const data = response.data
                        var i = 1
                        data.forEach(function(item) {
                            $('#data-table').append(`
                                <tr>
                                    <td>${i++}</td>
                                    <td>${item.category_name}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-action" 
                                                onclick="editCategoryModal(${item.id_category}, '${item.category_name}')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-action" 
                                                onclick="confirmDelete(${item.id_category   })">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>`);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Gagal memuat data kategori'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memuat data'
                    });
                }
            });
        }

        // Open edit modal with category data
        function editCategoryModal(id, name) {
            $('#modalCategoryLabel').text('Edit Kategori');
            $('#categoryId').val(id);
            $('#categoryName').val(name);
            $('#modalCategory').modal('show');
            console.log(id, name);
        }

        // Confirm delete modal
        function confirmDelete(id) {
            $('#deleteId').val(id);
            $('#deleteModal').modal('show');
            console.log(id);
            
        }

        // Create new category
        function createCategory(name) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                url: "http://127.0.0.1:8000/api/category-items",
                method: 'POST',
                data: {
                    category_name: name
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kategori berhasil ditambahkan'
                        });
                        $('#modalCategory').modal('hide');
                        loadCategories();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Gagal menambahkan kategori'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menambahkan kategori'
                    });
                }
            });
        }

        // Update category
        function updateCategory(id, name) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                url: "http://127.0.0.1:8000/api/category-items/" + id,
                method: 'PUT',
                data: {
                    category_name: name
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kategori berhasil diperbarui'
                        });
                        $('#modalCategory').modal('hide');
                        loadCategories();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Gagal memperbarui kategori'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memperbarui kategori'
                    });
                }
            });
        }

        // Delete category
        function deleteCategory(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                url: "http://127.0.0.1:8000/api/category-items/" + id,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kategori berhasil dihapus'
                        });
                        $('#deleteModal').modal('hide');
                        loadCategories();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Gagal menghapus kategori'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghapus kategori'
                    });
                }
            });
        }

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