<form action="{{ isset($branch) ? route('branches.update', $branch) : route('branches.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" id="form">
    @csrf
    @if(isset($branch))
        @method('PUT')
    @endif
    
    <input type="hidden" name="back_url" value="">
    
    <!-- Required Fields -->
    <div class="panel panel-default">
        <div class="panel-body bg-gray text-bold">Required Fields:</div>
    </div>
    
    <div class="form-group">
        <label for="inputBranchName" class="col-sm-3 control-label">Branch Name</label>
        <div class="col-sm-7">
            <input type="text" name="branch_name" class="form-control @error('branch_name') is-invalid @enderror" 
                   id="inputBranchName" placeholder="Branch Name" 
                   value="{{ old('branch_name', $branch->branch_name ?? '') }}" required>
            @error('branch_name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchOpenDate" class="col-sm-3 control-label">Branch Open Date</label>
        <div class="col-sm-7">
            <input type="date" name="branch_open_date" class="form-control @error('branch_open_date') is-invalid @enderror" 
                   id="inputBranchOpenDate" 
                   value="{{ old('branch_open_date', isset($branch) ? $branch->branch_open_date->format('Y-m-d') : '') }}" required>
            @error('branch_open_date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Optional Fields: Override Accounts Settings -->
    <div class="panel panel-default">
        <div class="panel-body bg-gray text-bold">Optional Fields: Override Accounts Settings</div>
    </div>
    
    <p>If you are operating in different countries, you can create a branch for each country and then override the account settings below. This is particularly useful for setting different currencies for each branch.</p>
    
    <div class="form-group">
        <div class="checkbox col-sm-offset-3 col-sm-9">
            <label>
                <input type="checkbox" name="account_settings_override" id="inputAccountSettingsOverride" value="1" 
                       {{ old('account_settings_override', $branch->account_settings_override ?? '') ? 'checked' : '' }}>
                <b>Override Account Settings?</b>
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="inputCountry" class="col-sm-3 control-label">Country</label>
        <div class="col-sm-7">
            <select class="form-control @error('branch_country') is-invalid @enderror" name="branch_country" id="inputCountry">
                <option value="">Select Country</option>
                @foreach([
                    'AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria',
                    'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla',
                    'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia',
                    'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan',
                    'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados',
                    'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin',
                    'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BQ' => 'Bonaire',
                    'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island',
                    'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam',
                    'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia',
                    'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands',
                    'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China',
                    'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia',
                    'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, The Democratic Republic of the',
                    'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote dIvoire', 'HR' => 'Croatia',
                    'CU' => 'Cuba', 'CW' => 'Curacao', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic',
                    'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic',
                    'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea',
                    'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)',
                    'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France',
                    'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories',
                    'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany',
                    'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland',
                    'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala',
                    'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana',
                    'HT' => 'Haiti', 'HM' => 'Heard Island and McDonald Islands', 'VA' => 'Holy See (Vatican City State)',
                    'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland',
                    'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic of', 'IQ' => 'Iraq',
                    'IE' => 'Ireland', 'IM' => 'Isle of Man', 'IL' => 'Israel', 'IT' => 'Italy',
                    'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan',
                    'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'Korea, Democratic People\'s Republic of',
                    'KR' => 'Korea, Republic of', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao PDR',
                    'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia',
                    'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg',
                    'MO' => 'Macao', 'MK' => 'Macedonia, Republic of', 'MG' => 'Madagascar', 'MW' => 'Malawi',
                    'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta',
                    'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius',
                    'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States of', 'MD' => 'Moldova, Republic of',
                    'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat',
                    'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia',
                    'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'NC' => 'New Caledonia',
                    'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria',
                    'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway',
                    'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine',
                    'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru',
                    'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal',
                    'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania',
                    'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
                    'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin (French part)', 'PM' => 'Saint Pierre and Miquelon',
                    'VC' => 'Saint Vincent and the Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome and Principe',
                    'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles',
                    'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SX' => 'Sint Maarten (Dutch part)', 'SK' => 'Slovakia',
                    'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa',
                    'GS' => 'South Georgia and the South Sandwich Islands', 'SS' => 'South Sudan', 'ES' => 'Spain', 'LK' => 'Sri Lanka',
                    'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard and Jan Mayen', 'SZ' => 'Swaziland',
                    'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan',
                    'TJ' => 'Tajikistan', 'TZ' => 'Tanzania, United Republic of', 'TH' => 'Thailand', 'TL' => 'Timor-Leste',
                    'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago',
                    'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks and Caicos Islands',
                    'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates',
                    'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Minor Outlying Islands', 'UY' => 'Uruguay',
                    'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela, Bolivarian Republic of', 'VN' => 'Vietnam',
                    'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.S.', 'WF' => 'Wallis and Futuna', 'EH' => 'Western Sahara',
                    'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'
                ] as $code => $name)
                    <option value="{{ $code }}" {{ old('branch_country', $branch->branch_country ?? '') == $code ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('branch_country')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputCurrency" class="col-sm-3 control-label">Currency</label>
        <div class="col-sm-7">
            <select class="form-control @error('branch_currency') is-invalid @enderror" name="branch_currency" id="inputCurrency">
                <option value="">Select Currency</option>
                @foreach([
                    'AED' => 'AED - د.إ', 'AFN' => 'AFN - Af', 'ALL' => 'ALL - Lek', 'AMD' => 'AMD - ֏',
                    'ANG' => 'ANG - ƒ', 'AOA' => 'AOA - Kz', 'ARS' => 'ARS - $', 'AUD' => 'AUD - $',
                    'AWG' => 'AWG - ƒ', 'AZN' => 'AZN - man', 'BAM' => 'BAM - KM', 'BBD' => 'BBD - $',
                    'BDT' => 'BDT - ৳', 'BGN' => 'BGN - лв', 'BHD' => 'BHD - .د.ب', 'BIF' => 'BIF - FBu',
                    'BMD' => 'BMD - $', 'BND' => 'BND - $', 'BOB' => 'BOB - $b', 'BRL' => 'BRL - R$',
                    'BSD' => 'BSD - $', 'BTN' => 'BTN - Nu.', 'BWP' => 'BWP - P', 'BYR' => 'BYR - p.',
                    'BZD' => 'BZD - BZ$', 'CAD' => 'CAD - $', 'CDF' => 'CDF - FC', 'CHF' => 'CHF - CHF',
                    'CLF' => 'CLF - CLF', 'CLP' => 'CLP - $', 'CNY' => 'CNY - ¥', 'COP' => 'COP - $',
                    'CRC' => 'CRC - ₡', 'CUP' => 'CUP - ₱', 'CVE' => 'CVE - $', 'CZK' => 'CZK - Kč',
                    'DJF' => 'DJF - Fdj', 'DKK' => 'DKK - kr', 'DOP' => 'DOP - RD$', 'DZD' => 'DZD - دج',
                    'EGP' => 'EGP - £', 'ETB' => 'ETB - Br', 'EUR' => 'EUR - €', 'FJD' => 'FJD - $',
                    'FKP' => 'FKP - £', 'GBP' => 'GBP - £', 'GEL' => 'GEL - ₾', 'GHS' => 'GHS - ¢',
                    'GIP' => 'GIP - £', 'GMD' => 'GMD - D', 'GNF' => 'GNF - FG', 'GTQ' => 'GTQ - Q',
                    'GYD' => 'GYD - $', 'HKD' => 'HKD - $', 'HNL' => 'HNL - L', 'HRK' => 'HRK - kn',
                    'HTG' => 'HTG - G', 'HUF' => 'HUF - Ft', 'IDR' => 'IDR - Rp', 'ILS' => 'ILS - ₪',
                    'INR' => 'INR - ₹', 'IQD' => 'IQD - ع.د', 'IRR' => 'IRR - ﷼', 'ISK' => 'ISK - kr',
                    'JEP' => 'JEP - £', 'JAM-DEX' => 'JAM-DEX - J$', 'JMD' => 'JMD - J$', 'JOD' => 'JOD - JD',
                    'JPY' => 'JPY - ¥', 'KES' => 'KES - KSh', 'KGS' => 'KGS - лв', 'KHR' => 'KHR - ៛',
                    'KMF' => 'KMF - CF', 'KPW' => 'KPW - ₩', 'KRW' => 'KRW - ₩', 'KWD' => 'KWD - د.ك',
                    'KYD' => 'KYD - $', 'KZT' => 'KZT - лв', 'LAK' => 'LAK - ₭', 'LBP' => 'LBP - £',
                    'LKR' => 'LKR - ₨', 'LRD' => 'LRD - $', 'LSL' => 'LSL - L', 'LTL' => 'LTL - Lt',
                    'LVL' => 'LVL - Ls', 'LYD' => 'LYD - ل.د', 'MAD' => 'MAD - د.م.', 'MDL' => 'MDL - L',
                    'MGA' => 'MGA - Ar', 'MKD' => 'MKD - ден', 'MMK' => 'MMK - K', 'MNT' => 'MNT - ₮',
                    'MOP' => 'MOP - MOP$', 'MRO' => 'MRO - UM', 'MUR' => 'MUR - ₨', 'MVR' => 'MVR - ރ.',
                    'MWK' => 'MWK - MK', 'MXN' => 'MXN - $', 'MYR' => 'MYR - RM', 'MZN' => 'MZN - MT',
                    'NAD' => 'NAD - $', 'NGN' => 'NGN - ₦', 'NIO' => 'NIO - C$', 'NOK' => 'NOK - kr',
                    'NPR' => 'NPR - ₨', 'NZD' => 'NZD - $', 'OMR' => 'OMR - ﷼', 'PAB' => 'PAB - B/.',
                    'PEN' => 'PEN - S/.', 'PGK' => 'PGK - K', 'PHP' => 'PHP - ₱', 'PKR' => 'PKR - ₨',
                    'PLN' => 'PLN - zł', 'PYG' => 'PYG - Gs', 'QAR' => 'QAR - ﷼', 'RON' => 'RON - lei',
                    'RSD' => 'RSD - Дин.', 'RUB' => 'RUB - руб', 'RWF' => 'RWF - R₣', 'SAR' => 'SAR - ﷼',
                    'SBD' => 'SBD - $', 'SCR' => 'SCR - ₨', 'SDG' => 'SDG - £', 'SEK' => 'SEK - kr',
                    'SGD' => 'SGD - $', 'SHP' => 'SHP - £', 'SLL' => 'SLL - Le', 'SOS' => 'SOS - S',
                    'SRD' => 'SRD - $', 'STD' => 'STD - Db', 'SVC' => 'SVC - $', 'SYP' => 'SYP - £',
                    'SZL' => 'SZL - L', 'THB' => 'THB - ฿', 'TJS' => 'TJS - TJS', 'TMT' => 'TMT - m',
                    'TND' => 'TND - د.ت', 'TOP' => 'TOP - T$', 'TRY' => 'TRY - ₺', 'TTD' => 'TTD - $',
                    'TWD' => 'TWD - NT$', 'TZS' => 'TZS - TZS', 'UAH' => 'UAH - ₴', 'UGX' => 'UGX - USh',
                    'USD' => 'USD - $', 'UYU' => 'UYU - $U', 'UZS' => 'UZS - лв', 'VEF' => 'VEF - Bs',
                    'VND' => 'VND - ₫', 'VUV' => 'VUV - VT', 'WST' => 'WST - WS$', 'XAF' => 'XAF - FCFA',
                    'XCD' => 'XCD - $', 'XCG' => 'XCG - Cg', 'XDR' => 'XDR - XDR', 'XOF' => 'XOF - XOF',
                    'XPF' => 'XPF - F', 'YER' => 'YER - ﷼', 'ZAR' => 'ZAR - R', 'ZiG' => 'ZiG - ZiG',
                    'ZMK' => 'ZMK - ZMW', 'ZWL' => 'ZWL - Z$'
                ] as $code => $name)
                    <option value="{{ $code }}" {{ old('branch_currency', $branch->branch_currency ?? '') == $code ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('branch_currency')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputDateformat" class="col-sm-3 control-label">Date Format</label>
        <div class="col-sm-7">
            <select class="form-control @error('branch_dateformat') is-invalid @enderror" name="branch_dateformat" id="inputDateformat">
                <option value="">Select Date Format</option>
                <option value="dd/mm/yyyy" {{ old('branch_dateformat', $branch->branch_dateformat ?? '') == 'dd/mm/yyyy' ? 'selected' : '' }}>dd/mm/yyyy</option>
                <option value="mm/dd/yyyy" {{ old('branch_dateformat', $branch->branch_dateformat ?? '') == 'mm/dd/yyyy' ? 'selected' : '' }}>mm/dd/yyyy</option>
                <option value="yyyy/mm/dd" {{ old('branch_dateformat', $branch->branch_dateformat ?? '') == 'yyyy/mm/dd' ? 'selected' : '' }}>yyyy/mm/dd</option>
            </select>
            @error('branch_dateformat')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputCurrencyInWords" class="col-sm-3 control-label">Currency in Words</label>
        <div class="col-sm-7">
            <input type="text" name="branch_currency_in_words" class="form-control @error('branch_currency_in_words') is-invalid @enderror" 
                   id="inputCurrencyInWords" placeholder="Currency in Words" 
                   value="{{ old('branch_currency_in_words', $branch->branch_currency_in_words ?? '') }}">
            <small class="form-text text-muted">Please visit Account Settings for an explanation on <b>Currency in Words</b> field.</small>
            @error('branch_currency_in_words')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <hr>

    <!-- Optional Fields: Address -->
    <div class="panel panel-default">
        <div class="panel-body bg-gray text-bold">Optional Fields: Address</div>
    </div>

    <div class="form-group">
        <label for="inputBranchAddress" class="col-sm-3 control-label">Branch Address</label>
        <div class="col-sm-7">
            <input type="text" name="branch_address" class="form-control @error('branch_address') is-invalid @enderror" 
                   id="inputBranchAddress" placeholder="Branch Address" 
                   value="{{ old('branch_address', $branch->branch_address ?? '') }}">
            @error('branch_address')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchCity" class="col-sm-3 control-label">Branch City</label>
        <div class="col-sm-7">
            <input type="text" name="branch_city" class="form-control @error('branch_city') is-invalid @enderror" 
                   id="inputBranchCity" placeholder="Branch City" 
                   value="{{ old('branch_city', $branch->branch_city ?? '') }}">
            @error('branch_city')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchProvince" class="col-sm-3 control-label">Branch Province</label>
        <div class="col-sm-7">
            <input type="text" name="branch_province" class="form-control @error('branch_province') is-invalid @enderror" 
                   id="inputBranchProvince" placeholder="Branch Province" 
                   value="{{ old('branch_province', $branch->branch_province ?? '') }}">
            @error('branch_province')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchZipcode" class="col-sm-3 control-label">Branch Zipcode</label>
        <div class="col-sm-7">
            <input type="text" name="branch_zipcode" class="form-control @error('branch_zipcode') is-invalid @enderror" 
                   id="inputBranchZipcode" placeholder="Branch Zipcode" 
                   value="{{ old('branch_zipcode', $branch->branch_zipcode ?? '') }}">
            @error('branch_zipcode')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchPhoneLandline" class="col-sm-3 control-label">Branch Landline</label>
        <div class="col-sm-7">
            <input type="text" name="branch_landline" class="form-control @error('branch_landline') is-invalid @enderror" 
                   id="inputBranchPhoneLandline" placeholder="Branch Landline" 
                   value="{{ old('branch_landline', $branch->branch_landline ?? '') }}">
            @error('branch_landline')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchMobile" class="col-sm-3 control-label">Branch Mobile</label>
        <div class="col-sm-7">
            <input type="text" name="branch_mobile" class="form-control @error('branch_mobile') is-invalid @enderror" 
                   id="inputBranchMobile" placeholder="Numbers only" 
                   value="{{ old('branch_mobile', $branch->branch_mobile ?? '') }}">
            @error('branch_mobile')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <hr>

    <!-- Optional Fields: Loan Restrictions -->
    <div class="panel panel-default">
        <div class="panel-body bg-gray text-bold">Optional Fields: Loan Restrictions</div>
    </div>

    <div class="form-group">
        <label for="inputBranchMinLoanAmount" class="col-sm-3 control-label">Minimum Loan Amount</label>
        <div class="col-sm-7">
            <input type="number" step="0.01" name="branch_min_loan_amount" class="form-control @error('branch_min_loan_amount') is-invalid @enderror" 
                   id="inputBranchMinLoanAmount" placeholder="Number or decimal only" 
                   value="{{ old('branch_min_loan_amount', $branch->branch_min_loan_amount ?? '') }}">
            @error('branch_min_loan_amount')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchMaxLoanAmount" class="col-sm-3 control-label">Maximum Loan Amount</label>
        <div class="col-sm-7">
            <input type="number" step="0.01" name="branch_max_loan_amount" class="form-control @error('branch_max_loan_amount') is-invalid @enderror" 
                   id="inputBranchMaxLoanAmount" placeholder="Number or decimal only" 
                   value="{{ old('branch_max_loan_amount', $branch->branch_max_loan_amount ?? '') }}">
            @error('branch_max_loan_amount')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchMinLoanInterest" class="col-sm-3 control-label">Minimum Loan Interest Rate</label>
        <div class="col-sm-7">
            <input type="number" step="0.01" name="branch_min_interest_rate" class="form-control @error('branch_min_interest_rate') is-invalid @enderror" 
                   id="inputBranchMinLoanInterest" placeholder="Number or decimal only" 
                   value="{{ old('branch_min_interest_rate', $branch->branch_min_interest_rate ?? '') }}">
            @error('branch_min_interest_rate')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputBranchMaxLoanInterest" class="col-sm-3 control-label">Maximum Loan Interest Rate</label>
        <div class="col-sm-7">
            <input type="number" step="0.01" name="branch_max_interest_rate" class="form-control @error('branch_max_interest_rate') is-invalid @enderror" 
                   id="inputBranchMaxLoanInterest" placeholder="Number or decimal only" 
                   value="{{ old('branch_max_interest_rate', $branch->branch_max_interest_rate ?? '') }}">
            @error('branch_max_interest_rate')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <hr>

    <!-- Optional Fields: Generate custom numbers -->
    <div class="panel panel-default">
        <div class="panel-body bg-gray text-bold">Optional Fields: Generate custom <u>Borrower Unique Numbers</u> and <u>Loan Unique Numbers</u></div>
    </div>

    <p class="margin">Below, you can generate a <b><u>Borrower Unique Number</u></b> on the Add Borrower page and a unique <b><u>Loan #</u></b> on the Add Loan page. If you do not set the below, for borrowers, the system leaves the <b>Borrower Unique Number</b> field empty. For loans, the system generates a unique 7 digit <b>Loan #</b>. But you might want a different format or a branch code in that number. You can use the below placeholders to force the system into generating borrower unique numbers and loan numbers based on the below patterns.</p>

    <div class="form-group">
        <label for="inputGenerateBorrowerUniqueNumbers" class="col-sm-3 control-label">Borrower Unique Number (optional)</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('borrower_num_placeholder') is-invalid @enderror" 
                   placeholder="" name="borrower_num_placeholder" id="inputGenerateBorrowerUniqueNumbers" 
                   value="{{ old('borrower_num_placeholder', $branch->borrower_num_placeholder ?? '') }}">
            <small class="form-text text-muted">Leave it empty if you do not need a Borrower Unique Number</small>
            @error('borrower_num_placeholder')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="inputGenerateLoanUniqueNumbers" class="col-sm-3 control-label">Loan Unique Number (optional)</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('loan_num_placeholder') is-invalid @enderror" 
                   placeholder="" name="loan_num_placeholder" id="inputGenerateLoanUniqueNumbers" 
                   value="{{ old('loan_num_placeholder', $branch->loan_num_placeholder ?? '') }}">
            <small class="form-text text-muted">Leave it empty if you would like the system to auto generate this</small>
            @error('loan_num_placeholder')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Branch Relationships -->
    @if(isset($loanProducts) && isset($staff))
        <div class="panel panel-default">
            <div class="panel-body bg-gray text-bold">Select the loan products that should be accessible in this branch</div>
        </div>

        <div class="form-group">
            <label for="inputLoanProducts" class="col-sm-3 control-label">Loan Products</label>
            <div class="col-sm-9">
                <select class="form-control loan_products_select @error('loan_products_ids') is-invalid @enderror" 
                        name="loan_products_ids[]" id="inputLoanProducts" multiple>
                    @foreach($loanProducts as $product)
                        <option value="{{ $product->id }}" 
                                {{ in_array($product->id, old('loan_products_ids', isset($branch) ? $branch->loanProducts->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Click in the box above to select multiple loan products.</small>
                @error('loan_products_ids')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body bg-gray text-bold">Select the loan officers that should be accessible in this branch</div>
        </div>

        <div class="form-group">
            <label for="inputLoanOfficers" class="col-sm-3 control-label">Loan Officers</label>
            <div class="col-sm-9">
                <select class="form-control loan_officers_select @error('loan_officers_ids') is-invalid @enderror" 
                        name="loan_officers_ids[]" id="inputLoanOfficers" multiple>
                    @foreach($staff as $officer)
                        <option value="{{ $officer->id }}" 
                                {{ in_array($officer->id, old('loan_officers_ids', isset($branch) ? $branch->loanOfficers->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                            {{ $officer->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Click in the box above to select multiple loan officers.</small>
                @error('loan_officers_ids')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body bg-gray text-bold">Select the repayment collectors that should be accessible in this branch</div>
        </div>

        <div class="form-group">
            <label for="inputRepaymentCollectors" class="col-sm-3 control-label">Repayment Collectors</label>
            <div class="col-sm-9">
                <select class="form-control repayment_collector_select @error('repayment_collector_ids') is-invalid @enderror" 
                        name="repayment_collector_ids[]" id="inputRepaymentCollectors" multiple>
                    @foreach($staff as $collector)
                        <option value="{{ $collector->id }}" 
                                {{ in_array($collector->id, old('repayment_collector_ids', isset($branch) ? $branch->collectors->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                            {{ $collector->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Click in the box above to select multiple repayment collectors.</small>
                @error('repayment_collector_ids')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endif

    <div class="box-footer">
        <button type="button" class="btn btn-default" onclick="window.history.back()">Back</button>
        <button type="submit" class="btn btn-info pull-right submit-button">
            {{ isset($branch) ? 'Update Branch' : 'Create Branch' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize select2 for multiple select boxes
        $('.loan_products_select, .loan_officers_select, .repayment_collector_select').select2({
            placeholder: "Select options",
            allowClear: true
        });

        // Show/hide account settings override fields
        $('#inputAccountSettingsOverride').change(function() {
            if ($(this).is(':checked')) {
                $('#inputCountry, #inputCurrency, #inputDateformat, #inputCurrencyInWords').prop('disabled', false);
            } else {
                $('#inputCountry, #inputCurrency, #inputDateformat, #inputCurrencyInWords').prop('disabled', true);
            }
        }).trigger('change');
    });
</script>
@endpush