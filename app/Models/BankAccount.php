<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'coa_code',
        'coa_name',
        'coa_default_categories',
        'access_branches',
    ];

    protected $casts = [
        'coa_default_categories' => 'array',
        'access_branches' => 'array',
    ];
}
