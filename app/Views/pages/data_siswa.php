<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Data Siswa</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ Breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="container bg-white shadow rounded p-4 mt-4">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <strong>Perhatian!</strong> <?= session()->getFlashdata('warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="font-bold">DATA SISWA</h3>
        
        <form action="" method="get" class="d-flex gap-2 flex-wrap mb-2 mb-md-0">
            <select name="tahun_akademik" class="form-select px-3 py-1 rounded border w-auto" onchange="this.form.submit()">
                <option value="">-- Semua Tahun Akademik --</option>
                <?php if (!empty($availableYears)) : ?>
                    <?php foreach ($availableYears as $year) : ?>
                        <option value="<?= esc($year) ?>" <?= ($selectedYear == $year) ? 'selected' : '' ?>>
                            <?= esc($year) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            
            <div class="input-group w-auto">
                <input type="text" name="keyword" class="form-control px-3 py-1 rounded-start border" 
                       placeholder="Cari Nama Siswa..." 
                       value="<?= esc($keyword ?? '') ?>">
                <button class="btn btn-primary px-3 py-1 rounded-end" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div>
            <a href="/siswa/export" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 me-2">
                <i class="fas fa-file-export"></i> Export CSV
            </a>
            <button type="button" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600 me-2" data-bs-toggle="modal" data-bs-target="#modalImportData">
                <i class="fas fa-file-import"></i> Import Data
            </button>
            <button type="button" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#modalTambahData">
                <i class="ti ti-plus"></i> Tambah data
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-white text-center text-nowrap">
                <tr>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Kelas</th>
                    <th>JK</th>
                    <th>Tanggal_Lahir</th>
                    <th>Alamat</th>
                    <th>HP</th>
                    <th>Data Ayah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                <?php if (empty($siswa)) : ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data siswa.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($siswa as $row): ?>
                        <tr>
                            <td class="text-nowrap"><?= esc($row['nisn']) ?></td>
                            <td class="text-start"><?= esc($row['nama']) ?></td>
                            <td class="text-nowrap"><?= esc($row['nik']) ?></td>
                            <td><?= esc($row['kelas'] ?? '-') ?></td>
                            <td><?= esc($row['jk']) ?></td>
                            <td class="text-nowrap"><?= esc($row['tanggal_lahir']) ?></td>
                            <td class="text-start"><?= esc($row['alamat']) ?></td>
                            <td class="text-nowrap"><?= esc($row['no_whatsapp']) ?></td>
                            <td class="text-start"><?= esc($row['orang_tua']) ?></td>
                            <td class="text-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="javascript:void(0);"
                                        class="flex items-center bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition duration-200 text-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditData"
                                        data-nisn="<?= esc($row['nisn']) ?>"
                                        data-nama="<?= esc($row['nama']) ?>"
                                        data-nik="<?= esc($row['nik']) ?>"
                                        data-kelas="<?= esc($row['kelas'] ?? '') ?>"
                                        data-jk="<?= esc($row['jk']) ?>"
                                        data-tgl_lahir="<?= esc($row['tanggal_lahir']) ?>"
                                        data-alamat="<?= esc($row['alamat']) ?>"
                                        data-no_wa="<?= esc($row['no_whatsapp']) ?>"
                                        data-ortu="<?= esc($row['orang_tua']) ?>"
                                        title="Edit Data">
                                        <i class="fas fa-edit mr-1"></i>
                                    </a>

                                    <a href="/siswa/hapus/<?= $row['nisn'] ?>"
                                        onclick="return confirm('Yakin ingin hapus data ini?')"
                                        class="flex items-center bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200 text-sm"
                                        title="Hapus Data">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- [ Main Content ] end -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/siswa/tambah" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="jk" class="form-label">JK</label>
                            <select name="jk" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal_Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>
                         <!-- Username hidden/removed -->

                        <div class="col-md-6">
                            <label for="no_wa" class="form-label">HP</label>
                            <input type="text" name="no_whatsapp" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="ortu" class="form-label">Data Ayah</label>
                            <input type="text" name="ortu" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/siswa/update" method="post" id="formEditSiswa">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDataLabel">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="original_nisn" id="edit_original_nisn">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_nisn" class="form-label">NISN</label>
                            <input type="text" name="nisn" id="edit_nisn" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="edit_nik" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_kelas" class="form-label">Kelas</label>
                            <input type="text" name="kelas" id="edit_kelas" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_jk" class="form-label">JK</label>
                            <select name="jk" id="edit_jk" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_tanggal_lahir" class="form-label">Tanggal_Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea>
                        </div>
                         <!-- Username hidden/removed -->

                        <div class="col-md-6">
                            <label for="edit_no_wa" class="form-label">HP</label>
                            <input type="text" name="no_whatsapp" id="edit_no_wa" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_ortu" class="form-label">Data Ayah</label>
                            <input type="text" name="ortu" id="edit_ortu" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEdit = document.getElementById('modalEditData');
        modalEdit.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            // Ambil data dari atribut data-
            const nisn = button.getAttribute('data-nisn');
            const nama = button.getAttribute('data-nama');
            const nik = button.getAttribute('data-nik');
            const kelas = button.getAttribute('data-kelas');
            const jk = button.getAttribute('data-jk');
            const tgl_lahir = button.getAttribute('data-tgl_lahir');
            const alamat = button.getAttribute('data-alamat');
            // const username = button.getAttribute('data-username'); // Removed
            const no_wa = button.getAttribute('data-no_wa');
            const ortu = button.getAttribute('data-ortu');

            // Set ke form modal
            modalEdit.querySelector('#edit_original_nisn').value = nisn; // Keep original NISN for update logic
            modalEdit.querySelector('#edit_nisn').value = nisn;
            modalEdit.querySelector('#edit_nama').value = nama;
            modalEdit.querySelector('#edit_nik').value = nik;
            modalEdit.querySelector('#edit_kelas').value = kelas;
            modalEdit.querySelector('#edit_jk').value = jk;
            if(modalEdit.querySelector('#edit_tanggal_lahir')) modalEdit.querySelector('#edit_tanggal_lahir').value = tgl_lahir;
            modalEdit.querySelector('#edit_alamat').value = alamat;
            // modalEdit.querySelector('#edit_username').value = username; // Removed
            modalEdit.querySelector('#edit_no_wa').value = no_wa;
            modalEdit.querySelector('#edit_ortu').value = ortu;
            // Kosongkan password (tidak perlu)

        });
    });
</script>


<script>
    // Auto-hide alert dalam 5 detik
    document.addEventListener('DOMContentLoaded', function() {
        const alertEl = document.querySelector('.alert-dismissible');
        if (alertEl) {
            setTimeout(() => {
                const alert = new bootstrap.Alert(alertEl);
                alert.close();
            }, 3000);
        }
    });
</script>
<!-- Modal Import Data -->
<div class="modal fade" id="modalImportData" tabindex="-1" aria-labelledby="modalImportDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/siswa/import" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportDataLabel">Import Data Siswa (Excel/CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_csv" class="form-label">Pilih File Excel/CSV</label>
                        <input type="file" name="file_csv" class="form-control" accept=".csv, .xls, .xlsx, .ods" required>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            Format CSV/Excel (urutan kolom):<br>
                            NISN, Nama, NIK, JK, Tanggal_Lahir, Alamat, (Skip Username), (Skip), HP, Data Ayah, Role.<br>
                            * Tanggal_Lahir format: YYYY-MM-DD.<br>
                            * Password & Username otomatis NISN.<br>
                            * Role default: 'siswa' jika kosong.
                        </small>
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
<?= $this->endSection() ?>