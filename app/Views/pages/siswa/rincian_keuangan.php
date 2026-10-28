<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Rincian Keuangan</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard-siswa">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rincian Keuangan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Tagihan Saya</h5>
            <a href="/dashboard-siswa" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Kategori Pembayaran</th>
                            <th class="text-end py-3 text-uppercase small fw-bold text-muted">Jumlah Tagihan</th>
                            <th class="text-center py-3 text-uppercase small fw-bold text-muted">Status</th>
                            <th class="pe-4 text-center py-3 text-uppercase small fw-bold text-muted">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = [
                            ['label' => 'Uang Pendaftaran', 'key' => 'pendaftaran', 'icon' => 'fa-user-plus text-primary'],
                            ['label' => 'UIS / UIM', 'key' => 'uis_uim', 'icon' => 'fa-file-invoice text-info'],
                            ['label' => 'Peralatan', 'key' => 'peralatan', 'icon' => 'fa-tools text-warning'],
                            ['label' => 'LKS', 'key' => 'lks', 'icon' => 'fa-book text-success'],
                            ['label' => 'Seragam & Tas', 'key' => 'seragam_tas', 'icon' => 'fa-tshirt text-indigo'],
                            ['label' => 'Kegiatan', 'key' => 'kegiatan', 'icon' => 'fa-running text-danger'],
                            ['label' => 'SPP', 'key' => 'spp', 'icon' => 'fa-graduation-cap text-purple'],
                            ['label' => 'DPP', 'key' => 'dpp', 'icon' => 'fa-building text-pink'],
                        ];

                        foreach ($items as $item): 
                            $amount = $data[$item['key']];
                            $isLunas = ($amount <= 0);
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 opacity-75">
                                        <i class="fas <?= $item['icon'] ?> fa-lg" style="width: 24px;"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?= $item['label'] ?></span>
                                </div>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                Rp <?= number_format($amount, 0, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <?php if ($isLunas): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Lunas</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Belum Lunas</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center">
                                <?php if (!$isLunas): ?>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3" onclick="alert('Silakan hubungi admin untuk pembayaran.')">
                                        Bayar
                                    </button>
                                <?php else: ?>
                                    <i class="fas fa-check-circle text-success fa-lg"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td class="ps-4 py-3 fw-bold">TOTAL TAGIHAN</td>
                            <td class="text-end py-3 fw-bold text-danger fs-5">
                                Rp <?= number_format($data['total'], 0, ',', '.') ?>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
