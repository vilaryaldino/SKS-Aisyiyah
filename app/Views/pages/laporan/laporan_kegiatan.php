<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">LAPORAN KEGIATAN</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Laporan Kegiatan</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ Breadcrumb ] end -->

<!-- [ Main Content ] start -->
<form action="" method="get" class="flex flex-wrap items-center gap-2 my-3">
    <select name="bulan" class="border rounded px-2 py-1">
        <option value="">-- Pilih Bulan --</option>
        <?php
        $bulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        foreach ($bulanList as $num => $nama) {
            $selected = ($_GET['bulan'] ?? '') === $num ? 'selected' : '';
            echo "<option value=\"$num\" $selected>$nama</option>";
        }
        ?>
    </select>

    <select name="tahun" class="border rounded px-2 py-1">
        <option value="">-- Pilih Tahun --</option>
        <?php
        $currentYear = date('Y');
        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
            $selected = ($_GET['tahun'] ?? '') == $i ? 'selected' : '';
            echo "<option value=\"$i\" $selected>$i</option>";
        }
        ?>
    </select>

    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
        Filter
    </button>

    <button type="button" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#modalTambahData">
        Tambah data
    </button>
</form>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" id="flash-success">
        <?= session()->getFlashdata('success') ?>
    </div>
    <script>
        setTimeout(function() {
            let alertEl = document.getElementById('flash-success');
            if (alertEl) { alertEl.style.display = 'none'; }
        }, 3000);
    </script>
<?php endif; ?>

<!-- Table -->
<div class="alert alert-info mb-3">
    <strong>Keterangan:</strong> Debet = Pemasukan, Kredit = Pengeluaran
</div>
<div class="overflow-x-auto shadow-md rounded-lg bg-white">
    <div class="table-responsive ">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>KETERANGAN</th>
                    <th>DEBIT</th>
                    <th>KREDIT</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                $total_debit = 0;
                $total_kredit = 0;
                if (!empty($data)) :
                    $no = 1;
                    foreach ($data as $row) :
                        $total_debit += $row['debit'];
                        $total_kredit += $row['kredit'];
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                            <td><?= esc($row['keterangan']) ?></td>
                            <td><?= number_format($row['debit'], 0, ',', '.') ?></td>
                            <td><?= number_format($row['kredit'], 0, ',', '.') ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" onclick="showModalEdit(<?= $row['id'] ?>, '<?= esc($row['keterangan']) ?>', '<?= $row['tanggal'] ?>', '<?= $row['debit'] ?>', '<?= $row['kredit'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="/laporan_kegiatan/delete/<?= $row['id'] ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin hapus data ini?');">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt mr-1"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="6">Tidak ada data</td></tr>
                <?php endif; ?>
            </tbody>
            <tbody class="text-center font-bold">
                <tr class="bg-blue-100 text-blue-800 rounded shadow font-bold">
                    <td colspan="3">TOTAL</td>
                    <td><?= number_format($total_debit) ?></td>
                    <td><?= number_format($total_kredit) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="/laporan_kegiatan/simpan" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="debit" class="form-label">Debit</label>
                        <input type="number" class="form-control" name="debit" id="debit" required>
                    </div>
                    <div class="mb-3">
                        <label for="kredit" class="form-label">Kredit</label>
                        <input type="number" class="form-control" name="kredit" id="kredit" required>
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

<!-- Modal edit data -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDataLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="formEditData" method="post" action="">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="edit-keterangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="edit-tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-debit" class="form-label">Debit</label>
                        <input type="number" class="form-control" name="debit" id="edit-debit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-kredit" class="form-label">Kredit</label>
                        <input type="number" class="form-control" name="kredit" id="edit-kredit" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditData" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModalEdit(id, keterangan, tanggal, debit, kredit) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-keterangan').value = keterangan;
        document.getElementById('edit-tanggal').value = tanggal;
        document.getElementById('edit-debit').value = debit;
        document.getElementById('edit-kredit').value = kredit;

        document.getElementById('formEditData').action = '/laporan_kegiatan/update/' + id;

        const modalEdit = new bootstrap.Modal(document.getElementById('modalEditData'));
        modalEdit.show();
    }
</script>
<?= $this->endSection() ?>
