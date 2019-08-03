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
            'AMBU' => 'Ambo University',
            'AMU' => 'Arba Minch University',
            'ARU' => 'Arsi University',
            'ASU' => 'Assosa University',
            'AXU' => 'Axsum University',

            'BDU' => 'Bahir Dar University',
            'BOU' => 'Bonga University',
            'BHU' => 'Bule Hora University',

            'DBKU' => 'Debark University',
            'DBU' => 'Debre Birhan University',
            'DMU' => 'Debre Markos University',
            'DTU' => 'Debre Tabor University',
            'DDU' => 'Dembi Dolo University',
            'DLU' => 'Dilla University',
            'DDU' => 'Dire Dawa University',

            'GMU' => 'Gambella University',
            'GU' => 'Gondar University',

            'HMU' => 'Haramaya University',
            'HWU' => 'Hawassa University',

            'IU' => 'Injibara University',

            'JJU' => 'Jijiga University',
            'JMU' => 'Jimma University',
            'JKU' => 'Jinka University',

            'KDU' => 'Kebri Dehar University',

            'MWU' => 'Madda Walabu University',
            'MAU' => 'Mekdela Amba University',
            'MU' => 'Mekele University',
            'MEU' => 'Mettu University',
            'MTU' => 'Mizan Tepi University',

            'OBU' => 'Oda Bultum University',

            'RU' => 'Raya University',

            'SLU' => 'Salale University',
            'SMU' => 'Semera University',

            'WCU' => 'Wachamo University',
            'WKU' => 'Welkite University',
            'WRU' => 'Werabe University',
            'WSU' => 'Wolaita Sodo University',
            'WDU' => 'Woldiya University',
            'WLU' => 'Wollega University',
            'WOU' => 'Wollo University',

            'ECSC' => 'Civil Service University',
            'DEC' => 'Ethiopian Defence University',
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
