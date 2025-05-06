<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalonSantri extends Model
{
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
        'verified_by_id',
        'verified_by_name',
        'payment_proof',
    ];

    /**
     * Relasi ke user yang memverifikasi (jika ingin menampilkan info user selama user masih ada).
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by_id');
    }
}
