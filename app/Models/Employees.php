<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employees extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'first_name',
        'last_name',
        'contact_no',
        'address',
        'birthday',
        'joining_date',
        'salary',
        'experience_years',
        'status',
    ];

    protected $casts = [
        'birthday' => 'date',
        'joining_date' => 'date',
        'salary' => 'decimal:2',
    ];

    /**
     * Get the user associated with the employee
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department of the employee
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    /**
     * Get all attendance records for the employee
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    /**
     * Get all leave requests for the employee
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(Leaves::class, 'employee_id');
    }

    /**
     * Get all payroll records for the employee
     */
    public function payrolls(): HasMany
    {
        return $this->hasMany(PayRolls::class, 'employee_id');
    }

    /**
     * Get the employee's full name
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'active' => '<span class="badge badge-success">Approved</span>',
            'inactive' => '<span class="badge badge-warning">Inactive</span>',
            'terminated' => '<span class="badge badge-danger">Terminated</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }
}
