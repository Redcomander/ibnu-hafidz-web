<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Exports\StudentExport;
use App\Exports\StudentsTemplateExport;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     */
    public function index(Request $request)
    {
        // Your existing code to fetch students with filters
        $students = Student::query();

        // Apply filters if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $students->where(function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Only apply filters for columns that exist in the database
        if ($request->filled('agama')) {
            $students->where('agama', $request->agama);
        }

        if ($request->filled('jenis_kelamin')) {
            $students->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('status_santri')) {
            $students->where('status_santri', $request->status_santri);
        }

        // Get year from tanggal_masuk_pondok if that's what you're filtering by
        if ($request->filled('tahun_masuk')) {
            $students->whereYear('tanggal_masuk_pondok', $request->tahun_masuk);
        }

        $students = $students->paginate(15);

        // Calculate stats
        $totalStudents = Student::count();
        $newStudents = Student::where('created_at', '>=', now()->subDays(30))->count();

        // Calculate last month's stats for comparison
        $lastMonthTotal = Student::where('created_at', '<', now()->subDays(30))->count();
        $lastMonthNew = Student::whereBetween('created_at', [
            now()->subDays(60),
            now()->subDays(30)
        ])->count();

        // Other stats - using only columns that exist in the database
        $maleStudents = Student::where('jenis_kelamin', 'Laki-laki')->count();
        $femaleStudents = Student::where('jenis_kelamin', 'Perempuan')->count();

        // Status counts based on status_santri which exists in the database
        $baruStudents = Student::where('status_santri', 'Baru')->count();
        $pindahanStudents = Student::where('status_santri', 'Pindahan')->count();
        $otherStudents = Student::where('status_santri', 'Lain-lain')->count();

        // For backward compatibility with the view, map these to the variables it expects
        $activeStudents = $baruStudents;
        $pendingStudents = $pindahanStudents;
        $inactiveStudents = $otherStudents;

        // Target and progress
        $targetStudents = 1000; // Set your target

        // Calculate profile completion percentage based on required fields
        $completeProfiles = Student::whereNotNull('nama_lengkap')
            ->whereNotNull('nis')
            ->whereNotNull('nisn')
            ->whereNotNull('jenis_kelamin')
            ->whereNotNull('tanggal_lahir')
            ->whereNotNull('tempat_lahir')
            ->whereNotNull('alamat')
            ->whereNotNull('no_hp_telpon')
            ->whereNotNull('email')
            ->count();

        $newStudentProgress = $totalStudents > 0 ? round(($completeProfiles / $totalStudents) * 100) : 0;

        // Get filter options - only for columns that exist
        $agamaOptions = Student::distinct()->pluck('agama')->filter()->toArray();
        $statusSantriOptions = ['Baru', 'Pindahan', 'Lain-lain']; // These are the enum values from the migration

        // Extract years from tanggal_masuk_pondok for the tahun_masuk filter
        $tahunMasukOptions = Student::whereNotNull('tanggal_masuk_pondok')
            ->selectRaw('YEAR(tanggal_masuk_pondok) as tahun_masuk')
            ->distinct()
            ->pluck('tahun_masuk')
            ->filter()
            ->toArray();

        // For backward compatibility with the view
        $statusOptions = $statusSantriOptions;
        $jurusanOptions = [];

        return view('students.index', compact(
            'students',
            'totalStudents',
            'newStudents',
            'lastMonthTotal',
            'lastMonthNew',
            'maleStudents',
            'femaleStudents',
            'activeStudents',
            'pendingStudents',
            'inactiveStudents',
            'targetStudents',
            'newStudentProgress',
            'agamaOptions',
            'statusOptions',
            'statusSantriOptions',
            'tahunMasukOptions',
            'jurusanOptions'
        ));
    }

    /**
     * Show the form for creating a new student.
     *
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in storage.
     *
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'nullable|string|max:50',
            'nis' => 'required|string|max:50|unique:students',
            'nisn' => 'required|string|max:50|unique:students',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'no_kk' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_akte' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'nik_ayah' => 'nullable|string|max:50',
            'tahun_lahir_ayah' => 'nullable|integer',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'tahun_lulus_ayah' => 'nullable|integer',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|max:50',
            'tahun_lahir_ibu' => 'nullable|integer',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'tahun_lulus_ibu' => 'nullable|integer',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_telpon' => 'nullable|string|max:20',
            'sekolah_asal' => 'nullable|string|max:255',
            'tahun_kelulusan' => 'nullable|integer',
            'no_peserta_un' => 'nullable|string|max:100',
            'no_seri_ijazah' => 'nullable|string|max:100',
            'no_skhun' => 'nullable|string|max:100',
            'status_santri' => 'nullable|string|in:Baru,Pindahan,Lain-lain',
            'status_santri_other' => 'nullable|string|max:100',
            'tanggal_masuk_pondok' => 'nullable|date',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'anak_ke' => 'nullable|integer',
            'jumlah_anak' => 'nullable|integer',
            'status_anak' => 'nullable|string|max:100',
            'no_kks' => 'nullable|string|max:100',
            'penerima_kps' => 'nullable|in:Ya,Tidak',
            'no_kps' => 'nullable|string|max:100',
            'no_kip' => 'nullable|string|max:100',
            'nama_di_kip' => 'nullable|string|max:255',
            'terima_fisik' => 'nullable|in:Ya,Tidak',
            'kartu_jaminan' => 'nullable|string|in:KIS,BPJS,Jamkesmas,Jamkesda',
            'email' => 'nullable|email|max:255',
            'jenis_pendaftaran' => 'nullable|string|max:100',
            'ket' => 'nullable|string',
            'anbk' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Student::create($request->all());

        return redirect()->route('student.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified student.
     *
     */
    public function show(Student $student, Request $request)
    {
        if ($request->wantsJson() || $request->has('modal')) {
            return response()->json([
                'student' => $student
            ]);
        }

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     *
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     *
     */
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'nullable|string|max:50',
            'nis' => 'required|string|max:50|unique:students,nis,' . $student->id,
            'nisn' => 'required|string|max:50|unique:students,nisn,' . $student->id,
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'no_kk' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_akte' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'nik_ayah' => 'nullable|string|max:50',
            'tahun_lahir_ayah' => 'nullable|integer',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'tahun_lulus_ayah' => 'nullable|integer',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|max:50',
            'tahun_lahir_ibu' => 'nullable|integer',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'tahun_lulus_ibu' => 'nullable|integer',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_telpon' => 'nullable|string|max:20',
            'sekolah_asal' => 'nullable|string|max:255',
            'tahun_kelulusan' => 'nullable|integer',
            'no_peserta_un' => 'nullable|string|max:100',
            'no_seri_ijazah' => 'nullable|string|max:100',
            'no_skhun' => 'nullable|string|max:100',
            'status_santri' => 'nullable|string|in:Baru,Pindahan,Lain-lain',
            'status_santri_other' => 'nullable|string|max:100',
            'tanggal_masuk_pondok' => 'nullable|date',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'anak_ke' => 'nullable|integer',
            'jumlah_anak' => 'nullable|integer',
            'status_anak' => 'nullable|string|max:100',
            'no_kks' => 'nullable|string|max:100',
            'penerima_kps' => 'nullable|in:Ya,Tidak',
            'no_kps' => 'nullable|string|max:100',
            'no_kip' => 'nullable|string|max:100',
            'nama_di_kip' => 'nullable|string|max:255',
            'terima_fisik' => 'nullable|in:Ya,Tidak',
            'kartu_jaminan' => 'nullable|string|in:KIS,BPJS,Jamkesmas,Jamkesda',
            'email' => 'nullable|email|max:255',
            'jenis_pendaftaran' => 'nullable|string|max:100',
            'ket' => 'nullable|string',
            'anbk' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student->update($request->all());

        return redirect()->route('student.index')
            ->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index')
            ->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Export students data to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new StudentExport, 'siswa_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Download template for student import.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function template()
    {
        return Excel::download(new StudentsTemplateExport, 'template_siswa.xlsx');
    }

    /**
     * Show form for importing students.
     *
     * @return \Illuminate\View\View
     */
    public function importForm()
    {
        return view('students.import');
    }

    /**
     * Import students from Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:10240',
        ]);

        try {
            $import = new StudentImport;
            Excel::import($import, $request->file('file'));

            $rowCount = count($import->rows ?? []);
            $errorCount = count($import->failures());
            $successCount = $rowCount - $errorCount;

            $message = "Import berhasil: {$successCount} data siswa berhasil diimpor.";

            if ($errorCount > 0) {
                $message .= " {$errorCount} baris gagal diimpor karena terdapat kesalahan.";
                return redirect()->route('student.index')
                    ->with('warning', $message);
            }

            return redirect()->route('student.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Search for students based on criteria.
     *
     */
    public function search(Request $request)
    {
        $query = Student::query();

        // Apply search filters based on request parameters
        if ($request->has('nama_lengkap') && !empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->has('nis') && !empty($request->nis)) {
            $query->where('nis', 'like', '%' . $request->nis . '%');
        }

        if ($request->has('nisn') && !empty($request->nisn)) {
            $query->where('nisn', 'like', '%' . $request->nisn . '%');
        }

        $students = $query->paginate(10);

        // Calculate stats for dashboard cards (same as index method)
        $totalStudents = Student::count();
        $newStudents = Student::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $maleStudents = Student::where('jenis_kelamin', 'Laki-laki')->count();
        $femaleStudents = Student::where('jenis_kelamin', 'Perempuan')->count();
        $incompleteProfiles = Student::where(function ($query) {
            $query->whereNull('nis')
                ->orWhereNull('nisn')
                ->orWhereNull('nama_lengkap')
                ->orWhereNull('tempat_lahir')
                ->orWhereNull('tanggal_lahir');
        })->count();

        return view('students.index', compact(
            'students',
            'totalStudents',
            'newStudents',
            'maleStudents',
            'femaleStudents',
            'incompleteProfiles'
        ));
    }
}
