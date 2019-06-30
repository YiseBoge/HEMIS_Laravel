<?php

namespace App\Models\Report;

use App\Traits\Enums;
use App\Traits\Uuids;
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
 */
class ReportCard extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;
    protected $enumKpis = [
        '1.1.1' => '% increase in undergraduate students enrollment',
        '1.1.2' => '% increase in postgraduate students enrollment',

        '1.2.1' => '% increase in the share of females from total undergraduate enrollment',
        '1.2.2' => '% increase in the share of females from total postgraduate enrollment ',

        '1.3.1' => '% increase in the number of undergraduate students with disabilities',
        '1.3.2' => '% increase in the number of postgraduate students with disabilities',

        '1.4.1' => '% increase in the number of students from economically disadvantaged backgrounds',
        '1.5.1' => '% increase in the number of students from emerging regions',
        '1.6.1' => '% share of students from rural areas from total enrollment',
        '1.7.1' => '% increase in the share of students enrolled in private HEIs',

        '2.1.1' => 'Decrease in the % of undergraduate students dropout',
        '2.1.2' => 'Decrease in the % of postgraduate students dropout',

        '2.2.1' => 'Decrease in the % of undergraduate female students dropout',
        '2.2.2' => 'Decrease in the % of postgraduate female students dropout',

        '2.3.1' => 'Decrease in the % of academic dismissal for undergraduate students',
        '2.3.2' => 'Decrease in the % of academic dismissal for postgraduate students',

        '2.4.1' => 'Decrease in the % of academic dismissal for undergraduate females',
        '2.4.2' => 'Decrease in the % of academic dismissal for postgraduate females',

        '2.5.1' => '% increase in the graduation rate of undergraduate students',
        '2.5.2' => '% increase in the graduation rate of postgraduate students',

        '2.6.1' => '% increase the graduation rate of undergraduate female students',
        '2.6.2' => '% increase in the graduation rate of postgraduate female students',

        '2.7.1' => '% decrease in the number of persons with disabilities dropping out',
        '2.8.1' => '% decrease in the number of economically disadvantaged students dropping out',
        '2.9.1' => '% decrease in the number of dropouts from emerging regions',

        '2.10.1' => 'Decrease in the % of academic faculty leaving their positions for good',
        '2.10.2' => 'Decrease in the % of non-academic professional staff leaving their positions',

        '3.1.1' => 'Increase in the proportion of adequately qualified staff',
        '3.1.2' => 'Decrease in adequately qualified teacher to student ratio',

        '3.2.1' => 'Increase in the % of graduates who pass graduates exit examination',
        '3.3.1' => 'Increase in the % of undergraduates accessing degree-relevant employment within 12 months after graduation',
        '3.4.1' => '% increase in enrollment in science and technology fields',

        '4.1.1' => 'Increase in publication per capita for academic staff with the rank of associate and full professorship',
        '4.1.2' => 'Increase in publication per capita for postgraduate researchers',
        '4.1.3' => '% increase in the number of patent earned',

        '5.1.1' => 'Increase in the % share of females from the total number of academic staff',
        '5.2.1' => 'Increase in the % share of females from total number of management staff',
        '5.3.1' => 'Increase in the % share of females from total student enrollment',
        '5.4.1' => '% increase in the share of academic staff who come from regions other than the region that host the institution from the total',
        '5.5.1' => '% increase in the share of management staff who come from regions other than the region that host the institution from the total staff',
        '5.6.1' => '% increase in the share of students who come from regions other than the region that host the institution',

        '6.1.1' => '% increase in the number of courses/modules taught or number of postgraduate researches advised by members of Ethiopian diaspora',

        '6.2.1' => '% increase in the number of foreign students enrolled in Ethiopian HEIs',
        '6.2.2' => '% increase in enrollment in joint programmes with foreign HEIs',

        '6.3.1' => '% Increase in the number of expatriate staff in Ethiopian HEIs',

        '7.1.1' => '% Increase in the proportion of budget mobilized from sources other than the government subsidy',
        '7.2.1' => '% Reduction in the amount of non-utilized funds',
        '7.3.1' => '% Increase in the amount of loan recovered from student cost sharing',
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
        return ReportCard::groupBy('policy')->pluck('policy', 'policy');
    }

    /**
     * @param $policy
     * @return array
     */
    private static function descriptions($policy)
    {
        return ReportCard::where('policy', $policy)->groupBy('policy_description')->pluck('policy_description', 'policy_description');
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

        return round((($current->value - $baseline->value) / ($this->target - $baseline->value)) * 100, 2);
    }

    public function reportYearValues()
    {
        return $this->hasMany('App\Models\Report\ReportYearValue');
    }
}
