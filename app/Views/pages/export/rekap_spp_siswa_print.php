<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap SPP Peserta Didik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .class-code {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            vertical-align: middle;
        }
        .name-col {
            text-align: left;
            width: 200px;
        }
        .no-col {
            width: 30px;
        }
        
        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

<div class="header">
    REKAP SPP PESERTA DIDIK<br>
    KB - TK AISYIYAH VI CANDI<br>
    TAHUN <?= $tahun ?>-<?= $tahun + 1 ?>
</div>

<div class="class-code"><?= esc($kelas) ?></div>

<table>
    <thead>
        <tr>
            <th rowspan="2" class="no-col">No</th>
            <th rowspan="2" class="name-col">Nama Peserta Didik</th>
            <th colspan="12">Bulan Pembayaran</th>
        </tr>
        <tr>
            <?php foreach ($months as $m => $name): ?>
                <th><?= substr($name, 0, 3) ?></th> <!-- Short Month Name -->
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($matrix as $name => $monthsData): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td class="name-col"><?= esc($name) ?></td>
            <?php foreach ($months as $m => $name): ?>
                <td><?= $monthsData[$m] ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        
        <?php if (empty($matrix)): ?>
        <tr>
            <td colspan="14">Tidak ada data siswa di kelas ini.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    window.print();
</script>

</body>
</html>
