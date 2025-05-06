<?php

namespace App\Http\Controllers;

use App\Models\CalonSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CalonSantri::query();

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                    ->orWhere('no_whatsapp', 'like', "%{$searchTerm}%")
                    ->orWhere('asal_sekolah', 'like', "%{$searchTerm}%")
                    ->orWhere('nama_ayah', 'like', "%{$searchTerm}%")
                    ->orWhere('nama_ibu', 'like', "%{$searchTerm}%");
            });
        }

        // Handle status filter
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Paginate the results
        $calonsantri = $query->latest()->paginate(10);

        return view('pendaftaran.index', compact('calonsantri'));
    }

    public function halamandepan()
    {
        return view('pendaftarandepan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pendaftaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        // Create a new CalonSantri record (store personal info)
        $calonSantri = CalonSantri::create([
            'nama' => $validated['nama'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'nama_ayah' => $validated['nama_ayah'],
            'nama_ibu' => $validated['nama_ibu'],
            'no_whatsapp' => $validated['no_whatsapp'],
            'asal_sekolah' => $validated['asal_sekolah'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'status' => 'Formulir', // Set the status to "Formulir" initially
        ]);

        // Store the calon santri ID in session to track progress
        session(['calon_santri_id' => $calonSantri->id]);

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($calonSantri);
        }

        if ($request->has('admin_created')) {
            return redirect()->route('pendaftaran.index')->with('success', 'Pendaftar baru berhasil ditambahkan.');
        }

        return redirect()->route('pendaftaran.verifikasi'); // Redirect for non-AJAX requests
    }

    public function verifikasi()
    {
        $calonSantriId = session('calon_santri_id');
        $calonSantri = CalonSantri::findOrFail($calonSantriId);

        return view('pendaftaran.verifikasi', compact('calonSantri'));
    }

    /**
     * Store the verification data (step 2).
     * MODIFIED: Keep status as "Formulir" and don't update verified_by fields
     */
    public function storeVerifikasi(Request $request)
    {
        // Get calon santri ID from request or session
        $calonSantriId = $request->input('calon_santri_id', session('calon_santri_id'));
        $calonSantri = CalonSantri::findOrFail($calonSantriId);

        // Status remains "Formulir" - no change to status here
        // Removed the verified_by logic from here

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($calonSantri);
        }

        if ($request->has('admin_action')) {
            return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftar berhasil diverifikasi.');
        }

        return redirect()->route('pendaftaran.pembayaran'); // Redirect for non-AJAX requests
    }

    /**
     * Show the payment form (step 3).
     */
    public function pembayaran()
    {
        $calonSantriId = session('calon_santri_id');
        $calonSantri = CalonSantri::findOrFail($calonSantriId);

        return view('pendaftaran.pembayaran', compact('calonSantri'));
    }

    /**
     * Store the payment proof (step 3).
     * MODIFIED: Change status to "Pembayaran" after payment proof is uploaded
     */
    public function storePembayaran(Request $request)
    {
        // Validate the request
        $request->validate([
            'payment_proof' => $request->has('admin_action') ? 'sometimes|image|max:5120' : 'required|image|max:5120', // 5MB max
            'calon_santri_id' => 'sometimes|exists:calon_santris,id'
        ]);

        // Get calon santri ID from request or session
        $calonSantriId = $request->input('calon_santri_id', session('calon_santri_id'));
        $calonSantri = CalonSantri::findOrFail($calonSantriId);

        // Store payment proof
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $calonSantri->payment_proof = $path;
        }

        // Update the status to "Pembayaran" and save
        $calonSantri->status = 'Pembayaran';
        $calonSantri->save();

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($calonSantri);
        }

        if ($request->has('admin_action')) {
            return redirect()->route('pendaftaran.index')->with('success', 'Status pendaftar berhasil diubah menjadi Pembayaran.');
        }

        return redirect()->route('pendaftaran.selesai'); // Redirect for non-AJAX requests
    }

    /**
     * Display the completion page (step 4).
     * MODIFIED: Update status to "Selesai" and set verified_by fields when admin completes the registration
     */
    public function selesai(Request $request, $id = null)
    {
        if ($id) {
            $calonSantri = CalonSantri::findOrFail($id);
        } else {
            $calonSantriId = session('calon_santri_id');
            $calonSantri = CalonSantri::findOrFail($calonSantriId);
        }

        // Mark the registration as completed
        $calonSantri->status = 'Selesai';

        // Set verified_by fields only when an admin completes the registration
        if (auth()->check() && $request->has('admin_action')) {
            $calonSantri->verified_by_id = auth()->id();
            $calonSantri->verified_by_name = auth()->user()->name;
        }

        $calonSantri->save();

        if ($request->has('admin_action')) {
            return redirect()->route('pendaftaran.index')->with('success', 'Status pendaftar berhasil diubah menjadi Selesai dan telah diverifikasi.');
        }

        return view('pendaftaran.selesai', compact('calonSantri'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calonSantri = CalonSantri::findOrFail($id);
        return view('pendaftaran.show', compact('calonSantri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $calonSantri = CalonSantri::findOrFail($id);
        return view('pendaftaran.edit', compact('calonSantri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $calonSantri = CalonSantri::findOrFail($id);

        // Validate the form data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:Formulir,Verifikasi,Pembayaran,Selesai',
        ]);

        $calonSantri->update($validated);

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calonSantri = CalonSantri::findOrFail($id);

        // Delete payment proof file if exists
        if ($calonSantri->payment_proof) {
            Storage::disk('public')->delete($calonSantri->payment_proof);
        }

        $calonSantri->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }

    /**
     * View payment proof
     */
    public function viewPaymentProof(string $id)
    {
        $calonSantri = CalonSantri::findOrFail($id);

        if (!$calonSantri->payment_proof) {
            return redirect()->route('pendaftaran.index')->with('error', 'Bukti pembayaran tidak ditemukan.');
        }

        return view('pendaftaran.payment-proof', compact('calonSantri'));
    }
}
