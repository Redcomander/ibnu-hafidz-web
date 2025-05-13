<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Carbon;

class StudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date fields
        $tanggal_lahir = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                $tanggal_lahir = Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    $tanggal_lahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Leave as null if parsing fails
                }
            }
        }

        $tanggal_masuk_pondok = null;
        if (!empty($row['tanggal_masuk_pondok'])) {
            try {
                $tanggal_masuk_pondok = Carbon::createFromFormat('d-m-Y', $row['tanggal_masuk_pondok'])->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    $tanggal_masuk_pondok = Carbon::parse($row['tanggal_masuk_pondok'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Leave as null if parsing fails
                }
            }
        }

        // Handle year fields
        $tahun_lahir_ayah = !empty($row['tahun_lahir_ayah']) ? (int) $row['tahun_lahir_ayah'] : null;
        $tahun_lulus_ayah = !empty($row['tahun_lulus_ayah']) ? (int) $row['tahun_lulus_ayah'] : null;
        $tahun_lahir_ibu = !empty($row['tahun_lahir_ibu']) ? (int) $row['tahun_lahir_ibu'] : null;
        $tahun_lulus_ibu = !empty($row['tahun_lulus_ibu']) ? (int) $row['tahun_lulus_ibu'] : null;
        $tahun_kelulusan = !empty($row['tahun_kelulusan']) ? (int) $row['tahun_kelulusan'] : null;

        // Handle enum fields
        $jenis_kelamin = null;
        if (!empty($row['jenis_kelamin'])) {
            if (in_array(strtolower($row['jenis_kelamin']), ['l', 'laki-laki', 'laki', 'pria', 'Laki-laki'])) {
                $jenis_kelamin = 'Laki-laki';
            } elseif (in_array(strtolower($row['jenis_kelamin']), ['p', 'perempuan', 'wanita', 'Perempuan'])) {
                $jenis_kelamin = 'Perempuan';
            }
        }

        $status_santri = null;
        if (!empty($row['status_santri'])) {
            if (in_array(strtolower($row['status_santri']), ['baru', 'new'])) {
                $status_santri = 'Baru';
            } elseif (in_array(strtolower($row['status_santri']), ['pindahan', 'transfer'])) {
                $status_santri = 'Pindahan';
            } elseif (!in_array(strtolower($row['status_santri']), ['baru', 'pindahan'])) {
                $status_santri = 'Lain-lain';
            }
        }

        $penerima_kps = null;
        if (isset($row['penerima_kps'])) {
            if (in_array(strtolower($row['penerima_kps']), ['ya', 'yes', '1', 'true', 'y'])) {
                $penerima_kps = 'Ya';
            } elseif (in_array(strtolower($row['penerima_kps']), ['tidak', 'no', '0', 'false', 'n'])) {
                $penerima_kps = 'Tidak';
            }
        }

        $terima_fisik = null;
        if (isset($row['terima_fisik'])) {
            if (in_array(strtolower($row['terima_fisik']), ['ya', 'yes', '1', 'true', 'y'])) {
                $terima_fisik = 'Ya';
            } elseif (in_array(strtolower($row['terima_fisik']), ['tidak', 'no', '0', 'false', 'n'])) {
                $terima_fisik = 'Tidak';
            }
        }

        $kartu_jaminan = null;
        if (!empty($row['kartu_jaminan'])) {
            $kartu_jaminan_value = strtoupper($row['kartu_jaminan']);
            if (in_array($kartu_jaminan_value, ['KIS', 'BPJS', 'JAMKESMAS', 'JAMKESDA'])) {
                $kartu_jaminan = $kartu_jaminan_value;
            }
        }

        // Handle numeric fields
        $tinggi_badan = !empty($row['tinggi_badan']) ? (float) $row['tinggi_badan'] : null;
        $berat_badan = !empty($row['berat_badan']) ? (float) $row['berat_badan'] : null;
        $anak_ke = !empty($row['anak_ke']) ? (int) $row['anak_ke'] : null;
        $jumlah_anak = !empty($row['jumlah_anak']) ? (int) $row['jumlah_anak'] : null;

        return new Student([
            'nip' => $row['nip'] ?? null,
            'nis' => $row['nis'] ?? null,
            'nisn' => $row['nisn'] ?? null,
            'nama_lengkap' => $row['nama_lengkap'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'jenis_kelamin' => $jenis_kelamin,
            'no_kk' => $row['no_kk'] ?? null,
            'nik' => $row['nik'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $tanggal_lahir,
            'no_akte' => $row['no_akte'] ?? null,
            'agama' => $row['agama'] ?? 'Islam',
            'kewarganegaraan' => $row['kewarganegaraan'] ?? null,
            'rt' => $row['rt'] ?? null,
            'rw' => $row['rw'] ?? null,
            'desa_kelurahan' => $row['desa_kelurahan'] ?? null,
            'kecamatan' => $row['kecamatan'] ?? null,
            'kabupaten_kota' => $row['kabupaten_kota'] ?? null,
            'provinsi' => $row['provinsi'] ?? null,
            'kode_pos' => $row['kode_pos'] ?? null,
            'nama_ayah' => $row['nama_ayah'] ?? null,
            'nik_ayah' => $row['nik_ayah'] ?? null,
            'tahun_lahir_ayah' => $tahun_lahir_ayah,
            'pendidikan_ayah' => $row['pendidikan_ayah'] ?? null,
            'tahun_lulus_ayah' => $tahun_lulus_ayah,
            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
            'nama_ibu' => $row['nama_ibu'] ?? null,
            'nik_ibu' => $row['nik_ibu'] ?? null,
            'tahun_lahir_ibu' => $tahun_lahir_ibu,
            'pendidikan_ibu' => $row['pendidikan_ibu'] ?? null,
            'tahun_lulus_ibu' => $tahun_lulus_ibu,
            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
            'no_hp_telpon' => $row['no_hp_telpon'] ?? null,
            'sekolah_asal' => $row['sekolah_asal'] ?? null,
            'tahun_kelulusan' => $tahun_kelulusan,
            'no_peserta_un' => $row['no_peserta_un'] ?? null,
            'no_seri_ijazah' => $row['no_seri_ijazah'] ?? null,
            'no_skhun' => $row['no_skhun'] ?? null,
            'status_santri' => $status_santri,
            'status_santri_other' => ($status_santri == 'Lain-lain') ? ($row['status_santri_other'] ?? $row['status_santri']) : null,
            'tanggal_masuk_pondok' => $tanggal_masuk_pondok,
            'tinggi_badan' => $tinggi_badan,
            'berat_badan' => $berat_badan,
            'anak_ke' => $anak_ke,
            'jumlah_anak' => $jumlah_anak,
            'status_anak' => $row['status_anak'] ?? null,
            'no_kks' => $row['no_kks'] ?? null,
            'penerima_kps' => $penerima_kps,
            'no_kps' => $row['no_kps'] ?? null,
            'no_kip' => $row['no_kip'] ?? null,
            'nama_di_kip' => $row['nama_di_kip'] ?? null,
            'terima_fisik' => $terima_fisik,
            'kartu_jaminan' => $kartu_jaminan,
            'email' => $row['email'] ?? null,
            'jenis_pendaftaran' => $row['jenis_pendaftaran'] ?? null,
            'ket' => $row['ket'] ?? null,
            'anbk' => $row['anbk'] ?? null,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nis' => 'nullable|string|max:50',
            'nisn' => 'nullable|string|max:50',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string',
            'email' => 'nullable|email',
        ];
    }
}
