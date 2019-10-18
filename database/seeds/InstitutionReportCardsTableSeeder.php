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
            '1' => '1.	Improve access & equity in higher education',
            '2' => '2.	Improve internal efficiency in higher education',
            '3' => '3.	Improve quality & relevance of higher education',
            '4' => '4.	Improve gender diversity in higher education',
            '5' => '5.	Improve internationalization',
            '6' => '6.	Improve capacity and resources mobilization',
        );

        $descriptions = array(
            '1.1' => '1.1	Increase capacity to enroll new students',
            '1.2' => '1.2	Increase enrollment in STEM study fields',
            '1.3' => '1.3	Increase participation of female students',
            '1.4' => '1.4	Increase participation of female students in STEM subjects',
            '1.5' => '1.5	Increase participation of persons with disabilities',
            '1.6' => '1.6	Increase participation of students from emerging regions',
            '1.7' => '1.7	Increase participation of students from economically poor households',

            '2.1' => '2.1	Reduce dropout rate of male and female students',
            '2.2' => '2.2	Reduce dropout rate of female students',
            '2.3' => '2.3	Reduce academic dismissal rate of male and female students',
            '2.4' => '2.4	Reduce academic dismissal rate of female students',
            '2.5' => '2.5	Increase graduation rate of male and female students',
            '2.6' => '2.6	Increase graduation rate of female students',
            '2.7' => '2.7	Increase graduation rate of students with disabilities',
            '2.8' => '2.8	Increase graduation rate of students from emerging regions',
            '2.9' => '2.9	Increase graduation rate of students from economically poor households',

            '3.1' => '3.1	Improve quality of instruction in HEIs',
            '3.2' => '3.2	Improve performance of students in exit examinations',
            '3.3' => '3.3	Improve employability of students in HEIs',
            '3.4' => '3.4	Improve quality, relevance and accessibility of higher education research and research outputs',

            '4.1' => '4.1	 Improve gender diversity of academic staff',
            '4.2' => '4.2	 Improve gender diversity of technical support staff',
            '4.3' => '4.3	 Improve gender diversity of professional staff in teaching hospitals',
            '4.4' => '4.4	 Improve gender diversity of administrative support staff',
            '4.5' => '4.5	 Improve gender diversity of staff appointed at senior management positions',
            '4.6' => '4.6	 Improve gender diversity of staff appointed at middle management positions',
            '4.7' => '4.7	 Improve gender diversity of staff appointed at lower management positions',

            '5.1' => '5.1	Increase the contribution of Ethiopian diaspora in academic activities',
            '5.2' => '5.2	Increase student exchange between Ethiopian and foreign universities',

            '6.1' => '6.1	Increase funds for research and development',
            '6.2' => '6.2	Increase resources mobilized from sources other than the government subsidy budget',
            '6.3' => '6.3	Increase efficiency in utilizing funds',
            '6.4' => '6.4	Decrease dependency on expatriate academic staff',
            '6.5' => '6.5	Reduce staff attrition rate',
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
        $field->policy_description = $descriptions['1.1'];
        $field->kpi = $kpis['1.1.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.1'];
        $field->kpi = $kpis['1.1.4'];
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
        $field->policy_description = $descriptions['1.2'];
        $field->kpi = $kpis['1.2.3'];
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

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.3'];
        $field->kpi = $kpis['1.3.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.3'];
        $field->kpi = $kpis['1.3.4'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.4'];
        $field->kpi = $kpis['1.4.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.4'];
        $field->kpi = $kpis['1.4.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.4'];
        $field->kpi = $kpis['1.4.3'];
        $field->save();


        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.5'];
        $field->kpi = $kpis['1.5.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.5'];
        $field->kpi = $kpis['1.5.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.5'];
        $field->kpi = $kpis['1.5.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.5'];
        $field->kpi = $kpis['1.5.4'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.6'];
        $field->kpi = $kpis['1.6.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.6'];
        $field->kpi = $kpis['1.6.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.6'];
        $field->kpi = $kpis['1.6.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.6'];
        $field->kpi = $kpis['1.6.4'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.7'];
        $field->kpi = $kpis['1.7.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.7'];
        $field->kpi = $kpis['1.7.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.7'];
        $field->kpi = $kpis['1.7.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.7'];
        $field->kpi = $kpis['1.7.4'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.2'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.3'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.4'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.2'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.3'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.4'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.2'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.3'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.4'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.2'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.3'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.4'];
        $field->is_decreasing = true;
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
        $field->policy_description = $descriptions['2.5'];
        $field->kpi = $kpis['2.5.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.5'];
        $field->kpi = $kpis['2.5.4'];
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
        $field->policy_description = $descriptions['2.6'];
        $field->kpi = $kpis['2.6.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.6'];
        $field->kpi = $kpis['2.6.4'];
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

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.7'];
        $field->kpi = $kpis['2.7.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.7'];
        $field->kpi = $kpis['2.7.4'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.8'];
        $field->kpi = $kpis['2.8.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.8'];
        $field->kpi = $kpis['2.8.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.8'];
        $field->kpi = $kpis['2.8.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.8'];
        $field->kpi = $kpis['2.8.4'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.9'];
        $field->kpi = $kpis['2.9.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.9'];
        $field->kpi = $kpis['2.9.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.9'];
        $field->kpi = $kpis['2.9.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.9'];
        $field->kpi = $kpis['2.9.4'];
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
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.1'];
        $field->kpi = $kpis['3.1.3'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.1'];
        $field->kpi = $kpis['3.1.4'];
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

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.4'];
        $field->kpi = $kpis['3.4.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.4'];
        $field->kpi = $kpis['3.4.2'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.4'];
        $field->kpi = $kpis['3.4.3'];
        $field->save();

        // break

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.2'];
        $field->kpi = $kpis['4.2.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.3'];
        $field->kpi = $kpis['4.3.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.4'];
        $field->kpi = $kpis['4.4.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.5'];
        $field->kpi = $kpis['4.5.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.6'];
        $field->kpi = $kpis['4.6.1'];
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.7'];
        $field->kpi = $kpis['4.7.1'];
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
        $field->policy_description = $descriptions['5.2'];
        $field->kpi = $kpis['5.2.2'];
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
        $field->policy_description = $descriptions['6.3'];
        $field->kpi = $kpis['6.3.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.4'];
        $field->kpi = $kpis['6.4.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.5'];
        $field->kpi = $kpis['6.5.1'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.5'];
        $field->kpi = $kpis['6.5.2'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.5'];
        $field->kpi = $kpis['6.5.3'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.5'];
        $field->kpi = $kpis['6.5.4'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.5'];
        $field->kpi = $kpis['6.5.5'];
        $field->is_decreasing = true;
        $field->save();

        $field = new InstitutionReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.5'];
        $field->kpi = $kpis['6.5.6'];
        $field->is_decreasing = true;
        $field->save();
    }
}
