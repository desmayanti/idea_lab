<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Idea;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Rating;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Pengguna Awal (Admin, Kelompok KIK, Responden)
        User::firstOrCreate(
            ['email' => 'admin@idealab.id'],
            [
                'name' => 'Administrator IDEA LAB',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'kelompok@idealab.id'],
            [
                'name' => 'Tim Pengembang XI PPLG 2',
                'role' => 'kelompok',
                'password' => Hash::make('kelompok123'),
            ]
        );

        // 2. Buat Survei Induk
        $survey = Survey::firstOrCreate(
            ['title' => 'Survei Validasi 10 Ide E-Commerce KYOTO STORE'],
            [
                'period_start' => now()->startOfMonth(),
                'period_end' => now()->addMonth(),
                'is_open' => true,
                'quadrant_threshold' => 4.00,
            ]
        );

        // 3. 10 Ide Wajib Sesuai Dokumen KIK Bab III
        $ideas = [
            [
                'code' => 'IDE-01',
                'title' => 'Dasbor Terpadu Kelola Stok Lintas Aplikasi',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Stok sering selisih antara marketplace berbeda saat flash sale.',
                'description' => 'Sinkronisasi stok otomatis real-time di berbagai marketplace dalam satu layar kendali.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-02',
                'title' => 'Rekomendasi Ukuran Otomatis Berbasis Postur',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Pembeli sering salah pilih ukuran pakaian karena size chart membingungkan.',
                'description' => 'Kalkulator AI pintar yang mencocokkan tinggi dan berat badan pembeli dengan potongan baju.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-03',
                'title' => 'Ulasan Video Singkat Pemakaian Asli 10 Detik',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Foto katalog terlihat bagus tetapi jatuhnya bahan saat dipakai tidak terlihat jelas.',
                'description' => 'Fitur galeri video 10 detik dari pembeli asli yang menampilkan tekstur dan gerak kain.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-04',
                'title' => 'Pratinjau Warna Asli Kain Berbagai Cahaya',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Warna baju yang datang sering berbeda dengan foto studio karena efek lighting.',
                'description' => 'Simulasi warna produk di bawah lampu ruangan (indoor), cahaya matahari (outdoor), dan lampu kuning.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-05',
                'title' => 'Bot Otomatis Konfirmasi Bayar di Tempat',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Tingginya angka gagal kirim (retur) pada pesanan COD karena pembeli tidak bisa dihubungi.',
                'description' => 'Bot WhatsApp otomatis untuk memvalidasi keseriusan dan alamat pembeli sebelum paket dikirim.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-06',
                'title' => 'Formulir Tukar Ukuran Mandiri Tanpa Perdebatan',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Proses komplain dan retur ukuran memakan waktu lama di ruang chat admin.',
                'description' => 'Portal klaim tukar ukuran mandiri terstruktur dengan validasi resi dan stok pengganti otomatis.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-07',
                'title' => 'Rekaman Kamera Kemas sebagai Bukti Kualitas',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Sengketa barang kurang atau cacat tanpa bukti valid dari gudang penjual.',
                'description' => 'Perekaman otomatis saat scan barcode resi pengemasan yang terhubung ke halaman lacak pembeli.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-08',
                'title' => 'Etalase Web Mandiri Bebas Potongan Komisi',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Biaya admin platform marketplace yang semakin tinggi menggerus margin keuntungan.',
                'description' => 'Micro-website katalog instan terintegrasi payment gateway dan hitung ongkir otomatis.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-09',
                'title' => 'Skor Reputasi Riwayat Bayar di Tempat',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Penjual tidak tahu apakah akun pembeli punya riwayat sering menolak paket COD.',
                'description' => 'Sistem pengecekan skor kredit/reputasi penerimaan paket COD lintas toko e-commerce.',
                'status' => 'active',
            ],
            [
                'code' => 'IDE-10',
                'title' => 'Kirim Dua Ukuran Sekaligus, Bayar Satu yang Pas',
                'target_user' => 'KYOTO STORE',
                'problem_solved' => 'Keraguan ekstrem saat berada di antara dua ukuran (misal M atau L).',
                'description' => 'Layanan pengiriman 2 ukuran untuk dicoba di tempat bersama kurir dan hanya membayar yang cocok.',
                'status' => 'active',
            ],
        ];

        // Sampel nilai awal agar ke-4 kuadran terwakili secara akurat sesuai Bab V Laporan
        $sampleScores = [
            1 => [[5, 5], [4, 5], [5, 4]], // Prioritas Utama (Feasibility 4.67, Impact 4.67)
            2 => [[4, 5], [5, 5], [4, 4]], // Prioritas Utama (Feasibility 4.33, Impact 4.67)
            3 => [[5, 4], [4, 4], [4, 5]], // Prioritas Utama (Feasibility 4.33, Impact 4.33)
            4 => [[3, 4], [3, 5], [2, 4]], // Potensi (Feasibility 2.67, Impact 4.33)
            5 => [[5, 5], [5, 5], [4, 5]], // Prioritas Utama - Peringkat #1 (Feasibility 4.67, Impact 5.00)
            6 => [[4, 3], [5, 3], [4, 2]], // Pertimbangkan (Feasibility 4.33, Impact 2.67)
            7 => [[3, 5], [3, 4], [4, 4]], // Potensi (Feasibility 3.33, Impact 4.33)
            8 => [[4, 3], [4, 4], [4, 2]], // Pertimbangkan (Feasibility 4.00, Impact 3.00)
            9 => [[2, 4], [3, 5], [3, 4]], // Potensi (Feasibility 2.67, Impact 4.33)
            10 => [[2, 3], [1, 2], [3, 3]], // Tunda (Feasibility 2.00, Impact 2.67)
        ];

        $respondents = ['Billy Tristan Pradipta', 'M. Yusuf Al Akil', 'Indriyanti'];

        // Buat data SurveyResponse untuk ketiga responden awal
        $responseMap = [];
        foreach ($respondents as $rName) {
            $surveyResponse = SurveyResponse::create([
                'survey_id' => $survey->id,
                'respondent_name' => $rName,
                'respondent_class' => 'XI PPLG 2',
                'submitted_at' => now()->subHours(rand(1, 48)),
            ]);
            $responseMap[$rName] = $surveyResponse->id;
        }

        foreach ($ideas as $index => $ideaData) {
            $idea = Idea::create($ideaData);
            $ideaNum = $index + 1;

            foreach ($sampleScores[$ideaNum] as $rIndex => $scores) {
                $rName = $respondents[$rIndex];
                Rating::create([
                    'idea_id' => $idea->id,
                    'survey_response_id' => $responseMap[$rName],
                    'respondent_name' => $rName,
                    'respondent_class' => 'XI PPLG 2',
                    'feasibility' => $scores[0],
                    'impact' => $scores[1],
                    'comment' => 'Validasi awal pengujian sistem IDEA LAB untuk ' . $idea->code . '.'
                ]);
            }
        }

        // Catat Log Aktivitas Awal
        ActivityLog::create([
            'user_name' => 'System Seeder',
            'action' => 'Inisialisasi Sistem',
            'description' => 'Berhasil memuat 10 ide solusi digital e-commerce dan data survei sampel 3 responden.',
        ]);
    }
}
