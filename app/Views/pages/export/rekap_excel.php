<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rekapitulasi Keuangan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h3>REKAPITULASI LAPORAN KEUANGAN</h3>
    <?php if ($bulan) echo "Bulan: " . $bulan . "<br>"; ?>
    <?php if ($tahun) echo "Tahun: " . $tahun . "<br>"; ?>
    <br>

	<table>
		<thead>
			<tr>
				<th style="background-color: #add8e6; text-align:center;">NO</th>
				<th style="background-color: #add8e6;">KETERANGAN</th>
				<th style="background-color: #add8e6; text-align:right;">PEMASUKAN (DEBET)</th>
				<th style="background-color: #add8e6; text-align:right;">PENGELUARAN (KREDIT)</th>
				<th style="background-color: #add8e6; text-align:right;">SALDO</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;
            foreach ($dataList as $row): ?>
				<tr>
					<td style="text-align:center;"><?= $no++ ?></td>
					<td><?= ($row['keterangan']) ?></td>
					<td style="text-align:right;">Rp. <?= number_format($row['debit'], 0, ',', '.') ?></td>
					<td style="text-align:right;">Rp. <?= number_format($row['kredit'], 0, ',', '.') ?></td>
					<td style="text-align:right;">Rp. <?= number_format($row['saldo'], 0, ',', '.') ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" style="text-align:center; font-weight:bold; background-color: #e6e6e6;">TOTAL</td>
				<td style="text-align:right; font-weight:bold; background-color: #e6e6e6;">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
				<td style="text-align:right; font-weight:bold; background-color: #e6e6e6;">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
				<td style="text-align:right; font-weight:bold; background-color: #e6e6e6;">Rp. <?= number_format($totalSaldo, 0, ',', '.') ?></td>
			</tr>
		</tfoot>
	</table>
    
    <br>
    <div style="font-size: 10px; color: #555;">
        Dicetak pada: <?= date('d-m-Y H:i:s') ?>
    </div>
</body>
</html>
