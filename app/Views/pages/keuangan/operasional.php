<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Pengeluaran Operasional</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="ti ti-plus"></i> Tambah Data
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Kategori</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($expenses as $item) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                                    <td><?= esc($item['keterangan']) ?></td>
                                    <td><span class="badge bg-light-info text-info"><?= esc($item['kategori']) ?></span></td>
                                    <td class="text-end">Rp <?= number_format($item['jumlah'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm btn-edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit"
                                            data-id="<?= $item['id'] ?>"
                                            data-tanggal="<?= $item['tanggal'] ?>"
                                            data-keterangan="<?= $item['keterangan'] ?>"
                                            data-kategori="<?= $item['kategori'] ?>"
                                            data-jumlah="<?= $item['jumlah'] ?>">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <a href="/operasional/hapus/<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="ti ti-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('operasional/simpan') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Bayar Listrik">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="Listrik & Air">Listrik & Air</option>
                            <option value="ATK">ATK</option>
                            <option value="Pemeliharaan">Pemeliharaan</option>
                            <option value="Konsumsi">Konsumsi</option>
                            <option value="Transportasi">Transportasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" required placeholder="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('operasional/update') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" id="edit_keterangan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" id="edit_kategori" class="form-control">
                            <option value="Listrik & Air">Listrik & Air</option>
                            <option value="ATK">ATK</option>
                            <option value="Pemeliharaan">Pemeliharaan</option>
                            <option value="Konsumsi">Konsumsi</option>
                            <option value="Transportasi">Transportasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" id="edit_jumlah" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEdit = document.getElementById('modalEdit');
        modalEdit.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            modalEdit.querySelector('#edit_id').value = button.getAttribute('data-id');
            modalEdit.querySelector('#edit_tanggal').value = button.getAttribute('data-tanggal');
            modalEdit.querySelector('#edit_keterangan').value = button.getAttribute('data-keterangan');
            modalEdit.querySelector('#edit_kategori').value = button.getAttribute('data-kategori');
            modalEdit.querySelector('#edit_jumlah').value = button.getAttribute('data-jumlah');
        });
    });
</script>

<?= $this->endSection() ?>
