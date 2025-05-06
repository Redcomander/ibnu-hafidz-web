<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     */
    public function index()
    {
        $students = Student::latest()->paginate(10);

        // Calculate stats for dashboard cards
        $totalStudents = Student::count();

        // New students (added in the last 30 days)
        $newStudents = Student::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->count();

        // Students by gender
        $maleStudents = Student::where('jenis_kelamin', 'Laki-laki')->count();
        $femaleStudents = Student::where('jenis_kelamin', 'Perempuan')->count();

        // Students by class level (assuming rombel_kelas contains class information like X, XI, XII)
        $classDistribution = Student::select('rombel_kelas', DB::raw('count(*) as total'))
            ->whereNotNull('rombel_kelas')
            ->groupBy('rombel_kelas')
            ->pluck('total', 'rombel_kelas')
            ->toArray();

        // Students with incomplete profiles (missing essential information)
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
            'classDistribution',
            'incompleteProfiles'
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

     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'nullable|string|max:50',
            'nis' => 'required|string|max:50|unique:students',
            'nisn' => 'required|string|max:50|unique:students',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'required|string|in:L,P',
            'no_kk' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_akte' => 'nullable|string|max:100',
            'agama' => 'required|string|max:50',
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
            'rombel_ads' => 'nullable|string|max:100',
            'rombel_kelas' => 'nullable|string|max:100',
            'sekolah_asal' => 'nullable|string|max:255',
            'tahun_kelulusan' => 'nullable|integer',
            'no_peserta_un' => 'nullable|string|max:100',
            'no_seri_ijazah' => 'nullable|string|max:100',
            'no_skhun' => 'nullable|string|max:100',
            'status_santri' => 'nullable|string|max:100',
            'status_santri_other' => 'nullable|string|max:100',
            'tanggal_masuk_pondok' => 'nullable|date',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'anak_ke' => 'nullable|integer',
            'jumlah_anak' => 'nullable|integer',
            'status_anak' => 'nullable|string|max:100',
            'no_kks' => 'nullable|string|max:100',
            'penerima_kps' => 'nullable|boolean',
            'no_kps' => 'nullable|string|max:100',
            'no_kip' => 'nullable|string|max:100',
            'nama_di_kip' => 'nullable|string|max:255',
            'terima_fisik' => 'nullable|boolean',
            'kartu_jaminan' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'jenis_pendaftaran' => 'nullable|string|max:100',
            'ket' => 'nullable|string',
            'kelas_lama' => 'nullable|string|max:100',
            'anbk' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     *

     */
    public function show(Student $student)
    {
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
            'jenis_kelamin' => 'required|string|in:L,P',
            'no_kk' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_akte' => 'nullable|string|max:100',
            'agama' => 'required|string|max:50',
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
            'rombel_ads' => 'nullable|string|max:100',
            'rombel_kelas' => 'nullable|string|max:100',
            'sekolah_asal' => 'nullable|string|max:255',
            'tahun_kelulusan' => 'nullable|integer',
            'no_peserta_un' => 'nullable|string|max:100',
            'no_seri_ijazah' => 'nullable|string|max:100',
            'no_skhun' => 'nullable|string|max:100',
            'status_santri' => 'nullable|string|max:100',
            'status_santri_other' => 'nullable|string|max:100',
            'tanggal_masuk_pondok' => 'nullable|date',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'anak_ke' => 'nullable|integer',
            'jumlah_anak' => 'nullable|integer',
            'status_anak' => 'nullable|string|max:100',
            'no_kks' => 'nullable|string|max:100',
            'penerima_kps' => 'nullable|boolean',
            'no_kps' => 'nullable|string|max:100',
            'no_kip' => 'nullable|string|max:100',
            'nama_di_kip' => 'nullable|string|max:255',
            'terima_fisik' => 'nullable|boolean',
            'kartu_jaminan' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'jenis_pendaftaran' => 'nullable|string|max:100',
            'ket' => 'nullable|string',
            'kelas_lama' => 'nullable|string|max:100',
            'anbk' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student->update($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Display a listing of students for export.
     *

     */
    public function export()
    {
        $students = Student::all();
        return view('students.export', compact('students'));
    }

    /**
     * Import students from file.
     *
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);

        // Here you would implement the logic to import students from the file
        // This would typically involve a package like maatwebsite/excel

        return redirect()->route('students.index')
            ->with('success', 'Students imported successfully.');
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

        if ($request->has('rombel_kelas') && !empty($request->rombel_kelas)) {
            $query->where('rombel_kelas', $request->rombel_kelas);
        }

        $students = $query->paginate(10);

        // Calculate stats for dashboard cards (same as index method)
        $totalStudents = Student::count();
        $newStudents = Student::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $maleStudents = Student::where('jenis_kelamin', 'Laki-laki')->count();
        $femaleStudents = Student::where('jenis_kelamin', 'Perempuan')->count();
        $classDistribution = Student::select('rombel_kelas', DB::raw('count(*) as total'))
            ->whereNotNull('rombel_kelas')
            ->groupBy('rombel_kelas')
            ->pluck('total', 'rombel_kelas')
            ->toArray();
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
            'classDistribution',
            'incompleteProfiles'
        ));
    }
}
