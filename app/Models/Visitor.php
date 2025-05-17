<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'session_id',
        'page_visited',
        'referrer',
        'device_type',
        'browser',
        'platform',
        'country',
        'region',
        'city',
        'is_bot',
        'is_unique'
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'is_unique' => 'boolean',
    ];

    /**
     * Scope a query to only include unique visitors.
     */
    public function scopeUnique($query)
    {
        return $query->where('is_unique', true);
    }

    /**
     * Scope a query to exclude bots.
     */
    public function scopeExcludeBots($query)
    {
        return $query->where('is_bot', false);
    }

    /**
     * Scope a query to only include visitors from today.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope a query to only include visitors from yesterday.
     */
    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', Carbon::yesterday());
    }

    /**
     * Scope a query to only include visitors from this week.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    /**
     * Scope a query to only include visitors from last week.
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek()
        ]);
    }

    /**
     * Scope a query to only include visitors from this month.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year);
    }

    /**
     * Scope a query to only include visitors from last month.
     */
    public function scopeLastMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year);
    }

    /**
     * Scope a query to only include visitors from this year.
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', Carbon::now()->year);
    }

    /**
     * Scope a query to only include visitors from last year.
     */
    public function scopeLastYear($query)
    {
        return $query->whereYear('created_at', Carbon::now()->subYear()->year);
    }
}
