<?php

namespace App\Http\Controllers;

use App\Models\AbsensiPanitia;
use App\Models\Panitia;
use App\Models\SesiPanitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AbsensiPanitiaController extends Controller
{
    /**
     * Tampilkan halaman KIOSK (menampilkan QR Code)
     */
    public function kiosk()
    {
        $sesiAktif = SesiPanitia::where('is_active', true)->first();

        // Generate token unik untuk sesi ini
        $token = $sesiAktif ? md5($sesiAktif->id . date('Y-m-d')) : null;

        return view('kiosk.index', compact('sesiAktif', 'token'));
    }

    /**
     * Tampilkan form absensi dari HP panitia
     */
    public function formHP($token)
    {
        // Validasi token
        $sesiAktif = SesiPanitia::where('is_active', true)->first();

        if (!$sesiAktif) {
            return view('kiosk.expired', ['message' => 'Tidak ada sesi aktif saat ini.']);
        }

        $validToken = md5($sesiAktif->id . date('Y-m-d'));

        if ($token !== $validToken) {
            return view('kiosk.expired', ['message' => 'QR Code sudah tidak valid. Silakan scan ulang.']);
        }

        return view('kiosk.form', compact('sesiAktif', 'token'));
    }

    /**
     * Cari panitia berdasarkan ID (untuk form HP)
     */
    public function cariPanitia($id_panitia)
    {
        $panitia = Panitia::where('id_panitia', $id_panitia)
                          ->where('is_active', true)
                          ->first();

        if ($panitia) {
            return response()->json([
                'found' => true,
                'nama' => $panitia->nama_lengkap,
                'jabatan' => $panitia->jabatan,
                'data' => $panitia,
            ]);
        }

        return response()->json([
            'found' => false,
            'message' => 'ID Panitia tidak ditemukan',
        ]);
    }

    /**
     * Submit absensi dari HP panitia
     */
    public function submitHP(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'id_panitia' => 'required|string|exists:panitia,id_panitia',
            'ttd' => 'required|string|min:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $id_panitia = $request->id_panitia;
            $ttdBase64 = $request->ttd;

            $panitia = Panitia::where('id_panitia', $id_panitia)
                              ->where('is_active', true)
                              ->first();
            if (!$panitia) {
                throw new \Exception('ID Panitia tidak ditemukan atau tidak aktif!');
            }

            $sesi = SesiPanitia::where('is_active', true)->first();
            if (!$sesi) {
                throw new \Exception('Tidak ada sesi aktif!');
            }

            $sudahAbsen = AbsensiPanitia::where('panitia_id', $panitia->id)
                                        ->where('sesi_id', $sesi->id)
                                        ->exists();
            if ($sudahAbsen) {
                throw new \Exception($panitia->nama_lengkap . ' sudah absen di sesi ini!');
            }

            $ttdPath = $this->saveTtdImage($ttdBase64, $id_panitia);
            $jamSekarang = now()->format('H:i:s');
            $status = $sesi->getStatus($jamSekarang);

            AbsensiPanitia::create([
                'panitia_id' => $panitia->id,
                'sesi_id' => $sesi->id,
                'jam_masuk' => $jamSekarang,
                'status' => $status,
                'keterangan' => 'Hadir',
                'ttd_image' => $ttdPath,
                'absen_manual' => false,
                'diabsensi_oleh' => null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Halo ' . $panitia->nama_lengkap . '! Absen berhasil. Status: ' . $status,
                'data' => [
                    'nama' => $panitia->nama_lengkap,
                    'jabatan' => $panitia->jabatan,
                    'status' => $status,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Proses absensi dari kiosk (TANPA STORED PROCEDURE)
     */
    public function kioskStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_panitia' => 'required|string|exists:panitia,id_panitia',
            'ttd' => 'required|string|min:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $id_panitia = $request->id_panitia;
            $ttdBase64 = $request->ttd;

            // Cari panitia
            $panitia = Panitia::where('id_panitia', $id_panitia)
                              ->where('is_active', true)
                              ->first();
            if (!$panitia) {
                throw new \Exception('ID Panitia tidak ditemukan atau tidak aktif!');
            }

            // Cari sesi aktif
            $sesi = SesiPanitia::where('is_active', true)->first();
            if (!$sesi) {
                throw new \Exception('Tidak ada sesi aktif!');
            }

            // Cek duplikat
            $sudahAbsen = AbsensiPanitia::where('panitia_id', $panitia->id)
                                        ->where('sesi_id', $sesi->id)
                                        ->exists();
            if ($sudahAbsen) {
                throw new \Exception($panitia->nama_lengkap . ' sudah absen di sesi ini!');
            }

            // Simpan TTD
            $ttdPath = $this->saveTtdImage($ttdBase64, $id_panitia);

            // Tentukan status
            $jamSekarang = now()->format('H:i:s');
            $status = $sesi->getStatus($jamSekarang);

            // Simpan absensi
            AbsensiPanitia::create([
                'panitia_id' => $panitia->id,
                'sesi_id' => $sesi->id,
                'jam_masuk' => $jamSekarang,
                'status' => $status,
                'keterangan' => 'Hadir',
                'ttd_image' => $ttdPath,
                'absen_manual' => false,
                'diabsensi_oleh' => null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Halo ' . $panitia->nama_lengkap . '! Absen berhasil. Status: ' . $status,
                'data' => [
                    'nama' => $panitia->nama_lengkap,
                    'jabatan' => $panitia->jabatan,
                    'status' => $status
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Simpan gambar TTD
     */
    private function saveTtdImage($base64, $id_panitia)
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $filename = 'ttd_' . $id_panitia . '_' . time() . '.png';
        $path = public_path('uploads/ttd/' . $filename);
        
        if (!file_exists(public_path('uploads/ttd'))) {
            mkdir(public_path('uploads/ttd'), 0755, true);
        }
        
        file_put_contents($path, $imageData);
        return 'uploads/ttd/' . $filename;
    }

    /**
     * Tampilkan riwayat absensi
     */
    public function log(Request $request)
    {
        $query = AbsensiPanitia::with(['panitia', 'sesi'])->orderBy('created_at', 'desc');

        if ($request->filled('sesi')) {
            $query->where('sesi_id', $request->sesi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('panitia', function($q) use ($search) {
                $q->where('id_panitia', 'like', "%$search%")
                  ->orWhere('nama_lengkap', 'like', "%$search%");
            });
        }

        $absensi = $query->paginate(20);
        $sesiList = SesiPanitia::all();

        return view('absensi.log', compact('absensi', 'sesiList'));
    }

    /**
     * Tampilkan absensi manual
     */
    public function manual()
    {
        $sesiAktif = SesiPanitia::where('is_active', true)->first();
        
        $query = Panitia::where('is_active', true);
        
        if ($sesiAktif) {
            $query->with(['absensi_manual' => function($q) use ($sesiAktif) {
                $q->where('sesi_id', $sesiAktif->id);
            }]);
        }

        $panitia = $query->orderBy('id_panitia')->paginate(20);

        $statistik = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpa' => 0];
        if ($sesiAktif) {
            $statistik['hadir'] = AbsensiPanitia::where('sesi_id', $sesiAktif->id)->where('keterangan', 'Hadir')->count();
            $statistik['sakit'] = AbsensiPanitia::where('sesi_id', $sesiAktif->id)->where('keterangan', 'Sakit')->count();
            $statistik['izin'] = AbsensiPanitia::where('sesi_id', $sesiAktif->id)->where('keterangan', 'Izin')->count();
            $statistik['alpa'] = AbsensiPanitia::where('sesi_id', $sesiAktif->id)->where('keterangan', 'Alpa')->count();
        }

        return view('absensi.manual', compact('panitia', 'sesiAktif', 'statistik'));
    }

    /**
     * Simpan absensi manual
     */
    public function manualStore(Request $request)
    {
        $request->validate([
            'changes' => 'required|array'
        ]);

        try {
            DB::beginTransaction();

            $sesiAktif = SesiPanitia::where('is_active', true)->first();
            if (!$sesiAktif) {
                throw new \Exception('Tidak ada sesi aktif!');
            }

            $adminName = Auth::user()->name ?? 'Admin';
            $saved = 0;

            foreach ($request->changes as $panitiaId => $keterangan) {
                $existing = AbsensiPanitia::where('panitia_id', $panitiaId)
                                          ->where('sesi_id', $sesiAktif->id)
                                          ->first();

                $jamSekarang = now()->format('H:i:s');
                $status = $sesiAktif->getStatus($jamSekarang);

                if ($existing) {
                    $existing->update([
                        'keterangan' => $keterangan,
                        'absen_manual' => true,
                        'diabsensi_oleh' => $adminName,
                        'jam_masuk' => $jamSekarang,
                        'status' => $status,
                    ]);
                } else {
                    $panitia = Panitia::find($panitiaId);
                    if (!$panitia) continue;
                    
                    AbsensiPanitia::create([
                        'panitia_id' => $panitiaId,
                        'sesi_id' => $sesiAktif->id,
                        'jam_masuk' => $jamSekarang,
                        'status' => $status,
                        'keterangan' => $keterangan,
                        'ttd_image' => 'manual_absensi',
                        'absen_manual' => true,
                        'diabsensi_oleh' => $adminName,
                    ]);
                }
                $saved++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menyimpan $saved data absensi manual!"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        $absensi = AbsensiPanitia::with(['panitia', 'sesi'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['No', 'ID Panitia', 'Nama', 'Jabatan', 'Sesi', 'Jam Masuk', 'Status', 'Keterangan', 'Absen Manual', 'Diabsensi Oleh'];
        foreach ($headers as $i => $header) {
            $col = chr(65 + $i);
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setARGB('FF1E3A8A');
            $sheet->getStyle($col . '1')->getFont()->getColor()->setARGB('FFFFFFFF');
        }

        foreach ($absensi as $i => $data) {
            $row = $i + 2;
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $data->panitia->id_panitia ?? '-');
            $sheet->setCellValue('C' . $row, $data->panitia->nama_lengkap ?? '-');
            $sheet->setCellValue('D' . $row, $data->panitia->jabatan ?? '-');
            $sheet->setCellValue('E' . $row, $data->sesi->nama_sesi ?? '-');
            $sheet->setCellValue('F' . $row, $data->jam_masuk ?? '-');
            $sheet->setCellValue('G' . $row, $data->status ?? '-');
            $sheet->setCellValue('H' . $row, $data->keterangan ?? '-');
            $sheet->setCellValue('I' . $row, $data->absen_manual ? 'Ya' : 'Tidak');
            $sheet->setCellValue('J' . $row, $data->diabsensi_oleh ?? '-');
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rekap_absensi_panitia_' . date('Y-m-d') . '.xlsx"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Export PDF
     */
    public function exportPdf()
    {
        $absensi = AbsensiPanitia::with(['panitia', 'sesi'])->get();
        $pdf = Pdf::loadView('absensi.pdf', compact('absensi'));
        return $pdf->download('rekap_absensi_panitia_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Get counter untuk kiosk
     */
    public function counter()
    {
        $today = now()->toDateString();
        $hadir = AbsensiPanitia::whereDate('created_at', $today)->count();
        $totalPanitia = Panitia::where('is_active', true)->count();

        return response()->json([
            'hadir' => $hadir,
            'total' => $totalPanitia,
        ]);
    }
}