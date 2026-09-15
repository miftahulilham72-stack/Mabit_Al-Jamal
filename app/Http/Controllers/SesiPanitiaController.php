<?php

namespace App\Http\Controllers;

use App\Models\SesiPanitia;
use App\Models\AbsensiPanitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SesiPanitiaController extends Controller
{
    /**
     * Tampilkan daftar sesi
     */
    public function index()
    {
        $sesi = SesiPanitia::orderBy('jam_mulai')->get();
        $sesiAktif = SesiPanitia::where('is_active', true)->first();
        return view('sesi.index', compact('sesi', 'sesiAktif'));
    }

    /**
     * Simpan sesi baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sesi' => 'required|string|max:100',
            'tipe_sesi' => 'required|in:Kehadiran Awal,Perkegiatan,Penutupan',
            'jam_mulai' => 'required|date_format:H:i',
            'batas_waktu' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        SesiPanitia::create([
            'nama_sesi' => $request->nama_sesi,
            'tipe_sesi' => $request->tipe_sesi,
            'jam_mulai' => $request->jam_mulai . ':00',
            'batas_waktu' => $request->batas_waktu . ':00',
            'is_active' => false,
        ]);

        return back()->with('success', 'Sesi berhasil ditambahkan!');
    }

    /**
     * Update sesi
     */
    public function update(Request $request, $id)
    {
        $sesi = SesiPanitia::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_sesi' => 'required|string|max:100',
            'tipe_sesi' => 'required|in:Kehadiran Awal,Perkegiatan,Penutupan',
            'jam_mulai' => 'required|date_format:H:i',
            'batas_waktu' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $sesi->update([
            'nama_sesi' => $request->nama_sesi,
            'tipe_sesi' => $request->tipe_sesi,
            'jam_mulai' => $request->jam_mulai . ':00',
            'batas_waktu' => $request->batas_waktu . ':00',
        ]);

        return response()->json(['success' => true, 'message' => 'Sesi berhasil diupdate!']);
    }

    /**
     * Hapus sesi
     */
    public function destroy($id)
    {
        $sesi = SesiPanitia::findOrFail($id);
        
        if ($sesi->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus sesi yang sedang aktif!'
            ], 400);
        }

        $sesi->delete();

        return response()->json(['success' => true, 'message' => 'Sesi berhasil dihapus!']);
    }

    /**
     * Hapus sesi dengan konfirmasi password admin
     */
    public function hapusDenganPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Password harus diisi!',
            ], 422);
        }

        $user = Auth::user();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah!',
            ], 422);
        }

        $sesi = SesiPanitia::findOrFail($id);

        if ($sesi->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus sesi yang sedang aktif! Nonaktifkan terlebih dahulu.',
            ], 400);
        }

        try {
            DB::transaction(function () use ($sesi) {
                AbsensiPanitia::where('sesi_id', $sesi->id)->delete();
                $sesi->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Sesi "' . $sesi->nama_sesi . '" berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle aktif/nonaktif sesi
     */
    public function toggleActive($id)
    {
        $sesi = SesiPanitia::findOrFail($id);
        
        // Nonaktifkan semua sesi lain
        if (!$sesi->is_active) {
            SesiPanitia::where('is_active', true)->update(['is_active' => false]);
        }
        
        $sesi->is_active = !$sesi->is_active;
        $sesi->save();

        $status = $sesi->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'success' => true,
            'message' => "Sesi {$sesi->nama_sesi} berhasil $status!",
            'is_active' => $sesi->is_active
        ]);
    }
}