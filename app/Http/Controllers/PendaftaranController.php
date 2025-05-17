<?php

namespace App\Http\Controllers;

use App\Models\CalonSantri;
use App\Models\PaymentInstallment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource for admin.
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
                    ->orWhere('nama_ibu', 'like', "%{$searchTerm}%")
                    ->orWhere('nomor_pendaftaran', 'like', "%{$searchTerm}%");
            });
        }

        // Handle status filter
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Handle payment type filter
        if ($request->has('payment_type') && $request->payment_type != 'all') {
            $query->where('payment_type', $request->payment_type);
        }

        // Paginate the results
        $calonsantri = $query->latest()->paginate(10);

        return view('pendaftaran.index', compact('calonsantri'));
    }

    /**
     * Display the front-end registration page
     */
    /**
     * Display the front-end registration page
     */
    public function halamandepan(Request $request)
    {
        // Get the current step from session or default to 'formulir'
        $currentStep = Session::get('current_step', 'formulir');

        // Get calon santri data from session if available
        $calonSantriData = null;
        $calonSantriId = Session::get('calon_santri_id');

        if ($calonSantriId) {
            $calonSantriData = CalonSantri::find($calonSantriId);

            // If we have data but the user is on the formulir step,
            // we should restore their progress to the appropriate step
            if ($currentStep === 'formulir' && $calonSantriData) {
                $currentStep = $calonSantriData->status;
                Session::put('current_step', $currentStep);
            }
        }

        return view('pendaftarandepan', compact('currentStep', 'calonSantriData'));
    }

    /**
     * Show the form for creating a new resource in admin panel.
     */
    public function create()
    {
        return view('pendaftaran.create');
    }

    /**
     * Store a newly created resource in storage.
     * This handles both admin creation and front-end form submission (step 1)
     */
    /**
     * Store a newly created resource in storage.
     * This handles both admin creation and front-end form submission (step 1)
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string',
                'nama_ayah' => 'required|string|max:255',
                'nama_ibu' => 'required|string|max:255',
                'no_whatsapp' => 'required|string|max:20',
                'asal_sekolah' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Create a new CalonSantri record
            $calonSantri = CalonSantri::create([
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'no_whatsapp' => $request->no_whatsapp,
                'asal_sekolah' => $request->asal_sekolah,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => 'formulir', // Set the status to "formulir" initially
            ]);

            // Store the calon santri ID in session to track progress
            Session::put('calon_santri_id', $calonSantri->id);
            Session::put('current_step', 'checking');

            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($calonSantri);
            }

            // If created by admin, redirect to admin index
            if ($request->has('admin_created')) {
                return redirect()->route('pendaftaran.index')->with('success', 'Pendaftar baru berhasil ditambahkan.');
            }

            // For regular form submission, redirect to the next step
            return redirect()->route('pendaftaran.checking');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in store method: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            // Return a proper error response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Process the checking data step (step 2)
     */
    public function checking(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'calon_santri_id' => 'required|exists:calon_santris,id',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator);
            }

            // Find the calon santri
            $calonSantri = CalonSantri::findOrFail($request->calon_santri_id);

            // Update status
            $calonSantri->status = 'checking';
            $calonSantri->save();

            // Update session
            Session::put('current_step', 'pembayaran');

            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($calonSantri);
            }

            // For regular form submission, redirect to the next step
            return redirect()->route('pendaftaran.pembayaran');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in checking method: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            // Return a proper error response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Terjadi kesalahan saat memproses data. Silakan coba lagi.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data. Silakan coba lagi.');
        }
    }

    /**
     * Process the payment step (step 3)
     */
    public function pembayaran(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'calon_santri_id' => 'required|exists:calon_santris,id',
                'payment_type' => 'required|in:Lunas,Cicilan',
                'payment_proof' => $request->has('admin_action') ? 'sometimes|image|max:5120' : 'required|image|max:5120',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator);
            }

            // Find the calon santri
            $calonSantri = CalonSantri::findOrFail($request->calon_santri_id);

            // Handle file upload
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = time() . '_' . $calonSantri->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payment_proofs', $filename, 'public');
                $calonSantri->payment_proof = $path;
            }

            // Generate registration number if not exists
            if (!$calonSantri->nomor_pendaftaran) {
                $calonSantri->nomor_pendaftaran = $calonSantri->generateNomorPendaftaran();
            }

            // Update status and payment type
            $calonSantri->status = 'berhasil';
            $calonSantri->payment_type = $request->payment_type;
            $calonSantri->save();

            // If payment type is Cicilan, automatically create the first installment of Rp. 600,000
            if ($request->payment_type === 'Cicilan') {
                // Create new payment installment record for the registration fee
                $installment = new PaymentInstallment();
                $installment->calon_santri_id = $calonSantri->id;
                $installment->installment_number = 1;
                $installment->amount = 1000000; // Rp. 1.000.000 for registration fee
                $installment->payment_date = now();
                $installment->payment_proof = $calonSantri->payment_proof; // Use the same proof uploaded for registration
                $installment->notes = 'Biaya pendaftaran awal';
                $installment->status = 'pending'; // Set status to pending (unverified)
                $installment->save();
            }

            // Update session
            Session::put('current_step', 'berhasil');

            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($calonSantri);
            }

            // If admin action, redirect to admin index
            if ($request->has('admin_action')) {
                return redirect()->route('pendaftaran.index')->with('success', 'Status pendaftar berhasil diubah menjadi Berhasil.');
            }

            // For regular form submission, redirect to the success page
            return redirect()->route('pendaftaran.berhasil')->with('calon_santri_id', $calonSantri->id);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in pembayaran method: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            // Return a proper error response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Display the success page (step 4)
     */
    public function berhasil()
    {
        $calonSantriId = Session::get('calon_santri_id');
        $calonSantri = CalonSantri::findOrFail($calonSantriId);

        return view('pendaftaran.berhasil', compact('calonSantri'));
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
            'no_whatsapp' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:formulir,checking,pembayaran,berhasil',
            'payment_type' => 'nullable|in:Lunas,Cicilan',
        ]);

        // Handle payment proof update if provided
        if ($request->hasFile('payment_proof')) {
            // Delete old file if exists
            if ($calonSantri->payment_proof) {
                Storage::disk('public')->delete($calonSantri->payment_proof);
            }

            $file = $request->file('payment_proof');
            $filename = time() . '_' . $calonSantri->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $calonSantri->payment_proof = $path;
        }

        // Generate registration number if not exists and status is berhasil
        if (!$calonSantri->nomor_pendaftaran && $validated['status'] === 'berhasil') {
            $calonSantri->nomor_pendaftaran = $this->generateNomorPendaftaran($calonSantri);
        }

        $calonSantri->update($validated);
        $calonSantri->save();

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

    /**
     * Generate a unique registration number
     */
    private function generateNomorPendaftaran($calonSantri)
    {
        $prefix = 'PSB-';
        $year = date('Y');
        $month = date('m');

        // Get the count of registrations in the current month
        $count = CalonSantri::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        // Format: PSB-YYYYMM-XXXX (XXXX is sequential number padded to 4 digits)
        return $prefix . $year . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function downloadPaymentProof(CalonSantri $calonSantri)
    {
        // Get the file path
        $path = storage_path('app/public/' . $calonSantri->payment_proof);

        // Check if file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Generate a filename for the download
        $filename = 'bukti_pembayaran_' . $calonSantri->registration_number . '.' . pathinfo($path, PATHINFO_EXTENSION);

        // Return the file as a download
        return response()->download($path, $filename);
    }

    /**
     * Track registration status by registration number
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trackPendaftaran(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string',
        ]);

        $nomorPendaftaran = $request->nomor_pendaftaran;

        // Find the calon santri directly by nomor_pendaftaran
        $calonSantri = CalonSantri::where('nomor_pendaftaran', $nomorPendaftaran)->first();

        if (!$calonSantri) {
            return response()->json(['error' => 'Nomor pendaftaran tidak ditemukan.'], 404);
        }

        // Get payment history if applicable
        $paymentHistory = [];
        if ($calonSantri->payment_type == 'Cicilan') {
            $paymentHistory = PaymentInstallment::where('calon_santri_id', $calonSantri->id)
                ->orderBy('installment_number', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'installment_number' => $item->installment_number,
                        'payment_date' => date('d-m-Y', strtotime($item->payment_date)),
                        'amount' => number_format($item->amount, 0, ',', '.'),
                        'status' => $item->status
                    ];
                });
        }

        // Calculate total paid and remaining amount for cicilan
        $totalPaid = 0;
        $remainingAmount = 9600000; // Total biaya administrasi

        if ($calonSantri->payment_type == 'Cicilan') {
            $totalPaid = PaymentInstallment::where('calon_santri_id', $calonSantri->id)
                ->where('status', 'verified')
                ->sum('amount');
            $remainingAmount = max(0, $remainingAmount - $totalPaid);
        } else if ($calonSantri->payment_type == 'Lunas') {
            $totalPaid = 9600000;
            $remainingAmount = 0;
        }

        return response()->json([
            'id' => $calonSantri->id,
            'nomor_pendaftaran' => $calonSantri->nomor_pendaftaran,
            'nama' => $calonSantri->nama,
            'status' => $calonSantri->status,
            'payment_type' => $calonSantri->payment_type,
            'total_paid' => number_format($totalPaid, 0, ',', '.'),
            'remaining_amount' => number_format($remainingAmount, 0, ',', '.'),
            'payment_history' => $paymentHistory
        ]);
    }

    /**
     * Upload installment payment proof.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalonSantri  $calonSantri
     * @return \Illuminate\Http\Response
     */
    public function uploadInstallment(Request $request, CalonSantri $calonSantri): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'installment_amount' => 'required|numeric|min:1',
            'installment_proof' => 'required|image|max:5120', // 5MB max
            'installment_date' => 'required|date',
            'installment_notes' => 'nullable|string|max:500',
        ]);

        // Check if the calon santri exists and has payment type 'Cicilan'
        if (!$calonSantri || $calonSantri->payment_type != 'Cicilan') {
            return redirect()->back()->with('error', 'Pembayaran cicilan hanya tersedia untuk pendaftar dengan jenis pembayaran cicilan.');
        }

        // Get the next installment number
        $lastInstallment = PaymentInstallment::where('calon_santri_id', $calonSantri->id)
            ->orderBy('installment_number', 'desc')
            ->first();

        $installmentNumber = $lastInstallment ? $lastInstallment->installment_number + 1 : 1;

        // Store the payment proof
        $proofPath = $request->file('installment_proof')->store('payment_proofs', 'public');

        // Create new payment installment record
        $installment = new PaymentInstallment();
        $installment->calon_santri_id = $calonSantri->id;
        $installment->installment_number = $installmentNumber;
        $installment->amount = $request->installment_amount;
        $installment->payment_date = $request->installment_date;
        $installment->payment_proof = $proofPath;
        $installment->notes = $request->installment_notes;
        $installment->status = 'pending'; // Default status is pending until verified
        $installment->save();

        // Update the calon santri record
        $calonSantri->status = 'pembayaran';
        $calonSantri->save();

        return redirect()->route('pendaftaran.show', $calonSantri->id)
            ->with('success', 'Bukti pembayaran cicilan berhasil diunggah dan sedang menunggu verifikasi.');
    }
    /**
     * Upload installment payment proof for unauthenticated users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadInstallmentPublic(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
            'installment_amount' => 'required|numeric|min:1',
            'installment_proof' => 'required|image|max:5120', // 5MB max
            'installment_date' => 'required|date',
            'installment_notes' => 'nullable|string|max:500',
        ]);

        // Find the calon santri by registration number
        $calonSantri = CalonSantri::where('registration_number', $request->registration_number)
            ->orWhere(function ($query) use ($request) {
                // Also check for default registration number format
                if (preg_match('/REG-(\d+)/', $request->registration_number, $matches)) {
                    $id = (int) $matches[1];
                    $query->where('id', $id);
                }
            })
            ->first();

        if (!$calonSantri) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor pendaftaran tidak ditemukan.'
            ], 404);
        }

        // Check if the calon santri has payment type 'Cicilan'
        if ($calonSantri->payment_type != 'Cicilan') {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran cicilan hanya tersedia untuk pendaftar dengan jenis pembayaran cicilan.'
            ], 400);
        }

        // Get the next installment number
        $lastInstallment = PaymentInstallment::where('calon_santri_id', $calonSantri->id)
            ->orderBy('installment_number', 'desc')
            ->first();

        $installmentNumber = $lastInstallment ? $lastInstallment->installment_number + 1 : 1;

        // Store the payment proof
        $proofPath = $request->file('installment_proof')->store('payment_proofs', 'public');

        // Create new payment installment record
        $installment = new PaymentInstallment();
        $installment->calon_santri_id = $calonSantri->id;
        $installment->installment_number = $installmentNumber;
        $installment->amount = $request->installment_amount;
        $installment->payment_date = $request->installment_date;
        $installment->payment_proof = $proofPath;
        $installment->notes = $request->installment_notes;
        $installment->status = 'pending'; // Default status is pending until verified
        $installment->save();

        // Update the calon santri record
        $calonSantri->status = 'pembayaran';
        $calonSantri->save();

        // Send notification to admin (optional)
        // You can implement this using Laravel notifications

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran cicilan berhasil diunggah dan sedang menunggu verifikasi.',
            'installment' => [
                'id' => $installment->id,
                'installment_number' => $installment->installment_number,
                'amount' => $installment->amount,
                'payment_date' => $installment->payment_date,
                'status' => $installment->status
            ]
        ]);
    }
    /**
     * View installment payments for a calon santri
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function viewInstallments($id)
    {
        $calonSantri = CalonSantri::findOrFail($id);
        $installments = PaymentInstallment::where('calon_santri_id', $id)
            ->orderBy('installment_number', 'asc')
            ->get();

        // Calculate total paid and remaining amount
        $totalPaid = $installments->where('status', 'verified')->sum('amount');
        $totalAmount = 9600000; // Total biaya administrasi
        $remainingAmount = max(0, $totalAmount - $totalPaid);

        return view('pendaftaran.installments', compact('calonSantri', 'installments', 'totalPaid', 'remainingAmount', 'totalAmount'));
    }

    /**
     * Verify an installment payment
     *
     * @param \Illuminate\Http\Request $request
     * @param int $installmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyInstallment(Request $request, $installmentId)
    {
        $installment = PaymentInstallment::findOrFail($installmentId);
        $installment->status = 'verified';
        $installment->verified_by = auth()->id();
        $installment->verified_at = now();
        $installment->save();

        // Check if all payments are complete
        $calonSantri = CalonSantri::findOrFail($installment->calon_santri_id);
        $totalPaid = PaymentInstallment::where('calon_santri_id', $calonSantri->id)
            ->where('status', 'verified')
            ->sum('amount');

        // If total paid equals or exceeds the required amount, mark as complete
        if ($totalPaid >= 9600000) {
            $calonSantri->status = 'Selesai';
            $calonSantri->save();
        }

        return redirect()->route('pendaftaran.viewInstallments', $installment->calon_santri_id)
            ->with('success', 'Pembayaran cicilan berhasil diverifikasi.');
    }
    public function updateSession(Request $request)
    {
        if ($request->has('current_step')) {
            Session::put('current_step', $request->current_step);
        }

        return response()->json(['success' => true]);
    }

    public function resetPendaftaran()
    {
        // Clear all session data related to registration
        Session::forget('calon_santri_id');
        Session::forget('current_step');
        // Redirect to the registration form
        return redirect()->route('pendaftaran.halamandepan')->with('success', 'Pendaftaran baru telah dimulai.');
    }
}
