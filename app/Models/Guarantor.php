<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guarantor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'business_name',
        'unique_number',
        'gender',
        'title',
        'mobile',
        'email',
        'date_of_birth',
        'address',
        'city',
        'province',
        'zipcode',
        'landline',
        'working_status',
        'photo',
        'description',
        'files',
        'created_by',
        'branch_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'files' => 'array',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_guarantors');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        if ($this->business_name) {
            return $this->business_name;
        }

        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getDisplayNameAttribute()
    {
        $name = $this->full_name;
        if ($this->unique_number) {
            $name .= " ({$this->unique_number})";
        }
        return $name;
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('business_name', 'like', "%{$search}%")
                ->orWhere('unique_number', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }
}
