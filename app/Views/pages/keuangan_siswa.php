<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">KEUANGAN SISWA</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Keuangan Siswa</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ Breadcrumb ] end -->

<!-- [ Main Content ] start -->
<!-- Filters -->
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
            $selected = ($bulan ?? '') === $num ? 'selected' : '';
            echo "<option value=\"$num\" $selected>$nama</option>";
        }
        ?>
    </select>

    <select name="tahun" class="border rounded px-2 py-1">
        <option value="">-- Pilih Tahun --</option>
        <?php
        $currentYear = date('Y');
        // Simple year range from current year back 5 years
        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
            $selected = ($tahun ?? '') == $i ? 'selected' : '';
            echo "<option value=\"$i\" $selected>$i</option>";
        }
        ?>
    </select>

    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
        Filter
    </button>
</form>

<div class="alert alert-info mb-3">
    <strong>Keterangan:</strong> Debet = Pemasukan, Kredit = Tagihan
</div>

<div class="overflow-x-auto shadow-md rounded-lg bg-white">
    <div class="table-responsive">
        <table class="table table-bordered w-100">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">NAMA</th>
                    <th colspan="8">RINCIAN</th>
                    <th rowspan="2">TOTAL</th>
                    <th rowspan="2">STATUS</th>
                    <th rowspan="2">AKSI</th>
                </tr>
                <tr>
                    <th>PENDAFTARAN</th>
                    <th>UIS/UIM</th>
                    <th>PERALATAN</th>
                    <th>LKS</th>
                    <th>SERAGAM/TAS</th>
                    <th>KEGIATAN</th>
                    <th>SPP</th>
                    <th>DPP</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($dataKeuangan)) : ?>
                    <?php foreach ($dataKeuangan as $item) : ?>
                        <tr>
                            <td><?= esc($item['nama']) ?></td>
                            <td><?= is_numeric($item['pendaftaran']) ? number_format($item['pendaftaran'], 0, ',', '.') : $item['pendaftaran'] ?></td>
                            <td><?= is_numeric($item['uis_uim']) ? number_format($item['uis_uim'], 0, ',', '.') : $item['uis_uim'] ?></td>
                            <td><?= is_numeric($item['peralatan']) ? number_format($item['peralatan'], 0, ',', '.') : $item['peralatan'] ?></td>
                            <td><?= is_numeric($item['lks']) ? number_format($item['lks'], 0, ',', '.') : $item['lks'] ?></td>
                            <td><?= is_numeric($item['seragam_tas']) ? number_format($item['seragam_tas'], 0, ',', '.') : $item['seragam_tas'] ?></td>
                            <td><?= is_numeric($item['kegiatan']) ? number_format($item['kegiatan'], 0, ',', '.') : $item['kegiatan'] ?></td>
                            <td><?= is_numeric($item['spp']) ? number_format($item['spp'], 0, ',', '.') : $item['spp'] ?></td>
                            <td><?= is_numeric($item['dpp']) ? number_format($item['dpp'], 0, ',', '.') : $item['dpp'] ?></td>
                            <td><?= is_numeric($item['total']) ? number_format($item['total'], 0, ',', '.') : $item['total'] ?></td>
                            <td><?= esc($item['status']) ?></td>
                            <td>
                                <div class="flex flex-wrap justify-center items-center gap-2">
                                    <a href="/rincian-keuangan-siswa?nisn=<?= esc($item['nisn']) ?>" class="flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200 text-sm" title="Lihat Detail">
                                        <i class="fas fa-info-circle mr-1"></i>
                                    </a>

                                    <?php
                                    $waNumber = $item['no_whatsapp']; // ambil nomor WA dari data siswa
                                    $sisaTagihan = is_numeric($item['total']) ? number_format($item['total'], 0, ',', '.') : 0;
                                    
                                    $message = "Assalamu’alaikum Warahmatullahi Wabarakatuh, Ayah/Bunda.\n\n"
                                        . "Berikut kami sampaikan update status pembayaran sekolah ananda di TK Aisyiyah:\n\n"
                                        . "Nama: {$item['nama']}\n"
                                        . "NISN: {$item['nisn']}\n";

                                    if ($item['status'] === 'Lunas') {
                                        $message .= "Status: Terbayarkan (Lunas)\n"
                                            . "Sisa Tagihan: Rp 0\n\n"
                                            . "Alhamdulillah, administrasi ananda telah selesai. Terima kasih atas kerja samanya.\n\n";
                                    } elseif ($item['status'] === 'Tidak ada tagihan') {
                                        $message .= "Status: Tidak ada tagihan\n\n"
                                            . "Mohon menunggu informasi tagihan selanjutnya.\n\n";
                                    } else {
                                        $message .= "Status: Belum Lunas\n"
                                            . "Sisa Tagihan: Rp {$sisaTagihan}\n\n"
                                            . "Mohon untuk segera menyelesaikan pembayaran. Terima kasih atas kerja samanya.\n\n";
                                    }

                                    $message .= "Wassalamu’alaikum Warahmatullahi Wabarakatuh.";
                                    $waMessage = urlencode($message);
                                    $waLink = "https://wa.me/{$waNumber}?text={$waMessage}";
                                    ?>
                                    <button class="flex items-center bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition duration-200 text-sm" title="Kirim WhatsApp">
                                        <a href="<?= $waLink ?>" target="_blank">
                                            <i class="fab fa-whatsapp mr-1 text-white"></i>
                                        </a>
                                    </button>
                                    
                                    <button type="button" class="flex items-center bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition duration-200 text-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalNotifikasi" 
                                        data-nisn="<?= $item['nisn'] ?>" 
                                        data-nama="<?= $item['nama'] ?>"
                                        title="Kirim Notifikasi">
                                        <i class="fas fa-bell mr-1"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="12">Data keuangan siswa tidak tersedia.</td>
                    </tr>
                <?php endif; ?>
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
<!-- [ Main Content ] end -->

<?= $this->endSection() ?>

<!-- Modal Kirim Notifikasi -->
<div class="modal fade" id="modalNotifikasi" tabindex="-1" aria-labelledby="modalNotifikasiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('siswa/notifikasi/kirim') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNotifikasiLabel">Kirim Notifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="nisn" id="notif_nisn">
                    <div class="mb-3">
                        <label for="notif_nama" class="form-label">Kepada</label>
                        <input type="text" class="form-control" id="notif_nama" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="notif_judul" class="form-label">Judul Notifikasi</label>
                        <select name="judul" class="form-control" required>
                            <option value="Tagihan SPP">Tagihan SPP</option>
                            <option value="Tagihan LKS">Tagihan LKS</option>
                            <option value="Tagihan Uang Gedung">Tagihan Uang Gedung</option>
                            <option value="Pembayaran Lunas">Pembayaran Lunas</option>
                            <option value="Informasi Sekolah">Informasi Sekolah</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notif_pesan" class="form-label">Pesan</label>
                        <textarea name="pesan" class="form-control" rows="3" required>Pembayaran Anda belum lunas. Mohon segera melakukan pembayaran.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalNotif = document.getElementById('modalNotifikasi');
        modalNotif.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const nisn = button.getAttribute('data-nisn');
            const nama = button.getAttribute('data-nama');

            modalNotif.querySelector('#notif_nisn').value = nisn;
            modalNotif.querySelector('#notif_nama').value = nama;
        });
    });
</script>
