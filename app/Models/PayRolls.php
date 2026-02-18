<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayRolls extends Model
{
    protected $table = 'payrolls';

    protected $fillable = [
        'employee_id',
        'salary_amount',
        'pay_period_start',
        'pay_period_end',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'salary_amount' => 'decimal:2',
        'pay_period_start' => 'date',
        'pay_period_end' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the employee for this payroll record
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'paid' => '<span class="badge badge-success">Paid</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }
}
