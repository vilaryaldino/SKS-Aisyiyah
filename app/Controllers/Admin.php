<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\PendaftaranModel;
use App\Models\UisUimModel;
use App\Models\PeralatanModel;
use App\Models\LksModel;
use App\Models\SeragamModel;
use App\Models\KegiatanModel;
use App\Models\SppModel;
use App\Models\DppModel;
use App\Models\TeacherModel;
use App\Models\PayrollModel;
use App\Models\Laporan\LaporanPendaftaranModel;
use App\Models\Laporan\LaporanUisUimModel;
use App\Models\Laporan\LaporanPeralatanModel;
use App\Models\Laporan\LaporanLksModel;
use App\Models\Laporan\LaporanSeragamTasModel;
use App\Models\Laporan\LaporanKegiatanModel;
use App\Models\Laporan\LaporanSppModel;
use App\Models\Laporan\LaporanDppModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Admin extends BaseController
{
    protected $pendaftaranModel;
    protected $siswaModel;
    protected $uisUimModel;
    protected $peralatanModel;
    protected $lksModel;
    protected $seragamModel;
    protected $kegiatanModel;
    protected $sppModel;
    protected $dppModel;
    protected $teacherModel;
    protected $payrollModel;
    protected $notificationModel;
    protected $operationalModel;

    // Laporan Models
    protected $laporanPendaftaranModel;
    protected $laporanUisUimModel;
    protected $laporanPeralatanModel;
    protected $laporanLksModel;
    protected $laporanSeragamTasModel;
    protected $laporanKegiatanModel;
    protected $laporanSppModel;
    protected $laporanDppModel;

    public function __construct()
    {
        $this->pendaftaranModel = new PendaftaranModel();
        $this->siswaModel = new SiswaModel();
        $this->uisUimModel = new UisUimModel();
        $this->peralatanModel = new PeralatanModel();
        $this->seragamModel = new SeragamModel();
        $this->lksModel = new LksModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->sppModel = new SppModel();
        $this->dppModel = new DppModel();
        $this->teacherModel = new TeacherModel();
        $this->payrollModel = new PayrollModel();
        $this->notificationModel = new \App\Models\NotificationModel();
        $this->operationalModel = new \App\Models\OperationalModel();

        // Init Laporan Models
        $this->laporanPendaftaranModel = new LaporanPendaftaranModel();
        $this->laporanUisUimModel = new LaporanUisUimModel();
        $this->laporanPeralatanModel = new LaporanPeralatanModel();
        $this->laporanLksModel = new LaporanLksModel();
        $this->laporanSeragamTasModel = new LaporanSeragamTasModel();
        $this->laporanKegiatanModel = new LaporanKegiatanModel();
        $this->laporanSppModel = new LaporanSppModel();
        $this->laporanDppModel = new LaporanDppModel();
    }

    public function main()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('pages/akun/login');
    }
    public function auth_login()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // 1. Cek tabel Admin
        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->where('username', $login)->first();

        if ($admin) {
            $passwordValid = false;
            
            // Cek Hash (Standard)
            if (password_verify($password, $admin['password'])) {
                $passwordValid = true;
            } 
            // Fallback: Cek Plain Text (Legacy/Migration)
            elseif ($password === $admin['password']) {
                $passwordValid = true;
                // Auto-update ke hash agar lebih aman kedepannya
                $adminModel->update($admin['id'], [
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);
            }

            if ($passwordValid) {
                $sessionData = [
                    'is_logged_in' => true,
                    'username' => $admin['username'],
                    'nama' => $admin['nama'],
                    'role' => 'admin'
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard')->with('swal_success', 'Login Berhasil sebagai Admin!');
            }
        }

        // 2. Cek tabel Siswa
        $user = $this->siswaModel->where('nisn', $login)
            ->first();

        if ($user) {
        // Updated: Password check uses NISN directly (Input Password must equal NISN)
        if ($password === $user['nisn']) {
            $sessionData = [
                'is_logged_in' => true,
                'nisn' => $user['nisn'],
                'username' => $user['nisn'],
                'nama' => $user['nama'],
                'nik' => $user['nik'], // Add nik to session
                'role' => 'siswa' // Default role for entries in data_siswa
            ];
            session()->set($sessionData);
            return redirect()->to('/dashboard-siswa')->with('swal_success', 'Login Berhasil!');
        }
    }

        return redirect()->to('/')
                ->with('swal_error', 'Username atau Password salah.')
                ->withInput(); // Return input so user doesn't have to retype everything
    }

    // Public registration removed as per request
    // public function register() { ... }
    // public function auth_register() { ... }

    public function rincian_keuangan_siswa()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/');
        }
        
        $namaSiswa = session()->get('nama');
        $nisn = session()->get('nisn');
        // $nik = session()->get('nik'); // Might not be in session, but we can query if needed. 
        // For now, let's just use what we have or query the student again to be sure.
        $siswa = $this->siswaModel->where('username', session()->get('username'))->first();
        $nik = $siswa['nik'] ?? '-';
        $no_wa = $siswa['no_whatsapp'] ?? '-';

        // Helper function (same as in keuangan_siswa but for single user)
        $sumModel = function ($model) use ($namaSiswa) {
            $m = new $model();
            $result = $m->selectSum('debit')->selectSum('kredit')->where('nama_siswa', $namaSiswa)->first();
            $debit = $result['debit'] ?? 0;
            $kredit = $result['kredit'] ?? 0;
            return $kredit - $debit;
        };

        $pendaftaran = $sumModel(\App\Models\PendaftaranModel::class);
        $uis_uim = $sumModel(\App\Models\UisUimModel::class);
        $peralatan = $sumModel(\App\Models\PeralatanModel::class);
        $lks = $sumModel(\App\Models\LksModel::class);
        $seragam_tas = $sumModel(\App\Models\SeragamModel::class);
        $kegiatan = $sumModel(\App\Models\KegiatanModel::class);
        $spp = $sumModel(\App\Models\SppModel::class);
        $dpp = $sumModel(\App\Models\DppModel::class);

        $total = $pendaftaran + $uis_uim + $peralatan + $lks + $seragam_tas + $kegiatan + $spp + $dpp;

        if ($total == 0) {
            $status = 'Tidak Ada Tagihan';
        } elseif ($total < 0) {
            $status = 'Belum Lunas';
        } else {
            $status = 'Lunas';
        }

        $dataSiswa = [
            'nama' => $namaSiswa,
            'nik' => $nik,
            'no_whatsapp' => $no_wa,
            'pendaftaran' => $pendaftaran,
            'uis_uim' => $uis_uim,
            'peralatan' => $peralatan,
            'lks' => $lks,
            'seragam_tas' => $seragam_tas,
            'kegiatan' => $kegiatan,
            'spp' => $spp,
            'dpp' => $dpp,
            'total' => $total,
            'status' => $status,
        ];

        return view('pages/rincian_keuangan_siswa', ['data' => $dataSiswa]);
    }

    public function dashboard_siswa()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/');
        }

        $namaSiswa = session()->get('nama');
        $nisn = session()->get('nisn');
        $year = date('Y');

        // Fetch Notifications
        $notifications = $this->notificationModel->where('nis', $nisn)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->limit(5)
                                                 ->findAll();
        
        $unreadCount = $this->notificationModel->where('nis', $nisn)
                                               ->where('status', 'unread')
                                               ->countAllResults();

        // Define models with friendly names
        $models = [
            'Pendaftaran'   => $this->pendaftaranModel,
            'UIS / UIM'     => $this->uisUimModel,
            'Peralatan'     => $this->peralatanModel,
            'LKS'           => $this->lksModel,
            'Seragam'       => $this->seragamModel,
            'Kegiatan'      => $this->kegiatanModel,
            'SPP'           => $this->sppModel,
            'DPP'           => $this->dppModel,
        ];

        // Init monthly data for chart (Payments/Kredit)
        $monthlyData = array_fill(1, 12, 0);
        
        // Init totals
        $totalTagihan = 0;
        $totalTerbayar = 0;
        
        // Init History
        $historyPembayaran = [];

        foreach ($models as $jenis => $model) {
            // 1. Calculate Totals (Debit = Bill, Kredit = Payment)
            $sum = $model->selectSum('debit')->selectSum('kredit')
                         ->where('nama_siswa', $namaSiswa)
                         ->first();
            
            $totalTagihan  += ($sum['kredit'] ?? 0);
            $totalTerbayar += ($sum['debit'] ?? 0);

            // 2. Chart Data: Payments per month (Kredit)
            // Switching from 'debit' to 'kredit' because the chart title is "Pembayaran" (Payment)
            $queryChart = $model->select("MONTH(tanggal) as month, SUM(debit) as total")
                ->where('nama_siswa', $namaSiswa)
                ->where("YEAR(tanggal)", $year)
                ->groupBy("MONTH(tanggal)")
                ->findAll();

            foreach ($queryChart as $row) {
                $monthlyData[(int)$row['month']] += (float)$row['total'];
            }
            
            // 3. Payment History: Fetch records with Kredit > 0
            // We select tanggal, kredit, and keterangan (if needed, though schema check failed earlier, usually standard fields match)
            // Assuming 'keterangan' exists in some models or we just use defaults. 
            // Safe bet: select * or just relevant fields.
            $history = $model->where('nama_siswa', $namaSiswa)
                             ->where('debit >', 0)
                             ->orderBy('tanggal', 'DESC')
                             ->limit(5) // Limit per model, we will sort and slice later
                             ->findAll();
                             
            foreach($history as $h) {
                $historyPembayaran[] = [
                    'tanggal' => $h['tanggal'],
                    'jenis'   => $jenis,
                    'jumlah'  => $h['debit'],
                    'ket'     => $h['keterangan'] ?? '-' // Use null coalesce if column missing implies logic handle it or it's implicitly there
                ];
            }
        }
        
        // Sort history by date descending
        usort($historyPembayaran, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        
        // Take top 10 recent payments
        $historyPembayaran = array_slice($historyPembayaran, 0, 10);

        $sisaTagihan = $totalTagihan - $totalTerbayar;

        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => array_values($monthlyData)
        ];

        return view('pages/dashboard_siswa', [
            'chartData'         => $chartData,
            'notifications'     => $notifications, 
            'unreadCount'       => $unreadCount,
            'totalTagihan'      => $totalTagihan,
            'totalTerbayar'     => $totalTerbayar,
            'sisaTagihan'       => $sisaTagihan,
            'historyPembayaran' => $historyPembayaran
        ]);
    }

    public function kirim_notifikasi()
    {
        $nisn = $this->request->getPost('nisn');
        $judul = $this->request->getPost('judul');
        $pesan = $this->request->getPost('pesan');



        // Note: We need to find the NIS based on the row clicked. 
        // The View 'keuangan_siswa' loops by NAME, not ID/NIS. 
        // We will need to update keuangan_siswa to pass the NIS.
        // For now, let's assume NIS is passed correctly.


        $data = [
            'nis' => $nisn,
            'judul' => $judul,
            'pesan' => $pesan,
            'status' => 'unread'
        ];
        
        if (!$this->notificationModel->save($data)) {
             $errors = implode(", ", $this->notificationModel->errors());
             file_put_contents('debug_notif.txt', "Save Failed at " . date('Y-m-d H:i:s') . "\nData: " . print_r($data, true) . "\nErrors: " . $errors . "\n", FILE_APPEND);
             return redirect()->back()->with('swal_error', 'Gagal mengirim notifikasi: ' . $errors);
        } else {
             file_put_contents('debug_notif.txt', "Save Success for NIS: $nis at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        }

        return redirect()->back()->with('swal_success', 'Notifikasi berhasil dikirim!');
    }

    public function mark_notification_read($id)
    {
        $this->notificationModel->update($id, ['status' => 'read']);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete_notification($id)
    {
        $this->notificationModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function get_notifications_json()
    {
        if (!session()->get('is_logged_in') || session()->get('role') == 'admin') {
             return $this->response->setJSON([]);
        }

        $nisn = session()->get('nisn');
        $notifications = $this->notificationModel->where('nis', $nisn)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->limit(5)
                                                 ->findAll();
        
        $unreadCount = $this->notificationModel->where('nis', $nisn)
                                               ->where('status', 'unread')
                                               ->countAllResults();

        return $this->response->setJSON([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    // Dashboard
    public function dashboard(): string
    {
        // Ambil total pengguna (jumlah siswa)
        $totalUsers = $this->siswaModel->countAllResults();

        // Ambil total order (jumlah transaksi di semua model keuangan)
        $totalOrders = 0;
        $totalSales = 0;

        $models = [
            $this->pendaftaranModel,
            $this->uisUimModel,
            $this->peralatanModel,
            $this->lksModel,
            $this->seragamModel,
            $this->kegiatanModel,
            $this->sppModel,
            $this->dppModel,
        ];

        // Initialize totals
        $totalRevenue = 0; // Uang Masuk (Kredit)
        $totalReceivable = 0; // Piutang (Debit - Kredit)
        $totalOrders = 0;

        foreach ($models as $model) {
            $count = $model->countAllResults();
            $totalOrders += $count;

            $sum = $model->selectSum('debit')->selectSum('kredit')->first();
            $debit = $sum['debit'] ?? 0;
            $kredit = $sum['kredit'] ?? 0;
            
            // Revenue = Total Uang Masuk (Debit)
            $totalRevenue += $debit;
            
            // Receivable = Total Tagihan (Kredit) - Total Bayar (Debit)
            $totalReceivable += ($kredit - $debit);
        }
        
        // Expense 1: Gaji Guru
        $payrollSum = $this->payrollModel->selectSum('total_gaji')->first();
        $totalGaji = isset($payrollSum['total_gaji']) ? $payrollSum['total_gaji'] : 0;

        // Expense 2: Operasional
        $opsSum = $this->operationalModel->selectSum('jumlah')->first();
        $totalOperasional = isset($opsSum['jumlah']) ? $opsSum['jumlah'] : 0;

        $totalExpenses = $totalGaji + $totalOperasional;
        $netIncome = $totalRevenue - $totalExpenses;

        $year = date('Y');

        // Helper to get income/expense for a specific range
        $getChartData = function($groupBy) use ($models, $year) {
            $incomeData = [];
            $expenseData = [];
            
            // Initialize arrays based on group by
            if ($groupBy === 'month') {
                 // 1-12
            } else { // week
                 // 0 (Mon) - 6 (Sun)
            }

            foreach ($models as $model) {
                $builder = $model->builder();
                if ($groupBy === 'month') {
                    $query = $builder->select("MONTH(tanggal) as label, SUM(debit) as income, SUM(kredit) as expense")
                        ->where("YEAR(tanggal)", $year)
                        ->groupBy("MONTH(tanggal)")
                        ->get()
                        ->getResultArray();
                } else { // Day of week (Mon-Sun)
                    // Get data for current week
                    $monday = date('Y-m-d', strtotime('monday this week'));
                    $sunday = date('Y-m-d', strtotime('sunday this week'));
                    
                    // WEEKDAY returns 0 for Monday, 6 for Sunday
                    $query = $builder->select("WEEKDAY(tanggal) as label, SUM(debit) as income, SUM(kredit) as expense")
                        ->where("tanggal >=", $monday)
                        ->where("tanggal <=", $sunday)
                        ->groupBy("WEEKDAY(tanggal)")
                        ->get()
                        ->getResultArray();
                }

                foreach ($query as $row) {
                    $key = (int)$row['label'];
                    if (!isset($incomeData[$key])) $incomeData[$key] = 0;
                    if (!isset($expenseData[$key])) $expenseData[$key] = 0;
                    
                    $incomeData[$key] += (float)$row['income'];
                    $expenseData[$key] += (float)$row['expense'];
                }
            }
            return ['income' => $incomeData, 'expense' => $expenseData];
        };

        // 1. Weekly Income (Mon-Sun)
        // Labels (Indonesian)
        $weekLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $weekDataRaw = $getChartData('week');
        $weekIncome = [];
        
        // Loop 0 to 6
        for ($i=0; $i<=6; $i++) {
            $weekIncome[] = $weekDataRaw['income'][$i] ?? 0;
        }

        $incomeOverview = [
            'labels' => $weekLabels,
            'data' => $weekIncome
        ];

        // 2. Monthly Report (Jan-Dec)
        $monthDataRaw = $getChartData('month');
        // Labels (Indonesian Short)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyIncome = [];
        $monthlyExpense = [];
        
        // Loop 1 to 12
        for ($i=1; $i<=12; $i++) {
            $monthlyIncome[] = $monthDataRaw['income'][$i] ?? 0;
            $monthlyExpense[] = $monthDataRaw['expense'][$i] ?? 0;
        }

        $salesReport = [
            'labels' => $months,
            'income' => $monthlyIncome,
            'expense' => $monthlyExpense,
        ];

        // Aggregate keuangan siswa data for recent orders table
        $siswaList = $this->siswaModel->findAll();

        $keuanganSiswaData = [];

        foreach ($siswaList as $siswa) {
        $namaSiswa = $siswa['nama'];
        $nisn = $siswa['nisn'] ?? '';
        $nik = $siswa['nik'] ?? '';
        $no_wa = $siswa['no_whatsapp'] ?? '';

            // Normalisasi nomor WhatsApp: jika diawali 0, ganti dengan 62
            if (substr($no_wa, 0, 1) === '0') {
                $no_wa = '62' . substr($no_wa, 1);
            }

            // Fungsi untuk menjumlahkan debit - kredit dari model berdasarkan nama siswa
            $sumModel = function ($model) use ($namaSiswa) {
                $m = new $model();
                $result = $m->selectSum('debit')->selectSum('kredit')->where('nama_siswa', $namaSiswa)->first();
                $debit = $result['debit'] ?? 0;
                $kredit = $result['kredit'] ?? 0;
                return $debit - $kredit;
            };

            $pendaftaran = $sumModel(\App\Models\PendaftaranModel::class);
            $uis_uim = $sumModel(\App\Models\UisUimModel::class);
            $peralatan = $sumModel(\App\Models\PeralatanModel::class);
            $lks = $sumModel(\App\Models\LksModel::class);
            $seragam_tas = $sumModel(\App\Models\SeragamModel::class);
            $kegiatan = $sumModel(\App\Models\KegiatanModel::class);
            $spp = $sumModel(\App\Models\SppModel::class);
            $dpp = $sumModel(\App\Models\DppModel::class);

            $total = $pendaftaran + $uis_uim + $peralatan + $lks + $seragam_tas + $kegiatan + $spp + $dpp;

            if ($total == 0) {
                $status = 'Tidak Ada Tagihan';
            } elseif ($total < 0) {
                $status = 'Belum Lunas';
            } else {
                $status = 'Lunas';
            }

            $keuanganSiswaData[] = [
            'nisn' => $nisn,
            'nama' => $namaSiswa,
            'nik' => $nik,
            'no_whatsapp' => $no_wa,
            'total' => $total,
            'status' => $status,
        ];
        }

        $data = [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalReceivable,
            'totalRevenue' => $totalRevenue,
            'totalGaji' => $totalGaji,
            'totalOperasional' => $totalOperasional,
            'totalExpenses' => $totalExpenses,
            'netIncome' => $netIncome,
            'incomeOverview' => $incomeOverview,
            'salesReport' => $salesReport,
            'keuanganSiswaData' => $keuanganSiswaData,
        ];

        return view('pages/dashboard', $data);
    }

    // Halaman keuangan
    // Halaman keuangan
    // Halaman Rincian Keuangan (Student View)
    public function siswa_rincian_keuangan()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/');
        }

        $nisn = session()->get('nisn');
        $siswa = $this->siswaModel->where('nisn', $nisn)->first();

        if (!$siswa) {
            return redirect()->to('/dashboard-siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        $namaSiswa = $siswa['nama'];
        $nik = $siswa['nik'];
        
        // Sum Logic
        $sumModel = function ($model) use ($namaSiswa) {
            $m = new $model();
            $result = $m->selectSum('debit')->selectSum('kredit')->where('nama_siswa', $namaSiswa)->first();
            $debit = $result['debit'] ?? 0;
            $kredit = $result['kredit'] ?? 0;
            return $kredit - $debit;
        };

        $pendaftaran = $sumModel(\App\Models\PendaftaranModel::class);
        $uis_uim = $sumModel(\App\Models\UisUimModel::class);
        $peralatan = $sumModel(\App\Models\PeralatanModel::class);
        $lks = $sumModel(\App\Models\LksModel::class);
        $seragam_tas = $sumModel(\App\Models\SeragamModel::class);
        $kegiatan = $sumModel(\App\Models\KegiatanModel::class);
        $spp = $sumModel(\App\Models\SppModel::class);
        $dpp = $sumModel(\App\Models\DppModel::class);

        $total = $pendaftaran + $uis_uim + $peralatan + $lks + $seragam_tas + $kegiatan + $spp + $dpp;
        $status = ($total <= 0) ? 'Lunas' : 'Belum Lunas';

        $data = [
            'nama' => $namaSiswa,
            'nik' => $nik,
            'nisn' => $siswa['nisn'],
            'pendaftaran' => $pendaftaran,
            'uis_uim' => $uis_uim,
            'peralatan' => $peralatan,
            'lks' => $lks,
            'seragam_tas' => $seragam_tas,
            'kegiatan' => $kegiatan,
            'spp' => $spp,
            'dpp' => $dpp,
            'total' => $total,
            'status' => $status
        ];

        return view('pages/siswa/rincian_keuangan', ['data' => $data]);
    }

    // Halaman keuangan
    // Halaman keuangan
    public function keuangan_siswa(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $siswaList = $this->siswaModel->findAll();

        $dataKeuangan = [];

        foreach ($siswaList as $siswa) {
            $namaSiswa = $siswa['nama'];
            $nik = $siswa['nik'];
            $no_wa = $siswa['no_whatsapp'];

            // Normalisasi nomor WhatsApp: jika diawali 0, ganti dengan 62
            if (substr($no_wa, 0, 1) === '0') {
                $no_wa = '62' . substr($no_wa, 1);
            }

            // Helper function to get billing data
            $getBillingData = function ($model) use ($namaSiswa, $bulan, $tahun) {
                $m = new $model();
                $m->selectSum('debit')->selectSum('kredit')->where('nama_siswa', $namaSiswa);
                
                if ($bulan) {
                    $m->where('MONTH(tanggal)', $bulan);
                }
                if ($tahun) {
                    $m->where('YEAR(tanggal)', $tahun);
                }

                $result = $m->first();
                $debit = $result['debit'] ?? 0;
                $kredit = $result['kredit'] ?? 0; // Total billed
                
                return [
                    'billed' => $kredit,
                    'balance' => $kredit - $debit // Remaining to pay
                ];
            };

            // Process each component
            $components = [
                'pendaftaran' => \App\Models\PendaftaranModel::class,
                'uis_uim' => \App\Models\UisUimModel::class,
                'peralatan' => \App\Models\PeralatanModel::class,
                'lks' => \App\Models\LksModel::class,
                'seragam_tas' => \App\Models\SeragamModel::class,
                'kegiatan' => \App\Models\KegiatanModel::class,
                'spp' => \App\Models\SppModel::class,
                'dpp' => \App\Models\DppModel::class,
            ];

            $siswaData = [
                'nisn' => $siswa['nisn'], 
                'nama' => $namaSiswa,
                'nik' => $nik,
                'no_whatsapp' => $no_wa,
            ];

            $totalBilled = 0;
            $totalBalance = 0;

            foreach ($components as $key => $modelClass) {
                $data = $getBillingData($modelClass);
                
                // If never billed (kredit == 0), show '-'
                // Otherwise show balance (even if 0, meaning paid)
                if ($data['billed'] == 0) {
                    $siswaData[$key] = '-';
                } else {
                    $siswaData[$key] = $data['balance'];
                    $totalBilled += $data['billed'];
                    $totalBalance += $data['balance'];
                }
            }

            // Determine Overall Status
            // Logic: 
            // 1. If NO bills at all -> "Tidak ada tagihan"
            // 2. If bills exist and Balance > 0 -> "Belum Lunas"
            // 3. If bills exist and Balance <= 0 -> "Lunas"
            
            if ($totalBilled == 0) {
                $status = 'Tidak ada tagihan';
                $siswaData['total'] = '-';
            } elseif ($totalBalance > 0) {
                $status = 'Belum Lunas';
                $siswaData['total'] = $totalBalance;
            } else {
                $status = 'Lunas';
                $siswaData['total'] = 0;
            }

            $siswaData['status'] = $status;
            $dataKeuangan[] = $siswaData;
        }

        return view('pages/keuangan_siswa', [
            'dataKeuangan' => $dataKeuangan,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    // Detail Keuangan Siswa
    // Detail Keuangan Siswa
    public function detail_keuangan_siswa()
    {
        $nisn = $this->request->getGet('nisn');
        $siswa = $this->siswaModel->where('nisn', $nisn)->first();

        if (!$siswa) {
            return redirect()->to('/keuangan_siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        $namaSiswa = $siswa['nama'];
        $nik = $siswa['nik'];
        
        // Helper function to get billing data
        $getBillingData = function ($model) use ($namaSiswa) {
            $m = new $model();
            $result = $m->selectSum('debit')->selectSum('kredit')->where('nama_siswa', $namaSiswa)->first();
            $debit = $result['debit'] ?? 0;
            $kredit = $result['kredit'] ?? 0;
            
            return [
                'billed' => $kredit,
                'balance' => $kredit - $debit
            ];
        };

        $components = [
            'pendaftaran' => \App\Models\PendaftaranModel::class,
            'uis_uim' => \App\Models\UisUimModel::class,
            'peralatan' => \App\Models\PeralatanModel::class,
            'lks' => \App\Models\LksModel::class,
            'seragam_tas' => \App\Models\SeragamModel::class,
            'kegiatan' => \App\Models\KegiatanModel::class,
            'spp' => \App\Models\SppModel::class,
            'dpp' => \App\Models\DppModel::class,
        ];

        $data = [
            'nama' => $namaSiswa,
            'kelas' => $siswa['kelas'] ?? '-', // Added fallback
            'nis' => $siswa['nis'] ?? $siswa['nisn'], // Fallback
            'nisn' => $siswa['nisn']
        ];

        $totalBilled = 0;
        $totalBalance = 0;

        foreach ($components as $key => $modelClass) {
            $billing = $getBillingData($modelClass);
            
            if ($billing['billed'] == 0) {
                $data[$key] = '-';
            } else {
                $data[$key] = $billing['balance'];
                $totalBilled += $billing['billed'];
                $totalBalance += $billing['balance'];
            }
        }

        if ($totalBilled == 0) {
            $status = 'Tidak ada tagihan';
            $data['total'] = '-';
        } elseif ($totalBalance > 0) {
            $status = 'Belum Lunas';
            $data['total'] = $totalBalance;
        } else {
            $status = 'Lunas';
            $data['total'] = 0;
        }

        $data['status'] = $status;

        return view('pages/rincian_keuangan_siswa', ['data' => $data]);
    }

    public function peralatan(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->peralatanModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/peralatan', $data);
    }

    public function uis_uim()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->uisUimModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/uis_uim', $data);
    }


    public function seragam_tas(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->seragamModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/seragam_tas', $data);
    }

    public function kegiatan(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->kegiatanModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/kegiatan', $data);
    }

    public function spp(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        // $query = $this->sppModel; // Removed direct assign
        $builder = $this->sppModel->select('spp.*, data_siswa.kelas')
                                  ->join('data_siswa', 'data_siswa.nama = spp.nama_siswa', 'left');

        if ($bulan && $tahun) {
            $builder->where('MONTH(spp.tanggal)', $bulan) // Access table explicitly
                    ->where('YEAR(spp.tanggal)', $tahun);
        }

        // Order by Kelas, then Name
        $builder->orderBy('data_siswa.kelas', 'ASC')->orderBy('spp.nama_siswa', 'ASC');

        $query = $builder; // For consistency with below code

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
            'kelasList' => $this->siswaModel->select('kelas')->distinct()->orderBy('kelas', 'ASC')->findAll(), // Added for Filter logic if needed later
        ];

        return view('pages/keuangan/spp', $data);
    }

    public function cetak_spp()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->sppModel->select('spp.*, data_siswa.kelas')
            ->join('data_siswa', 'data_siswa.nama = spp.nama_siswa', 'left');

        if ($bulan && $tahun) {
            $builder->where('MONTH(spp.tanggal)', $bulan)
                ->where('YEAR(spp.tanggal)', $tahun);
        }

        // Only include actual payments
        $builder->where('spp.debit >', 0);

        $allData = $builder->orderBy('data_siswa.kelas', 'ASC')->orderBy('spp.nama_siswa', 'ASC')->findAll();

        // Group by Class, then Aggregate by Student
        $groupedData = [];
        $totalPerClass = []; 
        $grandTotal = 0;

        foreach ($allData as $row) {
            $kelas = $row['kelas'];
            if (!$kelas) $kelas = 'Lain-lain'; // Fallback
            
            if (!isset($groupedData[$kelas])) {
                $groupedData[$kelas] = []; // Will store key=Nama, val=Total
                $totalPerClass[$kelas] = 0;
            }
            
            $nama = $row['nama_siswa'];
            $amount = $row['debit'];

            if (!isset($groupedData[$kelas][$nama])) {
                $groupedData[$kelas][$nama] = 0;
            }
            $groupedData[$kelas][$nama] += $amount;
            
            $totalPerClass[$kelas] += $amount;
            $grandTotal += $amount;
        }
        
        // Convert [Nama => Total] chart back to [ [nama=>..., jumlah=>...], ... ] for view compatibility
        // And sort keys
        ksort($groupedData);
        foreach ($groupedData as $k => $students) {
            ksort($students); // Sort by Name
            $flatList = [];
            foreach ($students as $n => $amt) {
                $flatList[] = ['nama' => $n, 'jumlah' => $amt];
            }
            $groupedData[$k] = $flatList;
        }

        $data = [
            'groupedData' => $groupedData,
            'totalPerClass' => $totalPerClass,
            'grandTotal' => $grandTotal,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('pages/export/rekap_spp_print', $data);
    }

    public function cetak_rekap_siswa()
    {
        $kelas = $this->request->getGet('kelas');
        $tahun = $this->request->getGet('tahun'); // e.g., 2024 (means 2024/2025)

        if (!$kelas || !$tahun) {
            return "Kelas dan Tahun harus dipilih";
        }

        // Define Month headers (July to June)
        $months = [
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 
            11 => 'November', 12 => 'Desember', 1 => 'Januari', 2 => 'Februari', 
            3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni'
        ];

        // Fetch Students in Class
        $students = $this->siswaModel->where('kelas', $kelas)->orderBy('nama', 'ASC')->findAll();
        
        // Fetch Payments for the School Year (July $tahun to June $tahun+1)
        $startDate = "$tahun-07-01";
        $endDate = ($tahun + 1) . "-06-30";
        
        // Note: Joining with data_siswa to filter by class if spp table doesn't have class.
        // Even though we refactored to not save class in SPP, we need to find payments for these students.
        // Efficient way: Fetch all SPP in date range, then filter by student list match.
        
        $payments = $this->sppModel->where('tanggal >=', $startDate)
                                   ->where('tanggal <=', $endDate)
                                   ->where('debit >', 0) // Only payments
                                   ->findAll();

        // Organize Matrix [StudentName][MonthIndex] = "dd/mm" or "tgl"
        $matrix = [];
        foreach ($students as $s) {
            $matrix[$s['nama']] = [];
            foreach ($months as $m => $name) {
                $matrix[$s['nama']][$m] = ''; 
            }
        }

        // Populate Matrix
        foreach ($payments as $p) {
            $pDate = strtotime($p['tanggal']);
            $pMonth = (int)date('m', $pDate);
            $pName = $p['nama_siswa'];

            if (isset($matrix[$pName]) && isset($matrix[$pName][$pMonth])) {
                // Determine day/month format based on image style "8/7" (Day/Month) or just Day?
                // Image shows "8/7", "31/7". It seems to be "Day/Month" or just "Day"?
                // Let's use "d/m" as requested in plan.
                // Wait, if multiple payments in same month? concat.
                $val = date('j/n', $pDate);
                
                if ($matrix[$pName][$pMonth] !== '') {
                    $matrix[$pName][$pMonth] .= ', ' . $val;
                } else {
                    $matrix[$pName][$pMonth] = $val;
                }
            }
        }

        $data = [
            'matrix' => $matrix,
            'months' => $months,
            'kelas' => $kelas,
            'tahun' => $tahun,
            'students' => $students // To keep order or separate list
        ];

        return view('pages/export/rekap_spp_siswa_print', $data);
    }

    public function dpp(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->dppModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/dpp', $data);
    }

    public function lks(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->lksModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/lks', $data);
    }

    public function pendaftaran(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $query = $this->pendaftaranModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun);
        }

        $data = [
            'data' => $query->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'siswaList' => $this->siswaModel->findAll(), // ini tambahan
        ];

        return view('pages/keuangan/pendaftaran', $data);
    }

    // Rekapitulasi
    // Rekapitulasi
    private function getRekapData($bulan, $tahun): array
    {
        // Mapping Label -> Model Class (Laporan Models)
        $categories = [
            'Pendaftaran' => \App\Models\Laporan\LaporanPendaftaranModel::class,
            'UIS / UIM' => \App\Models\Laporan\LaporanUisUimModel::class,
            'Peralatan' => \App\Models\Laporan\LaporanPeralatanModel::class,
            'LKS' => \App\Models\Laporan\LaporanLksModel::class,
            'Seragam / Tas' => \App\Models\Laporan\LaporanSeragamTasModel::class,
            'DPP' => \App\Models\Laporan\LaporanDppModel::class,
            'Kegiatan' => \App\Models\Laporan\LaporanKegiatanModel::class,
            'SPP' => \App\Models\Laporan\LaporanSppModel::class,
        ];

        $rekapData = [];
        $totalDebitAll = 0;
        $totalKreditAll = 0;

        // 1. Process Laporan Student Payment Categories
        foreach ($categories as $label => $modelClass) {
            $m = new $modelClass();
            
            if ($bulan) {
                 $m->where('MONTH(tanggal)', $bulan);
            }
            if ($tahun) {
                 $m->where('YEAR(tanggal)', $tahun);
            }
            
            $result = $m->selectSum('debit')->selectSum('kredit')->first();
            
            $debit = $result['debit'] ?? 0;
            $kredit = $result['kredit'] ?? 0;
            
            // Local balance for this category
            $saldo = $debit - $kredit; 
            
            $rekapData[] = [
                'keterangan' => $label,
                'debit' => $debit,
                'kredit' => $kredit, 
                'saldo' => $saldo
            ];
            
            $totalDebitAll += $debit;
            $totalKreditAll += $kredit;
        }

        // 2. Add Gaji Guru (Payroll)
        $payrollModel = new \App\Models\PayrollModel();
        if ($bulan) $payrollModel->where('bulan', $bulan);
        if ($tahun) $payrollModel->where('tahun', $tahun);
        
        $payrollSum = $payrollModel->selectSum('total_gaji')->first();
        $totalGaji = $payrollSum['total_gaji'] ?? 0;
        
        if ($totalGaji > 0) {
            $rekapData[] = [
                'keterangan' => 'Pengeluaran Gaji Guru',
                'debit' => 0,
                'kredit' => $totalGaji,
                'saldo' => 0 - $totalGaji
            ];
            $totalKreditAll += $totalGaji;
        }

        // Final Calculation
        $totalSaldo = $totalDebitAll - $totalKreditAll;
        
        return [
            'dataList' => $rekapData,
            'totalDebit' => $totalDebitAll,
            'totalKredit' => $totalKreditAll,
            'totalSaldo' => $totalSaldo,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
    }

    public function rekap(): string
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        
        $data = $this->getRekapData($bulan, $tahun);
        return view('pages/rekapitulasi', $data);
    }
    
    public function export_rekap_excel()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $data = $this->getRekapData($bulan, $tahun);
        
        $filename = 'Laporan_Rekapitulasi_Keuangan';
        if($bulan) $filename .= "_$bulan";
        if($tahun) $filename .= "_$tahun";
        $filename .= ".xls";
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        return view('pages/export/rekap_excel', $data);
    }

    public function export_rekap_print()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $data = $this->getRekapData($bulan, $tahun);

        return view('pages/export/rekap_print', $data);
    }



    // Gaji guru
    public function gaji_guru(): string
    {
        $data = [
            'teachers' => $this->teacherModel->findAll()
        ];
        return view('pages/gaji_guru', $data);
    }

    public function cetak_gaji_guru()
    {
        $data = [
            'teachers' => $this->teacherModel->findAll()
        ];
        return view('pages/export/gaji_guru_print', $data);
    }

    // CRUD Guru
    public function simpan_guru()
    {
        $data = [
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'gaji_pokok' => $this->request->getPost('gaji_pokok'),
            'tunjangan_jabatan' => $this->request->getPost('tunjangan_jabatan'),
            'tunjangan_walas' => $this->request->getPost('tunjangan_walas'),
            'tunjangan_masa_kerja' => $this->request->getPost('tunjangan_masa_kerja'),
            'kesejahteraan' => $this->request->getPost('kesejahteraan'),
            'transport_kehadiran' => $this->request->getPost('transport_kehadiran'),
            'kinerja' => $this->request->getPost('kinerja'),
            'rapat_dll' => $this->request->getPost('rapat_dll'),
            'tahfidz' => $this->request->getPost('tahfidz'),
            // 'tunjangan' => $this->request->getPost('tunjangan'), // Legacy
            'status_aktif' => 1
        ];

        $this->teacherModel->save($data);
        return redirect()->to('/gaji-guru')->with('success', 'Data guru berhasil disimpan');
    }

    public function update_guru()
    {
        $id = $this->request->getPost('id');
        $data = [
            'id' => $id,
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'gaji_pokok' => $this->request->getPost('gaji_pokok'),
            'tunjangan_jabatan' => $this->request->getPost('tunjangan_jabatan'),
            'tunjangan_walas' => $this->request->getPost('tunjangan_walas'),
            'tunjangan_masa_kerja' => $this->request->getPost('tunjangan_masa_kerja'),
            'kesejahteraan' => $this->request->getPost('kesejahteraan'),
            'transport_kehadiran' => $this->request->getPost('transport_kehadiran'),
            'kinerja' => $this->request->getPost('kinerja'),
            'rapat_dll' => $this->request->getPost('rapat_dll'),
            'tahfidz' => $this->request->getPost('tahfidz'),
            // 'tunjangan' => $this->request->getPost('tunjangan')
        ];

        $this->teacherModel->save($data);
        return redirect()->to('/gaji-guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function hapus_guru($id)
    {
        $this->teacherModel->delete($id);
        return redirect()->to('/gaji-guru')->with('success', 'Data guru berhasil dihapus');
    }

    public function slip_gaji(): string
    {
        $id = $this->request->getGet('teacher_id');
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $selectedTeacher = null;
        $previewGaji = null;

        if ($id) {
            $selectedTeacher = $this->teacherModel->find($id);
            // Calculate gaji (You might want to fetch checking if payroll already exists)
            // For now, let's just calculate logic for preview
            if ($selectedTeacher) {
                // Calculate Total
                $totalPenerimaan = $selectedTeacher['gaji_pokok'] +
                                   ($selectedTeacher['tunjangan_jabatan'] ?? 0) +
                                   ($selectedTeacher['tunjangan_walas'] ?? 0) +
                                   ($selectedTeacher['tunjangan_masa_kerja'] ?? 0) +
                                   ($selectedTeacher['kesejahteraan'] ?? 0) +
                                   ($selectedTeacher['transport_kehadiran'] ?? 0) +
                                   ($selectedTeacher['kinerja'] ?? 0) +
                                   ($selectedTeacher['rapat_dll'] ?? 0) +
                                   ($selectedTeacher['tahfidz'] ?? 0);
                                   // + ($selectedTeacher['tunjangan'] ?? 0); // Legacy check

                $previewGaji = [
                    'gaji_pokok' => $selectedTeacher['gaji_pokok'],
                    'tunjangan_jabatan' => $selectedTeacher['tunjangan_jabatan'] ?? 0,
                    'tunjangan_walas' => $selectedTeacher['tunjangan_walas'] ?? 0,
                    'tunjangan_masa_kerja' => $selectedTeacher['tunjangan_masa_kerja'] ?? 0,
                    'kesejahteraan' => $selectedTeacher['kesejahteraan'] ?? 0,
                    'transport_kehadiran' => $selectedTeacher['transport_kehadiran'] ?? 0,
                    'kinerja' => $selectedTeacher['kinerja'] ?? 0,
                    'rapat_dll' => $selectedTeacher['rapat_dll'] ?? 0,
                    'tahfidz' => $selectedTeacher['tahfidz'] ?? 0,
                    'tunjangan' => $selectedTeacher['tunjangan'] ?? 0, // Keep legacy just in case
                    'potongan' => 0, 
                    'total' => $totalPenerimaan
                ];
            }
        }

        $data = [
            'teachers' => $this->teacherModel->where('status_aktif', 1)->findAll(),
            'teacher_id' => $id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'selectedTeacher' => $selectedTeacher,
            'previewGaji' => $previewGaji
        ];

        return view('pages/slip_gaji', $data);
    }
    
    public function cetak_slip()
    {
        $id = $this->request->getGet('teacher_id');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        if (!$id) {
            return redirect()->to('/slip-gaji');
        }

        $teacher = $this->teacherModel->find($id);
        if (!$teacher) {
            return redirect()->to('/slip-gaji')->with('error', 'Guru tidak ditemukan');
        }

        // Logic Save/Check Payroll History could be here.
        // For simplicity, we create a record if it doesn't exist, or just show print view.
        // Let's just show print view.

        // Calculate Total
        $totalPenerimaan = $teacher['gaji_pokok'] +
                           ($teacher['tunjangan_jabatan'] ?? 0) +
                           ($teacher['tunjangan_walas'] ?? 0) +
                           ($teacher['tunjangan_masa_kerja'] ?? 0) +
                           ($teacher['kesejahteraan'] ?? 0) +
                           ($teacher['transport_kehadiran'] ?? 0) +
                           ($teacher['kinerja'] ?? 0) +
                           ($teacher['rapat_dll'] ?? 0) +
                           ($teacher['tahfidz'] ?? 0);
                           // + ($teacher['tunjangan'] ?? 0);

        $data = [
            'teacher' => $teacher,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $teacher['gaji_pokok'],
            'tunjangan_jabatan' => $teacher['tunjangan_jabatan'] ?? 0,
            'tunjangan_walas' => $teacher['tunjangan_walas'] ?? 0,
            'tunjangan_masa_kerja' => $teacher['tunjangan_masa_kerja'] ?? 0,
            'kesejahteraan' => $teacher['kesejahteraan'] ?? 0,
            'transport_kehadiran' => $teacher['transport_kehadiran'] ?? 0,
            'kinerja' => $teacher['kinerja'] ?? 0,
            'rapat_dll' => $teacher['rapat_dll'] ?? 0,
            'tahfidz' => $teacher['tahfidz'] ?? 0,
            'tunjangan' => $teacher['tunjangan'], // Legacy
            'potongan' => 0,
            'total' => $totalPenerimaan,
            'tanggal_cetak' => date('d F Y')
        ];

        return view('pages/cetak_slip', $data);
    }

    // Data Siswa
    // Data Siswa
    public function data_siswa()
    {
        $tahunAkademik = $this->request->getGet('tahun_akademik');
        $keyword = $this->request->getGet('keyword');
        
        // Get unique academic years for dropdown
        $db = \Config\Database::connect();
        $yearsQuery = $db->table('data_siswa')
                         ->select('tahun_akademik')
                         ->distinct()
                         ->orderBy('tahun_akademik', 'DESC')
                         ->get()
                         ->getResultArray();
                         
        $availableYears = array_column($yearsQuery, 'tahun_akademik');

        // Filter Data
        $builder = $this->siswaModel->builder(); // Alternatively use model directly if not using builder specific features, but model->where returns 'this'

        // Refactor to use Model Query Builder
        $query = $this->siswaModel;

        if ($tahunAkademik) {
            $query->where('tahun_akademik', $tahunAkademik);
        }

        if ($keyword) {
            $query->like('nama', $keyword);
        }

        $data['siswa'] = $query->findAll();

        $data['availableYears'] = $availableYears;
        $data['selectedYear'] = $tahunAkademik;
        $data['keyword'] = $keyword;

        return view('pages/data_siswa', $data);
    }

    public function tambah_siswa()
    {
        $data = [
            'nisn' => $this->request->getPost('nisn'),
            'nama' => $this->request->getPost('nama'),
            'nik' => $this->request->getPost('nik'),
            'kelas' => $this->request->getPost('kelas'),
            'jk' => $this->request->getPost('jk'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            // 'username' removed
            // 'password' removed as per request (nisn is used as password)
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
            'orang_tua' => $this->request->getPost('ortu'),
        ];

        $this->siswaModel->insert($data);
        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan.');
        return redirect()->to('/data-siswa');
    }

    public function hapus_data_siswa($nisn)
    {
        $this->siswaModel->delete($nisn);
        session()->setFlashdata('success', 'Data siswa berhasil dihapus.');
        return redirect()->to('/data-siswa');
    }

    public function edit_data_siswa($nisn)
    {
        $data['siswa'] = $this->siswaModel->find($nisn);

        if (!$data['siswa']) {
            return redirect()->to('/data-siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('pages/data_siswa', $data);
    }

    public function update_siswa()
    {
        $original_nisn = $this->request->getPost('original_nisn');
        $new_nisn = $this->request->getPost('nisn');
        
        // Validate if new NISN already exists (only if changed)
        if ($original_nisn != $new_nisn) {
            if ($this->siswaModel->find($new_nisn)) {
                 session()->setFlashdata('error', 'Gagal update: NISN baru sudah terdaftar.');
                 return redirect()->to('/data-siswa');
            }
        }

        $data = [
            'nisn' => $new_nisn, // Allow updating NISN
            'nama' => $this->request->getPost('nama'),
            'nik' => $this->request->getPost('nik'),
            'kelas' => $this->request->getPost('kelas'),
            'jk' => $this->request->getPost('jk'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            // 'username' removed
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
            'orang_tua' => $this->request->getPost('ortu'),
        ];



        log_message('error', "[Update Debug] Orig: $original_nisn, New: $new_nisn");

        // Use Builder update to ensure we can change Primary Key
        // Model::update($id, $data) might have protections.
        // WHERE nisn = $original_nisn SET ...
        $res = $this->siswaModel->where('nisn', $original_nisn)->set($data)->update();
        
        if (!$res) {
             log_message('error', "[Update Debug] Failed: " . json_encode($this->siswaModel->errors()));
             session()->setFlashdata('error', 'Gagal update data.');
        } else {
             session()->setFlashdata('success', 'Data siswa berhasil diperbarui.');
        }
        return redirect()->to('/data-siswa');
    }

    // Generic Import Function
    private function processImportExcel($model, $redirectUrl)
    {
        
        log_message('error', "[Import Financial Debug] Starting processImportExcel. Redirect: $redirectUrl");
        $file = $this->request->getFile('file_excel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                 if (!class_exists('ZipArchive')) {
                     throw new \Exception('Ekstensi PHP Zip belum aktif. Harap aktifkan "extension=zip" di php.ini dan restart Apache.');
                 }

                $filePath = $file->getTempName();
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                $successCount = 0;
                $failCount = 0;

                $colTanggal = 0;
                $colNama = 1;
                $colDebit = 2;
                $colKredit = 3;

                // Smart Header Mapping
                if (!empty($rows[0])) {
                    $headerRow = array_map('strtolower', array_map('trim', $rows[0]));
                    $foundDebit = false;
                    $foundKredit = false;

                    foreach ($headerRow as $idx => $colName) {
                        if (strpos($colName, 'tanggal') !== false) $colTanggal = $idx;
                        elseif (strpos($colName, 'nama') !== false) $colNama = $idx;
                        elseif (strpos($colName, 'debit') !== false) { $colDebit = $idx; $foundDebit = true; }
                        elseif (strpos($colName, 'kredit') !== false) { $colKredit = $idx; $foundKredit = true; }
                        elseif (strpos($colName, 'nominal tagihan') !== false || strpos($colName, 'tagihan') !== false) { 
                            $colKredit = $idx; 
                            $foundKredit = true; 
                        }
                    }

                    // Fallback for SPP template instruction error (Kelas at C)
                    if (!$foundDebit && !$foundKredit) {
                        if (isset($headerRow[2]) && strpos($headerRow[2], 'kelas') !== false) {
                            $colDebit = 3;
                            $colKredit = 4;
                        }
                    }
                }

                // Assume row 1 is header, start from row 2 (index 1)
                for ($i = 1; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    
                    // Basic validation: Check if row is not empty
                    if (empty($row[$colTanggal]) && empty($row[$colNama])) {
                        continue; 
                    }

                $tanggalInput = trim($row[$colTanggal] ?? '');
                $namaSiswa = trim($row[$colNama] ?? '');
                
                // Helper to clean formatting like Rp 150.000 or 150,000 before floatval
                $cleanNumber = function($val) {
                    $val = trim($val);
                    if (empty($val) || $val === '-') return 0;
                    // Remove Rp, spaces, and dots
                    $val = preg_replace('/[Rrp\s\.]/', '', $val);
                    // Replace comma with dot for decimals just in case
                    $val = str_replace(',', '.', $val);
                    return floatval($val);
                };

                $debit = $cleanNumber($row[$colDebit] ?? 0);
                $kredit = $cleanNumber($row[$colKredit] ?? 0);

                // Skip invalid name
                if (empty($namaSiswa)) {
                    log_message('error', "[Import Financial Debug] Row $i skipped: Nama Siswa empty. Raw: " . json_encode($row));
                    $failCount++; 
                    continue; 
                }

                // Format Date
                $tanggal = date('Y-m-d'); // Default today
                if (!empty($tanggalInput)) {
                    // Try various formats if needed
                    if (is_numeric($tanggalInput)) {
                        $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalInput)->format('Y-m-d');
                    } else {
                        // Try string parsing
                        $d = date_create($tanggalInput);
                        if ($d) {
                            $tanggal = date_format($d, 'Y-m-d');
                        } else {
                             log_message('error', "[Import Financial Debug] Row $i: Could not parse date '$tanggalInput'. Using today.");
                        }
                    }
                }

                $data = [
                    'tanggal' => $tanggal,
                    'nama_siswa' => $namaSiswa,
                    'debit' => $debit,
                    'kredit' => $kredit
                ];

                if ($model->save($data)) {
                    $successCount++;
                } else {
                    $errors = $model->errors();
                    log_message('error', "[Import Financial Debug] Row $i Save Failed. Errors: " . json_encode($errors));
                    $failCount++;
                }
            }

            $msg = "Import selesai. Berhasil: $successCount, Gagal: $failCount";
            log_message('error', "[Import Financial Debug] Finished. $msg");
            session()->setFlashdata('success', $msg);

        } catch (\Exception $e) {
            log_message('error', "[Import Financial Debug] Exception: " . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    } else {
        session()->setFlashdata('error', 'File tidak valid atau belum diupload.');
    }

    return redirect()->to($redirectUrl);
}

    public function import_pendaftaran()
    {
        return $this->processImportExcel($this->pendaftaranModel, '/pendaftaran');
    }

    public function import_uis_uim()
    {
        return $this->processImportExcel($this->uisUimModel, '/uis_uim');
    }

    public function import_peralatan()
    {
        return $this->processImportExcel($this->peralatanModel, '/peralatan');
    }

    public function import_lks()
    {
        return $this->processImportExcel($this->lksModel, '/lks');
    }

    public function import_seragam_tas()
    {
        return $this->processImportExcel($this->seragamModel, '/seragam_tas');
    }

    public function import_kegiatan()
    {
        return $this->processImportExcel($this->kegiatanModel, '/kegiatan');
    }

    public function import_spp()
    {
        return $this->processImportExcel($this->sppModel, '/spp');
    }

    public function import_dpp()
    {
        return $this->processImportExcel($this->dppModel, '/dpp');
    }

    public function export_siswa()
    {
        $siswa = $this->siswaModel->findAll();
        $filename = 'data_siswa_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Header CSV
        fputcsv($output, ['nisn', 'nama', 'nik', 'kelas', 'jk', 'tanggal_lahir', 'alamat', 'no_whatsapp', 'ortu', 'role']);

        foreach ($siswa as $row) {
            fputcsv($output, [
                $row['nisn'],
                $row['nama'],
                $row['nik'],
                $row['kelas'] ?? '',
                $row['jk'],
                $row['tanggal_lahir'],
                $row['alamat'],
                $row['alamat'],
                // $row['username'] removed
                // Password column removed
                $row['no_whatsapp'],
                $row['orang_tua'],
                $row['role'] ?? 'siswa'
            ]);
        }

        fclose($output);
        exit;
    }

    public function import_siswa()
    {
        log_message('error', '[Import Siswa Debug] Starting import_siswa function.');
        $file = $this->request->getFile('file_csv'); 

        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                if (!class_exists('ZipArchive')) {
                    throw new \Exception('Ekstensi PHP Zip belum aktif di server.');
                }

                $filePath = $file->getTempName();
                log_message('error', "[Import Siswa Debug] File path: $filePath");
                
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();
                
                log_message('error', '[Import Siswa Debug] Total rows found: ' . count($rows));

                if (count($rows) < 2) {
                    throw new \Exception('File kosong atau tidak ada data.');
                }

                // 1. Smart Header Search
                // Scan first 10 rows to find a row that contains 'nisn' or 'nama'
                $headerRowIndex = -1;
                $header = [];
                $limitSearch = min(10, count($rows));

                // Define Keyword Synonyms mapping
                $map = [
                    'nisn' => ['nisn', 'nis', 'nomor induk siswa nasional', 'nomor induk', 'nipd', 'no induk', 'nomor induk siswa'],
                    'nama' => ['nama', 'nama siswa', 'nama peserta didik', 'nama lengkap', 'name', 'nama pd'],
                    'nik'  => ['nik', 'nomor induk kependudukan', 'no ktp', 'ktp'], 
                    'kelas' => ['kelas', 'rombel', 'group', 'ruang kelas'],
                    'jk' => ['jk', 'jenis kelamin', 'sex', 'gender', 'l/p', 'lp'],
                    'tanggal_lahir' => ['tanggal lahir', 'tgl lahir', 'tanggal_lahir', 'dob', 'birth date'],
                    'alamat' => ['alamat', 'alamat siswa', 'alamat jalan', 'address', 'tempat tinggal', 'domisili'],

                    // 'username' => ['username', 'user', 'akun'],
                    'no_whatsapp' => ['hp', 'no hp', 'nomor hp', 'handphone', 'wa', 'whatsapp', 'no wa', 'nomor wa', 'nomor telepon'],
                    'orang_tua' => ['data ayah', 'nama ayah', 'data ayah nama', 'ayah', 'ortu', 'orang tua', 'nama orang tua', 'wali', 'nama wali'],
                    'role' => ['role', 'peran', 'akses']
                ];

                $bestScore = -1;

                for ($r = 0; $r < $limitSearch; $r++) {
                    // Convert row to string, lowercased, for easy searching
                    $rowString = implode(' ', array_map('strtolower', array_map('trim', $rows[$r])));
                    
                    $currentScore = 0;
                    // Count how many keys are found in this row
                    foreach ($map as $key => $keywords) {
                        foreach ($keywords as $kw) {
                            if (strpos($rowString, $kw) !== false) {
                                $currentScore++;
                                break; // Count key only once per row
                            }
                        }
                    }

                    // Strict check: Row must have at least 2 recognized columns to be a valid header candidate
                    // Or if it simply matches "NISN" strongly.
                    
                    if ($currentScore > $bestScore) {
                        $bestScore = $currentScore;
                        $headerRowIndex = $r;
                        $header = array_map('strtolower', array_map('trim', $rows[$r])); // Keep array for column mapping
                    }
                }

                if ($bestScore <= 0) {
                     // Fallback check: if we found nothing, but maybe the first row has legitimate data or we just take row 0.
                     // But if score is 0, it likely means NO keywords found.
                     // Check if ANY NISN-like keyword exists in best row?
                     // Let's stick to the previous fallback behavior if really nothing found.
                }

                if ($headerRowIndex === -1) {
                    // Fallback to row 0 if detection fails
                    $headerRowIndex = 0;
                    $header = array_map('strtolower', array_map('trim', $rows[0]));
                    log_message('error', '[Import Siswa Debug] Could not identify header row confidently. Using Row 0.');
                } else {
                     log_message('error', "[Import Siswa Debug] Header found at row index: $headerRowIndex");
                     
                // Parent Header Check removed (caused pollution with metadata rows)

                }

                // Find indices (Prioritize Keywords Order)
                // Iterate through Keys -> Keywords -> Columns
                // This ensures if 'nisn' is preferred over 'nipd', we find 'nisn' first regardless of column position.
                
                $indices = [];
                foreach ($map as $key => $keywords) {
                    $indices[$key] = -1;
                    
                    foreach ($keywords as $kw) {
                        // Scan ALL columns for this keyword
                        foreach ($header as $colIdx => $colName) {
                            // Normalize column name
                            $colNameClean = trim(preg_replace('/[^a-z0-9]/', ' ', $colName));
                            $colNameClean = preg_replace('/\s+/', ' ', $colNameClean);
                            
                            // Regex Match
                            $pattern = '/\b' . preg_quote($kw, '/') . '\b/';
                            if (preg_match($pattern, $colNameClean)) {
                                $indices[$key] = $colIdx;
                                break 2; // Found match for this Key, break to next Key
                            }
                        }
                    }
                }
                
                // BROAD SEARCH FALLBACKS (If exact keys failed)
                // Search for ANY column containing keywords, excluding 'Parent Contexts'
                $blacklistParent = ['ayah', 'ibu', 'wali', 'orang tua', 'ortu'];
                
                // Helper for broad search
                $findBroad = function($keyword, $blacklist) use ($header) {
                     foreach ($header as $i => $h) {
                        if (str_contains($h, $keyword)) {
                             // Check blacklist
                             $isBad = false;
                             foreach ($blacklist as $bad) {
                                 if (str_contains($h, $bad)) { $isBad = true; break; }
                             }
                             if (!$isBad) return $i;
                        }
                    }
                    return -1;
                };
                
                if ($indices['nik'] === -1) {
                    // Try finding 'nik' or 'ktp'
                    $idx = $findBroad('nik', $blacklistParent);
                    if ($idx === -1) $idx = $findBroad('ktp', $blacklistParent);
                    if ($idx !== -1) $indices['nik'] = $idx;
                }
                
                if ($indices['alamat'] === -1) {
                     $idx = $findBroad('alamat', $blacklistParent);
                     if ($idx === -1) $idx = $findBroad('address', $blacklistParent);
                     if ($idx === -1) $idx = $findBroad('jalan', $blacklistParent); 
                     if ($idx !== -1) $indices['alamat'] = $idx;
                }
                
                if ($indices['no_whatsapp'] === -1) {
                     $idx = $findBroad('hp', $blacklistParent);
                     if ($idx === -1) $idx = $findBroad('wa', $blacklistParent); 
                     if ($idx === -1) $idx = $findBroad('telepon', $blacklistParent);
                     if ($idx !== -1) $indices['no_whatsapp'] = $idx;
                }
                
                if ($indices['tanggal_lahir'] === -1) {
                     $idx = $findBroad('tanggal', $blacklistParent); // Broader? 'tanggal' might match 'tanggal masuk'? Risk.
                     if ($idx === -1) $idx = $findBroad('tgl lahir', $blacklistParent);
                     if ($idx === -1) $idx = $findBroad('birth', $blacklistParent);
                      if ($idx !== -1) $indices['tanggal_lahir'] = $idx;
                }

                // Defaults Removed. If -1, it means not found, and getVal will return empty.
                // This prevents mapping strictly wrong columns (like Col 0 -> NISN) when detection fails.
                
                log_message('error', '[Import Siswa Debug] Final Indices: ' . json_encode($indices));

                $successCount = 0;
                $failCount = 0;
                
                // Start from row matching + 1
                for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    
                    // Helper to get value safely
                    $getVal = function($key) use ($row, $indices) {
                        if (!isset($indices[$key])) return ''; 
                        $idx = $indices[$key];
                        if ($idx !== -1 && isset($row[$idx])) {
                            return trim($row[$idx]);
                        }
                        return '';
                    };

                    $nisn = (string) $getVal('nisn'); 
                    
                    if (strlen($nisn) < 1) { 
                        continue; 
                    }
                    
                    // Safety: Skip if NISN looks like a header
                    if (strtolower($nisn) === 'nisn' || strtolower($nisn) === 'nomor induk') {
                         continue;
                    }

                    // ... (Date parsing) ... (keep existing)
                    $tglLahirInput = $getVal('tanggal_lahir');
                    $tglLahir = null;
                    if (!empty($tglLahirInput)) {
                         if (is_numeric($tglLahirInput)) {
                            $tglLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglLahirInput)->format('Y-m-d');
                        } else {
                            $cleanDate = str_replace('/', '-', $tglLahirInput);
                            $timestamp = strtotime($cleanDate);
                            if ($timestamp) {
                                $tglLahir = date('Y-m-d', $timestamp);
                            }
                        }
                    }

                    $rawJk = $getVal('jk');
                    $cleanJk = '';
                    if (stripos($rawJk, 'l') !== false) {
                        $cleanJk = 'L';
                    } elseif (stripos($rawJk, 'p') !== false) {
                        $cleanJk = 'P';
                    }
                    
                    $data = [
                        'nisn' => $nisn,
                        'nama' => $getVal('nama'),
                        'nik' => $getVal('nik'),
                        'kelas' => $getVal('kelas'),
                        'jk' => $cleanJk,
                        'tanggal_lahir' => $tglLahir,
                        'alamat' => $getVal('alamat'),
                        // 'password' removed 
                        'no_whatsapp' => $getVal('no_whatsapp'),
                        'orang_tua' => $getVal('orang_tua'),
                        'role' => $getVal('role') ?: 'siswa',
                    ];

                    // Cek apakah data sudah ada
                    $exists = $this->siswaModel->where('nisn', $nisn)->first();
                    $saveResult = false;
                    
                    if ($exists) {
                        $saveResult = $this->siswaModel->update($nisn, $data);
                    } else {
                        $saveResult = $this->siswaModel->insert($data);
                    }

                    if ($saveResult) {
                        $successCount++;
                    } else {
                        $failCount++;
                        log_message('error', "[Import Siswa Debug] Row $i Save Failed: " . json_encode($this->siswaModel->errors()));
                         if (!session()->getFlashdata('error_sample')) {
                             session()->setFlashdata('error_sample', "NISN $nisn: Gagal simpan.");
                        }
                    }
                }
                
                $msg = "Import selesai. Berhasil: $successCount. Gagal: $failCount.";
                log_message('error', "[Import Siswa Debug] Finished. $msg");
                
                if ($successCount == 0 && $failCount == 0) {
                     $debugInfo = "Header dideteksi Baris: $headerRowIndex. Isi Header: [" . implode(', ', $header) . "]";
                     session()->setFlashdata('error', "$msg Tidak ada data. Debug: $debugInfo");
                } elseif ($failCount > 0) {
                     $errorSample = session()->getFlashdata('error_sample');
                     $msg .= " Contoh error: " . $errorSample;
                     session()->setFlashdata('warning', $msg);
                } else {
                    session()->setFlashdata('success', $msg);
                }

            } catch (\Exception $e) {
                log_message('error', "[Import Siswa Debug] Exception: " . $e->getMessage());
                session()->setFlashdata('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
            }
        } else {
            log_message('error', '[Import Siswa Debug] File invalid or not uploaded.');
            session()->setFlashdata('error', 'Gagal mengupload file atau file tidak valid.');
        }

        return redirect()->to('/data-siswa');
    }


    // Simpan data PENDAFTARAN
    public function simpan_pendaftaran()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        // Format Rupiah
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->pendaftaranModel->save($data);

        // Notifikasi - REVISED
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan Pendaftaran Baru", 
                "Tagihan Pendaftaran sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran Pendaftaran Diterima", 
                "Pembayaran Pendaftaran sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/pendaftaran')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_pendaftaran($id)
    {
        $this->pendaftaranModel->delete($id);
        return redirect()->to('/pendaftaran')->with('success', 'Data berhasil dihapus');
    }

    // Update
    public function update_pendaftaran($id)
    {
        $data = [
            'id' => $id,
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ];
        $this->pendaftaranModel->save($data);
        return redirect()->to('/pendaftaran')->with('success', 'Data berhasil diupdate');
    }

    // EDIT
    public function edit_pendaftaran($id)
    {
        $pendaftaran = $this->pendaftaranModel->find($id);

        if (!$pendaftaran) {
            return redirect()->to('/pendaftaran')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/pendaftaran', [
            'pendaftaran' => $pendaftaran,
            'siswaList' => $siswaList
        ]);
    }

    // Simpan data LKS
    public function simpan_lks()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->lksModel->save($data);

        // Notifikasi - REVISED
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan LKS Baru", 
                "Tagihan LKS sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran LKS Diterima", 
                "Pembayaran LKS sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/lks')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_lks($id)
    {
        $this->lksModel->delete($id);
        return redirect()->to('/lks')->with('success', 'Data berhasil dihapus');
    }

    // Update
    public function update_lks($id)
    {
        $data = [
            'id' => $id,
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ];
        $this->lksModel->save($data);
        return redirect()->to('/lks')->with('success', 'Data berhasil diupdate');
    }

    // EDIT
    public function edit_lks($id)
    {
        $lks = $this->lksModel->find($id);

        if (!$lks) {
            return redirect()->to('/lks')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/lks', [
            'lks' => $lks,
            'siswaList' => $siswaList
        ]);
    }


    // Simpan data PERALATAN
    public function simpan_peralatan()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->peralatanModel->save($data);

        // Notifikasi - REVISED
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan Peralatan Baru", 
                "Tagihan Peralatan sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran Peralatan Diterima", 
                "Pembayaran Peralatan sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/peralatan')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_peralatan($id)
    {
        $this->peralatanModel->delete($id);
        return redirect()->to('/peralatan')->with('success', 'Data berhasil dihapus');
    }

    // Update
    public function update_peralatan($id)
    {
        $data = [
            'id' => $id,
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ];
        $this->peralatanModel->save($data);
        return redirect()->to('/peralatan')->with('success', 'Data berhasil diupdate');
    }

    // EDIT
    public function edit_peralatan($id)
    {
        $peralatan = $this->peralatanModel->find($id);

        if (!$peralatan) {
            return redirect()->to('/peralatan')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/peralatan', [
            'peralatan' => $peralatan,
            'siswaList' => $siswaList
        ]);
    }

    // Simpan data UIS / UIM
    public function simpan_uis_uim()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->uisUimModel->save($data);

        // Notifikasi - REVISED
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan UIS/UIM Baru", 
                "Tagihan UIS/UIM sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran UIS/UIM Diterima", 
                "Pembayaran UIS/UIM sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/uis_uim')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_uis_uim($id)
    {
        $this->uisUimModel->delete($id);
        return redirect()->to('/uis_uim')->with('success', 'Data berhasil dihapus');
    }

    // Update
    public function update_uis_uim($id)
    {
        $data = [
            'id' => $id,
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ];
        $this->uisUimModel->save($data);
        return redirect()->to('/uis_uim')->with('success', 'Data berhasil diupdate');
    }

    // EDIT
    public function edit_uis_uim($id)
    {
        $uis_uim = $this->uisUimModel->find($id);

        if (!$uis_uim) {
            return redirect()->to('/uis_uim')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/uis_uim', [
            'uis_uim' => $uis_uim,
            'siswaList' => $siswaList
        ]);
    }

    // Simpan data SERAGAM / TAS
    public function simpan_seragam_tas()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->seragamModel->save($data);

        // Notifikasi - REVISED
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan Seragam/Tas Baru", 
                "Tagihan Seragam/Tas sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran Seragam/Tas Diterima", 
                "Pembayaran Seragam/Tas sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/seragam_tas')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_seragam_tas($id)
    {
        $this->seragamModel->delete($id);
        return redirect()->to('/seragam_tas')->with('success', 'Data berhasil dihapus');
    }

    // Update
    public function update_seragam_tas($id)
    {
        $data = [
            'id' => $id,
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ];
        $this->seragamModel->save($data);
        return redirect()->to('/seragam_tas')->with('success', 'Data berhasil diupdate');
    }

    // EDIT
    public function edit_seragam_tas($id)
    {
        $seragamtas = $this->seragamModel->find($id);

        if (!$seragamtas) {
            return redirect()->to('/seragam_tas')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/seragam_tas', [
            'seragam_tas' => $seragamtas,
            'siswaList' => $siswaList
        ]);
    }

    // Simpan data KEGIATAN
    public function simpan_kegiatan()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->kegiatanModel->save($data);

        // Notifikasi - REVISED
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan Kegiatan Baru", 
                "Tagihan Kegiatan sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran Kegiatan Diterima", 
                "Pembayaran Kegiatan sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/kegiatan')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_kegiatan($id)
    {
        $this->kegiatanModel->delete($id);
        return redirect()->to('/kegiatan')->with('success', 'Data berhasil dihapus');
    }



    // UPDATE
    public function update_kegiatan($id)
    {
        $id = $this->request->getPost('id');
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit')
        ];

        $this->kegiatanModel->update($id, $data);
        return redirect()->to('/kegiatan')->with('success', 'Data berhasil diperbarui');
    }



    // EDIT
    public function edit_kegiatan($id)
    {
        $kegiatan = $this->kegiatanModel->find($id);

        if (!$kegiatan) {
            return redirect()->to('/kegiatan')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/kegiatan', [
            'kegiatan' => $kegiatan,
            'siswaList' => $siswaList
        ]);
    }

    // Helper untuk membuat notifikasi otomatis
    private function create_notification($nama_siswa, $judul, $pesan)
    {
        $siswa = $this->siswaModel->where('nama', $nama_siswa)->first();

        if ($siswa) {
            // Gunakan NISN atau NIS sesuai struktur DB (di sini asumsi mapping ke kolom 'nis' di tabel notifications)
            // Cek Dashboard Siswa menggunakan: session()->get('nisn') -> where('nis', $nisn)
            // Jadi kita gunakan nisn siswa untuk kolom nis
            $nisVal = $siswa['nisn'] ?? $siswa['nis'];
            
            $this->notificationModel->save([
                'nis' => $nisVal,
                'judul' => $judul,
                'pesan' => $pesan,
                'status' => 'unread'
            ]);
        }
    }

    // Simpan data SPP
    public function simpan_spp()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        // Format Rupiah for message
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->sppModel->save($data);

        // Logika Notifikasi - REVISED (Debit = Pembayaran, Kredit = Tagihan)
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan SPP Baru", 
                "Anda memiliki tagihan SPP baru sebesar {$fmtKredit} pada tanggal " . date('d M Y', strtotime($tanggal))
            );
        }

        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran SPP Diterima", 
                "Pembayaran SPP sebesar {$fmtDebit} telah divalidasi pada tanggal " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/spp')->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_spp($id)
    {
        $this->sppModel->delete($id);
        return redirect()->to('/spp')->with('success', 'Data berhasil dihapus');
    }

    // UPDATE
    public function update_spp($id)
    {
        $id = $this->request->getPost('id');
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit')
        ];

        $this->sppModel->update($id, $data);
        return redirect()->to('/spp')->with('success', 'Data berhasil diperbarui');
    }

    // EDIT
    public function edit_spp($id)
    {
        $spp = $this->sppModel->find($id);

        if (!$spp) {
            return redirect()->to('/spp')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/spp', [
            'spp' => $spp,
            'siswaList' => $siswaList
        ]);
    }

    // Simpan data DPP
    public function simpan_dpp()
    {
        $namaSiswa = $this->request->getPost('nama_siswa');
        $debit = $this->request->getPost('debit');
        $kredit = $this->request->getPost('kredit');
        $tanggal = $this->request->getPost('tanggal');
        
        $fmtDebit = "Rp " . number_format($debit, 0, ',', '.');
        $fmtKredit = "Rp " . number_format($kredit, 0, ',', '.');

        $data = [
            'tanggal' => $tanggal,
            'nama_siswa' => $namaSiswa,
            'debit' => $debit,
            'kredit' => $kredit,
        ];

        $this->dppModel->save($data);

        // Logika Notifikasi - REVISED (Debit = Pembayaran, Kredit = Tagihan)
        if ($kredit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Tagihan DPP Baru", 
                "Tagihan DPP sebesar {$fmtKredit} pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }
        if ($debit > 0) {
            $this->create_notification(
                $namaSiswa, 
                "Pembayaran DPP Diterima", 
                "Pembayaran DPP sebesar {$fmtDebit} divalidasi pada tgl " . date('d M Y', strtotime($tanggal))
            );
        }

        return redirect()->to('/dpp')
            ->with('success', 'Data berhasil disimpan!');
    }
    // DELETE
    public function delete_dpp($id)
    {
        $this->dppModel->delete($id);
        return redirect()->to('/dpp')->with('success', 'Data berhasil dihapus');
    }

    // UPDATE
    public function update_dpp($id)
    {
        $id = $this->request->getPost('id');
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit')
        ];

        $this->dppModel->update($id, $data);
        return redirect()->to('/dpp')->with('success', 'Data berhasil diperbarui');
    }

    // EDIT
    public function edit_dpp($id)
    {
        $dpp = $this->dppModel->find($id);

        if (!$dpp) {
            return redirect()->to('/dpp')->with('error', 'Data tidak ditemukan');
        }

        $siswaList = $this->siswaModel->findAll();

        return view('pages/keuangan/dpp', [
            'dpp' => $dpp,
            'siswaList' => $siswaList
        ]);
    }

    // OPERASIONAL
    public function operasional()
    {
        $data = [
            'expenses' => $this->operationalModel->orderBy('tanggal', 'DESC')->findAll()
        ];
        return view('pages/keuangan/operasional', $data);
    }

    public function simpan_operasional()
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'kategori' => $this->request->getPost('kategori'),
            'jumlah' => $this->request->getPost('jumlah'),
        ];
        $this->operationalModel->save($data);
        return redirect()->to('/operasional')->with('swal_success', 'Data operasional berhasil disimpan.');
    }

    public function update_operasional()
    {
        $id = $this->request->getPost('id');
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'kategori' => $this->request->getPost('kategori'),
            'jumlah' => $this->request->getPost('jumlah'),
        ];
        
        $this->operationalModel->update($id, $data);
        return redirect()->to('/operasional')->with('swal_success', 'Data operasional berhasil diperbarui.');
    }

    public function hapus_operasional($id)
    {
        $this->operationalModel->delete($id);
        return redirect()->to('/operasional')->with('swal_success', 'Data operasional berhasil dihapus.');
    }

    // ============================================
    // LAPORAN PENDAFTARAN
    // ============================================
    public function laporan_pendaftaran()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanPendaftaranModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_pendaftaran', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_pendaftaran()
    {
        $this->laporanPendaftaranModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_pendaftaran')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_pendaftaran($id)
    {
        $item = $this->laporanPendaftaranModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanPendaftaranModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_pendaftaran', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_pendaftaran($id)
    {
        $this->laporanPendaftaranModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_pendaftaran')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_pendaftaran($id)
    {
        $this->laporanPendaftaranModel->delete($id);
        return redirect()->to('/laporan_pendaftaran')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN UIS / UIM
    // ============================================
    public function laporan_uis_uim()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanUisUimModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_uis_uim', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_uis_uim()
    {
        $this->laporanUisUimModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_uis_uim')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_uis_uim($id)
    {
        $item = $this->laporanUisUimModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanUisUimModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_uis_uim', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_uis_uim($id)
    {
        $this->laporanUisUimModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_uis_uim')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_uis_uim($id)
    {
        $this->laporanUisUimModel->delete($id);
        return redirect()->to('/laporan_uis_uim')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN PERALATAN
    // ============================================
    public function laporan_peralatan()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanPeralatanModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_peralatan', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_peralatan()
    {
        $this->laporanPeralatanModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_peralatan')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_peralatan($id)
    {
        $item = $this->laporanPeralatanModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanPeralatanModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_peralatan', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_peralatan($id)
    {
        $this->laporanPeralatanModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_peralatan')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_peralatan($id)
    {
        $this->laporanPeralatanModel->delete($id);
        return redirect()->to('/laporan_peralatan')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN LKS
    // ============================================
    public function laporan_lks()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanLksModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_lks', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_lks()
    {
        $this->laporanLksModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_lks')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_lks($id)
    {
        $item = $this->laporanLksModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanLksModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_lks', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_lks($id)
    {
        $this->laporanLksModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_lks')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_lks($id)
    {
        $this->laporanLksModel->delete($id);
        return redirect()->to('/laporan_lks')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN SERAGAM / TAS
    // ============================================
    public function laporan_seragam_tas()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanSeragamTasModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_seragam_tas', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_seragam_tas()
    {
        $this->laporanSeragamTasModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_seragam_tas')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_seragam_tas($id)
    {
        $item = $this->laporanSeragamTasModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanSeragamTasModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_seragam_tas', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_seragam_tas($id)
    {
        $this->laporanSeragamTasModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_seragam_tas')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_seragam_tas($id)
    {
        $this->laporanSeragamTasModel->delete($id);
        return redirect()->to('/laporan_seragam_tas')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN KEGIATAN
    // ============================================
    public function laporan_kegiatan()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanKegiatanModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_kegiatan', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_kegiatan()
    {
        $this->laporanKegiatanModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_kegiatan')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_kegiatan($id)
    {
        $item = $this->laporanKegiatanModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanKegiatanModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_kegiatan', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_kegiatan($id)
    {
        $this->laporanKegiatanModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_kegiatan')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_kegiatan($id)
    {
        $this->laporanKegiatanModel->delete($id);
        return redirect()->to('/laporan_kegiatan')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN SPP
    // ============================================
    public function laporan_spp()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanSppModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_spp', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_spp()
    {
        $this->laporanSppModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_spp')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_spp($id)
    {
        $item = $this->laporanSppModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanSppModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_spp', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_spp($id)
    {
        $this->laporanSppModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_spp')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_spp($id)
    {
        $this->laporanSppModel->delete($id);
        return redirect()->to('/laporan_spp')->with('success', 'Data berhasil dihapus!');
    }

    // ============================================
    // LAPORAN DPP
    // ============================================
    public function laporan_dpp()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanDppModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_dpp', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun
        ]);
    }
    public function simpan_laporan_dpp()
    {
        $this->laporanDppModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_dpp')->with('success', 'Data berhasil disimpan!');
    }
    public function edit_laporan_dpp($id)
    {
        $item = $this->laporanDppModel->find($id);
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $query = $this->laporanDppModel;
        if ($bulan && $tahun) {
            $query = $query->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun);
        }
        return view('pages/laporan/laporan_dpp', [
            'data' => $query->findAll(), 'bulan' => $bulan, 'tahun' => $tahun, 'editData' => $item
        ]);
    }
    public function update_laporan_dpp($id)
    {
        $this->laporanDppModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'debit' => $this->request->getPost('debit'),
            'kredit' => $this->request->getPost('kredit'),
        ]);
        return redirect()->to('/laporan_dpp')->with('success', 'Data berhasil diperbarui!');
    }
    public function delete_laporan_dpp($id)
    {
        $this->laporanDppModel->delete($id);
        return redirect()->to('/laporan_dpp')->with('success', 'Data berhasil dihapus!');
    }

    // Print Financial Report (All Categories)
    private function getReportDataWithBalance($model, $month, $year)
    {
        $m = new $model();
        $startDate = "$year-$month-01";
        
        // Calculate Previous Balance
        // For Laporan models (Debit = Masuk, Kredit = Keluar)
        // Saldo = Sum(Debit) - Sum(Kredit)
        $prevBalanceQuery = $m->selectSum('debit')->selectSum('kredit')
                              ->where('tanggal <', $startDate)
                              ->first();
        
        $prevDebit = $prevBalanceQuery['debit'] ?? 0;
        $prevKredit = $prevBalanceQuery['kredit'] ?? 0;
        $saldoAwal = $prevDebit - $prevKredit;

        // Fetch Transactions
        $transactions = $m->where('MONTH(tanggal)', $month)
                          ->where('YEAR(tanggal)', $year)
                          ->orderBy('tanggal', 'ASC')
                          ->findAll();
                          
        return [
            'saldo_awal' => $saldoAwal,
            'transactions' => $transactions
        ];
    }

    public function cetak_laporan_keuangan()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        
        // Using LAPORAN Models (General Ledger) instead of Student Transaction Models
        $models = [
            'PENDAFTARAN'   => \App\Models\Laporan\LaporanPendaftaranModel::class,
            'UIS/UIM'       => \App\Models\Laporan\LaporanUisUimModel::class,
            'PERALATAN'     => \App\Models\Laporan\LaporanPeralatanModel::class,
            'LKS'           => \App\Models\Laporan\LaporanLksModel::class,
            'SERAGAM/TAS'   => \App\Models\Laporan\LaporanSeragamTasModel::class,
            'KEGIATAN'      => \App\Models\Laporan\LaporanKegiatanModel::class,
            'SPP'           => \App\Models\Laporan\LaporanSppModel::class,
            'DPP'           => \App\Models\Laporan\LaporanDppModel::class,
        ];
        
        $reportData = [];
        foreach ($models as $title => $modelClass) {
            $reportData[$title] = $this->getReportDataWithBalance($modelClass, $bulan, $tahun);
        }
        
        $dateObj   = \DateTime::createFromFormat('!m', $bulan);
        $monthName = $dateObj->format('F'); 
        
        return view('pages/export/cetak_laporan_keuangan', [
            'reportData' => $reportData,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'monthName' => $monthName
        ]);
    }

    public function filter_cetak_laporan()
    {
        return view('pages/export/filter_cetak_laporan');
    }

    // --- MANAJEMEN ADMIN ---

    public function kelola_admin()
    {
        // Pastikan hanya admin yang bisa akses
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard-siswa');
        }

        $adminModel = new \App\Models\AdminModel();
        $data = [
            'admins' => $adminModel->findAll()
        ];

        return view('pages/admin/kelola_admin', $data);
    }

    public function simpan_admin()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back();
        }

        $adminModel = new \App\Models\AdminModel();
        
        // Validasi
        $username = $this->request->getPost('username');
        if($adminModel->where('username', $username)->first()){
             return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $username,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $adminModel->save($data);
        return redirect()->to('/admin/users')->with('success', 'Admin berhasil ditambahkan');
    }

    public function update_admin($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back();
        }

        $adminModel = new \App\Models\AdminModel();
        
        $data = [
            'id' => $id,
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username')
        ];

        // Cek password baru
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $adminModel->save($data);
        return redirect()->to('/admin/users')->with('success', 'Data admin berhasil diperbarui');
    }

    public function hapus_admin($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back();
        }

        $adminModel = new \App\Models\AdminModel();
        
        $adminModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'Admin berhasil dihapus');
    }
}
