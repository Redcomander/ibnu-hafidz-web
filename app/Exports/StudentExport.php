<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'NIP',
            'NIS',
            'NISN',
            'Nama Lengkap',
            'Alamat',
            'Jenis Kelamin',
            'No KK',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'No Akte',
            'Agama',
            'Kewarganegaraan',
            'RT',
            'RW',
            'Desa/Kelurahan',
            'Kecamatan',
            'Kabupaten/Kota',
            'Provinsi',
            'Kode Pos',
            'Nama Ayah',
            'NIK Ayah',
            'Tahun Lahir Ayah',
            'Pendidikan Ayah',
            'Tahun Lulus Ayah',
            'Pekerjaan Ayah',
            'Nama Ibu',
            'NIK Ibu',
            'Tahun Lahir Ibu',
            'Pendidikan Ibu',
            'Tahun Lulus Ibu',
            'Pekerjaan Ibu',
            'No HP/Telepon',
            'Sekolah Asal',
            'Tahun Kelulusan',
            'No Peserta UN',
            'No Seri Ijazah',
            'No SKHUN',
            'Status Santri',
            'Status Santri Lainnya',
            'Tanggal Masuk Pondok',
            'Tinggi Badan',
            'Berat Badan',
            'Anak Ke',
            'Jumlah Anak',
            'Status Anak',
            'No KKS',
            'Penerima KPS',
            'No KPS',
            'No KIP',
            'Nama di KIP',
            'Terima Fisik',
            'Kartu Jaminan',
            'Email',
            'Jenis Pendaftaran',
            'Keterangan',
            'ANBK',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($student): array
    {
        return [
            $student->id,
            $student->nip,
            $student->nis,
            $student->nisn,
            $student->nama_lengkap,
            $student->alamat,
            $student->jenis_kelamin,
            $student->no_kk,
            $student->nik,
            $student->tempat_lahir,
            $student->tanggal_lahir ? date('d-m-Y', strtotime($student->tanggal_lahir)) : '',
            $student->no_akte,
            $student->agama,
            $student->kewarganegaraan,
            $student->rt,
            $student->rw,
            $student->desa_kelurahan,
            $student->kecamatan,
            $student->kabupaten_kota,
            $student->provinsi,
            $student->kode_pos,
            $student->nama_ayah,
            $student->nik_ayah,
            $student->tahun_lahir_ayah,
            $student->pendidikan_ayah,
            $student->tahun_lulus_ayah,
            $student->pekerjaan_ayah,
            $student->nama_ibu,
            $student->nik_ibu,
            $student->tahun_lahir_ibu,
            $student->pendidikan_ibu,
            $student->tahun_lulus_ibu,
            $student->pekerjaan_ibu,
            $student->no_hp_telpon,
            $student->sekolah_asal,
            $student->tahun_kelulusan,
            $student->no_peserta_un,
            $student->no_seri_ijazah,
            $student->no_skhun,
            $student->status_santri,
            $student->status_santri_other,
            $student->tanggal_masuk_pondok ? date('d-m-Y', strtotime($student->tanggal_masuk_pondok)) : '',
            $student->tinggi_badan,
            $student->berat_badan,
            $student->anak_ke,
            $student->jumlah_anak,
            $student->status_anak,
            $student->no_kks,
            $student->penerima_kps,
            $student->no_kps,
            $student->no_kip,
            $student->nama_di_kip,
            $student->terima_fisik,
            $student->kartu_jaminan,
            $student->email,
            $student->jenis_pendaftaran,
            $student->ket,
            $student->anbk,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}
