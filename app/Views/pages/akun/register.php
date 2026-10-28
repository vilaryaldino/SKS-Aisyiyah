<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem KIP Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-card {
            display: flex;
            width: 800px;
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .register-left {
            background-color: #211C84;
            color: white;
            padding: 40px;
            text-align: center;
            width: 50%;
        }

        .register-left img {
            width: 120px;
        }

        .register-right {
            padding: 40px;
            width: 50%;
        }

        /* Versi 1 */
        .form-control {
            background-color: #f5f5f5;
            border: none;
            border-radius: 20px;
            padding: 12px;
        }

        /* Versi 2 */
        .form-control {
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #211C84;
            border-left: 2px solid #211C84;
            border-bottom-left-radius: 5px;
            padding: 5px;
            padding-left: 10px;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-bottom: 2px solid #007ACC;
            outline: none;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #211C84;
            border: none;
            border-radius: 20px;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #007ACC;
        }

        /* Media Query untuk Layar Kecil (Mode HP) */
        @media (max-width: 768px) {
            .register-card {
                width: 95%;

                flex-direction: column;
            }

            .register-left,
            .register-right {
                width: 100%;
                padding: 20px;
            }

            .register-left {
                padding-bottom: 0;
            }
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="register-card">
            <!-- Bagian Kiri -->
            <div class="register-left d-flex flex-column align-items-center justify-content-center">
                <img src="images/logo.png" alt="Logo Sekolah">
                <h4 class="mt-3">Sistem Manajemen Keuangan Siswa</h4>
                <p>TK Aisyiyah 6 Candi</p>
            </div>

            <!-- Bagian Kanan -->
            <div class="register-right">
                <div class="text-center">
                    <img src="images/bismillah-hitam.png" alt="Bismillah">
                    <h4 class="fw-bold">Daftar Akun</h4>
                    <p class="text-muted">Jangan lewatkan kesempatan! Daftar sekarang dan raih manfaatnya</p>
                </div>

                 <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" value="<?= old('nama') ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username') ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?= old('email') ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="pass_confirm" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
                <hr>
                <p class="text-center">Sudah punya akun? <a href="login" class="text-primary">Login</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>