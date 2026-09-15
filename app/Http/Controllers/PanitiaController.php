<?php

namespace App\Http\Controllers;

use App\Models\Panitia;
use App\Models\AbsensiPanitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PanitiaController extends Controller
{
    /**
     * Tampilkan daftar panitia
     */
    public function index(Request $request)
    {
        $query = Panitia::query();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id_panitia', 'like', "%$search%")
                  ->orWhere('nama_lengkap', 'like', "%$search%")
                  ->orWhere('jabatan', 'like', "%$search%");
            });
        }

        // Response JSON untuk AJAX search
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'panitia' => $query->limit(10)->get(),
            ]);
        }
        
        $panitia = $query->orderBy('id_panitia')->paginate(15);
        $total = Panitia::count();
        
        return view('panitia.index', compact('panitia', 'total'));
    }

    /**
     * Simpan panitia baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_panitia' => 'required|string|unique:panitia,id_panitia|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'no_telepon' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $panitia = Panitia::create([
            'id_panitia' => $request->id_panitia,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'no_telepon' => $request->no_telepon,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Panitia berhasil ditambahkan!',
            'data' => $panitia
        ]);
    }

    /**
     * Tampilkan data panitia untuk edit (JSON)
     */
    public function edit($id)
    {
        $panitia = Panitia::findOrFail($id);
        return response()->json($panitia);
    }

    /**
     * Update panitia
     */
    public function update(Request $request, $id)
    {
        $panitia = Panitia::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_panitia' => 'required|string|max:20|unique:panitia,id_panitia,' . $id,
            'nama_lengkap' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'no_telepon' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $panitia->update([
            'id_panitia' => $request->id_panitia,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'no_telepon' => $request->no_telepon,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data panitia berhasil diupdate!',
            'data' => $panitia
        ]);
    }

    /**
     * Hapus panitia
     */
    public function destroy($id)
    {
        try {
            $panitia = Panitia::findOrFail($id);
            
            // Hapus absensi terkait
            AbsensiPanitia::where('panitia_id', $id)->delete();
            
            $panitia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Panitia berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cari panitia berdasarkan ID (untuk kiosk)
     */
    public function cari($id_panitia)
    {
        $panitia = Panitia::where('id_panitia', $id_panitia)
                          ->where('is_active', true)
                          ->first();
        
        if ($panitia) {
            return response()->json([
                'found' => true,
                'nama' => $panitia->nama_lengkap,
                'jabatan' => $panitia->jabatan,
                'data' => $panitia
            ]);
        }

        return response()->json([
            'found' => false,
            'message' => 'ID Panitia tidak ditemukan'
        ]);
    }

    /**
     * Toggle status aktif panitia
     */
    public function toggleActive($id)
    {
        $panitia = Panitia::findOrFail($id);
        $panitia->is_active = !$panitia->is_active;
        $panitia->save();

        $status = $panitia->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'success' => true,
            'message' => "Panitia {$panitia->nama_lengkap} berhasil $status!",
            'is_active' => $panitia->is_active
        ]);
    }
}