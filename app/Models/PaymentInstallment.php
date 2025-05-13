<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'calon_santri_id',
        'installment_number',
        'amount',
        'payment_date',
        'payment_proof',
        'notes',
        'status',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the calon santri that owns the payment installment.
     */
    public function calonSantri()
    {
        return $this->belongsTo(CalonSantri::class);
    }

    /**
     * Get the user who verified the payment.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
