<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pendaftaran Akun KIP Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #211C84, #0056b3);
            color: white;
            font-family: Arial, sans-serif;
        }

        .login-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            backdrop-filter: blur(10px);
        }

        .login-box input {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .login-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-box .btn {
            background-color: #ff8000;
            border: none;
        }

        .login-box .btn:hover {
            background-color: #e67300;
        }

        .gradient-bar {
            height: 5px;
            background: linear-gradient(to right, orange, green);
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <div class="container-fluid login-container">
        <div class="row w-100">
            <!-- Kiri (Logo dan Deskripsi) -->
            <div class="col-md-7 d-flex flex-column align-items-start justify-content-center">
                <!-- <img src="images/umsida-logo.png" alt="UMSIDA Logo" class="umsida-logo mb-3 w-25"> -->
                <div class="text-start w-100">
                    <h1>SIPAKU</h1>
                    <h5>Sistem Pendaftaran Akun KIP-K UMSIDA</h5>
                </div>
            </div>

            <!-- Kanan (Form Login) -->
            <div class="col-md-5 d-flex justify-content-center">
                <div class="login-box text-center">
                    <img src="images/bismillah-white.png" class="img-fluid" alt="...">

                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn w-100 text-white">Login</button>
                    </form>

                    <p class="small text-start mt-2">Punya akun? <a href="register" class="text-warning">Daftar sekarang</a></p>
                    <!-- <a href="#" class="text-warning text-start d-block mt-3">Lupa Password?</a> -->
                    <div class="gradient-bar"></div>
                    <p class="small text-start">Ubah password Anda secara berkala. Gunakan kombinasi karakter yang aman.</p>
                    <div class="gradient-bar"></div>
                    <p class="small text-start">Jangan lupa logout untuk menjaga keamanan akun Anda.</p>
                    <div class="gradient-bar"></div>
                    <p class="small mt-5">Copyright © 2025 <br>Universitas Muhammadiyah Sidoarjo</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>