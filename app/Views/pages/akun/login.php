<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SKS-AISYIYAH 6 CANDI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .login-card {
            display: flex;
            width: 900px;
            max-width: 100%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); /* Soft, deep shadow */
            overflow: hidden;
            min-height: 550px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-left {
            width: 50%;
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%); /* Matching dashboard theme */
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles for background interest */
        .login-left::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .login-left img {
            width: 180px; 
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            position: relative;
            z-index: 1;
        }

        .login-left h4 {
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .login-left p {
            font-size: 0.9rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .login-right {
            width: 50%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header img {
            max-width: 180px;
            margin-bottom: 15px;
        }

        .form-floating > .form-control {
            border-radius: 12px;
            border: 2px solid #eef2f7;
            padding-left: 20px;
        }

        .form-floating > .form-control:focus {
            border-color: #4e54c8;
            box-shadow: 0 0 0 0.25rem rgba(78, 84, 200, 0.25);
        }
        
        .form-floating > label {
            padding-left: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.4);
            background: linear-gradient(135deg, #4449ad 0%, #7d82e8 100%);
        }

        /* Mobile Response */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                height: auto;
            }
            .login-left, .login-right {
                width: 100%;
                padding: 30px;
            }
            .login-left {
                padding-bottom: 40px;
            }
            .login-left img {
                width: 120px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (session()->getFlashdata('swal_success')) : ?>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '<?= session()->getFlashdata('swal_success') ?>',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('swal_error')) : ?>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '<?= session()->getFlashdata('swal_error') ?>',
                });
            });
        <?php endif; ?>
    </script>
</head>

<body>

    <div class="login-container">
        <div class="login-card">
            <!-- Bagian Kiri -->
            <div class="login-left">
                <img src="../images/logo_new.png" alt="Logo Sekolah" onerror="this.src='https://via.placeholder.com/150?text=Logo+Sekolah'">
                <h4>Sistem Manajemen<br>Keuangan Siswa</h4>
                <p>TK Aisyiyah 6 Candi</p>
                <div class="mt-4 small d-none d-md-block opacity-75">
                    &copy; <?= date('Y') ?> All Rights Reserved
                </div>
            </div>

            <!-- Bagian Kanan -->
            <div class="login-right">
                <div class="login-header">
                    <img src="../images/bismillah-hitam.png" alt="Bismillah" class="mb-2" style="opacity: 0.8;">
                    <h3 class="fw-bold text-dark mt-2">Selamat Datang</h3>
                    <p class="text-muted small">Silakan login dengan akun Anda</p>
                </div>
                
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                         <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="loginInput" name="login" placeholder="NISN / Username" required>
                        <label for="loginInput" class="text-muted"><i class="fas fa-user me-2"></i>NISN / Username</label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" required>
                        <label for="passwordInput" class="text-muted"><i class="fas fa-lock me-2"></i>Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk Sekarang
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted">Lupa password? Hubungi Administrator</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>