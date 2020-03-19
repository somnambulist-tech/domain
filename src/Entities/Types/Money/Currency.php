<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Money;

use Somnambulist\Domain\Entities\AbstractMultiton;

/**
 * Class Currency
 *
 * @package    Somnambulist\Domain\Entities\Types\Money
 * @subpackage Somnambulist\Domain\Entities\Types\Money\Currency
 */
final class Currency extends AbstractMultiton
{

    private string $name;

    protected function __construct(string $code, string $name)
    {
        $this->name = $name;

        parent::__construct($code);
    }

    protected static function initializeMembers()
    {
        foreach (static::$mappings as $code => $name) {
            new static($code, $name);
        }
    }

    public function toString(): string
    {
        return (string)$this->code();
    }

    public function equals(object $object): bool
    {
        if (get_class($object) === get_class($this)) {
            return $object->code() === $this->code() && $object->name() === $this->name();
        }

        return false;
    }

    public function code(): string
    {
        return $this->key();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function precision(): int
    {
        if (array_key_exists($this->code(), static::$precision)) {
            return static::$precision[$this->code()];
        }

        return 2;
    }

    private static array $mappings = [
        'AED' => 'UAE Dirham',
        'AFN' => 'Afghani',
        'ALL' => 'Lek',
        'AMD' => 'Armenian Dram',
        'ANG' => 'Netherlands Antillean Guilder',
        'AOA' => 'Kwanza',
        'ARS' => 'Argentine Peso',
        'AUD' => 'Australian Dollar',
        'AWG' => 'Aruban Florin',
        'AZN' => 'Azerbaijanian Manat',
        'BAM' => 'Convertible Mark',
        'BBD' => 'Barbados Dollar',
        'BDT' => 'Taka',
        'BGN' => 'Bulgarian Lev',
        'BHD' => 'Bahraini Dinar',
        'BIF' => 'Burundi Franc',
        'BMD' => 'Bermudian Dollar',
        'BND' => 'Brunei Dollar',
        'BOB' => 'Boliviano',
        'BRL' => 'Brazilian Real',
        'BSD' => 'Bahamian Dollar',
        'BTN' => 'Ngultrum',
        'BWP' => 'Pula',
        'BYR' => 'Belarussian Ruble',
        'BZD' => 'Belize Dollar',
        'CAD' => 'Canadian Dollar',
        'CDF' => 'Congolese Franc',
        'CHF' => 'Swiss Franc',
        'CLF' => 'Unidad de Fomento',
        'CLP' => 'Chilean Peso',
        'CNY' => 'Yuan Renminbi',
        'COP' => 'Colombian Peso',
        'CRC' => 'Costa Rican Colon',
        'CUP' => 'Cuban Peso',
        'CVE' => 'Cabo Verde Escudo',
        'CZK' => 'Czech Koruna',
        'DJF' => 'Djibouti Franc',
        'DKK' => 'Danish Krone',
        'DOP' => 'Dominican Peso',
        'DZD' => 'Algerian Dinar',
        'EGP' => 'Egyptian Pound',
        'ETB' => 'Ethiopian Birr',
        'EUR' => 'Euro',
        'FJD' => 'Fiji Dollar',
        'FKP' => 'Falkland Islands Pound',
        'GBP' => 'Pound Sterling',
        'GEL' => 'Lari',
        'GHS' => 'Ghana Cedi',
        'GIP' => 'Gibraltar Pound',
        'GMD' => 'Dalasi',
        'GNF' => 'Guinea Franc',
        'GTQ' => 'Quetzal',
        'GYD' => 'Guyana Dollar',
        'HKD' => 'Hong Kong Dollar',
        'HNL' => 'Lempira',
        'HRK' => 'Kuna',
        'HTG' => 'Gourde',
        'HUF' => 'Forint',
        'IDR' => 'Rupiah',
        'ILS' => 'New Israeli Sheqel',
        'INR' => 'Indian Rupee',
        'IQD' => 'Iraqi Dinar',
        'IRR' => 'Iranian Rial',
        'ISK' => 'Iceland Krona',
        'JMD' => 'Jamaican Dollar',
        'JOD' => 'Jordanian Dinar',
        'JPY' => 'Yen',
        'KES' => 'Kenyan Shilling',
        'KGS' => 'Som',
        'KHR' => 'Riel',
        'KMF' => 'Comoro Franc',
        'KPW' => 'North Korean Won',
        'KRW' => 'Won',
        'KWD' => 'Kuwaiti Dinar',
        'KYD' => 'Cayman Islands Dollar',
        'KZT' => 'Tenge',
        'LAK' => 'Kip',
        'LBP' => 'Lebanese Pound',
        'LKR' => 'Sri Lanka Rupee',
        'LRD' => 'Liberian Dollar',
        'LSL' => 'Loti',
        'LYD' => 'Libyan Dinar',
        'MAD' => 'Moroccan Dirham',
        'MDL' => 'Moldovan Leu',
        'MGA' => 'Malagasy Ariary',
        'MKD' => 'Denar',
        'MMK' => 'Kyat',
        'MNT' => 'Tugrik',
        'MOP' => 'Pataca',
        'MRO' => 'Ouguiya',
        'MUR' => 'Mauritius Rupee',
        'MVR' => 'Rufiyaa',
        'MWK' => 'Kwacha',
        'MXN' => 'Mexican Peso',
        'MYR' => 'Malaysian Ringgit',
        'MZN' => 'Mozambique Metical',
        'NAD' => 'Namibia Dollar',
        'NGN' => 'Naira',
        'NIO' => 'Cordoba Oro',
        'NOK' => 'Norwegian Krone',
        'NPR' => 'Nepalese Rupee',
        'NZD' => 'New Zealand Dollar',
        'OMR' => 'Rial Omani',
        'PAB' => 'Balboa',
        'PEN' => 'Nuevo Sol',
        'PGK' => 'Kina',
        'PHP' => 'Philippine Peso',
        'PKR' => 'Pakistan Rupee',
        'PLN' => 'Zloty',
        'PYG' => 'Guarani',
        'QAR' => 'Qatari Rial',
        'RON' => 'Romanian Leu',
        'RSD' => 'Serbian Dinar',
        'RUB' => 'Russian Ruble',
        'RWF' => 'Rwanda Franc',
        'SAR' => 'Saudi Riyal',
        'SBD' => 'Solomon Islands Dollar',
        'SCR' => 'Seychelles Rupee',
        'SDG' => 'Sudanese Pound',
        'SEK' => 'Swedish Krona',
        'SGD' => 'Singapore Dollar',
        'SHP' => 'Saint Helena Pound',
        'SLL' => 'Leone',
        'SOS' => 'Somali Shilling',
        'SRD' => 'Surinam Dollar',
        'STD' => 'Dobra',
        'SVC' => 'El Salvador Colon',
        'SYP' => 'Syrian Pound',
        'SZL' => 'Lilangeni',
        'THB' => 'Baht',
        'TJS' => 'Somoni',
        'TMT' => 'Turkmenistan New Manat',
        'TND' => 'Tunisian Dinar',
        'TOP' => 'Pa’anga',
        'TRY' => 'Turkish Lira',
        'TTD' => 'Trinidad and Tobago Dollar',
        'TWD' => 'New Taiwan Dollar',
        'TZS' => 'Tanzanian Shilling',
        'UAH' => 'Hryvnia',
        'UGX' => 'Uganda Shilling',
        'USD' => 'US Dollar',
        'UYU' => 'Peso Uruguayo',
        'UZS' => 'Uzbekistan Sum',
        'VEF' => 'Bolivar',
        'VND' => 'Dong',
        'VUV' => 'Vatu',
        'WST' => 'Tala',
        'XAF' => 'CFA Franc BEAC',
        'XCD' => 'East Caribbean Dollar',
        'XDR' => 'SDR (Special Drawing Right)',
        'XOF' => 'CFA Franc BCEAO',
        'XPF' => 'CFP Franc',
        'YER' => 'Yemeni Rial',
        'ZAR' => 'Rand',
        'ZWL' => 'Zimbabwe Dollar',
    ];

    private static array $precision = [
        'BHD' => 3,
        'BIF' => 0,
        'CLF' => 4,
        'CLP' => 0,
        'CVE' => 0,
        'DJF' => 0,
        'GNF' => 0,
        'IQD' => 3,
        'ISK' => 0,
        'JOD' => 3,
        'JPY' => 0,
        'KMF' => 0,
        'KRW' => 0,
        'KWD' => 3,
        'LYD' => 3,
        'OMR' => 3,
        'PYG' => 0,
        'RWF' => 0,
        'TND' => 3,
        'UGX' => 0,
        'VND' => 0,
        'VUV' => 0,
        'XAF' => 0,
        'XOF' => 0,
        'XPF' => 0,
    ];
}
