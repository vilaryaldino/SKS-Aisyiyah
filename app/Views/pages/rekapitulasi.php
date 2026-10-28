<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">REKAPITULASI</h5>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Rekapitulasi</a></li>
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
    
    <!-- Export Buttons -->
    <button type="submit" formaction="/rekap/excel" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 ml-2">
        Export Excel
    </button>
    <button type="submit" formaction="/rekap/print" formtarget="_blank" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 ml-2">
        Cetak PDF
    </button>
</form>

<div class="alert alert-info mb-3">
    <strong>Keterangan:</strong> Debet = Pemasukan, Kredit = Pengeluaran
</div>

<!-- Table -->
<div class="overflow-x-auto shadow-md rounded-lg bg-white">
    <div class="table-responsive ">
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-blue-100 text-center font-bold">
                <tr>
                    <th class="w-12">NO</th>
                    <th class="text-left bg-light-blue-100">KETERANGAN</th>
                    <th class="text-right bg-light-blue-100">PEMASUKAN (DEBET)</th>
                    <th class="text-right bg-light-blue-100">PENGELUARAN (KREDIT)</th>
                    <th class="text-right bg-light-blue-100">SALDO</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dataList as $row): ?>
                    <tr>
                        <td class="text-center font-bold"><?= $no++ ?></td>
                        <td class="text-start pl-4"><?= esc($row['keterangan']) ?></td>
                        <td class="text-end pr-4">Rp. <?= number_format($row['debit'], 0, ',', '.') ?></td>
                        <td class="text-end pr-4"><?= ($row['kredit'] > 0) ? 'Rp. ' . number_format($row['kredit'], 0, ',', '.') : '-' ?></td>
                        <td class="text-end pr-4">Rp. <?= number_format($row['saldo'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-gray-100">
                    <td colspan="2" class="text-center text-uppercase">TOTAL :</td>
                    <td class="text-end pr-4">Rp. <?= number_format($totalDebit, 2, ',', '.') ?></td>
                    <td class="text-end pr-4">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
                    <td class="text-end pr-4">Rp. <?= number_format($totalSaldo, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
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
