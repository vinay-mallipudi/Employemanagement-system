<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'total_hours',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the employee for this attendance record
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    /**
     * Calculate total hours worked
     */
    public function calculateTotalHours(): void
    {
        if ($this->clock_in && $this->clock_out) {
            $clockIn = Carbon::parse($this->clock_in);
            $clockOut = Carbon::parse($this->clock_out);
            
            $this->total_hours = $clockOut->diffInHours($clockIn, true);
        }
    }

    /**
     * Boot method to auto-calculate total hours
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            $attendance->calculateTotalHours();
        });
    }
}
