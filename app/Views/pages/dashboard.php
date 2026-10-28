<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <!-- <div class="page-header-title">
                    <h5 class="m-b-10">Home</h5>
                </div> -->
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ sample-page ] start -->
    <!-- [ sample-page ] start -->
    <div class="col-md-6 col-xl-4">
        <div class="card bg-primary text-white order-card">
            <div class="card-body">
                <h6 class="text-white mb-3">Total Siswa</h6>
                <h2 class="text-end text-white"><i class="fas fa-users float-start"></i><span><?= number_format($totalUsers) ?></span></h2>
                <p class="m-b-0">Aktif Tahun Ini <i class="fas fa-arrow-up ms-2"></i></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-4">
        <div class="card bg-success text-white order-card">
            <div class="card-body">
                <h6 class="text-white mb-3">Total Transaksi</h6>
                <h2 class="text-end text-white"><i class="fas fa-file-invoice-dollar float-start"></i><span><?= number_format($totalOrders) ?></span></h2>
                <p class="m-b-0">Data Masuk <i class="fas fa-check ms-2"></i></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card bg-warning text-white order-card">
            <div class="card-body">
                <h6 class="text-white mb-3">Total Piutang (Belum Lunas)</h6>
                <h2 class="text-end text-white"><i class="fas fa-wallet float-start"></i><span>Rp<?= number_format($totalSales, 0, ',', '.') ?></span></h2>
                <p class="m-b-0">Total Tagihan - Total Bayar <i class="fas fa-info-circle ms-2"></i></p>
            </div>
        </div>
    </div>

    <!-- Financial Report Section -->
    <div class="col-md-12">
        <h5 class="mb-3">Laporan Keuangan Sekolah (Laba/Rugi)</h5>
    </div>

    <!-- Shortcut Cetak Laporan -->
    <div class="col-md-12 mb-4">
        <div class="card bg-white shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Cetak Laporan Keuangan</h5>
                    <p class="text-muted mb-0">Cetak laporan lengkap semua kategori (Pendaftaran, SPP, dll)</p>
                </div>
                <a href="/laporan/filter" class="btn btn-danger btn-lg rounded-pill">
                    <i class="fas fa-print me-2"></i> Cetak Laporan Lengkap
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-xl-4">
        <div class="card bg-c-blue order-card" style="background: linear-gradient(45deg, #4099ff, #73b4ff);">
            <div class="card-body">
                <h6 class="text-white mb-3">Total Pendapatan (Uang Masuk)</h6>
                <h2 class="text-end text-white"><i class="fas fa-money-bill-wave float-start"></i><span>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></span></h2>
                <p class="m-b-0 text-white">Dari Pembayaran Siswa</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-4">
        <div class="card bg-c-pink order-card" style="background: linear-gradient(45deg, #FF5370, #ff869a);">
            <div class="card-body">
                <h6 class="text-white mb-3">Total Pengeluaran</h6>
                <h2 class="text-end text-white"><i class="fas fa-file-invoice float-start"></i><span>Rp <?= number_format($totalExpenses, 0, ',', '.') ?></span></h2>
                <p class="m-b-0 text-white">Gaji: <?= number_format($totalGaji, 0, ',', '.') ?> | Ops: <?= number_format($totalOperasional, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-4">
        <div class="card <?= $netIncome >= 0 ? 'bg-c-green' : 'bg-c-red' ?> order-card" style="background: <?= $netIncome >= 0 ? 'linear-gradient(45deg, #2ed8b6, #59e0c5)' : 'linear-gradient(45deg, #FF5370, #ff869a)' ?>;">
            <div class="card-body">
                <h6 class="text-white mb-3">Saldo Bersih (Laba/Rugi)</h6>
                <h2 class="text-end text-white"><i class="fas fa-chart-line float-start"></i><span>Rp <?= number_format($netIncome, 0, ',', '.') ?></span></h2>
                <p class="m-b-0 text-white">Pendapatan - Pengeluaran</p>
            </div>
        </div>
    </div>
    

    <div class="col-md-6 col-xl-6">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Grafik Pemasukan</h5>
            <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-home"
                        type="button" role="tab" aria-controls="chart-tab-home" aria-selected="true">Tahun Ini</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                        aria-selected="false">Minggu Ini</button>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="chart-tab-tabContent">
                    <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab"
                        tabindex="0">
                        <div id="chart-income-year"></div>
                    </div>
                    <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel"
                        aria-labelledby="chart-tab-profile-tab" tabindex="0">
                        <div id="chart-income-week"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-6">
        <h5 class="mb-3">Laporan Pemasukan & Pengeluaran</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Statistik Tahun Ini</h6>
                <h3 class="mb-0">Rp <?= number_format($netIncome, 0, ',', '.') ?></h3>
                <div id="chart-sales-report"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-8">
        <h5 class="mb-3">Recent Orders</h5>
        <div class="card tbl-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>NISN</th>
                                <th>NAMA SISWA</th>
                                <th>BULAN KE -</th>
                                <th class="text-end">TOTAL TAGIHAN</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($keuanganSiswaData as $data): ?>
                                <tr>
                                    <td><a href="#" class="text-muted"><?= $data['nisn'] ?? '' ?></a></td>
                                    <td><?= $data['nama'] ?? '' ?></td>
                                    <td>1</td>
                                    <td class="text-end">Rp.<?= number_format($data['total'] ?? '') ?></td>
                                    <td>
                                        <?php if ($data['status'] === 'Lunas'): ?>
                                            <span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-success f-10 m-r-5"></i><?= $data['status'] ?></span>
                                        <?php elseif ($data['status'] === 'Belum Lunas'): ?>
                                            <span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-danger f-10 m-r-5"></i><?= $data['status'] ?></span>
                                        <?php else: ?>
                                            <span><?= $data['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (session()->getFlashdata('swal_success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Selamat Datang!',
            text: '<?= session()->getFlashdata('swal_success') ?>',
            timer: 2000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>

<!-- Custom Charts Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            // 1. Chart Income Week (Minggu Ini)
            var optionsWeek = {
                chart: {
                    height: 450,
                    type: 'area',
                    toolbar: { show: false }
                },
                dataLabels: { enabled: false },
                colors: ['#1890ff'],
                series: [{
                    name: 'Pemasukan',
                    data: <?= json_encode($incomeOverview['data']) ?>
                }],
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: <?= json_encode($incomeOverview['labels']) ?>,
                }
            };
            var chartWeek = new ApexCharts(document.querySelector('#chart-income-week'), optionsWeek);
            chartWeek.render();

            // 2. Chart Income Year (Tahun Ini)
            var optionsYear = {
                chart: {
                    height: 450,
                    type: 'area',
                    toolbar: { show: false }
                },
                dataLabels: { enabled: false },
                colors: ['#13c2c2'],
                series: [{
                    name: 'Pemasukan',
                    data: <?= json_encode($salesReport['income']) ?>
                }],
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: <?= json_encode($salesReport['labels']) ?>,
                }
            };
            var chartYear = new ApexCharts(document.querySelector('#chart-income-year'), optionsYear);
            chartYear.render();

            // 3. Sales Report (Income vs Expense)
            var optionsSales = {
                chart: {
                    type: 'bar',
                    height: 430,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: { columnWidth: '45%', borderRadius: 4 }
                },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                dataLabels: { enabled: false },
                colors: ['#faad14', '#1890ff'],
                series: [{
                    name: 'Pengeluaran',
                    data: <?= json_encode($salesReport['expense']) ?>
                }, {
                    name: 'Pemasukan',
                    data: <?= json_encode($salesReport['income']) ?>
                }],
                xaxis: {
                    categories: <?= json_encode($salesReport['labels']) ?>
                },
                legend: { position: 'top' }
            }
            var chartSales = new ApexCharts(document.querySelector('#chart-sales-report'), optionsSales);
            chartSales.render();
            
        }, 700); // Wait for default scripts if any (though we renamed IDs so no conflict)
    });
</script>
<?= $this->endSection() ?>
