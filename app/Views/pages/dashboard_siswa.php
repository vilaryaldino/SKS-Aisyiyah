<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    /* Enhanced Gradients */
    .bg-gradient-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success-custom {
        background: linear-gradient(135deg, #2af598 0%, #009efd 100%);
    }
    .bg-gradient-warning-custom {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%); /* Lighter finish */
        background: linear-gradient(135deg, #fce38a 0%, #f38181 100%);
    }
    /* Override warning for better contrast */
    .bg-gradient-warning-custom {
        background: linear-gradient(135deg, #FF8008 0%, #FFC837 100%);
    }
    
    .card-icon-bg {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-size: 1.8rem;
    }
    
    /* Typography Enhancements */
    .amount-text {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .card-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }
    
    .welcome-text {
        font-family: 'Nunito', sans-serif;
        color: #2d3748;
    }
    .table-modern thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e2e8f0;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .table-modern td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .notif-item {
        transition: background-color 0.2s;
        border-left: 4px solid transparent;
    }
    .notif-item.unread {
        background-color: #f8faff;
        border-left-color: #4e54c8;
    }
    .notif-item:hover {
        background-color: #f1f5f9;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-4 pt-4">

    <!-- Notification Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card dashboard-card bg-white">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold welcome-text"><i class="fas fa-bell text-warning me-2"></i>Notifikasi Terbaru</h5>
                    <?php if (isset($unreadCount) && $unreadCount > 0) : ?>
                        <span class="badge rounded-pill bg-danger shadow-sm px-3 py-2">
                            <?= $unreadCount ?> Pesan Baru
                        </span>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($notifications)) : ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($notifications as $notif) : ?>
                                <div class="list-group-item border-0 border-bottom px-4 py-3 notif-item <?= $notif['status'] == 'unread' ? 'unread' : '' ?>" id="notif-<?= $notif['id'] ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold text-dark"><?= esc($notif['judul']) ?></h6>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i><?= date('d M, H:i', strtotime($notif['created_at'])) ?></small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-2 text-secondary small flex-grow-1" style="line-height: 1.5;"><?= esc($notif['pesan']) ?></p>
                                        <button class="btn btn-sm btn-link text-danger text-decoration-none p-0 ms-3 delete-notif-btn" data-id="<?= $notif['id'] ?>" title="Hapus Notifikasi">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <?php if ($notif['status'] == 'unread') : ?>
                                        <button class="btn btn-sm btn-link text-decoration-none p-0 fw-bold mark-read-btn text-primary" data-id="<?= $notif['id'] ?>">
                                            <i class="fas fa-check-double me-1"></i> Tandai Dibaca
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="p-5 text-center text-muted">
                            <img src="https://img.icons8.com/color/96/000000/nothing-found.png" alt="Empty" width="64" class="mb-3 opacity-50">
                            <p class="mb-0">Tidak ada notifikasi saat ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="card dashboard-card bg-gradient-primary-custom h-100 text-white">
                <div class="card-body p-4 position-relative">
                     <!-- Decorative circle -->
                     <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="position-relative z-1">
                            <p class="card-label">Total Tagihan</p>
                            <h2 class="amount-text mb-2">Rp <?= number_format($totalTagihan ?? 0, 0, ',', '.') ?></h2>
                            <small class="text-light-50"><i class="fas fa-calendar-alt me-1"></i> Tahun Ajaran <?= date('Y') ?></small>
                        </div>
                        <div class="card-icon-bg position-relative z-1 ms-3">
                            <i class="fas fa-file-invoice-dollar text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card bg-gradient-success-custom h-100 text-white">
                <div class="card-body p-4 position-relative">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="position-relative z-1">
                            <p class="card-label">Sudah Terbayar</p>
                            <h2 class="amount-text mb-2">Rp <?= number_format($totalTerbayar ?? 0, 0, ',', '.') ?></h2>
                            <small class="text-light-50"><i class="fas fa-check-circle me-1"></i> Terverifikasi</small>
                        </div>
                        <div class="card-icon-bg position-relative z-1 ms-3">
                            <i class="fas fa-wallet text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card bg-gradient-warning-custom h-100 text-white">
                <div class="card-body p-4 position-relative">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="position-relative z-1">
                            <p class="card-label">Sisa Tagihan</p>
                            <h2 class="amount-text mb-2">Rp <?= number_format($sisaTagihan ?? 0, 0, ',', '.') ?></h2>
                            <small class="text-light-50 fw-bold"><i class="fas fa-exclamation-circle me-1"></i> Segera Lunasi</small>
                        </div>
                        <div class="card-icon-bg position-relative z-1 ms-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Chart Section -->
        <div class="col-lg-8">
            <div class="card dashboard-card bg-white h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="m-0 fw-bold welcome-text text-primary">
                        <i class="fas fa-chart-line me-2"></i>Statistik Pembayaran
                    </h5>
                    <small class="text-muted">Grafik pembayaran bulanan tahun <?= date('Y') ?></small>
                </div>
                <div class="card-body px-4 pb-4">
                    <div id="chart-payment-graph"></div>
                </div>
            </div>
        </div>

        <!-- Recent Payment History Section -->
        <div class="col-lg-4">
            <div class="card dashboard-card bg-white h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold welcome-text text-primary">
                        <i class="fas fa-history me-2"></i>Riwayat
                    </h5>
                    <a href="<?= base_url('/siswa/keuangan') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($historyPembayaran)) : ?>
                        <div class="table-responsive">
                            <table class="table table-modern mb-0 w-100">
                                <thead style="display: none;">
                                    <tr>
                                        <th>Detail</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historyPembayaran as $hist) : ?>
                                        <tr class="border-bottom-0">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-receipt text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;"><?= esc($hist['jenis']) ?></h6>
                                                        <small class="text-muted" style="font-size: 0.75rem;">
                                                            <?= date('d M Y, H:i', strtotime($hist['tanggal'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                <h6 class="mb-0 fw-bold text-success">+Rp <?= number_format($hist['jumlah'], 0, ',', '.') ?></h6>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="h-100 d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-wallet fa-3x mb-3 text-light"></i>
                            <span class="text-center small">Belum ada data transaksi.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark Read Logic
        document.querySelectorAll('.mark-read-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const btn = this;
                const item = document.getElementById(`notif-${id}`);
                
                // Optimistic UI update
                item.classList.remove('unread');
                item.style.opacity = '0.5';
                
                fetch(`/siswa/notifikasi/read/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        item.remove(); // Remove from list or keep as read
                        // location.reload(); // Optional: Reload to update counters
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    item.style.opacity = '1'; // Revert on error
                });
            });
        });

        // Delete Notification Logic
        document.querySelectorAll('.delete-notif-btn').forEach(button => {
            button.addEventListener('click', function() {
                if(!confirm('Hapus notifikasi ini?')) return;

                const id = this.getAttribute('data-id');
                const item = document.getElementById(`notif-${id}`);

                item.style.opacity = '0.3';

                fetch(`/siswa/notifikasi/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        item.remove();
                        // Check if list is empty and show empty state if needed
                        if(document.querySelectorAll('.notif-item').length === 0) {
                            location.reload(); 
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    item.style.opacity = '1';
                });
            });
        });

        // Chart Logic
        var options = {
            series: [{
                name: 'Pembayaran',
                data: <?= json_encode($chartData['data']) ?>
            }],
            chart: {
                height: 320,
                type: 'area', // Changed to Area for more premium look
                fontFamily: 'Nunito, sans-serif',
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            colors: ['#4e54c8'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: <?= json_encode($chartData['labels']) ?>,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#a0aec0', fontSize: '12px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#a0aec0', fontSize: '12px' },
                    formatter: function(val) {
                        if (val >= 1000000) return (val / 1000000).toFixed(1) + " Jt";
                        if (val >= 1000) return (val / 1000).toFixed(0) + " Rb";
                        return val;
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function(val) {
                        return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-payment-graph"), options);
        chart.render();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?= $this->endSection() ?>
