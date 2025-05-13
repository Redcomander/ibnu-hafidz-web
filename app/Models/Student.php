<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'profile_photo',
        'status',
        'jurusan',
    ];

    protected $dates = [
        'tanggal_lahir',
        'tanggal_masuk_pondok',
        'deleted_at'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk_pondok' => 'date',
        'penerima_kps' => 'boolean',
        'terima_fisik' => 'boolean',
        'tinggi_badan' => 'float',
        'berat_badan' => 'float',
        'anak_ke' => 'integer',
        'jumlah_anak' => 'integer',
    ];

    /**
     * Get the student's age.
     *
     * @return int
     */
    public function getAgeAttribute()
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : null;
    }

    /**
     * Get the student's full address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $parts = [];

        if ($this->alamat)
            $parts[] = $this->alamat;
        if ($this->rt && $this->rw)
            $parts[] = "RT {$this->rt}/RW {$this->rw}";
        if ($this->desa_kelurahan)
            $parts[] = $this->desa_kelurahan;
        if ($this->kecamatan)
            $parts[] = $this->kecamatan;
        if ($this->kabupaten_kota)
            $parts[] = $this->kabupaten_kota;
        if ($this->provinsi)
            $parts[] = $this->provinsi;
        if ($this->kode_pos)
            $parts[] = "Kode Pos: {$this->kode_pos}";

        return implode(', ', $parts);
    }

    /**
     * Check if the student profile is complete.
     *
     * @return bool
     */
    public function isProfileComplete()
    {
        $requiredFields = [
            'nama_lengkap',
            'nis',
            'nisn',
            'jenis_kelamin',
            'tanggal_lahir',
            'tempat_lahir',
            'alamat',
            'no_hp_telpon',
            'email'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the student's BMI (Body Mass Index).
     *
     * @return float|null
     */
    public function getBmiAttribute()
    {
        if ($this->tinggi_badan && $this->berat_badan) {
            // Convert height from cm to m
            $heightInMeters = $this->tinggi_badan / 100;
            // BMI formula: weight (kg) / (height (m) * height (m))
            return round($this->berat_badan / ($heightInMeters * $heightInMeters), 2);
        }

        return null;
    }

    /**
     * Get the student's BMI category.
     *
     * @return string|null
     */
    public function getBmiCategoryAttribute()
    {
        $bmi = $this->bmi;

        if ($bmi === null) {
            return null;
        }

        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi < 25) {
            return 'Normal';
        } elseif ($bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }

    /**
     * Scope a query to only include active students.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include students with incomplete profiles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncompleteProfile($query)
    {
        $requiredFields = [
            'nama_lengkap',
            'nis',
            'nisn',
            'jenis_kelamin',
            'tanggal_lahir',
            'tempat_lahir',
            'alamat',
            'no_hp_telpon',
            'email'
        ];

        foreach ($requiredFields as $field) {
            $query->orWhereNull($field)->orWhere($field, '');
        }

        return $query;
    }
}
