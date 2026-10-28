<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">UIS / UIM</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">UIS / UIM</a></li>
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
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
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

    <!-- Tombol yang memicu modal -->
    <!-- Tombol Buat Tagihan -->
    <button type="button" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" data-bs-toggle="modal" data-bs-target="#modalTagihan">
        <i class="fas fa-file-invoice-dollar"></i> Buat Tagihan
    </button>

    <!-- Tombol Input Pembayaran -->
    <button type="button" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 ml-2" data-bs-toggle="modal" data-bs-target="#modalPembayaran">
        <i class="fas fa-money-bill-wave"></i> Input Pembayaran
    </button>
    
    <!-- Import Button -->
    <button type="button" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 ml-2" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        Import Excel
    </button>
</form>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" id="flash-success">
        <?= session()->getFlashdata('success') ?>
    </div>

    <script>
        setTimeout(function() {
            let alertEl = document.getElementById('flash-success');
            if (alertEl) {
                alertEl.style.display = 'none';
            }
        }, 3000); // 3000 ms = 3 detik
    </script>
<?php endif; ?>





<!-- Table -->
<div class="alert alert-info mb-3">
    <strong>Keterangan:</strong> Debet = Pemasukan, Kredit = Tagihan
</div>
<div class="overflow-x-auto shadow-md rounded-lg bg-white">
    <div class="table-responsive ">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>NAMA SISWA</th>
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
                            <td><?= esc($row['nama_siswa']) ?></td>
                            <td><?= number_format($row['debit'], 0, ',', '.') ?></td>
                            <td><?= number_format($row['kredit'], 0, ',', '.') ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" onclick="showModalEdit(<?= $row['id'] ?>, '<?= $row['nama_siswa'] ?>', '<?= $row['tanggal'] ?>', '<?= $row['debit'] ?>', '<?= $row['kredit'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="/uis_uim/delete/<?= $row['id'] ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin hapus data ini?');">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt mr-1"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">Tidak ada data</td>
                    </tr>
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

<!-- Pagination -->
<div class="flex justify-center mt-4">
    <nav class="inline-flex">
        <button class="px-3 py-1 rounded-l bg-gray-200 hover:bg-gray-300">&laquo;</button>
        <button class="px-3 py-1 bg-blue-500 text-white">1</button>
        <button class="px-3 py-1 rounded-r bg-gray-200 hover:bg-gray-300">&raquo;</button>
    </nav>
</div>

<!-- Modal Buat Tagihan -->
<div class="modal fade" id="modalTagihan" tabindex="-1" aria-labelledby="modalTagihanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Tagihan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="/uis_uim/simpan" method="post">
                <div class="modal-body">
                    <input type="hidden" name="debit" value="0">
                    <div class="mb-3">
                        <label for="tagihan_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tagihan_tanggal" required value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tagihan_siswa" class="form-label">Nama Siswa</label>
                        <select class="form-select" name="nama_siswa" id="tagihan_siswa" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswaList as $siswa) : ?>
                                <option value="<?= htmlspecialchars($siswa['nama']) ?>">
                                    <?= htmlspecialchars($siswa['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Field Kredit (Tagihan) Aktif -->
                    <div class="mb-3">
                        <label for="tagihan_kredit" class="form-label">Nominal Tagihan (Kredit)</label>
                        <input type="number" class="form-control" name="kredit" id="tagihan_kredit" required placeholder="Masukkan jumlah tagihan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan Tagihan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Input Pembayaran -->
<div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Pembayaran Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="/uis_uim/simpan" method="post">
                <div class="modal-body">
                    <!-- Kredit diset 0 untuk pembayaran -->
                    <input type="hidden" name="kredit" value="0">
                    
                    <div class="mb-3">
                        <label for="bayar_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="bayar_tanggal" required value="<?= date('Y-m-d') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="bayar_siswa" class="form-label">Nama Siswa</label>
                        <select class="form-select" name="nama_siswa" id="bayar_siswa" required onchange="updateTagihanInfo(this.value)">
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswaList as $siswa) : ?>
                                <option value="<?= htmlspecialchars($siswa['nama']) ?>">
                                    <?= htmlspecialchars($siswa['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Info Tagihan (Read Only) -->
                    <div class="mb-3">
                        <label for="bayar_info_tagihan" class="form-label text-danger">Total Tagihan Tertunggak (Bulan Ini)</label>
                        <input type="text" class="form-control bg-light" id="bayar_info_tagihan" readonly value="Rp 0">
                        <small class="text-muted">*Diambil dari data Kredit di tabel (filter saat ini)</small>
                    </div>

                    <!-- Field Debit (Pembayaran) Aktif -->
                    <div class="mb-3">
                        <label for="bayar_debit" class="form-label">Nominal Pembayaran (Debit)</label>
                        <input type="number" class="form-control" name="debit" id="bayar_debit" required placeholder="Masukkan jumlah pembayaran">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Data Tagihan & Pembayaran per Siswa
    const dataKeuanganSiswa = {};
    
    <?php 
    // Reset iterator datanya
    $pembayaranPerSiswa = [];
    if (!empty($data)) {
        foreach ($data as $row) {
            $n = $row['nama_siswa'];
            if (!isset($pembayaranPerSiswa[$n])) $pembayaranPerSiswa[$n] = 0;
            $pembayaranPerSiswa[$n] += (float)$row['debit'];
        }
    }

    if (!empty($data)) {
        foreach ($data as $row) {
            $nama = addslashes($row['nama_siswa']);
            $kredit = (float) $row['kredit'];
            $totalBayar = $pembayaranPerSiswa[$row['nama_siswa']] ?? 0;
            
            echo "if (!dataKeuanganSiswa['$nama']) dataKeuanganSiswa['$nama'] = { total_kredit: 0, total_debit: $totalBayar };";
            echo "dataKeuanganSiswa['$nama'].total_kredit += $kredit;";
        }
    }
    ?>

    function updateTagihanInfo(namaSiswa) {
        const inputTagihan = document.getElementById('bayar_info_tagihan');
        const data = dataKeuanganSiswa[namaSiswa];
        
        // Hitung sisa tagihan
        let sisaTagihan = 0;
        if (data) {
            sisaTagihan = data.total_kredit - data.total_debit;
        }
        
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });
        
        inputTagihan.value = formatter.format(sisaTagihan);
        
        if (sisaTagihan <= 0) {
            inputTagihan.classList.remove('text-danger');
            inputTagihan.classList.add('text-success');
            if (sisaTagihan === 0) {
                inputTagihan.value += " (Lunas)";
            } else {
                inputTagihan.value += " (Lebih Bayar)";
            }
        } else {
            inputTagihan.classList.add('text-danger');
            inputTagihan.classList.remove('text-success');
        }
    }

    function showModalEdit(id, nama, tanggal, debit, kredit) {
        // Set values to correct IDs (hyphens)
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-tanggal').value = tanggal;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-debit').value = debit;
        document.getElementById('edit-kredit').value = kredit;
        
        // Show Modal
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEditData'));
        modalEdit.show();
        
        // Ganti action form
        document.getElementById('formEditData').action = '/uis_uim/update/' + id;

        // LOGIC STRICT EDIT
        const inputDebit = document.getElementById('edit-debit');
        const inputKredit = document.getElementById('edit-kredit');
        const inputTanggal = document.getElementById('edit-tanggal');
        
        // Reset state
        inputDebit.readOnly = false;
        inputKredit.readOnly = false;
        inputTanggal.readOnly = false;
        
        const isTagihan = parseFloat(kredit) > 0;
        const isPembayaran = parseFloat(debit) > 0;
        const totalBayarSiswa = dataKeuanganSiswa[nama] ? dataKeuanganSiswa[nama].total_debit : 0;

        if (isTagihan) {
            // Rule 1: Tagihan -> Debit Locked & Tanggal Locked
            inputDebit.readOnly = true; 
            inputDebit.value = 0; 
            inputTanggal.readOnly = true;

            // Rule 2: Ada Pembayaran -> Kredit Locked
            if (totalBayarSiswa > 0) {
                inputKredit.readOnly = true;
                alert('Peringatan: Siswa ini sudah memiliki riwayat pembayaran. Nominal tagihan tidak dapat diubah demi konsistensi data.');
            }
        } else if (isPembayaran) {
            // Rule 3: Pembayaran -> Kredit Locked
            inputKredit.readOnly = true;
            inputKredit.value = 0; 
        }
    }
</script>

<!-- Modal edit data -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDataLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <form id="formEditData" method="post" action="">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama_siswa" id="edit-nama" required>
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
            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditData" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportExcel" tabindex="-1" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportExcelLabel">Import Data Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/uis_uim/import" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_excel" class="form-label">Pilih File Excel</label>
                        <input class="form-control" type="file" id="file_excel" name="file_excel" accept=".xls,.xlsx,.csv,.ods" required>
                    </div>
                    <div class="alert alert-info">
                        <small>Pastikan format file: <br>
                        Kolom A: Tanggal (YYYY-MM-DD)<br>
                        Kolom B: Nama Siswa<br>
                        Kolom C: Debit<br>
                        Kolom D: Kredit</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<script>

</script>
<?= $this->endSection() ?>
