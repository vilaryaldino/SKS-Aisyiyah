<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">GAJI GURU</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Gaji guru</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ Breadcrumb ] end -->

<!-- [ Main Content ] start -->

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGuru">
            <i class="fas fa-plus mr-1"></i> Tambah Guru
        </button>
        <a href="/gaji-guru/cetak" target="_blank" class="btn btn-danger">
            <i class="fas fa-print mr-1"></i> Cetak Tanda Terima
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="table-guru" style="font-size: 0.85rem;">
                <thead class="text-center align-middle">
                    <tr>
                        <th rowspan="2">NAMA GURU</th>
                        <th rowspan="2">JABATAN</th>
                        <th colspan="9">RINCIAN</th>
                        <th rowspan="2">JUMLAH KESELURUHAN</th>
                        <th rowspan="2">AKSI</th>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <th>Tunj. Jabatan</th>
                        <th>Tunj. Walas</th>
                        <th>Tunj. Masa Kerja</th>
                        <th>Kesejahteraan</th>
                        <th>Transport</th>
                        <th>Kinerja</th>
                        <th>Rapat & dll</th>
                        <th>Tahfidz</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($teachers)) : ?>
                        <?php foreach ($teachers as $teacher) : ?>
                            <?php 
                                $total = ($teacher['gaji_pokok'] ?? 0) + 
                                         ($teacher['tunjangan_jabatan'] ?? 0) + 
                                         ($teacher['tunjangan_walas'] ?? 0) + 
                                         ($teacher['tunjangan_masa_kerja'] ?? 0) + 
                                         ($teacher['kesejahteraan'] ?? 0) + 
                                         ($teacher['transport_kehadiran'] ?? 0) + 
                                         ($teacher['kinerja'] ?? 0) + 
                                         ($teacher['rapat_dll'] ?? 0) + 
                                         ($teacher['tahfidz'] ?? 0);
                            ?>
                            <tr>
                                <td class="text-start"><?= esc($teacher['nama']) ?></td>
                                <td><?= esc($teacher['jabatan']) ?></td>
                                <td class="text-end"><?= number_format($teacher['gaji_pokok'], 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['tunjangan_jabatan'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['tunjangan_walas'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['tunjangan_masa_kerja'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['kesejahteraan'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['transport_kehadiran'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['kinerja'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['rapat_dll'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($teacher['tahfidz'] ?? 0, 0, ',', '.') ?></td>
                                <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning btn-sm btn-edit" 
                                            data-id="<?= $teacher['id'] ?>"
                                            data-nip="<?= $teacher['nip'] ?>"
                                            data-nama="<?= $teacher['nama'] ?>"
                                            data-jabatan="<?= $teacher['jabatan'] ?>"
                                            data-gaji="<?= $teacher['gaji_pokok'] ?>"
                                            
                                            data-tunjangan_jabatan="<?= $teacher['tunjangan_jabatan'] ?? 0 ?>"
                                            data-tunjangan_walas="<?= $teacher['tunjangan_walas'] ?? 0 ?>"
                                            data-tunjangan_masa_kerja="<?= $teacher['tunjangan_masa_kerja'] ?? 0 ?>"
                                            data-kesejahteraan="<?= $teacher['kesejahteraan'] ?? 0 ?>"
                                            data-transport_kehadiran="<?= $teacher['transport_kehadiran'] ?? 0 ?>"
                                            data-kinerja="<?= $teacher['kinerja'] ?? 0 ?>"
                                            data-rapat_dll="<?= $teacher['rapat_dll'] ?? 0 ?>"
                                            data-tahfidz="<?= $teacher['tahfidz'] ?? 0 ?>"
                                            
                                            data-bs-toggle="modal" data-bs-target="#modalGuru">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="/gaji-guru/hapus/<?= $teacher['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="13">Tidak ada data guru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Guru -->
<div class="modal fade" id="modalGuru" tabindex="-1" aria-labelledby="modalGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGuruLabel">Tambah/Edit Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/gaji-guru/simpan" method="post" id="formGuru">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" required>
                        </div>
                    </div>
                    <hr>
                    <h6 class="mb-3">Tunjangan & Lainnya</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tunjangan_jabatan" class="form-label">Tunjangan Jabatan</label>
                            <input type="number" class="form-control" id="tunjangan_jabatan" name="tunjangan_jabatan" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tunjangan_walas" class="form-label">Tunjangan Walas</label>
                            <input type="number" class="form-control" id="tunjangan_walas" name="tunjangan_walas" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tunjangan_masa_kerja" class="form-label">Tunjangan Masa Kerja</label>
                            <input type="number" class="form-control" id="tunjangan_masa_kerja" name="tunjangan_masa_kerja" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kesejahteraan" class="form-label">Kesejahteraan</label>
                            <input type="number" class="form-control" id="kesejahteraan" name="kesejahteraan" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="transport_kehadiran" class="form-label">Transport Kehadiran</label>
                            <input type="number" class="form-control" id="transport_kehadiran" name="transport_kehadiran" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kinerja" class="form-label">Kinerja</label>
                            <input type="number" class="form-control" id="kinerja" name="kinerja" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rapat_dll" class="form-label">Rapat & dll</label>
                            <input type="number" class="form-control" id="rapat_dll" name="rapat_dll" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahfidz" class="form-label">Tahfidz</label>
                            <input type="number" class="form-control" id="tahfidz" name="tahfidz" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalGuru = document.getElementById('modalGuru');
        const formGuru = document.getElementById('formGuru');
        
        modalGuru.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            
            if (id) {
                // Edit Mode
                formGuru.setAttribute('action', '/gaji-guru/update');
                document.getElementById('id').value = id;
                document.getElementById('nip').value = button.getAttribute('data-nip');
                document.getElementById('nama').value = button.getAttribute('data-nama');
                document.getElementById('jabatan').value = button.getAttribute('data-jabatan');
                document.getElementById('gaji_pokok').value = button.getAttribute('data-gaji');
                
                document.getElementById('tunjangan_jabatan').value = button.getAttribute('data-tunjangan_jabatan');
                document.getElementById('tunjangan_walas').value = button.getAttribute('data-tunjangan_walas');
                document.getElementById('tunjangan_masa_kerja').value = button.getAttribute('data-tunjangan_masa_kerja');
                document.getElementById('kesejahteraan').value = button.getAttribute('data-kesejahteraan');
                document.getElementById('transport_kehadiran').value = button.getAttribute('data-transport_kehadiran');
                document.getElementById('kinerja').value = button.getAttribute('data-kinerja');
                document.getElementById('rapat_dll').value = button.getAttribute('data-rapat_dll');
                document.getElementById('tahfidz').value = button.getAttribute('data-tahfidz');

                document.getElementById('modalGuruLabel').textContent = 'Edit Guru';
            } else {
                // Add Mode
                formGuru.setAttribute('action', '/gaji-guru/simpan');
                formGuru.reset();
                document.getElementById('id').value = '';
                document.getElementById('modalGuruLabel').textContent = 'Tambah Guru';
            }
        });
    });
</script>

<?= $this->endSection() ?>