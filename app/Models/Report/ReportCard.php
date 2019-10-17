<?php

namespace App\Models\Report;

use App\Traits\Enums;
use App\Traits\Uuids;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static ReportCard where(string $string, $kpi)
 * @method Collection get()
 * @method static ReportCard find(int $id)
 * @property Collection reportYearValues
 * @property double target
 * @property string|null policy
 * @property string|null policy_description
 * @property string|null kpi
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property boolean is_decreasing
 */
class ReportCard extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;

    protected $enumKpis = [
        '1.1.1' => 'Increase in the Gross Enrollment Ratio (GER)',
        '1.1.2' => 'Increase in the Net Enrollment Ratio (NER)',

        '1.2.1' => 'Increase capacity to enroll new students in undergraduate programs',
        '1.2.2' => 'Increase capacity to enroll new students in master programs',
        '1.2.3' => 'Increase capacity to enroll new students n doctoral studies',
        '1.2.4' => 'Increase capacity to enroll new students in health specialty programs',

        '1.3.1' => 'Increase in the share of private HEIs from the total enrollment in undergraduate programs',
        '1.3.2' => 'Increase in the share of private HEIs from the total enrollment in master programs',
        '1.3.3' => 'Increase in the share of private HEIs from the gross enrollment in doctoral studies',
        '1.3.4' => 'Increase in the share of private HEIs from the gross enrollment in health specialty programs',

        '1.4.1' => 'Increase in the share of STEM subjects from undergraduate enrollment',
        '1.4.2' => 'Increase in the share of STEM subjects from master programs',
        '1.4.3' => 'Increase in the share of STEM subjects from doctoral studies',

        '1.5.1' => 'Increase in the percentage of females in undergraduate programs',
        '1.5.2' => 'Increase in the percentage of females in master programs',
        '1.5.3' => 'Increase in the percentage of females in doctoral studies',
        '1.5.4' => 'Increase in the percentage of females in health specialty programs',

        '1.6.1' => 'Increase in the percentage of females undergraduate in STEM subjects',
        '1.6.2' => 'Increase in the percentage of females in STEM master programs',
        '1.6.3' => 'Increase in the percentage of females in STEM doctoral studies',

        '1.7.1' => 'Increase in the percentage of students with disabilities in undergraduate programs',
        '1.7.2' => 'Increase in the percentage of students with disabilities in master programs',
        '1.7.3' => 'Increase in the percentage of students with disabilities in doctoral studies',
        '1.7.4' => 'Increase in the percentage of students with disabilities in health specialty programs',

        '1.8.1' => 'Increase in the percentage of students from emerging regions in undergraduate programs',
        '1.8.2' => 'Increase in the percentage of students from emerging regions in master programs',
        '1.8.3' => 'Increase in the percentage of students from emerging regions in doctoral studies',
        '1.8.4' => 'Increase in the percentage of students from emerging regions in health specialty programs',

        '1.9.1' => 'Increase in the percentage of students from economically poorhouse holds in undergraduate programs',
        '1.9.2' => 'Increase in the percentage of students from economically poor households in master programs',
        '1.9.3' => 'Increase in the percentage of students from economically poor households in doctoral studies',
        '1.9.4' => 'Increase in the percentage of students from economically poor households in health specialty programs',

        '2.1.1' => 'Decrease in the dropout rate of undergraduate students',
        '2.1.2' => 'Decrease in the dropout rate of master students',
        '2.1.3' => 'Decrease in the dropout rate of doctoral students',
        '2.1.4' => 'Decrease in the dropout rate of health specialty students',

        '2.2.1' => 'Decrease in the dropout rate of female undergraduate students',
        '2.2.2' => 'Decrease in the dropout rate of female master students',
        '2.2.3' => 'Decrease in the dropout rate of female doctoral students',
        '2.2.4' => 'Decrease in the dropout rate of female health specialty students',

        '2.3.1' => 'Decrease in the academic dismissal rate of undergraduate students',
        '2.3.2' => 'Decrease in the academic dismissal rate of master students',
        '2.3.3' => 'Decrease in the academic dismissal rate of doctoral students',
        '2.3.4' => 'Decrease in the academic dismissal rate of health specialty students',

        '2.4.1' => 'Decrease in the academic dismissal rate of female undergraduate students',
        '2.4.2' => 'Decrease in the academic dismissal rate of female master students',
        '2.4.3' => 'Decrease in the academic dismissal rate of female doctoral students',
        '2.4.4' => 'Decrease in the academic dismissal rate of female health specialty students',

        '2.5.1' => 'Increase in the graduation rate of undergraduate students',
        '2.5.2' => 'Increase in the graduation rate of master students',
        '2.5.3' => 'Increase in the graduation rate of doctoral students',
        '2.5.4' => 'Increase in the graduation rate of health specialty students',

        '2.6.1' => 'Increase in the graduation rate of female undergraduate students',
        '2.6.2' => 'Increase in the graduation rate of female master students',
        '2.6.3' => 'Increase in the graduation rate of female doctoral students',
        '2.6.4' => 'Increase in the graduation rate of female health specialty students',

        '2.7.1' => 'Increase in the graduation rate of undergraduate students with disabilities',
        '2.7.2' => 'Increase in the graduation rate of master students with disabilities',
        '2.7.3' => 'Increase in the graduation rate of doctoral students with disabilities',
        '2.7.4' => 'Increase in the graduation rate of health specialty students with disabilities',

        '2.8.1' => 'Increase in the graduation rate of undergraduate students from emerging regions',
        '2.8.2' => 'Increase in the graduation rate of master students from emerging regions',
        '2.8.3' => 'Increase in the graduation rate of doctoral students from emerging regions',
        '2.8.4' => 'Increase in the graduation rate of health specialty students from emerging regions',

        '2.9.1' => 'Increase in the graduation rate of students from economically poor households',
        '2.9.2' => 'Increase in the graduation rate of master students from economically poor households',
        '2.9.3' => 'Increase in the graduation rate of doctoral students from economically poor households',
        '2.9.4' => 'Increase in the graduation rate of health specialty students economically poor households',

        '3.1.1' => 'Increase in the percentage of appropriately qualified academic staff',
        '3.1.2' => 'Decrease in the student to appropriately qualified academic staff ratio',
        '3.1.3' => 'Increase in the percentage of smart classrooms',
        '3.1.4' => 'Increase in the percentage of company sponsored internships',

        '3.2.1' => 'Increase in the pass rate of graduates in exit examinations',
        '3.3.1' => 'Increase in the percentage of undergraduates accessing degree-relevant employment within 12 months from graduation',

        '3.4.1' => 'Increase in the publication per capita for appropriately qualified academic staff',
        '3.4.2' => 'Increase in the publication per capita for doctoral students',
        '3.4.3' => 'Increase in the number of patents earned',

        '4.1.1' => 'Increase in the percentage of females from the total number of appropriately qualified academic staff',
        '4.2.1' => 'Increase in the percentage of females from the total number of technical support staff',
        '4.3.1' => 'Increase in the percentage of females from the total number of professional staff in teaching hospitals',
        '4.4.1' => 'Increase in the percentage of females from the total number of administrative support staff',
        '4.5.1' => 'Increase in the percentage of females appointed to senior management positions',
        '4.6.1' => 'Increase in the percentage of females appointed to middle management positions',
        '4.7.1' => 'Increase in the percentage of females appointed to lower management positions',

        '5.1.1' => 'Increase in the percentage of the Ethiopian diaspora academics taking part in teaching, research and academic advising activities in HEIs',

        '5.2.1' => 'Increase in the number of foreign students attending HEIs in Ethiopia',
        '5.2.2' => 'Increase in the number of students enrolled in joint programs implemented in partnership with foreign HEIs',

        '6.1.1' => 'Increase in the percentage of funds allocated for research and development from the total expenditure',
        '6.2.1' => 'Increase in the proportion of budget mobilized from sources other than the government subsidy budget',
        '6.3.1' => 'Decrease in the percentage of improperly utilized funds',
        '6.4.1' => 'Decrease in the percentage of expatriate staff in Ethiopian HEIs',

        '6.5.1' => 'Decrease in the attrition rate of academic staff with appropriate qualification',
        '6.5.2' => 'Decrease in the attrition rate of female academic staff',
        '6.5.3' => 'Decrease in the attrition rate of technical support staff',
        '6.5.4' => 'Decrease in the attrition rate of professionals in teaching hospitals',
        '6.5.5' => 'Decrease in the attrition rate of staff in middle and senior management positions',
        '6.5.6' => 'Decrease in the attrition rate of administrative support staff',
    ];

    /**
     * @return array
     */
    public static function groupedReports()
    {
        $policyArray = array();
        foreach (ReportCard::policies() as $policy) {
            $descriptionArray = array();
            foreach (ReportCard::descriptions($policy) as $description) {
                $kpiArray = array();
                foreach (ReportCard::kpis($policy, $description) as $kpi) {
                    $kpiArray[] = $kpi;
                }
                $descriptionArray[$description] = $kpiArray;
            }
            $policyArray[$policy] = $descriptionArray;
        }
        return $policyArray;
    }

    /**
     * @return array
     */
    private static function policies()
    {
        return ReportCard::groupBy('policy')->orderBy('policy')->pluck('policy', 'policy');
    }

    /**
     * @param $policy
     * @return array
     */
    private static function descriptions($policy)
    {
        return ReportCard::where('policy', $policy)->groupBy('policy_description')->orderBy('policy_description')->pluck('policy_description', 'policy_description');
    }

    /**
     * @param $policy
     * @param $description
     * @return array
     */
    private static function kpis($policy, $description)
    {
        $kpis = array();
        $values = DB::table('report_cards')->where(array(
            'policy' => $policy,
            'policy_description' => $description))
            ->get();
        foreach ($values as $value) {
            $kpi = new ReportCard();
            $kpi->id = $value->id;
            $kpi->policy = $value->policy;
            $kpi->policy_description = $value->policy_description;
            $kpi->kpi = $value->kpi;
            $kpi->target = $value->target;
            $kpi->created_at = $value->created_at;
            $kpi->updated_at = $value->updated_at;

            $kpis[] = $kpi;
        }

        return $kpis;
    }

    /**
     * @return float|int
     */
    public function change()
    {
        $years = $this->reportYearValues()->orderBy('year')->get();
        if (count($years) <= 1) {
            return 0;
        }
        $current = $years[count($years) - 1];
        $baseline = $years[0];

        if (($this->target - $baseline->value) == 0) {
            return 0;
        }

        $change = round((($current->value - $baseline->value) / ($this->target - $baseline->value)) * 100, 2);
        if ($this->is_decreasing) $change *= -1;

        return $change;
    }

    public function reportYearValues()
    {
        return $this->hasMany('App\Models\Report\ReportYearValue');
    }
}
