<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <span>Admin Panel</span>
        </div>
        <div class="list-group">
            <a href="{{ url('/dashboard') }}" class="list-group-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ url('/dashboard/users') }}" class="list-group-item"><i class="fas fa-users"></i> Data User</a>
            <a href="{{ url('/dashboard/category-items') }}" class="list-group-item"><i class="fas fa-tags"></i> Data Kategori</a>
            <a href="{{ url('/dashboard/items') }}" class="list-group-item"><i class="fas fa-tags"></i> Data Barang</a>
            <a href="{{ url('/dashboard/peminjaman') }}" class="list-group-item"><i class="fas fa-arrow-circle-down"></i> Data Peminjaman</a>
            <a href="{{ url('/dashboard/pengembalian') }}" class="list-group-item active"><i class="fas fa-arrow-circle-up"></i> Data Pengembalian</a>
            <a href="#" id="logoutButton" class="list-group-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div id="content-wrapper">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">Daftar Pengembalian</h6>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
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
                                            <th>Tanggal Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-table">
                                        <!-- Data akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/';
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('logoutButton').addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('token');
            window.location.href = '/';
        });

        function fetchReturns() {
            fetch('http://127.0.0.1:8000/api/detail-returns', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    const data = res.data;
                    const tbody = document.getElementById('data-table');
                    tbody.innerHTML = '';

                    if (!data || data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>';
                        return;
                    }

                    data.forEach((item, index) => {
                        const name = item.user_name || '-';
                        const email = item.user_email || '-';
                        const dateReturn = item.date_return || '-';
                        const status = item.status;

                        const statusBadge =
                            status === 'approve' ?
                            '<span class="badge bg-success text-white">Approve</span>' :
                            status === 'pending' ?
                            '<span class="badge bg-warning text-white">Pending</span>' :
                            '<span class="badge bg-danger text-white">Not Approve</span>';

                        tbody.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${name}</td>
                                <td>${email}</td>
                                <td>${dateReturn}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="approveReturn(${item.id_detail_return})" ${status === 'approve' ? 'disabled' : ''}><i class="fas fa-check"></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectReturn(${item.id_detail_return})" ${status === 'not approve' ? 'disabled' : ''}><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal memuat data pengembalian.',
                    });
                });
        }

        function approveReturn(id) {
            Swal.fire({
                title: 'Yakin ingin menyetujui?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://127.0.0.1:8000/api/details-return/${id}/approve`, {
                            method: 'PUT',
                            headers: {
                                'Authorization': `Bearer` + token,
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.text().then(text => {
                                    throw new Error(text || 'Gagal menyetujui.');
                                });
                            }
                            return res.json();
                        })
                        .then(() => {
                            Swal.fire('Berhasil!', 'Pengembalian disetujui.', 'success');
                            fetchReturns();
                        })
                        .catch(err => {
                            Swal.fire('Gagal!', err.message || 'Terjadi kesalahan saat menyetujui.', 'error');
                        });
                }
            });
        }

        function rejectReturn(id) {
            Swal.fire({
                title: 'Yakin ingin menolak?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://127.0.0.1:8000/api/details-return/${id}/reject`, {
                            method: 'PUT',
                            headers: {

                                'Authorization': `Bearer` + token,
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.text().then(text => {
                                    throw new Error(text || 'Gagal menolak.');
                                });
                            }
                            return res.json();
                        })
                        .then(() => {
                            Swal.fire('Ditolak!', 'Pengembalian ditolak.', 'success');
                            fetchReturns();
                        })
                        .catch(err => {
                            Swal.fire('Gagal!', err.message || 'Terjadi kesalahan saat menolak.', 'error');
                        });
                }
            });
        }


        fetchReturns();
    </script>
</body>

</html>