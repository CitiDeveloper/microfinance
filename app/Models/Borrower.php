<?php
// app/Models/Borrower.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrower extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'county',
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
        'credit_score',
        'photo',
        'description',
        'files',
        'loan_officer_access',
    ];

    protected $casts = [
        'files' => 'array',
        'loan_officer_access' => 'array',
        'date_of_birth' => 'date',
    ];

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'county' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'unique_number' => 'nullable|string|unique:borrowers,unique_number,' . $id,
            'gender' => 'nullable|in:Male,Female,Nonbinary,Other,Decline to state',
            'title' => 'nullable|in:Mr.,Mrs.,Miss,Ms.,Dr.,Prof.,Rev.',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'landline' => 'nullable|string|max:20',
            'working_status' => 'nullable|in:Employee,Government Employee,Private Sector Employee,Owner,Student, Business Person,Overseas Worker,Pensioner,Unemployed',
            'credit_score' => 'nullable|integer|min:0|max:1000',
            'photo' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        if ($this->business_name) {
            return $this->business_name;
        }

        return trim($this->first_name . ' ' . $this->last_name);
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('business_name', 'like', "%{$search}%")
            ->orWhere('unique_number', 'like', "%{$search}%")
            ->orWhere('mobile', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
    }
}
