<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .container {
            width: 100%;
            max-width: 210mm; /* A4 width */
            margin: 0 auto;
        }
        h3 {
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        @media print {
            @page {
                margin: 10mm;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <!-- Optional Global Header if needed -->
        <!-- <h2 class="text-center">LAPORAN KEUANGAN BULAN <?= strtoupper($monthName) ?> <?= $tahun ?></h2> -->

        <?php 
        $indonesianMonths = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        $bulanIndo = $indonesianMonths[$monthName] ?? $monthName;
        ?>

        <?php foreach ($reportData as $title => $data): ?>
            <div class="section-title"><?= $title ?></div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">TANGGAL</th>
                        <th style="width: 40%;">KETERANGAN</th>
                        <th style="width: 15%;">DEBET</th>
                        <th style="width: 15%;">KREDIT</th>
                        <th style="width: 15%;">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Saldo Awal Row -->
                    <tr>
                        <td class="text-center"> - </td>
                        <td>Saldo bulan <?= $bulanIndo ?> (Awal)</td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp<?= number_format($data['saldo_awal'], 0, ',', '.') ?></td>
                    </tr>
                    
                    <?php 
                    $currentSaldo = $data['saldo_awal'];
                    $totalDebet = 0;
                    $totalKredit = 0;
                    ?>
                    
                    <?php foreach ($data['transactions'] as $row): ?>
                        <?php 
                        $debit = $row['debit'];
                        $kredit = $row['kredit'];
                        $currentSaldo = $currentSaldo + $debit - $kredit; 
                        
                        $totalDebet += $debit;
                        $totalKredit += $kredit;
                        ?>
                        <tr>
                            <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                            <td><?= esc($row['keterangan'] ?? '-') ?></td>
                            <td class="text-right"><?= $debit > 0 ? 'Rp' . number_format($debit, 0, ',', '.') : '-' ?></td>
                            <td class="text-right"><?= $kredit > 0 ? 'Rp' . number_format($kredit, 0, ',', '.') : '-' ?></td>
                            <td class="text-right">Rp<?= number_format($currentSaldo, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <!-- Total Row -->
                    <tr style="font-weight: bold; background-color: #fafafa;">
                        <td colspan="2" class="text-center">TOTAL</td>
                        <td class="text-right">Rp<?= number_format($totalDebet, 0, ',', '.') ?></td>
                        <td class="text-right">Rp<?= number_format($totalKredit, 0, ',', '.') ?></td>
                        <td class="text-right">Rp<?= number_format($currentSaldo, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
</body>
</html>
