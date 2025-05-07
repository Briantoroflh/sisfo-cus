<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="{{ url('/dashboard/peminjaman') }}" class="list-group-item  active">
                <i class="fas fa-arrow-circle-down"></i> Data Peminjaman
            </a>
            <a href="{{ url('/dashboard/pengembalian') }}" class="list-group-item">
                <i class="fas fa-arrow-circle-up"></i> Data Pengembalian
            </a>
            <a href="#" id="logoutButton" class="list-group-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Content -->
    <div id="content-wrapper">
        <div class="container-fluid">
            <h1 class="h3 mb-0 text-gray-800 mb-4">Dashboard</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Daftar Peminjaman</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama User</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-table">
                                <!-- Data akan dimuat JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="detail-id"></span></p>
                    <p><strong>Nama:</strong> <span id="detail-name"></span></p>
                    <p><strong>Email:</strong> <span id="detail-email"></span></p>
                    <p><strong>Kelas:</strong> <span id="detail-kelas"></span></p>
                    <p><strong>Tanggal Pinjam:</strong> <span id="detail-date-borrowed"></span></p>
                    <p><strong>Jatuh Tempo:</strong> <span id="detail-due-date"></span></p>
                    <p><strong>Status:</strong> <span id="detail-status"></span></p>
                    <p><strong>Catatan:</strong> <span id="detail-notes"></span></p>
                    <hr>
                    <h6>Barang Dipinjam:</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="detail-items"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const borrowedData = [];

        document.getElementById('logoutButton')?.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('token');
            window.location.href = '/';
        });

        fetch('http://127.0.0.1:8000/api/borrowed', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    borrowedData.push(...result.data); // Simpan data untuk akses detail
                    const dataTable = document.getElementById('data-table');

                    result.data.forEach(item => {
                        const row = document.createElement('tr');

                        let actionButtons = '';
                        if (item.status === 'approved') {
                            actionButtons = `
                            <button class="btn btn-info btn-sm me-1" onclick="showDetail(${item.id_borrowed})">
                                <i class="fas fa-eye"></i> Detail
                            </button>`;
                        } else if (item.status === 'not approved') {
                            actionButtons = `<span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>`;
                        } else {
                            actionButtons = `
                            <button class="btn btn-success btn-sm me-1" onclick="handleApprove(${item.id_borrowed})">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="handleReject(${item.id_borrowed})">
                                <i class="fas fa-times"></i>
                            </button>`;
                        }

                        row.innerHTML = `
                        <td>${item.id_borrowed}</td>
                        <td>${item.id_user.name || '-'}</td>
                        <td>${item.id_details_borrow.date_borrowed}</td>
                        <td>${item.id_details_borrow.due_date}</td>
                        <td><span class="badge ${getBadgeClass(item.status)}">${item.status}</span></td>
                        <td>${actionButtons}</td>`;
                        dataTable.appendChild(row);
                    });
                }
            });

        function getBadgeClass(status) {
            switch (status) {
                case 'approved':
                    return 'bg-success';
                case 'not approved':
                    return 'bg-danger';
                case 'pending':
                    return 'bg-warning';
                default:
                    return 'bg-secondary';
            }
        }

        function handleApprove(id) {
            Swal.fire({
                title: 'Setujui peminjaman?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://127.0.0.1:8000/api/borrowed/${id}/approve`, {
                            method: 'PUT',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            Swal.fire('Sukses', res.message, 'success').then(() => location.reload());
                        });
                }
            });
        }

        function handleReject(id) {
            Swal.fire({
                title: 'Tolak peminjaman?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://127.0.0.1:8000/api/borrowed/${id}/reject`, {
                            method: 'PUT',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            Swal.fire('Ditolak', res.message, 'success').then(() => location.reload());
                        });
                }
            });
        }

        function showDetail(id) {
            const borrowItem = borrowedData.find(item => item.id_borrowed === id);
            if (!borrowItem) return;

            document.getElementById('detail-id').textContent = borrowItem.id_borrowed;
            document.getElementById('detail-name').textContent = borrowItem.id_user.name || '-';
            document.getElementById('detail-email').textContent = borrowItem.id_user.email || '-';
            document.getElementById('detail-kelas').textContent = borrowItem.id_details_borrow.class || '-';
            document.getElementById('detail-date-borrowed').textContent = borrowItem.id_details_borrow.date_borrowed;
            document.getElementById('detail-due-date').textContent = borrowItem.id_details_borrow.due_date;
            document.getElementById('detail-status').textContent = borrowItem.status;
            document.getElementById('detail-notes').textContent = borrowItem.id_details_borrow.used_for || 'Tidak ada catatan';



            fetch(`http://127.0.0.1:8000/api/details-borrow/${borrowItem.id_details_borrow.id_details_borrow}/items`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(result => {
                    const itemsContainer = document.getElementById('detail-items');
                    itemsContainer.innerHTML = '';

                    if (result.success && result.data.length > 0) {
                        result.data.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${item.item_name || '-'}</td>
                            <td>${item.category_name || '-'}</td>
                            <td>${item.quantity || '-'}</td>`;
                            itemsContainer.appendChild(row);
                        });
                    } else {
                        itemsContainer.innerHTML = `
                        <tr><td colspan="4" class="text-center">Tidak ada data barang</td></tr>`;
                    }

                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                });
        }
    </script>
</body>

</html>