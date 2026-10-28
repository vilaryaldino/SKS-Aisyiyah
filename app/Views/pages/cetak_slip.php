<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - <?= esc($teacher['nama']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2, .header h3 {
            margin: 5px 0;
        }
        .details {
            width: 100%;
            margin-bottom: 20px;
        }
        .details td {
            padding: 5px;
            vertical-align: top;
        }
        .table-gaji {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-gaji th, .table-gaji td {
            border: 1px solid #000;
            padding: 8px;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            text-align: center;
            width: 200px;
        }
        .signature p {
            margin-top: 60px;
            font-weight: bold;
            border-top: 1px solid #000;
        }
        @media print {
            body { 
                margin: 0; 
                padding: 0;
            }
            .container {
                border: none;
                width: 100%;
                max-width: none;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="btn-print" onclick="window.print()" style="margin-bottom: 20px; padding: 10px; cursor: pointer;">Print Valid</button>
        
        <div class="header">
            <h2>SKS AISYIYAH</h2>
            <h3>SLIP GAJI GURU</h3>
            <p>Periode: <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?></p>
        </div>

        <table class="details">
            <tr>
                <td width="15%"><strong>Nama</strong></td>
                <td width="2%">:</td>
                <td width="33%"><?= esc($teacher['nama']) ?></td>
                <td width="15%"><strong>Jabatan</strong></td>
                <td width="2%">:</td>
                <td width="33%"><?= esc($teacher['jabatan']) ?></td>
            </tr>
            <tr>
                <td><strong>NIP</strong></td>
                <td>:</td>
                <td><?= esc($teacher['nip']) ?></td>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?= $tanggal_cetak ?></td>
            </tr>
        </table>

        <table class="table-gaji">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: #f0f0f0;">PENERIMAAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gaji Pokok</td>
                    <td class="text-right">Rp <?= number_format($gaji_pokok, 0, ',', '.') ?></td>
                </tr>
                <?php if (!empty($tunjangan_jabatan)) : ?>
                <tr>
                    <td>Tunjangan Jabatan</td>
                    <td class="text-right">Rp <?= number_format($tunjangan_jabatan, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($tunjangan_walas)) : ?>
                <tr>
                    <td>Tunjangan Walas</td>
                    <td class="text-right">Rp <?= number_format($tunjangan_walas, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($tunjangan_masa_kerja)) : ?>
                <tr>
                    <td>Tunjangan Masa Kerja</td>
                    <td class="text-right">Rp <?= number_format($tunjangan_masa_kerja, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($kesejahteraan)) : ?>
                <tr>
                    <td>Kesejahteraan</td>
                    <td class="text-right">Rp <?= number_format($kesejahteraan, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($transport_kehadiran)) : ?>
                <tr>
                    <td>Transport Kehadiran</td>
                    <td class="text-right">Rp <?= number_format($transport_kehadiran, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($kinerja)) : ?>
                <tr>
                    <td>Kinerja</td>
                    <td class="text-right">Rp <?= number_format($kinerja, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($rapat_dll)) : ?>
                <tr>
                    <td>Rapat & dll</td>
                    <td class="text-right">Rp <?= number_format($rapat_dll, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($tahfidz)) : ?>
                <tr>
                    <td>Tahfidz</td>
                    <td class="text-right">Rp <?= number_format($tahfidz, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>
                <!--
                <tr>
                    <td>Tunjangan Lainnya</td>
                    <td class="text-right">Rp <?= number_format($tunjangan, 0, ',', '.') ?></td>
                </tr>
                -->
                <!-- Tambahkan item lain jika ada -->
                
                <tr>
                    <td><strong>Total Penerimaan (Kotor)</strong></td>
                    <td class="text-right"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>

        <table class="table-gaji">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: #f0f0f0;">POTONGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Potongan Lain-lain</td>
                    <td class="text-right">Rp <?= number_format($potongan, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td><strong>Total Potongan</strong></td>
                    <td class="text-right"><strong>Rp <?= number_format($potongan, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div style="border: 2px solid #000; padding: 10px; margin-bottom: 20px;">
            <table width="100%">
                <tr>
                    <td class="text-right" style="font-size: 16px;"><strong>TOTAL GAJI BERSIH : &nbsp; Rp <?= number_format($total - $potongan, 0, ',', '.') ?></strong></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="signature">
                <br>
                Penerima,
                <p><?= esc($teacher['nama']) ?></p>
            </div>
            <div class="signature">
                Mengetahui,<br>
                Kepala Sekolah
                <p>( ................................. )</p>
            </div>
        </div>
    </div>
</body>
</html>
