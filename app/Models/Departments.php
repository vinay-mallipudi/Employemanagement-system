<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all employees in this department
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employees::class, 'department_id');
    }
}
