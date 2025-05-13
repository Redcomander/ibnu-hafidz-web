<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSantri extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calon_santris';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'no_whatsapp',
        'asal_sekolah',
        'jenis_kelamin',
        'status',
        'payment_type',
        'nomor_pendaftaran',
        'verified_by_id',
        'verified_by_name',
        'payment_proof',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Generate a unique registration number for the calon santri.
     *
     * @return string
     */
    public function generateNomorPendaftaran()
    {
        $prefix = 'PSB-';
        $year = date('Y');
        $month = date('m');

        // Get the count of registrations in the current month
        $count = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        // Format: PSB-YYYYMM-XXXX (XXXX is sequential number padded to 4 digits)
        return $prefix . $year . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the formatted tanggal_lahir attribute.
     *
     * @return string
     */
    public function getFormattedTanggalLahirAttribute()
    {
        return $this->tanggal_lahir->format('d-m-Y');
    }

    /**
     * Get the formatted created_at attribute.
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    /**
     * Get the formatted updated_at attribute.
     *
     * @return string
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d-m-Y H:i:s');
    }

    /**
     * Get the user who verified this calon santri.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by_id');
    }

    /**
     * Scope a query to only include calon santri with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include calon santri with a specific payment type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $paymentType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaymentType($query, $paymentType)
    {
        return $query->where('payment_type', $paymentType);
    }

    /**
     * Check if the calon santri has completed the registration process.
     *
     * @return bool
     */
    public function isRegistrationComplete()
    {
        return $this->status === 'berhasil' && !empty($this->payment_proof);
    }

    /**
     * Get the payment proof URL.
     *
     * @return string|null
     */
    public function getPaymentProofUrlAttribute()
    {
        if ($this->payment_proof) {
            return asset('storage/' . $this->payment_proof);
        }

        return null;
    }
}
