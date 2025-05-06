<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <span>Admin Panel</span>
        </div>
        <div class="list-group">
            <a href="{{ url('/dashboard') }}" class="list-group-item active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ url('/dashboard/users') }}" class="list-group-item"><i class="fas fa-users"></i> Data User</a>
            <a href="{{ url('/dashboard/category-items') }}" class="list-group-item"><i class="fas fa-tags"></i> Data Kategori</a>
            <a href="{{ url('/dashboard/items') }}" class="list-group-item"><i class="fas fa-tags"></i> Data Barang</a>
            <a href="{{ url('/dashboard/peminjaman') }}" class="list-group-item"><i class="fas fa-arrow-circle-down"></i> Data Peminjaman</a>
            <a href="{{ url('/dashboard/pengembalian') }}" class="list-group-item"><i class="fas fa-arrow-circle-up"></i> Data Pengembalian</a>
            <a href="#" id="logoutButton" class="list-group-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div id="content-wrapper">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
            </div>

            <div class="row">
                <!-- Total User -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total User</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_users }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kategori -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kategori</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_categories }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tags fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Peminjaman -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Peminjaman</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_borrows }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-arrow-circle-down fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pengembalian -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pengembalian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_returns }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-arrow-circle-up fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row Data -->
            <div class="row">
                <!-- Peminjaman Terbaru -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">Peminjaman Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recent_borrows as $borrow)
                                            <tr>
                                                <td>{{ $borrow->id }}</td>
                                                <td>{{ $borrow->user->name ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($borrow->created_at)->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge {{ $borrow->status === 'returned' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ ucfirst($borrow->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($recent_borrows->isEmpty())
                                            <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Terbaru -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">User Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Tanggal Daftar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recent_users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                        @if ($recent_users->isEmpty())
                                            <tr><td colspan="3" class="text-center">Tidak ada data</td></tr>
                                        @endif
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

        // Logout functionality
        document.getElementById('logoutButton').addEventListener('click', function (e) {
            e.preventDefault();
            // Remove token from localStorage
            localStorage.removeItem('token');
            // Redirect to login page
            window.location.href = '/'; // Sesuaikan dengan URL login Anda  
        });
    </script>
</body>
</html>
