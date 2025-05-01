<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5 w-50 card p-5">
        <h3>Login</h3>
        <p>Masukan email dan password untuk login!</p>
        <hr>
        <div>
            <label class="form-label">Email</label>
            <input type="email" id="email" class="form-control">
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" id="password" class="form-control" aria-describedby="passwordHelpBlock">
        </div>
        <button type="button" id="login-btn" class="btn btn-primary mt-5">Login</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        var token = localStorage.getItem('token');
        if (token) {
            // Jika token ada, redirect ke dashboard
            window.location.href = '/dashboard';
        }

        $(document).ready(function() {
            $('#login-btn').on('click', function(e) {
                e.preventDefault();

                let email = $('#email').val()
                let password = $('#password').val()

                if (!email || !password) {
                    Swal.fire({
                        icon: "warning",
                        title: "Peringatan",
                        text: "Email dan password wajib diisi!"
                    });
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
                            window.location.href = '/dashboard';
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: response.message
                            })
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
                            text: errorMsg
                        }); 
                    }
                });
            })
        })
    </script>
</body>

</html>