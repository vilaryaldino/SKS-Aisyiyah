<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start; /* Align left */
            gap: 10px; /* Space between tables */
        }
        .class-table-container {
            border: 1px solid #000;
            width: 200px; /* Fixed width per class column like in the image */
        }
        .class-header {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #000;
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 3px 5px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
            text-align: center;
            border-bottom: 1px solid #000;
        }
        /* Remove internal borders to mimic the image style (columns only) if desired, 
           but image shows grid lines. Let's keep typical grid lines for clarity. 
           Actually, image shows clear outer border and internal lines. */
        
        .amount {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
            border-top: 2px solid #000;
        }
        
        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

<?php
    $bulanName = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    $displayBulan = isset($bulanName[$bulan]) ? $bulanName[$bulan] : $bulan;
    $title = "REKAP SPP BULAN " . strtoupper($displayBulan) . " " . $tahun;
?>

<h2><?= $title ?></h2>

<div class="container">
    <?php foreach ($groupedData as $kelas => $students) : ?>
    <div class="class-table-container">
        <div class="class-header"><?= esc($kelas) ?></div>
        <!-- Sub-header like image: Nama | Jumlah -->
        <table>
            <thead>
                <tr>
                    <th style="width: 60%">NAMA</th>
                    <th style="width: 40%">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                <tr>
                    <td><?= esc($student['nama']) ?></td>
                    <td class="amount">Rp<?= number_format($student['jumlah'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                
                <!-- Fill empty rows if needed to align heights? Not critical for basic print -->
                
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td class="amount">Rp<?= number_format($totalPerClass[$kelas] ?? 0, 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php endforeach; ?>
</div>

<!-- Grand Total Summary if needed, though image doesn't explicitly show a Grand Total box, usually good to have -->
<div style="margin-top: 20px; font-weight: bold; text-align: right; border-top: 1px dashed black; padding-top:10px;">
    GRAND TOTAL: Rp<?= number_format($grandTotal, 0, ',', '.') ?>
</div>

<script>
    window.print();
</script>

</body>
</html>
