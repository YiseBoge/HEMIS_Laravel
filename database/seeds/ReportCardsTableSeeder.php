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
            '1' => '1.	Improve access & equity in higher education',
            '2' => '2.	Improve internal efficiency in higher education',
            '3' => '3.	Improve quality & relevance of higher education',
            '4' => '4.	Improve gender diversity in higher education',
            '5' => '5.	Improve internationalization',
            '6' => '6.	Improve capacity and resources mobilization',
        );

        $descriptions = array(
            '1.1' => '1.1	Increase enrollment in higher education',
            '1.2' => '1.2	Increase capacity to enroll new students',
            '1.3' => '1.3	Increase capacity of private HEIs to enroll students',
            '1.4' => '1.4	Increase enrollment in STEM study fields',
            '1.5' => '1.5	Increase participation of female students',
            '1.6' => '1.6	Increase participation of female students in STEM subjects',
            '1.7' => '1.7	Increase participation of persons with disabilities',
            '1.8' => '1.8	Increase participation of students from emerging regions',
            '1.9' => '1.9	Increase participation of students from economically poor households',

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

        $kpis = ReportCard::getEnum('kpi');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.1', '1.1.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.1', '1.1.2');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.2', '1.2.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.2', '1.2.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.2', '1.2.3');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.2', '1.2.4');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.3', '1.3.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.3', '1.3.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.3', '1.3.3');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.3', '1.3.4');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.4', '1.4.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.4', '1.4.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.4', '1.4.3');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.5', '1.5.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.5', '1.5.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.5', '1.5.3');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.5', '1.5.4');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.6', '1.6.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.6', '1.6.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.6', '1.6.3');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.7', '1.7.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.7', '1.7.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.7', '1.7.3');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.7', '1.7.4');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.8', '1.8.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.8', '1.8.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.8', '1.8.3');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.8', '1.8.4');

        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.9', '1.9.1');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.9', '1.9.2');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.9', '1.9.3');
        $this->saveKpi($policies, $descriptions, $kpis, '1', '1.9', '1.9.4');

        // break

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.1', '2.1.1', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.1', '2.1.2', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.1', '2.1.3', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.1', '2.1.4', true);

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.2', '2.2.1', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.2', '2.2.2', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.2', '2.2.3', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.2', '2.2.4', true);

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.3', '2.3.1', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.3', '2.3.2', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.3', '2.3.3', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.3', '2.3.4', true);

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.4', '2.4.1', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.4', '2.4.2', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.4', '2.4.3', true);
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.4', '2.4.4', true);

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.5', '2.5.1');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.5', '2.5.2');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.5', '2.5.3');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.5', '2.5.4');

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.6', '2.6.1');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.6', '2.6.2');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.6', '2.6.3');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.6', '2.6.4');

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.7', '2.7.1');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.7', '2.7.2');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.7', '2.7.3');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.7', '2.7.4');

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.8', '2.8.1');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.8', '2.8.2');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.8', '2.8.3');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.8', '2.8.4');

        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.9', '2.9.1');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.9', '2.9.2');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.9', '2.9.3');
        $this->saveKpi($policies, $descriptions, $kpis, '2', '2.9', '2.9.4');

        // break

        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.1', '3.1.1');
        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.1', '3.1.2', true);
        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.1', '3.1.3');
        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.1', '3.1.4');

        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.2', '3.2.1');
        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.3', '3.3.1');

        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.4', '3.4.1');
        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.4', '3.4.2');
        $this->saveKpi($policies, $descriptions, $kpis, '3', '3.4', '3.4.3');

        // break

        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.1', '4.1.1');
        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.2', '4.2.1');
        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.3', '4.3.1');
        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.4', '4.4.1');
        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.5', '4.5.1');
        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.6', '4.6.1');
        $this->saveKpi($policies, $descriptions, $kpis, '4', '4.7', '4.7.1');

        // break

        $this->saveKpi($policies, $descriptions, $kpis, '5', '5.1', '5.1.1');

        $this->saveKpi($policies, $descriptions, $kpis, '5', '5.2', '5.2.1');
        $this->saveKpi($policies, $descriptions, $kpis, '5', '5.2', '5.2.2');

        // break

        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.1', '6.1.1');
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.2', '6.2.1');
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.3', '6.3.1', true);
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.4', '6.4.1', true);

        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.5', '6.5.1', true);
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.5', '6.5.2', true);
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.5', '6.5.3', true);
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.5', '6.5.4', true);
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.5', '6.5.5', true);
        $this->saveKpi($policies, $descriptions, $kpis, '6', '6.5', '6.5.6', true);
    }

    /**
     * @param array $policies
     * @param array $descriptions
     * @param $kpis
     * @param $policyNumber
     * @param $descriptionNumber
     * @param $kpiNumber
     * @param bool $is_decreasing
     * @return void
     */
    private function saveKpi(array $policies, array $descriptions, $kpis, $policyNumber, $descriptionNumber, $kpiNumber, $is_decreasing = false)
    {
        $field = new ReportCard();
        $field->policy = $policies[$policyNumber];
        $field->policy_description = $descriptions[$descriptionNumber];
        $field->kpi = $kpis[$kpiNumber];
        $field->is_decreasing = $is_decreasing;
        $field->save();
    }
}
