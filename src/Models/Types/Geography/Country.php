<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Geography;

use Somnambulist\Components\Models\AbstractMultiton;
use function strtoupper;

final class Country extends AbstractMultiton
{
    protected function __construct(
        private readonly int $id,
        private readonly string $code2,
        string $code3,
        private readonly string $name
    ) {
        parent::__construct($code3);
    }

    protected static function initializeMembers(): void
    {
        foreach (self::$mappings as $map) {
            new self($map['id'], $map['code2'], $map['code3'], $map['name']);
        }
    }

    public static function getByISONumber(int $code): self
    {
        return static::memberBy('id', $code);
    }

    public static function getByISO2Char(string $code): self
    {
        return static::memberBy('code2', strtoupper($code));
    }

    public static function getByISO3Char(string $code): self
    {
        return static::memberByKey(strtoupper($code));
    }

    public function toString(): string
    {
        return $this->code();
    }

    public function equals(object $object): bool
    {
        if (get_class($object) === get_class($this)) {
            return $object->code() === $this->code() && $object->name() === $this->name();
        }

        return false;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function code2(): string
    {
        return $this->code2;
    }

    public function code3(): string
    {
        return $this->code();
    }

    public function code(): string
    {
        return $this->key();
    }

    public function name(): string
    {
        return $this->name;
    }

    // generated from: https://www.iso.org/obp/ui/#search and https://www.iban.com/country-codes
    private static array $mappings = [
        ['name' => 'Afghanistan', 'code2' => 'AF', 'code3' => 'AFG', 'id' => 4],
        ['name' => 'Albania', 'code2' => 'AL', 'code3' => 'ALB', 'id' => 8],
        ['name' => 'Algeria', 'code2' => 'DZ', 'code3' => 'DZA', 'id' => 12],
        ['name' => 'American Samoa', 'code2' => 'AS', 'code3' => 'ASM', 'id' => 16],
        ['name' => 'Andorra', 'code2' => 'AD', 'code3' => 'AND', 'id' => 20],
        ['name' => 'Angola', 'code2' => 'AO', 'code3' => 'AGO', 'id' => 24],
        ['name' => 'Anguilla', 'code2' => 'AI', 'code3' => 'AIA', 'id' => 660],
        ['name' => 'Antarctica', 'code2' => 'AQ', 'code3' => 'ATA', 'id' => 10],
        ['name' => 'Antigua and Barbuda', 'code2' => 'AG', 'code3' => 'ATG', 'id' => 28],
        ['name' => 'Argentina', 'code2' => 'AR', 'code3' => 'ARG', 'id' => 32],
        ['name' => 'Armenia', 'code2' => 'AM', 'code3' => 'ARM', 'id' => 51],
        ['name' => 'Aruba', 'code2' => 'AW', 'code3' => 'ABW', 'id' => 533],
        ['name' => 'Australia', 'code2' => 'AU', 'code3' => 'AUS', 'id' => 36],
        ['name' => 'Austria', 'code2' => 'AT', 'code3' => 'AUT', 'id' => 40],
        ['name' => 'Azerbaijan', 'code2' => 'AZ', 'code3' => 'AZE', 'id' => 31],
        ['name' => 'Bahamas', 'code2' => 'BS', 'code3' => 'BHS', 'id' => 44],
        ['name' => 'Bahrain', 'code2' => 'BH', 'code3' => 'BHR', 'id' => 48],
        ['name' => 'Bangladesh', 'code2' => 'BD', 'code3' => 'BGD', 'id' => 50],
        ['name' => 'Barbados', 'code2' => 'BB', 'code3' => 'BRB', 'id' => 52],
        ['name' => 'Belarus', 'code2' => 'BY', 'code3' => 'BLR', 'id' => 112],
        ['name' => 'Belgium', 'code2' => 'BE', 'code3' => 'BEL', 'id' => 56],
        ['name' => 'Belize', 'code2' => 'BZ', 'code3' => 'BLZ', 'id' => 84],
        ['name' => 'Benin', 'code2' => 'BJ', 'code3' => 'BEN', 'id' => 204],
        ['name' => 'Bermuda', 'code2' => 'BM', 'code3' => 'BMU', 'id' => 60],
        ['name' => 'Bhutan', 'code2' => 'BT', 'code3' => 'BTN', 'id' => 64],
        ['name' => 'Bolivia', 'code2' => 'BO', 'code3' => 'BOL', 'id' => 68],
        ['name' => 'Bonaire, Sint Eustatius and Saba', 'code2' => 'BQ', 'code3' => 'BES', 'id' => 535],
        ['name' => 'Bosnia and Herzegovina', 'code2' => 'BA', 'code3' => 'BIH', 'id' => 70],
        ['name' => 'Botswana', 'code2' => 'BW', 'code3' => 'BWA', 'id' => 72],
        ['name' => 'Bouvet Island', 'code2' => 'BV', 'code3' => 'BVT', 'id' => 74],
        ['name' => 'Brazil', 'code2' => 'BR', 'code3' => 'BRA', 'id' => 76],
        ['name' => 'British Indian Ocean Territory', 'code2' => 'IO', 'code3' => 'IOT', 'id' => 86],
        ['name' => 'Brunei Darussalam', 'code2' => 'BN', 'code3' => 'BRN', 'id' => 96],
        ['name' => 'Bulgaria', 'code2' => 'BG', 'code3' => 'BGR', 'id' => 100],
        ['name' => 'Burkina Faso', 'code2' => 'BF', 'code3' => 'BFA', 'id' => 854],
        ['name' => 'Burundi', 'code2' => 'BI', 'code3' => 'BDI', 'id' => 108],
        ['name' => 'Cabo Verde', 'code2' => 'CV', 'code3' => 'CPV', 'id' => 132],
        ['name' => 'Cambodia', 'code2' => 'KH', 'code3' => 'KHM', 'id' => 116],
        ['name' => 'Cameroon', 'code2' => 'CM', 'code3' => 'CMR', 'id' => 120],
        ['name' => 'Canada', 'code2' => 'CA', 'code3' => 'CAN', 'id' => 124],
        ['name' => 'Cayman Islands', 'code2' => 'KY', 'code3' => 'CYM', 'id' => 136],
        ['name' => 'Central African Republic', 'code2' => 'CF', 'code3' => 'CAF', 'id' => 140],
        ['name' => 'Chad', 'code2' => 'TD', 'code3' => 'TCD', 'id' => 148],
        ['name' => 'Chile', 'code2' => 'CL', 'code3' => 'CHL', 'id' => 152],
        ['name' => 'China', 'code2' => 'CN', 'code3' => 'CHN', 'id' => 156],
        ['name' => 'Christmas Island', 'code2' => 'CX', 'code3' => 'CXR', 'id' => 162],
        ['name' => 'Cocos (Keeling) Islands', 'code2' => 'CC', 'code3' => 'CCK', 'id' => 166],
        ['name' => 'Colombia', 'code2' => 'CO', 'code3' => 'COL', 'id' => 170],
        ['name' => 'Comoros', 'code2' => 'KM', 'code3' => 'COM', 'id' => 174],
        ['name' => 'Congo (the Democratic Republic of the)', 'code2' => 'CD', 'code3' => 'COD', 'id' => 180],
        ['name' => 'Congo', 'code2' => 'CG', 'code3' => 'COG', 'id' => 178],
        ['name' => 'Cook Islands', 'code2' => 'CK', 'code3' => 'COK', 'id' => 184],
        ['name' => 'Costa Rica', 'code2' => 'CR', 'code3' => 'CRI', 'id' => 188],
        ['name' => 'Croatia', 'code2' => 'HR', 'code3' => 'HRV', 'id' => 191],
        ['name' => 'Cuba', 'code2' => 'CU', 'code3' => 'CUB', 'id' => 192],
        ['name' => 'Curaçao', 'code2' => 'CW', 'code3' => 'CUW', 'id' => 531],
        ['name' => 'Cyprus', 'code2' => 'CY', 'code3' => 'CYP', 'id' => 196],
        ['name' => 'Czechia', 'code2' => 'CZ', 'code3' => 'CZE', 'id' => 203],
        ['name' => 'Côte d\'Ivoire', 'code2' => 'CI', 'code3' => 'CIV', 'id' => 384],
        ['name' => 'Denmark', 'code2' => 'DK', 'code3' => 'DNK', 'id' => 208],
        ['name' => 'Djibouti', 'code2' => 'DJ', 'code3' => 'DJI', 'id' => 262],
        ['name' => 'Dominica', 'code2' => 'DM', 'code3' => 'DMA', 'id' => 212],
        ['name' => 'Dominican Republic', 'code2' => 'DO', 'code3' => 'DOM', 'id' => 214],
        ['name' => 'Ecuador', 'code2' => 'EC', 'code3' => 'ECU', 'id' => 218],
        ['name' => 'Egypt', 'code2' => 'EG', 'code3' => 'EGY', 'id' => 818],
        ['name' => 'El Salvador', 'code2' => 'SV', 'code3' => 'SLV', 'id' => 222],
        ['name' => 'Equatorial Guinea', 'code2' => 'GQ', 'code3' => 'GNQ', 'id' => 226],
        ['name' => 'Eritrea', 'code2' => 'ER', 'code3' => 'ERI', 'id' => 232],
        ['name' => 'Estonia', 'code2' => 'EE', 'code3' => 'EST', 'id' => 233],
        ['name' => 'Eswatini', 'code2' => 'SZ', 'code3' => 'SWZ', 'id' => 748],
        ['name' => 'Ethiopia', 'code2' => 'ET', 'code3' => 'ETH', 'id' => 231],
        ['name' => 'Falkland Islands [Malvinas]', 'code2' => 'FK', 'code3' => 'FLK', 'id' => 238],
        ['name' => 'Faroe Islands', 'code2' => 'FO', 'code3' => 'FRO', 'id' => 234],
        ['name' => 'Fiji', 'code2' => 'FJ', 'code3' => 'FJI', 'id' => 242],
        ['name' => 'Finland', 'code2' => 'FI', 'code3' => 'FIN', 'id' => 246],
        ['name' => 'France', 'code2' => 'FR', 'code3' => 'FRA', 'id' => 250],
        ['name' => 'French Guiana', 'code2' => 'GF', 'code3' => 'GUF', 'id' => 254],
        ['name' => 'French Polynesia', 'code2' => 'PF', 'code3' => 'PYF', 'id' => 258],
        ['name' => 'French Southern Territories', 'code2' => 'TF', 'code3' => 'ATF', 'id' => 260],
        ['name' => 'Gabon', 'code2' => 'GA', 'code3' => 'GAB', 'id' => 266],
        ['name' => 'Gambia', 'code2' => 'GM', 'code3' => 'GMB', 'id' => 270],
        ['name' => 'Georgia', 'code2' => 'GE', 'code3' => 'GEO', 'id' => 268],
        ['name' => 'Germany', 'code2' => 'DE', 'code3' => 'DEU', 'id' => 276],
        ['name' => 'Ghana', 'code2' => 'GH', 'code3' => 'GHA', 'id' => 288],
        ['name' => 'Gibraltar', 'code2' => 'GI', 'code3' => 'GIB', 'id' => 292],
        ['name' => 'Greece', 'code2' => 'GR', 'code3' => 'GRC', 'id' => 300],
        ['name' => 'Greenland', 'code2' => 'GL', 'code3' => 'GRL', 'id' => 304],
        ['name' => 'Grenada', 'code2' => 'GD', 'code3' => 'GRD', 'id' => 308],
        ['name' => 'Guadeloupe', 'code2' => 'GP', 'code3' => 'GLP', 'id' => 312],
        ['name' => 'Guam', 'code2' => 'GU', 'code3' => 'GUM', 'id' => 316],
        ['name' => 'Guatemala', 'code2' => 'GT', 'code3' => 'GTM', 'id' => 320],
        ['name' => 'Guernsey', 'code2' => 'GG', 'code3' => 'GGY', 'id' => 831],
        ['name' => 'Guinea', 'code2' => 'GN', 'code3' => 'GIN', 'id' => 324],
        ['name' => 'Guinea-Bissau', 'code2' => 'GW', 'code3' => 'GNB', 'id' => 624],
        ['name' => 'Guyana', 'code2' => 'GY', 'code3' => 'GUY', 'id' => 328],
        ['name' => 'Haiti', 'code2' => 'HT', 'code3' => 'HTI', 'id' => 332],
        ['name' => 'Heard Island and McDonald Islands', 'code2' => 'HM', 'code3' => 'HMD', 'id' => 334],
        ['name' => 'Holy See', 'code2' => 'VA', 'code3' => 'VAT', 'id' => 336],
        ['name' => 'Honduras', 'code2' => 'HN', 'code3' => 'HND', 'id' => 340],
        ['name' => 'Hong Kong', 'code2' => 'HK', 'code3' => 'HKG', 'id' => 344],
        ['name' => 'Hungary', 'code2' => 'HU', 'code3' => 'HUN', 'id' => 348],
        ['name' => 'Iceland', 'code2' => 'IS', 'code3' => 'ISL', 'id' => 352],
        ['name' => 'India', 'code2' => 'IN', 'code3' => 'IND', 'id' => 356],
        ['name' => 'Indonesia', 'code2' => 'ID', 'code3' => 'IDN', 'id' => 360],
        ['name' => 'Iran (Islamic Republic of)', 'code2' => 'IR', 'code3' => 'IRN', 'id' => 364],
        ['name' => 'Iraq', 'code2' => 'IQ', 'code3' => 'IRQ', 'id' => 368],
        ['name' => 'Ireland', 'code2' => 'IE', 'code3' => 'IRL', 'id' => 372],
        ['name' => 'Isle of Man', 'code2' => 'IM', 'code3' => 'IMN', 'id' => 833],
        ['name' => 'Israel', 'code2' => 'IL', 'code3' => 'ISR', 'id' => 376],
        ['name' => 'Italy', 'code2' => 'IT', 'code3' => 'ITA', 'id' => 380],
        ['name' => 'Jamaica', 'code2' => 'JM', 'code3' => 'JAM', 'id' => 388],
        ['name' => 'Japan', 'code2' => 'JP', 'code3' => 'JPN', 'id' => 392],
        ['name' => 'Jersey', 'code2' => 'JE', 'code3' => 'JEY', 'id' => 832],
        ['name' => 'Jordan', 'code2' => 'JO', 'code3' => 'JOR', 'id' => 400],
        ['name' => 'Kazakhstan', 'code2' => 'KZ', 'code3' => 'KAZ', 'id' => 398],
        ['name' => 'Kenya', 'code2' => 'KE', 'code3' => 'KEN', 'id' => 404],
        ['name' => 'Kiribati', 'code2' => 'KI', 'code3' => 'KIR', 'id' => 296],
        ['name' => 'Korea (the Democratic People\'s Republic of)', 'code2' => 'KP', 'code3' => 'PRK', 'id' => 408],
        ['name' => 'Korea (the Republic of)', 'code2' => 'KR', 'code3' => 'KOR', 'id' => 410],
        ['name' => 'Kuwait', 'code2' => 'KW', 'code3' => 'KWT', 'id' => 414],
        ['name' => 'Kyrgyzstan', 'code2' => 'KG', 'code3' => 'KGZ', 'id' => 417],
        ['name' => 'Lao People\'s Democratic Republic', 'code2' => 'LA', 'code3' => 'LAO', 'id' => 418],
        ['name' => 'Latvia', 'code2' => 'LV', 'code3' => 'LVA', 'id' => 428],
        ['name' => 'Lebanon', 'code2' => 'LB', 'code3' => 'LBN', 'id' => 422],
        ['name' => 'Lesotho', 'code2' => 'LS', 'code3' => 'LSO', 'id' => 426],
        ['name' => 'Liberia', 'code2' => 'LR', 'code3' => 'LBR', 'id' => 430],
        ['name' => 'Libya', 'code2' => 'LY', 'code3' => 'LBY', 'id' => 434],
        ['name' => 'Liechtenstein', 'code2' => 'LI', 'code3' => 'LIE', 'id' => 438],
        ['name' => 'Lithuania', 'code2' => 'LT', 'code3' => 'LTU', 'id' => 440],
        ['name' => 'Luxembourg', 'code2' => 'LU', 'code3' => 'LUX', 'id' => 442],
        ['name' => 'Macao', 'code2' => 'MO', 'code3' => 'MAC', 'id' => 446],
        ['name' => 'Madagascar', 'code2' => 'MG', 'code3' => 'MDG', 'id' => 450],
        ['name' => 'Malawi', 'code2' => 'MW', 'code3' => 'MWI', 'id' => 454],
        ['name' => 'Malaysia', 'code2' => 'MY', 'code3' => 'MYS', 'id' => 458],
        ['name' => 'Maldives', 'code2' => 'MV', 'code3' => 'MDV', 'id' => 462],
        ['name' => 'Mali', 'code2' => 'ML', 'code3' => 'MLI', 'id' => 466],
        ['name' => 'Malta', 'code2' => 'MT', 'code3' => 'MLT', 'id' => 470],
        ['name' => 'Marshall Islands', 'code2' => 'MH', 'code3' => 'MHL', 'id' => 584],
        ['name' => 'Martinique', 'code2' => 'MQ', 'code3' => 'MTQ', 'id' => 474],
        ['name' => 'Mauritania', 'code2' => 'MR', 'code3' => 'MRT', 'id' => 478],
        ['name' => 'Mauritius', 'code2' => 'MU', 'code3' => 'MUS', 'id' => 480],
        ['name' => 'Mayotte', 'code2' => 'YT', 'code3' => 'MYT', 'id' => 175],
        ['name' => 'Mexico', 'code2' => 'MX', 'code3' => 'MEX', 'id' => 484],
        ['name' => 'Micronesia (Federated States of)', 'code2' => 'FM', 'code3' => 'FSM', 'id' => 583],
        ['name' => 'Moldova (the Republic of)', 'code2' => 'MD', 'code3' => 'MDA', 'id' => 498],
        ['name' => 'Monaco', 'code2' => 'MC', 'code3' => 'MCO', 'id' => 492],
        ['name' => 'Mongolia', 'code2' => 'MN', 'code3' => 'MNG', 'id' => 496],
        ['name' => 'Montenegro', 'code2' => 'ME', 'code3' => 'MNE', 'id' => 499],
        ['name' => 'Montserrat', 'code2' => 'MS', 'code3' => 'MSR', 'id' => 500],
        ['name' => 'Morocco', 'code2' => 'MA', 'code3' => 'MAR', 'id' => 504],
        ['name' => 'Mozambique', 'code2' => 'MZ', 'code3' => 'MOZ', 'id' => 508],
        ['name' => 'Myanmar', 'code2' => 'MM', 'code3' => 'MMR', 'id' => 104],
        ['name' => 'Namibia', 'code2' => 'NA', 'code3' => 'NAM', 'id' => 516],
        ['name' => 'Nauru', 'code2' => 'NR', 'code3' => 'NRU', 'id' => 520],
        ['name' => 'Nepal', 'code2' => 'NP', 'code3' => 'NPL', 'id' => 524],
        ['name' => 'Netherlands', 'code2' => 'NL', 'code3' => 'NLD', 'id' => 528],
        ['name' => 'New Caledonia', 'code2' => 'NC', 'code3' => 'NCL', 'id' => 540],
        ['name' => 'New Zealand', 'code2' => 'NZ', 'code3' => 'NZL', 'id' => 554],
        ['name' => 'Nicaragua', 'code2' => 'NI', 'code3' => 'NIC', 'id' => 558],
        ['name' => 'Niger', 'code2' => 'NE', 'code3' => 'NER', 'id' => 562],
        ['name' => 'Nigeria', 'code2' => 'NG', 'code3' => 'NGA', 'id' => 566],
        ['name' => 'Niue', 'code2' => 'NU', 'code3' => 'NIU', 'id' => 570],
        ['name' => 'Norfolk Island', 'code2' => 'NF', 'code3' => 'NFK', 'id' => 574],
        ['name' => 'North Macedonia', 'code2' => 'MK', 'code3' => 'MKD', 'id' => 807],
        ['name' => 'Northern Mariana Islands', 'code2' => 'MP', 'code3' => 'MNP', 'id' => 580],
        ['name' => 'Norway', 'code2' => 'NO', 'code3' => 'NOR', 'id' => 578],
        ['name' => 'Oman', 'code2' => 'OM', 'code3' => 'OMN', 'id' => 512],
        ['name' => 'Pakistan', 'code2' => 'PK', 'code3' => 'PAK', 'id' => 586],
        ['name' => 'Palau', 'code2' => 'PW', 'code3' => 'PLW', 'id' => 585],
        ['name' => 'Palestine, State of', 'code2' => 'PS', 'code3' => 'PSE', 'id' => 275],
        ['name' => 'Panama', 'code2' => 'PA', 'code3' => 'PAN', 'id' => 591],
        ['name' => 'Papua New Guinea', 'code2' => 'PG', 'code3' => 'PNG', 'id' => 598],
        ['name' => 'Paraguay', 'code2' => 'PY', 'code3' => 'PRY', 'id' => 600],
        ['name' => 'Peru', 'code2' => 'PE', 'code3' => 'PER', 'id' => 604],
        ['name' => 'Philippines', 'code2' => 'PH', 'code3' => 'PHL', 'id' => 608],
        ['name' => 'Pitcairn', 'code2' => 'PN', 'code3' => 'PCN', 'id' => 612],
        ['name' => 'Poland', 'code2' => 'PL', 'code3' => 'POL', 'id' => 616],
        ['name' => 'Portugal', 'code2' => 'PT', 'code3' => 'PRT', 'id' => 620],
        ['name' => 'Puerto Rico', 'code2' => 'PR', 'code3' => 'PRI', 'id' => 630],
        ['name' => 'Qatar', 'code2' => 'QA', 'code3' => 'QAT', 'id' => 634],
        ['name' => 'Romania', 'code2' => 'RO', 'code3' => 'ROU', 'id' => 642],
        ['name' => 'Russian Federation', 'code2' => 'RU', 'code3' => 'RUS', 'id' => 643],
        ['name' => 'Rwanda', 'code2' => 'RW', 'code3' => 'RWA', 'id' => 646],
        ['name' => 'Réunion', 'code2' => 'RE', 'code3' => 'REU', 'id' => 638],
        ['name' => 'Saint Barthélemy', 'code2' => 'BL', 'code3' => 'BLM', 'id' => 652],
        ['name' => 'Saint Helena, Ascension and Tristan da Cunha', 'code2' => 'SH', 'code3' => 'SHN', 'id' => 654],
        ['name' => 'Saint Kitts and Nevis', 'code2' => 'KN', 'code3' => 'KNA', 'id' => 659],
        ['name' => 'Saint Lucia', 'code2' => 'LC', 'code3' => 'LCA', 'id' => 662],
        ['name' => 'Saint Martin (French part)', 'code2' => 'MF', 'code3' => 'MAF', 'id' => 663],
        ['name' => 'Saint Pierre and Miquelon', 'code2' => 'PM', 'code3' => 'SPM', 'id' => 666],
        ['name' => 'Saint Vincent and the Grenadines', 'code2' => 'VC', 'code3' => 'VCT', 'id' => 670],
        ['name' => 'Samoa', 'code2' => 'WS', 'code3' => 'WSM', 'id' => 882],
        ['name' => 'San Marino', 'code2' => 'SM', 'code3' => 'SMR', 'id' => 674],
        ['name' => 'Sao Tome and Principe', 'code2' => 'ST', 'code3' => 'STP', 'id' => 678],
        ['name' => 'Saudi Arabia', 'code2' => 'SA', 'code3' => 'SAU', 'id' => 682],
        ['name' => 'Senegal', 'code2' => 'SN', 'code3' => 'SEN', 'id' => 686],
        ['name' => 'Serbia', 'code2' => 'RS', 'code3' => 'SRB', 'id' => 688],
        ['name' => 'Seychelles', 'code2' => 'SC', 'code3' => 'SYC', 'id' => 690],
        ['name' => 'Sierra Leone', 'code2' => 'SL', 'code3' => 'SLE', 'id' => 694],
        ['name' => 'Singapore', 'code2' => 'SG', 'code3' => 'SGP', 'id' => 702],
        ['name' => 'Sint Maarten (Dutch part)', 'code2' => 'SX', 'code3' => 'SXM', 'id' => 534],
        ['name' => 'Slovakia', 'code2' => 'SK', 'code3' => 'SVK', 'id' => 703],
        ['name' => 'Slovenia', 'code2' => 'SI', 'code3' => 'SVN', 'id' => 705],
        ['name' => 'Solomon Islands', 'code2' => 'SB', 'code3' => 'SLB', 'id' => 90],
        ['name' => 'Somalia', 'code2' => 'SO', 'code3' => 'SOM', 'id' => 706],
        ['name' => 'South Africa', 'code2' => 'ZA', 'code3' => 'ZAF', 'id' => 710],
        ['name' => 'South Georgia and the South Sandwich Islands', 'code2' => 'GS', 'code3' => 'SGS', 'id' => 239],
        ['name' => 'South Sudan', 'code2' => 'SS', 'code3' => 'SSD', 'id' => 728],
        ['name' => 'Spain', 'code2' => 'ES', 'code3' => 'ESP', 'id' => 724],
        ['name' => 'Sri Lanka', 'code2' => 'LK', 'code3' => 'LKA', 'id' => 144],
        ['name' => 'Sudan', 'code2' => 'SD', 'code3' => 'SDN', 'id' => 729],
        ['name' => 'Suriname', 'code2' => 'SR', 'code3' => 'SUR', 'id' => 740],
        ['name' => 'Svalbard and Jan Mayen', 'code2' => 'SJ', 'code3' => 'SJM', 'id' => 744],
        ['name' => 'Sweden', 'code2' => 'SE', 'code3' => 'SWE', 'id' => 752],
        ['name' => 'Switzerland', 'code2' => 'CH', 'code3' => 'CHE', 'id' => 756],
        ['name' => 'Syrian Arab Republic', 'code2' => 'SY', 'code3' => 'SYR', 'id' => 760],
        ['name' => 'Taiwan (Province of China)', 'code2' => 'TW', 'code3' => 'TWN', 'id' => 158],
        ['name' => 'Tajikistan', 'code2' => 'TJ', 'code3' => 'TJK', 'id' => 762],
        ['name' => 'Tanzania, the United Republic of', 'code2' => 'TZ', 'code3' => 'TZA', 'id' => 834],
        ['name' => 'Thailand', 'code2' => 'TH', 'code3' => 'THA', 'id' => 764],
        ['name' => 'Timor-Leste', 'code2' => 'TL', 'code3' => 'TLS', 'id' => 626],
        ['name' => 'Togo', 'code2' => 'TG', 'code3' => 'TGO', 'id' => 768],
        ['name' => 'Tokelau', 'code2' => 'TK', 'code3' => 'TKL', 'id' => 772],
        ['name' => 'Tonga', 'code2' => 'TO', 'code3' => 'TON', 'id' => 776],
        ['name' => 'Trinidad and Tobago', 'code2' => 'TT', 'code3' => 'TTO', 'id' => 780],
        ['name' => 'Tunisia', 'code2' => 'TN', 'code3' => 'TUN', 'id' => 788],
        ['name' => 'Turkey', 'code2' => 'TR', 'code3' => 'TUR', 'id' => 792],
        ['name' => 'Turkmenistan', 'code2' => 'TM', 'code3' => 'TKM', 'id' => 795],
        ['name' => 'Turks and Caicos Islands', 'code2' => 'TC', 'code3' => 'TCA', 'id' => 796],
        ['name' => 'Tuvalu', 'code2' => 'TV', 'code3' => 'TUV', 'id' => 798],
        ['name' => 'Uganda', 'code2' => 'UG', 'code3' => 'UGA', 'id' => 800],
        ['name' => 'Ukraine', 'code2' => 'UA', 'code3' => 'UKR', 'id' => 804],
        ['name' => 'United Arab Emirates', 'code2' => 'AE', 'code3' => 'ARE', 'id' => 784],
        ['name' => 'United Kingdom of Great Britain and Northern Ireland', 'code2' => 'GB', 'code3' => 'GBR', 'id' => 826],
        ['name' => 'United States Minor Outlying Islands', 'code2' => 'UM', 'code3' => 'UMI', 'id' => 581],
        ['name' => 'United States of America', 'code2' => 'US', 'code3' => 'USA', 'id' => 840],
        ['name' => 'Uruguay', 'code2' => 'UY', 'code3' => 'URY', 'id' => 858],
        ['name' => 'Uzbekistan', 'code2' => 'UZ', 'code3' => 'UZB', 'id' => 860],
        ['name' => 'Vanuatu', 'code2' => 'VU', 'code3' => 'VUT', 'id' => 548],
        ['name' => 'Venezuela (Bolivarian Republic of)', 'code2' => 'VE', 'code3' => 'VEN', 'id' => 862],
        ['name' => 'Viet Nam', 'code2' => 'VN', 'code3' => 'VNM', 'id' => 704],
        ['name' => 'Virgin Islands (British)', 'code2' => 'VG', 'code3' => 'VGB', 'id' => 92],
        ['name' => 'Virgin Islands (U.S.)', 'code2' => 'VI', 'code3' => 'VIR', 'id' => 850],
        ['name' => 'Wallis and Futuna', 'code2' => 'WF', 'code3' => 'WLF', 'id' => 876],
        ['name' => 'Western Sahara*', 'code2' => 'EH', 'code3' => 'ESH', 'id' => 732],
        ['name' => 'Yemen', 'code2' => 'YE', 'code3' => 'YEM', 'id' => 887],
        ['name' => 'Zambia', 'code2' => 'ZM', 'code3' => 'ZMB', 'id' => 894],
        ['name' => 'Zimbabwe', 'code2' => 'ZW', 'code3' => 'ZWE', 'id' => 716],
        ['name' => 'Åland Islands', 'code2' => 'AX', 'code3' => 'ALA', 'id' => 248],

        // see: https://www.iso.org/glossary-for-iso-3166.html
        // see: https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#User-assigned_code_elements
        // see: https://en.wikipedia.org/wiki/ISO_3166-1_numeric#User-assigned_code_elements
        ['name' => 'Worldwide', 'code2' => 'ZZ', 'code3' => 'ZZZ', 'id' => 999],
    ];
}
