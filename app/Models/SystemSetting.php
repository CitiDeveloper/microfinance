<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'country',
        'timezone',
        'currency',
        'currency_in_words',
        'date_format',
        'decimal_separator',
        'thousand_separator',
        'monthly_repayment_cycle',
        'yearly_repayment_cycle',
        'days_in_month_interest',
        'days_in_year_interest',
        'business_registration_number',
        'address',
        'city',
        'province',
        'zipcode',
        'company_logo',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the system settings (singleton pattern)
     */
    public static function getSettings()
    {
        $settings = self::first();
        if (!$settings) {
            $settings = self::create([]);
        }
        return $settings;
    }

    /**
     * Get decimal separator character
     */
    public function getDecimalSeparatorCharAttribute()
    {
        return $this->decimal_separator === 'dot' ? '.' : ',';
    }

    /**
     * Get thousand separator character
     */
    public function getThousandSeparatorCharAttribute()
    {
        switch ($this->thousand_separator) {
            case 'comma':
                return ',';
            case 'dot':
                return '.';
            case 'space':
                return ' ';
            default:
                return ',';
        }
    }

    /**
     * Format number according to system settings
     */
    public function formatNumber($number, $decimals = 2)
    {
        return number_format(
            $number,
            $decimals,
            $this->decimal_separator_char,
            $this->thousand_separator_char
        );
    }

    /**
     * Format date according to system settings
     */
    public function formatDate($date)
    {
        $date = $date instanceof \Carbon\Carbon ? $date : \Carbon\Carbon::parse($date);

        switch ($this->date_format) {
            case 'dd/mm/yyyy':
                return $date->format('d/m/Y');
            case 'mm/dd/yyyy':
                return $date->format('m/d/Y');
            case 'yyyy/mm/dd':
                return $date->format('Y/m/d');
            default:
                return $date->format('d/m/Y');
        }
    }

    public function generateLoanId()
    {
        
        $prefix = $this->loan_id_prefix ?? 'LN-';
        $sequence = $this->loan_id_sequence ?? 1;
        $padding = $this->loan_id_padding ?? 5;
        $loanId = $prefix . str_pad($sequence, $padding, '0', STR_PAD_LEFT);       
        $this->loan_id_sequence = $sequence + 1;
        $this->save();

        return $loanId;
    }
}
