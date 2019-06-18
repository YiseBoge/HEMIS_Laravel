<?php

use App\Models\Report\ReportCard;
use Illuminate\Database\Seeder;

class ReportCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $policies = array(
            '1' => '1.	Improve access & equity',
            '2' => '2.	Improve internal efficiency',
            '3' => '3.	Improve quality & relevance of education',
            '4' => '4.	Improve quality & relevance of research',
            '5' => '5.	Promote diversity in higher education institutions',
            '6' => '6.	Improve internationalization',
            '7' => '7.	Improve resources mobilization',
        );

        $descriptions = array(
            '1.1' => '1.1	Increase capacity to take new student in tertiary education programmes',
            '1.2' => '1.2	Increase participation of female students in higher education',
            '1.3' => '1.3	Increase participation of persons with disabilities in higher education',
            '1.4' => '1.4	Increase participation of students from economically disadvantaged backgrounds in higher education',
            '1.5' => '1.5	Increase participation of students from emerging regions',
            '1.6' => '1.6	Increase in rural students participation in higher education',
            '1.7' => '1.7	Increase enrollment capacity of private HEIs',

            '2.1' => '2.1	Reduce student dropout rate (both sex)',
            '2.2' => '2.2	Reduce dropout rate for female students',
            '2.3' => '2.3	Reduce academic dismissal rate (both sex)',
            '2.4' => '2.4	Reduce academic dismissal rate for female students',
            '2.5' => '2.5	Improve graduation rate (both sex)',
            '2.6' => '2.6	Increase graduation rate of female students',
            '2.7' => '2.7	Reduce dropout rate for students with disabilities',
            '2.8' => '2.8	Reduce dropout rate for economically poor students',
            '2.9' => '2.9	Reduce dropout rate for students from emerging regions',
            '2.10' => '2.10	Reduce higher education staff attrition rate',

            '3.1' => '3.1	Improve quality of instruction in HEIs',
            '3.2' => '3.2	Increase performance of students in exist examinations',
            '3.3' => '3.3	Improve employability of students in HEIs',
            '3.4' => '3.4	Increase students enrollment in science & technology fields',

            '4.1' => '4.1	Improve quality, relevance and accessibility of higher education research and research outputs',

            '5.1' => '5.1   Improve gender diversity of academic staff ',
            '5.2' => '5.2	Improve gender diversity of university management staff at all levels (lower, middle, senior levels)',
            '5.3' => '5.3	Improve gender diversity of students',
            '5.4' => '5.4	Improve regional diversity of academic staff',
            '5.5' => '5.5	Improve regional diversity of management staff at all levels (lower, middle, senior levels)',
            '5.6' => '5.6	Improve regional diversity of students',

            '6.1' => '6.1	Increase the contribution of Ethiopia diaspora in teaching and research advising',
            '6.2' => '6.2	Increase student exchange between Ethiopian and foreign universities (inbound and outbound mobility)',
            '6.3' => '6.3	Increase staff exchange foreign universities',

            '7.1' => '7.1	Increase resources mobilized from sources other than the government subsidy budget',
            '7.2' => '7.2	Improve efficiency & effectiveness in fund utilization',
            '7.3' => '7.3	Improve loan recovery from student cost sharing loan',
        );

        $kpis = ReportCard::getEnum('kpi');

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.1'];
        $field->kpi = $kpis['1.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.1'];
        $field->kpi = $kpis['1.1.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.2'];
        $field->kpi = $kpis['1.2.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.2'];
        $field->kpi = $kpis['1.2.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.3'];
        $field->kpi = $kpis['1.3.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.3'];
        $field->kpi = $kpis['1.3.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.4'];
        $field->kpi = $kpis['1.4.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.5'];
        $field->kpi = $kpis['1.5.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.6'];
        $field->kpi = $kpis['1.6.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['1'];
        $field->policy_description = $descriptions['1.7'];
        $field->kpi = $kpis['1.7.1'];
        $field->save();

        // break

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.1'];
        $field->kpi = $kpis['2.1.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.2'];
        $field->kpi = $kpis['2.2.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.3'];
        $field->kpi = $kpis['2.3.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.4'];
        $field->kpi = $kpis['2.4.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.5'];
        $field->kpi = $kpis['2.5.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.5'];
        $field->kpi = $kpis['2.5.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.6'];
        $field->kpi = $kpis['2.6.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.6'];
        $field->kpi = $kpis['2.6.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.7'];
        $field->kpi = $kpis['2.7.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.8'];
        $field->kpi = $kpis['2.8.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.9'];
        $field->kpi = $kpis['2.9.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.10'];
        $field->kpi = $kpis['2.10.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['2'];
        $field->policy_description = $descriptions['2.10'];
        $field->kpi = $kpis['2.10.2'];
        $field->save();

        // break

        $field = new ReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.1'];
        $field->kpi = $kpis['3.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.1'];
        $field->kpi = $kpis['3.1.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.2'];
        $field->kpi = $kpis['3.2.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.3'];
        $field->kpi = $kpis['3.3.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['3'];
        $field->policy_description = $descriptions['3.4'];
        $field->kpi = $kpis['3.4.1'];
        $field->save();

        // break

        $field = new ReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['4'];
        $field->policy_description = $descriptions['4.1'];
        $field->kpi = $kpis['4.1.3'];
        $field->save();

        // break

        $field = new ReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.1'];
        $field->kpi = $kpis['5.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.2'];
        $field->kpi = $kpis['5.2.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.3'];
        $field->kpi = $kpis['5.3.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.4'];
        $field->kpi = $kpis['5.4.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.5'];
        $field->kpi = $kpis['5.5.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['5'];
        $field->policy_description = $descriptions['5.6'];
        $field->kpi = $kpis['5.6.1'];
        $field->save();

        // break

        $field = new ReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.1'];
        $field->kpi = $kpis['6.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.2'];
        $field->kpi = $kpis['6.2.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.2'];
        $field->kpi = $kpis['6.2.2'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['6'];
        $field->policy_description = $descriptions['6.3'];
        $field->kpi = $kpis['6.3.1'];
        $field->save();

        // break

        $field = new ReportCard();
        $field->policy = $policies['7'];
        $field->policy_description = $descriptions['7.1'];
        $field->kpi = $kpis['7.1.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['7'];
        $field->policy_description = $descriptions['7.2'];
        $field->kpi = $kpis['7.2.1'];
        $field->save();

        $field = new ReportCard();
        $field->policy = $policies['7'];
        $field->policy_description = $descriptions['7.3'];
        $field->kpi = $kpis['7.3.1'];
        $field->save();
    }
}
