<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            color: #212529;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: white;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 400px;
            width: 100%;
            padding: 2.5rem;
        }

        .login-title {
            font-weight: 600;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #212529;
            box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.15);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .login-btn {
            background-color: #212529;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            width: 100%;
        }

        .login-btn:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 1.5rem 0;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-right: none;
        }

        .password-toggle {
            cursor: pointer;
            color: #6c757d;
        }

        .brand-logo {
            width: 50px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <h3 class="login-title">Welcome Back</h3>
                <p class="login-subtitle">Masukkan email dan password untuk login</p>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    <input type="email" id="email" class="form-control" placeholder="nama@example.com">
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Password</label>
                    <a href="#" class="text-decoration-none text-secondary" style="font-size: 0.8rem;">Lupa password?</a>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    <input type="password" id="password" class="form-control" placeholder="Masukkan password">
                    <span class="input-group-text password-toggle" id="togglePassword">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="button" id="login-btn" class="btn btn-dark login-btn">
                Login <i class="fa fa-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const token = localStorage.getItem('token')
        if (token) {
            window.location.href = '/dashboard';
        }

        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const icon = $(this).find('i');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Login button click handler
            $('#login-btn').on('click', function(e) {
                e.preventDefault();

                // Show loading state
                $(this).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');
                $(this).attr('disabled', true);

                let email = $('#email').val()
                let password = $('#password').val()

                if (!email || !password) {
                    Swal.fire({
                        icon: "warning",
                        title: "Peringatan",
                        text: "Email dan password wajib diisi!",
                        confirmButtonColor: '#212529'
                    });

                    // Reset button
                    $(this).html('Login <i class="fa fa-arrow-right ms-1"></i>');
                    $(this).attr('disabled', false);
                    return
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    url: 'http://127.0.0.1:8000/api/login',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            // Simpan token
                            localStorage.setItem('token', response.token);

                            // Show success message before redirect
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Login berhasil, sedang mengalihkan...',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '/dashboard';
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: response.message,
                                confirmButtonColor: '#212529'
                            });

                            // Reset button
                            $('#login-btn').html('Login <i class="fa fa-arrow-right ms-1"></i>');
                            $('#login-btn').attr('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = "Terjadi kesalahan pada server!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: errorMsg,
                            confirmButtonColor: '#212529'
                        });

                        // Reset button
                        $('#login-btn').html('Login <i class="fa fa-arrow-right ms-1"></i>');
                        $('#login-btn').attr('disabled', false);
                    }
                });
            })
        })
    </script>
</body>

</html>