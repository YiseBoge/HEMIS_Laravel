<?php

use App\Models\Report\InstitutionReportCard;
use Illuminate\Database\Seeder;

class InstitutionReportCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $policies = array(
            '1' => '1.	Improve Access & Equity',
            '2' => '2.	Improve Internal Efficiency',
            '3' => '3.	Improve Quality & Relevance of Education',
            '4' => '4.	Improve Quality & Relevance of Research',
            '5' => '5.	Improve Unity in Diversity',
            '6' => '6.	Improve Internationalization',
            '7' => '7.	Improve Resources Mobilization',
        );

        $descriptions = array(
            '1.1' => '1.1	Increase capacity to enroll new students',
            '1.2' => '1.2	Increase participation of female students',
            '1.3' => '1.3	Increase participation of persons with disabilities',

            '2.1' => '2.1	Reduce student dropout rate (both sex)',
            '2.2' => '2.2	Reduce dropout rate for female students',
            '2.3' => '2.3	Reduce academic dismissal rate (both sex)',
            '2.4' => '2.4	Reduce academic dismissal rate for female students',
            '2.5' => '2.5	Improve graduation rate (both sex)',
            '2.6' => '2.6	Increase graduation rate of female students',
            '2.7' => '2.7	Reduce staff attrition rate',

            '3.1' => '3.1	Improve quality of instruction',
            '3.2' => '3.2	Increase performance of students in exit examinations',
            '3.3' => '3.3	Improve employability of students',

            '4.1' => '4.1	Improve quality, relevance and accessibility of higher education research and research outputs',

            '5.1' => '5.1   Improve gender diversity of academic staff ',
            '5.2' => '5.2	Improve gender diversity of university management staff at all levels',
            '5.3' => '5.3	Improve gender diversity of students',
            '5.4' => '5.4	Improve regional diversity of academic staff',
            '5.5' => '5.5	Improve regional diversity of management staff at all levels',
            '5.6' => '5.6	Improve regional diversity of students',

            '6.1' => '6.1	Increase the contribution of Ethiopia diaspora in teaching and research advising',
            '6.2' => '6.2	Increase student exchange between Ethiopian and foreign universities (inbound and outbound mobility)',
            '6.3' => '6.3	Increase staff exchange foreign universities',

            '7.1' => '7.1	Increase resources mobilized from sources other than the government subsidy budget',
            '7.2' => '7.2	Improve efficiency & effectiveness in fund utilization',
        );

        $kpis = InstitutionReportCard::getEnum('kpi');

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.1'];
        $field->kpi = $kpis['1.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.1'];
        $field->kpi = $kpis['1.1.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.2'];
        $field->kpi = $kpis['1.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.2'];
        $field->kpi = $kpis['1.2.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.3'];
        $field->kpi = $kpis['1.3.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.3'];
        $field->kpi = $kpis['1.3.2'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.5'];
        $field->kpi = $kpis['2.5.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.5'];
        $field->kpi = $kpis['2.5.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.6'];
        $field->kpi = $kpis['2.6.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.6'];
        $field->kpi = $kpis['2.6.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.7'];
        $field->kpi = $kpis['2.7.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.7'];
        $field->kpi = $kpis['2.7.2'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.1'];
        $field->kpi = $kpis['3.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.1'];
        $field->kpi = $kpis['3.1.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.2'];
        $field->kpi = $kpis['3.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.3'];
        $field->kpi = $kpis['3.3.1'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.3'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.1'];
        $field->kpi = $kpis['5.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.2'];
        $field->kpi = $kpis['5.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.3'];
        $field->kpi = $kpis['5.3.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.4'];
        $field->kpi = $kpis['5.4.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.5'];
        $field->kpi = $kpis['5.5.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.6'];
        $field->kpi = $kpis['5.6.1'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.1'];
        $field->kpi = $kpis['6.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.2'];
        $field->kpi = $kpis['6.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.2'];
        $field->kpi = $kpis['6.2.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.3'];
        $field->kpi = $kpis['6.3.1'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['7'];
        $field->policy_description = $descriptions['7.1'];
        $field->kpi = $kpis['7.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['7'];
        $field->policy_description = $descriptions['7.2'];
        $field->kpi = $kpis['7.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['7'];
        $field->policy_description = $descriptions['7.2'];
        $field->kpi = $kpis['7.2.2'];
        $field->save();
    }
}
