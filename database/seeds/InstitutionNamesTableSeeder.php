<?php

use App\Models\Institution\InstitutionName;
use Illuminate\Database\Seeder;

class InstitutionNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allInstitutions = [
            'ASTU' => 'Adama Science & Technology University',
            'AASTU' => 'Addis Ababa Science & Technology University',
            'AAU' => 'Addis Ababa University',
            'ADU' => 'Adigrat University',
            'AKU' => 'Aksum University',
            'AMBU' => 'Ambo University',
            'AMU' => 'Arba Minch University',
            'ARSIUN' => 'Arsi University',
            'ASU' => 'Assosa University',

            'BDU' => 'Bahir Dar University',
            'BU' => 'Bonga University',
            'BHU' => 'Bule Hora University',

            'DADU' => 'Dambi Dolo University',
            'DBKU' => 'Debark University',
            'DBU' => 'Debre Birhan University',
            'DMU' => 'Debre Markos University',
            'DTU' => 'Debre Tabor University',
            'DU' => 'Dilla University',
            'DDU' => 'Dire Dawa University',

            'GMU' => 'Gambella University',

            'HMU' => 'Haramaya University',
            'HU' => 'Hawassa University',

            'INU' => 'Injibara University',

            'JJU' => 'Jijiga University',
            'JU' => 'Jimma University',
            'JKU' => 'Jinka University',

            'KDU' => 'Kebri Dehar University',

            'MWU' => 'Madda Walabu University',
            'MAU' => 'Mekdela Amba University',
            'MU' => 'Mekele University',
            'MEU' => 'Mettu University',
            'MTU' => 'Mizan Tepi University',

            'OBU' => 'Oda Bultum University',

            'RAYU' => 'Raya University',

            'SLU' => 'Salale University',
            'SMU' => 'Semera University',

            'UoG' => 'University of Gondar',

            'WCU' => 'Wachamo University',
            'WRU' => 'Werabe University',
            'WSU' => 'Wolaita Sodo University',
            'WLDU' => 'Woldiya University',
            'WKU' => 'Wolkite University',
            'WLU' => 'Wollega University',
            'WU' => 'Wollo University',

            'ECSC' => 'Civil Service University',
            'NDU' => 'Defence University',
        ];

        foreach ($allInstitutions as $acronym => $name) {
            $institutionName = new InstitutionName();
            $institutionName->acronym = $acronym;
            $institutionName->institution_name = $name;
            $institutionName->is_private = false;

            $institutionName->save();
        }
    }
}
