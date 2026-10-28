<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="<?= base_url('images/logo_new.png') ?>" class="img-fluid" alt="logo" style="max-height: 50px; width: auto;">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <?php if (session('role') === 'admin') : ?>
                <li class="pc-item">
                    <a href="/dashboard" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (session('role') === 'admin') : ?>
                <li class="pc-item pc-caption">
                    <label>Data Master</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-diamond"></i></span><span class="pc-mtext">Keuangan</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="/pendaftaran">Pendaftaran</a></li>
                        <li class="pc-item"><a class="pc-link" href="/uis_uim">UIS / UIM</a></li>
                        <li class="pc-item"><a class="pc-link" href="/peralatan">Peralatan</a></li>
                        <li class="pc-item"><a class="pc-link" href="/lks">LKS</a></li>
                        <li class="pc-item"><a class="pc-link" href="/seragam_tas">Seragam / Tas</a></li>
                        <li class="pc-item"><a class="pc-link" href="/kegiatan">Kegiatan</a></li>
                        <li class="pc-item"><a class="pc-link" href="/spp">SPP</a></li>
                        <li class="pc-item"><a class="pc-link" href="/dpp">DPP</a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-file-analytics"></i></span><span class="pc-mtext">Laporan Keuangan</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="/laporan_pendaftaran">Pendaftaran</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_uis_uim">UIS / UIM</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_peralatan">Peralatan</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_lks">LKS</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_seragam_tas">Seragam / Tas</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_kegiatan">Kegiatan</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_spp">SPP</a></li>
                        <li class="pc-item"><a class="pc-link" href="/laporan_dpp">DPP</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <?php if (session('role') === 'admin') : ?>
                    <li class="pc-item">
                        <a href="/keuangan_siswa" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-book"></i></span>
                            <span class="pc-mtext">Keuangan Siswa</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="/rekap" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
                            <span class="pc-mtext">Rekapitulasi</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="/laporan/filter" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-printer"></i></span>
                            <span class="pc-mtext">Cetak Laporan</span>
                        </a>
                    </li>
                    <?php endif; ?>

                <?php if (session('role') === 'admin') : ?>
                <li class="pc-item pc-caption">
                    <label>Data Siswa</label>
                    <i class="ti ti-news"></i>
                </li>
                <li class="pc-item">
                    <a href="/data-siswa" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                        <span class="pc-mtext">Data Siswa</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (session('role') === 'siswa') : ?>
                <li class="pc-item">
                    <a href="/dashboard-siswa" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="/siswa/keuangan" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-analytics"></i></span>
                        <span class="pc-mtext">Rincian Keuangan</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (session('role') === 'admin') : ?>
                <!-- <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-lock"></i></span>
                        <span class="pc-mtext">Akun Siswa</span>
                    </a>
                </li> -->
                <?php endif; ?>


                <?php if (session('role') === 'admin') : ?>
                <li class="pc-item pc-caption">
                    <label>Pengeluaran</label>
                    <i class="ti ti-wallet"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-wallet"></i></span><span class="pc-mtext">Pengeluaran</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="/gaji-guru">Gaji Guru</a></li>
                        <li class="pc-item"><a class="pc-link" href="/operasional">Operasional Lainnya</a></li>
                    </ul>
                </li>
                 <li class="pc-item">
                    <a href="/slip-gaji" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-invoice"></i></span>
                        <span class="pc-mtext">Slip Gaji Guru</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (session('role') === 'admin') : ?>
                <li class="pc-item pc-caption">
                    <label>Manajemen User</label>
                    <i class="ti ti-settings"></i>
                </li>
                <li class="pc-item">
                    <a href="/admin/users" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Kelola Admin</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>