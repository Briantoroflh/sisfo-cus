<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
        }

        .form-title {
            color: #333;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
        }

        .btn-register {
            background-color: #4361ee;
            border: none;
            width: 100%;
            padding: 10px;
            font-weight: 500;
            margin-top: 10px;
        }

        .btn-register:hover {
            background-color: #3a56d4;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-container">
                    <h2 class="form-title">Update User</h2>
                    <form>
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter full name" autocomplete="off">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email address" autocomplete="off">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password" autocomplete="off">
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" required>
                                <option value="" selected disabled>Select role</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Major -->
                        <div class="mb-3">
                            <label for="major" class="form-label">Major</label>
                            <select class="form-select" id="major" required>
                                <option value="" selected disabled>Select major</option>
                                <option value="RPL">RPL</option>
                                <option value="ANIMASI">ANIMASI</option>
                                <option value="TJKT">TJKT</option>
                                <option value="PSPT">PSPT</option>
                                <option value="TE">TE</option>
                            </select>
                        </div>

                        <!-- Class -->
                        <div class="mb-3">
                            <label for="class" class="form-label">Class</label>
                            <input type="text" class="form-control" id="class" placeholder="Enter class" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-register" id="btn-regis">Register User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        const token = localStorage.getItem('token')
        if (!token) {
            window.location.href = '/'
        }

        var userId = window.location.pathname.split('/').pop()

        $(document).ready(function() {
            $.ajax({
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                url: 'http://127.0.0.1:8000/api/users/' + userId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const user = response.data
                    if (response.success) {
                        $('#name').val(user.name)
                        $('#email').val(user.email)
                        $('#password').val(user.password)
                        $('#role').val(user.role)
                        $('#major').val(user.major)
                        $('#class').val(user.class)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        })
                    }
                },
            })
        })

        $(document).ready(function() {
            $('#btn-regis').on('click', function(e) {
                e.preventDefault()

                var name = $('#name').val()
                var email = $('#email').val()
                var password = $('#password').val()
                var role = $('#role').val()
                var major = $('#major').val()
                var className = $('#class').val()

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    url: 'http://127.0.0.1:8000/api/users/' + userId,
                    method: 'PUT',
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        role: role,
                        major: major,
                        class: className
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.data)
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                window.location.href = '/dashboard/users'
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            })
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>