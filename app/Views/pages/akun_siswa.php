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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-bold">DATA SISWA</h3>
        <a href="/siswa/tambah" class="btn btn-success">
            <i class="ti ti-plus"></i> Tambah Siswa
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-white  text-center">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tbody>
                <?php if (empty($siswa)) : ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data siswa.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($siswa as $row) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['nis']) ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td><?= esc($row['kelas']) ?></td>
                            <td><?= esc($row['jenis_kelamin']) ?></td>
                            <td><?= esc($row['alamat']) ?></td>
                            <td>
                                <a href="/siswa/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <a href="/siswa/hapus/<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">
                                    <i class="ti ti-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- [ Main Content ] end -->

<?= $this->endSection() ?>