<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return array
     */
    public function array(): array
    {
        // Return an empty array for the template
        return [];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'nip',
            'nis',
            'nisn',
            'nama_lengkap',
            'alamat',
            'jenis_kelamin',
            'no_kk',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'no_akte',
            'agama',
            'kewarganegaraan',
            'rt',
            'rw',
            'desa_kelurahan',
            'kecamatan',
            'kabupaten_kota',
            'provinsi',
            'kode_pos',
            'nama_ayah',
            'nik_ayah',
            'tahun_lahir_ayah',
            'pendidikan_ayah',
            'tahun_lulus_ayah',
            'pekerjaan_ayah',
            'nama_ibu',
            'nik_ibu',
            'tahun_lahir_ibu',
            'pendidikan_ibu',
            'tahun_lulus_ibu',
            'pekerjaan_ibu',
            'no_hp_telpon',
            'sekolah_asal',
            'tahun_kelulusan',
            'no_peserta_un',
            'no_seri_ijazah',
            'no_skhun',
            'status_santri',
            'status_santri_other',
            'tanggal_masuk_pondok',
            'tinggi_badan',
            'berat_badan',
            'anak_ke',
            'jumlah_anak',
            'status_anak',
            'no_kks',
            'penerima_kps',
            'no_kps',
            'no_kip',
            'nama_di_kip',
            'terima_fisik',
            'kartu_jaminan',
            'email',
            'jenis_pendaftaran',
            'ket',
            'anbk',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Tambahkan komentar pada kolom-kolom tertentu untuk panduan pengisian
        $sheet->getComment('F1')->getText()->createTextRun('Isi dengan: Laki-laki atau Perempuan');
        $sheet->getComment('J1')->getText()->createTextRun('Format: DD-MM-YYYY (contoh: 15-08-2005)');
        $sheet->getComment('L1')->getText()->createTextRun('Default: Islam');
        $sheet->getComment('W1')->getText()->createTextRun('Isi dengan tahun saja (contoh: 1980)');
        $sheet->getComment('Y1')->getText()->createTextRun('Isi dengan tahun saja (contoh: 2000)');
        $sheet->getComment('AC1')->getText()->createTextRun('Isi dengan tahun saja (contoh: 1982)');
        $sheet->getComment('AE1')->getText()->createTextRun('Isi dengan tahun saja (contoh: 2002)');
        $sheet->getComment('AH1')->getText()->createTextRun('Isi dengan tahun saja (contoh: 2020)');
        $sheet->getComment('AL1')->getText()->createTextRun('Isi dengan: Baru, Pindahan, atau Lain-lain');
        $sheet->getComment('AM1')->getText()->createTextRun('Isi jika Status Santri adalah Lain-lain');
        $sheet->getComment('AN1')->getText()->createTextRun('Format: DD-MM-YYYY (contoh: 01-07-2021)');
        $sheet->getComment('AU1')->getText()->createTextRun('Isi dengan: Ya atau Tidak');
        $sheet->getComment('AY1')->getText()->createTextRun('Isi dengan: Ya atau Tidak');
        $sheet->getComment('AZ1')->getText()->createTextRun('Isi dengan: KIS, BPJS, Jamkesmas, atau Jamkesda');

        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}
