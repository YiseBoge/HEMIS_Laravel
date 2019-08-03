<?php

use App\Models\Staff\IctStaffType;
use Illuminate\Database\Seeder;

class IctStaffTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Junior Network Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Network Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Senior Network Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Network Engineer';
        $ict->save();


        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Junior System Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'System Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Senior System Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['INFRASTRUCTURE_SERVICES'];
        $ict->type = 'Systems Engineer';
        $ict->save();

        // break

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['BUSINESS_APPLICATION_DEVELOPMENT'];
        $ict->type = 'Junior Application/Software Developer';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['BUSINESS_APPLICATION_DEVELOPMENT'];
        $ict->type = 'Application/Software Developer';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['BUSINESS_APPLICATION_DEVELOPMENT'];
        $ict->type = 'Senior Application/Software Developer';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['BUSINESS_APPLICATION_DEVELOPMENT'];
        $ict->type = 'Junior Application Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['BUSINESS_APPLICATION_DEVELOPMENT'];
        $ict->type = 'Application Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['BUSINESS_APPLICATION_DEVELOPMENT'];
        $ict->type = 'Database Administrator';
        $ict->save();

        // break

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['TEACHING_LEARNING_TECHNOLOGIES'];
        $ict->type = 'Video Conference Technician';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['TEACHING_LEARNING_TECHNOLOGIES'];
        $ict->type = 'Junior E-learning Administrator';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['TEACHING_LEARNING_TECHNOLOGIES'];
        $ict->type = 'Web Admin';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['TEACHING_LEARNING_TECHNOLOGIES'];
        $ict->type = 'Content Developer';
        $ict->save();

        // break

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Junior Support Technician';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Support Technician';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Senior Support Technician';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Maintenance Technician';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Support Maintenance Technician-I';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Support Maintenance Technician-II';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Support Maintenance Technician-III';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'Senior Maintenance Technician';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['SUPPORT_MAINTENANCE'];
        $ict->type = 'IT Attendant';
        $ict->save();

        // break

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['TRAINING_CONSULTANCY'];
        $ict->type = 'Training Project Manager';
        $ict->save();

        $ict = new IctStaffType();
        $ict->category = IctStaffType::getEnum('category')['TRAINING_CONSULTANCY'];
        $ict->type = 'Training Admin Assistant';
        $ict->save();

    }
}
