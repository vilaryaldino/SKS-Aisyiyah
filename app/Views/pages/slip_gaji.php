<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Slip Gaji Guru</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Slip Gaji Guru</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ Breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Pilih Guru & Periode</h5>
            </div>
            <div class="card-body">
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Nama Guru</label>
                        <select name="teacher_id" id="teacher_id" class="form-control" required>
                            <option value="">-- Pilih Guru --</option>
                            <?php foreach ($teachers as $t) : ?>
                                <option value="<?= $t['id'] ?>" <?= ($teacher_id == $t['id']) ? 'selected' : '' ?>>
                                    <?= $t['nama'] ?> - <?= $t['nip'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <?php for ($m = 1; $m <= 12; $m++) : ?>
                                <option value="<?= $m ?>" <?= ($bulan == $m) ? 'selected' : '' ?>>
                                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <?php for ($y = date('Y') - 1; $y <= date('Y') + 1; $y++) : ?>
                                <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>>
                                    <?= $y ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cari / Lihat Slip</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <?php if ($selectedTeacher && $previewGaji) : ?>
            <div class="card bg-white shadow rounded">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="font-bold">PREVIEW SLIP GAJI</h3>
                        <p class="text-sm text-gray-600">Periode: <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p><strong>Nama:</strong> <?= esc($selectedTeacher['nama']) ?></p>
                            <p><strong>Jabatan:</strong> <?= esc($selectedTeacher['jabatan']) ?></p>
                            <p><strong>NIP:</strong> <?= esc($selectedTeacher['nip']) ?></p>
                        </div>
                        <div class="text-right">
                            <p><strong>Tanggal Cetak:</strong> <?= date('d M Y') ?></p>
                        </div>
                    </div>

                    <table class="table table-bordered w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th>Deskripsi</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gaji Pokok</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['gaji_pokok'], 0, ',', '.') ?></td>
                            </tr>
                            <?php if (!empty($previewGaji['tunjangan_jabatan'])) : ?>
                            <tr>
                                <td>Tunjangan Jabatan</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['tunjangan_jabatan'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['tunjangan_walas'])) : ?>
                            <tr>
                                <td>Tunjangan Walas</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['tunjangan_walas'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['tunjangan_masa_kerja'])) : ?>
                            <tr>
                                <td>Tunjangan Masa Kerja</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['tunjangan_masa_kerja'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['kesejahteraan'])) : ?>
                            <tr>
                                <td>Kesejahteraan</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['kesejahteraan'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['transport_kehadiran'])) : ?>
                            <tr>
                                <td>Transport Kehadiran</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['transport_kehadiran'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['kinerja'])) : ?>
                            <tr>
                                <td>Kinerja</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['kinerja'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['rapat_dll'])) : ?>
                            <tr>
                                <td>Rapat & dll</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['rapat_dll'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($previewGaji['tahfidz'])) : ?>
                            <tr>
                                <td>Tahfidz</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['tahfidz'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td>Potongan</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['potongan'], 0, ',', '.') ?></td>
                            </tr>
                            <tr class="font-bold bg-gray-100">
                                <td>Total Gaji Diterima</td>
                                <td class="text-right">Rp <?= number_format($previewGaji['total'], 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-end">
                        <a href="/cetak-slip?teacher_id=<?= $teacher_id ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" target="_blank" class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Slip (PDF/Print)
                        </a>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-info">
                Silakan pilih guru dan periode untuk melihat data gaji.
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- [ Main Content ] end -->

<?= $this->endSection() ?>