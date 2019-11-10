@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="row">
            <div class="col-md">
                <h1 class="text-primary">{{$institution->institutionName}}</h1>
            </div>
        </div>
        {!! Form::open(['action' => ['Institution\InstitutionsController@update', $institution->id], 'method' => 'POST']) !!}
        <fieldset class="card shadow h-100 my-4">
            <div class="card-header text-primary">
                General
            </div>
            <div class="card-body p-4">
                <div class="row mb-2">
                    <div class="form-group col-md">
                        {{ Form::number('campuses', $institution->generalInformation->campuses, ['class'=>'form-control', 'id'=>'edit_campuses', 'required' => 'true']) }}
                        {{ Form::label('edit_campuses', 'Campuses', ['class' => 'form-control-placeholder']) }}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('colleges', $institution->generalInformation->colleges, ['class'=>'form-control', 'id'=>'edit_colleges', 'required' => 'true']) !!}
                        {!! Form::label('edit_colleges', 'Colleges', ['class' => 'form-control-placeholder']) !!}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('schools', $institution->generalInformation->schools, ['class'=>'form-control', 'id'=>'edit_schools', 'required' => 'true']) !!}
                        {!! Form::label('edit_schools', 'Schools', ['class' => 'form-control-placeholder']) !!}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('institutes', $institution->generalInformation->institutes, ['class'=>'form-control', 'id'=>'edit_institutes', 'required' => 'true']) !!}
                        {!! Form::label('edit_institutes', 'Institutes', ['class' => 'form-control-placeholder']) !!}
                    </div>
                </div>

                 <div class="row mb-2">
                    <div class="form-group col-md">
                        {{ Form::number('centers', $institution->generalInformation->centers, ['class'=>'form-control', 'id'=>'edit_centers', 'required' => 'true']) }}
                        {{ Form::label('edit_centers', 'Centers', ['class' => 'form-control-placeholder']) }}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('faculties', $institution->generalInformation->faculties, ['class'=>'form-control', 'id'=>'edit_faculties', 'required' => 'true']) !!}
                        {!! Form::label('edit_faculties', 'Faculties', ['class' => 'form-control-placeholder']) !!}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('departments', $institution->generalInformation->departments, ['class'=>'form-control', 'id'=>'edit_departments', 'required' => 'true']) !!}
                        {!! Form::label('edit_departments', 'Departments', ['class' => 'form-control-placeholder']) !!}
                    </div>

                </div>

                <div class="row mb-2">
                    <div class="form-group col-md">
                        {{ Form::number('board_members', $institution->generalInformation->board_members, ['class'=>'form-control', 'id'=>'edit_board_members', 'required' => 'true']) }}
                        {{ Form::label('edit_board_members', 'Board Members', ['class' => 'form-control-placeholder']) }}
                    </div>
                    <div class="form-group col-md">
                        {{ Form::number('vice_presidents', $institution->generalInformation->vice_presidents, ['class'=>'form-control', 'id'=>'edit_vice_presidents', 'required' => 'true']) }}
                        {{ Form::label('edit_vice_presidents', 'Vice Presidents', ['class' => 'form-control-placeholder']) }}
                    </div>
                    <div class="form-group col-md">
                        {{ Form::number('middle_level_leaders', $institution->generalInformation->middle_level_leaders, ['class'=>'form-control', 'id'=>'edit_middle_level_leaders', 'required' => 'true']) }}
                        {{ Form::label('edit_middle_level_leaders', 'Middle Level Leaders', ['class' => 'form-control-placeholder']) }}
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card shadow h-100 my-4">
            <div class="card-header text-primary">
                Community Service
            </div>

            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 p-3">
                                Number of Community Services Delivered
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::number('community_services', $institution->generalInformation->communityService->community_services, ['class'=>'form-control', 'id'=>'edit_community_services', 'required' => 'true']) }}
                                {{ Form::label('edit_community_services', 'Middle Level Leaders', ['class' => 'form-control-placeholder']) }}
                            </div>

                            <div class="col-md-6 p-3">
                                Teachers who participated in community Service
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('male_teachers_participated', $institution->generalInformation->communityService->male_teachers_participated, ['class'=>'form-control', 'id'=>'edit_male_teachers_participated', 'required' => 'true']) }}
                                {{ Form::label('edit_male_teachers_participated', 'Males', ['class' => 'form-control-placeholder']) }}
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('female_teachers_participated', $institution->generalInformation->communityService->female_teachers_participated, ['class'=>'form-control', 'id'=>'edit_female_teachers_participated', 'required' => 'true']) }}
                                {{ Form::label('edit_female_teachers_participated', 'Females', ['class' => 'form-control-placeholder']) }}
                            </div>

                            <div class="col-md-6 p-3">
                                People who benefited from Community Service
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('male_benefited', $institution->generalInformation->communityService->male_benefited, ['class'=>'form-control', 'id'=>'edit_male_benefited', 'required' => 'true']) }}
                                {{ Form::label('edit_male_benefited', 'Males', ['class' => 'form-control-placeholder']) }}
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('female_benefited', $institution->generalInformation->communityService->female_benefited, ['class'=>'form-control', 'id'=>'edit_female_benefited', 'required' => 'true']) }}
                                {{ Form::label('edit_female_benefited', 'Females', ['class' => 'form-control-placeholder']) }}
                            </div>

                            <div class="col-md-6 p-3">
                                TVET's linked to the University
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::number('linked_tvets', $institution->generalInformation->communityService->linked_tvets, ['class'=>'form-control', 'id'=>'edit_linked_tvets', 'required' => 'true']) }}
                                {{ Form::label('edit_linked_tvets', 'Middle Level Leaders', ['class' => 'form-control-placeholder']) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h5>This Institution has:</h5>
                        <hr>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_spd', null,  $institution->generalInformation->communityService->has_spd, ['id' => "select_spd", 'class' => 'form-check-input']) !!}
                            {!! Form::label('Strategic Plan Document', null, ['class' => 'form-check-label', 'for' => "select_spd"]) !!}
                        </div>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_incubation', null,  $institution->generalInformation->communityService->has_incubation, ['id' => "select_incubation", 'class' => 'form-check-input']) !!}
                            {!! Form::label('Incubation Center', null, ['class' => 'form-check-label', 'for' => "select_incubation"]) !!}
                        </div>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_hdp_lead', null,  $institution->generalInformation->communityService->has_hdp_lead, ['id' => "select_hdp_lead", 'class' => 'form-check-input']) !!}
                            {!! Form::label('HDP Lead', null, ['class' => 'form-check-label', 'for' => "select_hdp_lead"]) !!}
                        </div>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_ccpd_coordinator', null,  $institution->generalInformation->communityService->has_ccpd_coordinator, ['id' => "select_ccpd_coordinator", 'class' => 'form-check-input']) !!}
                            {!! Form::label('CCPD Coordinator', null, ['class' => 'form-check-label', 'for' => "select_ccpd_coordinator"]) !!}
                        </div>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_elip_teachers', null,  $institution->generalInformation->communityService->has_elip_teachers, ['id' => "select_elip_teachers", 'class' => 'form-check-input']) !!}
                            {!! Form::label('ELIP Center for Teachers', null, ['class' => 'form-check-label', 'for' => "select_elip_teachers"]) !!}
                        </div>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_elip_students', null,  $institution->generalInformation->communityService->has_elip_students, ['id' => "select_elip_students", 'class' => 'form-check-input']) !!}
                            {!! Form::label('ELIP Center for Teachers', null, ['class' => 'form-check-label', 'for' => "select_elip_students"]) !!}
                        </div>
                        <div class="form-check m-2">
                            {!! Form::checkbox('has_career_center', null,  $institution->generalInformation->communityService->has_career_center, ['id' => "select_career_center", 'class' => 'form-check-input']) !!}
                            {!! Form::label('Career Center', null, ['class' => 'form-check-label', 'for' => "select_career_center"]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>


        <fieldset class="card shadow h-100 my-4">
            <div class="card-header text-primary">
                Resources
            </div>
            <div class="card-body p-4">
                <div class="row mb-2">
                    <div class="col-md-4 p-3 mb-2">
                        Libraries
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {{ Form::number('number_of_libraries', $institution->generalInformation->resource->number_of_libraries, ['class'=>'form-control', 'id'=>'edit_number_of_libraries', 'required' => 'true']) }}
                        {{ Form::label('edit_number_of_libraries', 'Quantity', ['class' => 'form-control-placeholder']) }}
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {!! Form::select('status_of_libraries', $status_of_libraries , \App\Models\Institution\Resource::getValueKey(\App\Models\Institution\Resource::getEnum('status_of_libraries'), $institution->generalInformation->resource->status_of_libraries), ['class' => 'form-control', 'id' => 'edit_status_of_libraries']) !!}
                        {!! Form::label('edit_status_of_libraries', 'Status', ['class' => 'form-control-placeholder']) !!}
                    </div>

                    <div class="col-md-4 p-3 mb-2">
                        Laboratories
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {{ Form::number('number_of_laboratories', $institution->generalInformation->resource->number_of_laboratories, ['class'=>'form-control', 'id'=>'edit_number_of_laboratories', 'required' => 'true']) }}
                        {{ Form::label('edit_number_of_laboratories', 'Quantity', ['class' => 'form-control-placeholder']) }}
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {!! Form::select('status_of_laboratories', $status_of_laboratories , \App\Models\Institution\Resource::getValueKey(\App\Models\Institution\Resource::getEnum('status_of_laboratories'), $institution->generalInformation->resource->status_of_laboratories), ['class' => 'form-control', 'id' => 'edit_status_of_laboratories']) !!}
                        {!! Form::label('edit_status_of_laboratories', 'Status', ['class' => 'form-control-placeholder']) !!}
                    </div>

                    <div class="col-md-4 p-3 mb-2">
                        Workshops
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {{ Form::number('number_of_workshops', $institution->generalInformation->resource->number_of_workshops, ['class'=>'form-control', 'id'=>'edit_number_of_workshops', 'required' => 'true']) }}
                        {{ Form::label('edit_number_of_workshops', 'Quantity', ['class' => 'form-control-placeholder']) }}
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {!! Form::select('status_of_workshops', $status_of_workshops , \App\Models\Institution\Resource::getValueKey(\App\Models\Institution\Resource::getEnum('status_of_workshops'), $institution->generalInformation->resource->status_of_workshops) , ['class' => 'form-control', 'id' => 'edit_status_of_workshops']) !!}
                        {!! Form::label('edit_status_of_workshops', 'Status', ['class' => 'form-control-placeholder']) !!}
                    </div>

                </div>

                <div class="row mt-4">

                    <div class="form-group col-md-4">
                        {{ Form::number('number_of_classrooms', $institution->generalInformation->resource->number_of_classrooms, ['class'=>'form-control', 'id'=>'edit_number_of_classrooms', 'required' => 'true']) }}
                        {{ Form::label('edit_number_of_classrooms', 'Classrooms', ['class' => 'form-control-placeholder']) }}
                    </div>

                    <div class="form-group col-md-4">
                        {{ Form::number('number_of_smart_classrooms', $institution->generalInformation->resource->number_of_smart_classrooms, ['class'=>'form-control', 'id'=>'edit_number_of_smart_classrooms', 'required' => 'true']) }}
                        {{ Form::label('edit_number_of_smart_classrooms', 'Smart Classrooms', ['class' => 'form-control-placeholder']) }}
                    </div>

                    <div class="form-group col-md-4">
                        {{ Form::number('unjustifiable_expenses', $institution->generalInformation->resource->unjustifiable_expenses, ['class'=>'form-control', 'id'=>'edit_unjustifiable_expenses', 'required' => 'true']) }}
                        {{ Form::label('edit_unjustifiable_expenses', 'Improperly Utilized Funds', ['class' => 'form-control-placeholder']) }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 text-center">
                        <div class="input-group mb-3 w-75 float-left">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0">
                                    Pupil : Teacher =
                                </span>
                            </div>
                            {{ Form::number('pupil_per_teacher', $institution->generalInformation->resource->pupil_per_teacher, ['class'=>'rounded-left ml-2 form-control text-right', 'id'=>'edit_pupil_per_teacher']) }}
                            <div class="input-group-append">
                                <span class="input-group-text rounded-right">
                                     : 1
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 text-center">
                        <div class="input-group mb-3 w-75 float-right">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0">
                                    Student : Text =
                                </span>
                            </div>
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-left">
                                     1 :
                                </span>
                            </div>
                            {{ Form::number('text_per_student', $institution->generalInformation->resource->text_per_student, ['class'=>'rounded-right mr-2 form-control', 'id'=>'edit_text_per_student']) }}
                        </div>

                    </div>
                </div>
            </div>
        </fieldset>

        {!! Form::hidden('_method', 'PUT') !!}
        {!! Form::submit('Save', ['class' => 'btn btn-outline-secondary float-right my-1']) !!}
        {!! Form::close() !!}
    </div>
@endsection