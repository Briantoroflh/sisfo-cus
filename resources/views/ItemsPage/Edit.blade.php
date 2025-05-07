<!DOCTYPE html>

<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
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
    ```

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-container">
                    <h2 class="form-title">Edit Item</h2>
                    <form enctype="multipart/form-data">
                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama barang" autocomplete="off">
                        </div>

                        <!-- Upload Gambar -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control" id="image" accept="image/*">
                            <input type="hidden" id="old_image" name="old_image">
                            <div class="d-flex justify-content-center mt-2 border border-primary rounded">
                                <img id="preview-image" src="#" alt="Preview" class="card img-fluid d-none m-5" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Kode Barang -->
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="code" placeholder="Masukkan kode barang" autocomplete="off">
                        </div>

                        <!-- Stok -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" placeholder="Masukkan jumlah stok" min="0">
                        </div>

                        <!-- Brand -->
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="string" class="form-control" id="brand" placeholder="Masukkan brand" autocomplete="off">
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" required>
                                <option value="" selected disabled>Pilih kategori</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-register" id="btn-regis">Update Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const token = localStorage.getItem('token')
        if (!token) {
            window.location.href = '/'
        }

        const itemId = window.location.pathname.split('/').pop()

        $(document).ready(function() {
            // Load item data
            $.ajax({
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                url: 'http://127.0.0.1:8000/api/items/' + itemId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        $('#name').val(data.item_name);
                        $('#code').val(data.code_items);
                        $('#stock').val(data.stock);
                        $('#brand').val(data.brand);
                        $('#category').val(data.id_category);

                        if (data.item_image) {
                            $('#preview-image')
                                .attr('src', `http://127.0.0.1:8000${data.item_image}`)
                                .removeClass('d-none');
                            $('#old_image').val(data.item_image);
                        }

                        console.log('Gambar URL:', `http://127.0.0.1:8000/storage/${data.item_image}`);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        })
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil data item.'
                    })
                }
            });

            // Preview image
            $('#image').change(function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result).removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#preview-image').addClass('d-none').attr('src', '#');
                }
            });

            // Load categories
            $.ajax({
                url: 'http://127.0.0.1:8000/api/category-items',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data
                        data.forEach(function(item) {
                            $('#category').append(`<option value="${item.id_category}">${item.category_name}</option>`)
                        })
                    } else {
                        console.error('Gagal mengambil kategori:', response.message)
                    }
                },
                error: function(err) {
                    console.error('Gagal mengambil kategori:', err)
                }
            });

            // Submit form
            $('#btn-regis').on('click', function(e) {
                e.preventDefault();

                const formData = new FormData();
                formData.append('_method', 'PUT'); // WAJIB
                formData.append('item_name', $('#name').val());

                const imageFile = $('#image')[0].files[0];
                if (imageFile) {
                    formData.append('item_image', imageFile);
                }

                formData.append('code_items', $('#code').val());
                formData.append('stock', $('#stock').val());
                formData.append('brand', $('#brand').val());
                formData.append('id_category', $('#category').val());

                console.log({
                    item_name: $('#name').val(),
                    code_items: $('#code').val(),
                    stock: $('#stock').val(),
                    brand: $('#brand').val(),
                    id_category: $('#category').val(),
                    item_image: $('#image')[0].files[0] || $('#old_image').val()
                });

                $.ajax({
                    url: 'http://127.0.0.1:8000/api/items/' + itemId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                window.location.href = '/dashboard/items'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    }
                });
            });
        });
    </script>
    ```

</body>

</html>