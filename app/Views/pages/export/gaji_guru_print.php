<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tanda Terima Ihsan Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px; /* Slightly smaller to fit landscape */
            margin: 0;
            padding: 10px;
        }
        @page {
            size: landscape;
            margin: 10mm;
        }
        .header {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }
        .header img {
            position: absolute;
            left: 20px;
            top: 0;
            width: 90px;
        }
        .header h3, .header h4 {
            margin: 2px 0;
            text-transform: uppercase;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            vertical-align: middle;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
        
        /* Signature Section */
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
            padding: 0 50px;
        }
        .sig-block {
            text-align: center;
            width: 250px;
        }
        .sig-name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .sig-nbm {
            font-size: 10px;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body onload="window.print()">

    <?php
        // Helper date formatting
        $bulanNames = [
            '01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL',
            '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS',
            '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'
        ];
        
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        // Logic for academic year
        if ($currentMonth >= 7) {
            $tahunAjar = $currentYear . "-" . ($currentYear + 1);
        } else {
            $tahunAjar = ($currentYear - 1) . "-" . $currentYear;
        }

        $namaBulan = $bulanNames[$currentMonth];
    ?>

    <div class="header">
        <img src="<?= base_url('images/logo_aisyiyah_new.png') ?>" alt="Logo">
        <h3>TANDA TERIMA IHSAN GURU BULAN <?= $namaBulan ?> <?= $currentYear ?></h3>
        <h3>KB - TK AISYIYAH VI CANDI</h3>
        <h3>TAHUN <?= $tahunAjar ?></h3>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" width="30px">No</th>
                <th rowspan="2">Nama Guru</th>
                <th rowspan="2">Jabatan</th>
                <th colspan="9">Rincian</th>
                <th rowspan="2">Jumlah<br>Keseluruhan</th>
                <th rowspan="2" width="80px">TTD</th>
            </tr>
            <tr>
                <th>Gaji Pokok</th>
                <th>Tunjangan<br>Jabatan</th>
                <th>Tunjangan<br>Walas</th>
                <th>Tunjangan<br>Masa Kerja</th>
                <th>Kesejahteraan</th>
                <th>Transport<br>Kehadiran</th>
                <th>Kinerja</th>
                <th>Rapat & dll</th>
                <th>Tahfidz</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $grandTotal = 0;
                $no = 1;
            ?>
            <?php foreach ($teachers as $teacher): ?>
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
                    $grandTotal += $total;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($teacher['nama']) ?></td>
                    <td><?= esc($teacher['jabatan']) ?></td>
                    <td class="text-right">Rp <?= number_format($teacher['gaji_pokok'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= ($teacher['tunjangan_jabatan'] > 0) ? 'Rp ' . number_format($teacher['tunjangan_jabatan'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['tunjangan_walas'] > 0) ? 'Rp ' . number_format($teacher['tunjangan_walas'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['tunjangan_masa_kerja'] > 0) ? 'Rp ' . number_format($teacher['tunjangan_masa_kerja'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['kesejahteraan'] > 0) ? 'Rp ' . number_format($teacher['kesejahteraan'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['transport_kehadiran'] > 0) ? 'Rp ' . number_format($teacher['transport_kehadiran'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['kinerja'] > 0) ? 'Rp ' . number_format($teacher['kinerja'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['rapat_dll'] > 0) ? 'Rp ' . number_format($teacher['rapat_dll'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= ($teacher['tahfidz'] > 0) ? 'Rp ' . number_format($teacher['tahfidz'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="12" class="text-center">JUMLAH KESELURUHAN</td>
                <td class="text-right">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <div class="sig-block">
            <div>KEPALA SEKOLAH</div>
            <div class="sig-name">ERNI ANDAYANI, S.Pd.I</div>
            <div class="sig-nbm">NBM. 1258866</div>
        </div>
        <div class="sig-block">
            <div>BENDAHARA</div>
            <div class="sig-name">RISTIA MAULAH</div>
            <div class="sig-nbm">NBM. 1385921</div>
        </div>
    </div>

</body>
</html>
