<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Rincian Keuangan Siswa (Admin View)</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/keuangan_siswa">Keuangan Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rincian</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 text-gray-800">Detail Tagihan: <?= esc($data['nama']) ?></h5>
                    <small class="text-muted">Kelas: <?= esc($data['kelas']) ?> | NIS: <?= esc($data['nis']) ?></small>
                </div>
                <div class="col-auto">
                    <a href="/keuangan_siswa" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
             <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>Kategori</th>
                            <th>Jumlah Tagihan (Sisa)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = [
                            'Pendaftaran' => 'pendaftaran',
                            'UIS / UIM' => 'uis_uim',
                            'Peralatan' => 'peralatan',
                            'LKS' => 'lks',
                            'Seragam / Tas' => 'seragam_tas',
                            'Kegiatan' => 'kegiatan',
                            'SPP' => 'spp',
                            'DPP' => 'dpp',
                        ];
                        
                        foreach ($items as $label => $key):
                            $amount = $data[$key];
                            $isUnbilled = ($amount === '-');
                            $isLunas = (!$isUnbilled && $amount <= 0);
                        ?>
                        <tr>
                            <td class="align-middle fw-bold"><?= $label ?></td>
                            <td class="align-middle text-end">
                                <?= $isUnbilled ? '-' : 'Rp ' . number_format($amount, 0, ',', '.') ?>
                            </td>
                            <td class="align-middle text-center">
                                <?php if ($isUnbilled): ?>
                                    <span class="badge bg-secondary">Tidak ada tagihan</span>
                                <?php elseif ($isLunas): ?>
                                    <span class="badge bg-success">Lunas</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Belum Lunas</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="fw-bold bg-light">
                        <tr>
                            <td class="text-end">TOTAL TAGIHAN</td>
                            <td class="text-end text-danger">
                                <?= ($data['total'] === '-') ? '-' : 'Rp ' . number_format($data['total'], 0, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <?php
                                $badgeClass = 'bg-danger';
                                if ($data['status'] == 'Lunas') $badgeClass = 'bg-success';
                                elseif ($data['status'] == 'Tidak ada tagihan') $badgeClass = 'bg-secondary';
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $data['status'] ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
