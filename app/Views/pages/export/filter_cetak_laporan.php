<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Cetak Laporan Keuangan</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-6 offset-md-3">
        <div class="card shadow">
            <div class="card-header">
                <h5>Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form action="/laporan/cetak" method="get" target="_blank">
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Pilih Bulan</label>
                        <select name="bulan" id="bulan" class="form-control" required>
                            <?php
                            $months = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                            $currentMonth = date('m');
                            foreach ($months as $key => $val) {
                                $selected = $key == $currentMonth ? 'selected' : '';
                                echo "<option value='$key' $selected>$val</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-control" required>
                            <?php
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-printer"></i> Cetak Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
