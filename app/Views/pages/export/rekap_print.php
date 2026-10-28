<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            position: relative;
        }
        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }
        .header-text {
            text-align: center;
            width: 100%;
        }
        .header-text h3, .header-text h4 {
            margin: 5px 0;
            text-transform: uppercase;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        th {
            background-color: #f0f0f0; /* Match image grey header if needed, else white */
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-block {
            text-align: center;
            width: 30%;
        }
        .sig-name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .sig-nbm {
            font-size: 11px;
        }
        .center-sig {
            margin-top: 40px;
            text-align: center;
            page-break-inside: avoid;
        }
        .center-sig .sig-name {
            margin-top: 60px;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                -webkit-print-color-adjust: exact;
            }
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
        $namaBulan = $bulanNames[$bulan] ?? '';
        
        // Periode calculation
        $periode = ($tahun) ? $tahun . "-" . ($tahun + 1) : '-';
        
        // Report Date (End of Month)
        $reportDate = "";
        if ($tahun && $bulan) {
            // Check validity
            $time = strtotime("$tahun-$bulan-01");
            if ($time !== false) {
               $lastDay = date("t", $time);
               $reportDate = "$lastDay/$bulan/$tahun";
            }
        }
    ?>

    <div class="header">
        <!-- Adjust path to your logo -->
        <img src="<?= base_url('images/logo_aisyiyah.png') ?>" class="logo" alt="Logo">
        <div class="header-text">
            <h4>LAPORAN KEUANGAN BULAN <?= $namaBulan ?></h4>
            <h3>KB-TK AISYIYAH 6 CANDI DURUNG BEDUG</h3>
            <h4>PERIODE <?= $periode ?></h4>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">TANGGAL</th>
                <th>KETERANGAN</th>
                <th width="18%">DEBET</th>
                <th width="18%">KREDIT</th>
                <th width="18%">SALDO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                // Only show date on the first row
                $firstRow = true;
                foreach ($dataList as $row): 
            ?>
                <tr>
                    <td class="text-center">
                        <?php 
                            if ($firstRow) {
                                echo $reportDate;
                                $firstRow = false; // Only show once as per image style
                            }
                        ?>
                    </td>
                    <td class="text-left"><?= ($row['keterangan']) ?></td>
                    <td class="text-right">
                        <?= ($row['debit'] != 0) ? 'Rp' . number_format($row['debit'], 0, ',', '.') : '' ?>
                    </td>
                    <td class="text-right">
                        <?= ($row['kredit'] != 0) ? 'Rp' . number_format($row['kredit'], 0, ',', '.') : '' ?>
                    </td>
                    <!-- Saldo usually shown only at the bottom in the image, or running balance? 
                         The image has empty saldo cells except footer. Let's check user intent.
                         Image shows Saldo column EMPTY for rows, and TOTAL at bottom.
                         I will leave it empty for rows to match "seperti ini" exactly. -->
                    <td class="text-right"></td> 
                </tr>
            <?php endforeach ?>
            
            <!-- Fill empty rows to make it look full if needed? No, just data. -->
            
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="2"></td> <!-- Empty Tanggal/Ket for footer alignment? 
                                           Image has total row spanning? 
                                           Image: Total row has empty Tanggal/Ket/Debet/Kredit cells? 
                                           Actually image bottom row:
                                           [Empty] | [Empty] | Rp24.790.000 | Rp1.074.000 | Rp23.716.000
                                           Wait, the footer row aligns with columns. 
                                           Let's match that.
                                       -->
                
                <td class="text-right">Rp<?= number_format($totalDebit, 0, ',', '.') ?></td>
                <td class="text-right">Rp<?= number_format($totalKredit, 0, ',', '.') ?></td>
                <td class="text-right">Rp<?= number_format($totalSaldo, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
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

    <div class="center-sig">
        <div>PIMPINAN RANTING AISYIYAH</div>
        <div class="sig-name">DZULIANI QOYYUM W, S.Pd</div>
        <div class="sig-nbm">NBM. 1258857</div>
    </div>

</body>
</html>
