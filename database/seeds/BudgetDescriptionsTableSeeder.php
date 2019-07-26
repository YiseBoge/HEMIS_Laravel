<?php

use App\Models\College\BudgetDescription;
use Illuminate\Database\Seeder;

class BudgetDescriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allDescriptions = [

            // Recurrent Budget //

//            '6110' => 'Employee's Payment',
            '6111' => 'Salaries to permanent staff',
            '6113' => 'Wages to contract staff',
            '6114' => 'Wages to casual (laborer) staff',
            '6115' => 'Wages to external contract staff',
            '6116' => 'Miscellaneous payments to staff',

//            '6120' => 'Allowances and Other Benefits',
            '6121' => 'Allowances to permanent staff',
            '6123' => 'Allowances to contract staff',
            '6124' => 'Allowances to external contract staff',

//            '6130' => 'Pension /Provident Fund',
            '6131' => 'Gov\'t contribution to permanent staff pension',
            '6133' => 'Non-gov\'t contribution to staff provident fund',

//            '6210' => 'Goods and Services',
            '6211' => 'Uniforms, clothing, bedding',
            '6212' => 'Stationery and other office supplies',
            '6213' => 'Printing',
            '6214' => 'Medical Supplies',
            '6215' => 'Educational supplies/materials',
            '6216' => 'Food',
            '6217' => 'Fuel and Lubricants',
            '6218' => 'Other Material Supplies',
            '6219' => 'Miscellaneous equipment and books',
            '6223' => 'Research and development supplies',
            '6225' => 'Agriculture, Forestry and Marine inputs',
            '6231' => 'Per diem',
            '6232' => 'Transportation',
            '6233' => 'Official entertainment and invitation',

//            '6240' => 'Maintenance and Repair Service',
            '6241' => 'Maintenance and repair of vehicles & other transport',
            '6243' => 'Maintenance and repair of plant, machinery & equipment',
            '6244' => 'Maintenance and repair of buildings,furnishings and fixtures',
            '6245' => 'Maintenance and repair of infrastructure',

//            '6250' => 'Contractual Services Payment',
            '6251' => 'Contracted professional services',
            '6252' => 'Rent',
            '6253' => 'Advertising',
            '6254' => 'Insurance',
            '6255' => 'Freight',
            '6256' => 'Fee and Charges',
            '6257' => 'Electric Charges',
            '6258' => 'Telecommunication Charges',
            '6259' => 'Water, post and other utilities',

//            '6270' => 'Training',
            '6271' => 'Local Training',
            '6272' => 'External Training',

            // Capital Budget //

//            '6310' => 'Fixed Assets and construction',
            '6311' => 'Purchase of vehicles & other transport',
            '6313' => 'Purchase of plant, machinery & equipment',
            '6314' => 'Purchase of buildings,furnishings and fixtures',
            '6315' => 'Purchase of livestock and Transport Animals',
            '6321' => 'Pre-construction activities',
            '6322' => 'Construction of buildings (residential)',
            '6323' => 'Construction of buildings (non-residential)',
            '6324' => 'Construction of infrastructure',
            '6326' => 'Construction of supervisor',

            '' => 'Others',
        ];

        foreach ($allDescriptions as $code => $description) {
            $budgetDescription = new BudgetDescription();
            $budgetDescription->budget_code = $code;
            $budgetDescription->description = $description;

            $budgetDescription->save();
        }
    }
}
