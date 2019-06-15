@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible">
                    {{$error}}
                </div>
            @endforeach
        @endif
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
                        {{ Form::label('campuses', 'Campuses', ['class' => 'form-control-placeholder', 'for' => 'edit_campuses']) }}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('colleges', $institution->generalInformation->colleges, ['class'=>'form-control', 'id'=>'edit_colleges', 'required' => 'true']) !!}
                        {!! Form::label('colleges', 'Colleges', ['class' => 'form-control-placeholder', 'for' => 'edit_colleges']) !!}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('schools', $institution->generalInformation->schools, ['class'=>'form-control', 'id'=>'edit_schools', 'required' => 'true']) !!}
                        {!! Form::label('schools', 'Institutes', ['class' => 'form-control-placeholder', 'for' => 'edit_schools']) !!}
                    </div>

                    <div class="form-group col-md">
                        {!! Form::number('institutes', $institution->generalInformation->institutes, ['class'=>'form-control', 'id'=>'edit_institutes', 'required' => 'true']) !!}
                        {!! Form::label('institutes', 'Institutes', ['class' => 'form-control-placeholder', 'for' => 'edit_institutes']) !!}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="form-group col-md">
                        {{ Form::number('board_members', $institution->generalInformation->board_members, ['class'=>'form-control', 'id'=>'edit_board_members', 'required' => 'true']) }}
                        {{ Form::label('board_members', 'Board Members', ['class' => 'form-control-placeholder', 'for' => 'edit_board_members']) }}
                    </div>
                    <div class="form-group col-md">
                        {{ Form::number('vice_presidents', $institution->generalInformation->vice_presidents, ['class'=>'form-control', 'id'=>'edit_vice_presidents', 'required' => 'true']) }}
                        {{ Form::label('vice_presidents', 'Vice Presidents', ['class' => 'form-control-placeholder', 'for' => 'edit_vice_presidents']) }}
                    </div>
                    <div class="form-group col-md">
                        {{ Form::number('middle_level_leaders', $institution->generalInformation->middle_level_leaders, ['class'=>'form-control', 'id'=>'edit_middle_level_leaders', 'required' => 'true']) }}
                        {{ Form::label('middle_level_leaders', 'Middle Level Leaders', ['class' => 'form-control-placeholder', 'for' => 'edit_middle_level_leaders']) }}
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
                                {{ Form::label('community_services', 'Middle Level Leaders', ['class' => 'form-control-placeholder', 'for' => 'edit_community_services']) }}
                            </div>

                            <div class="col-md-6 p-3">
                                Teachers who participated in community Service
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('male_teachers_participated', $institution->generalInformation->communityService->male_teachers_participated, ['class'=>'form-control', 'id'=>'edit_male_teachers_participated', 'required' => 'true']) }}
                                {{ Form::label('male_teachers_participated', 'Males', ['class' => 'form-control-placeholder', 'for' => 'edit_male_teachers_participated']) }}
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('female_teachers_participated', $institution->generalInformation->communityService->female_teachers_participated, ['class'=>'form-control', 'id'=>'edit_female_teachers_participated', 'required' => 'true']) }}
                                {{ Form::label('female_teachers_participated', 'Females', ['class' => 'form-control-placeholder', 'for' => 'edit_female_teachers_participated']) }}
                            </div>

                            <div class="col-md-6 p-3">
                                People who benefited from Community Service
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('male_benefited', $institution->generalInformation->communityService->male_benefited, ['class'=>'form-control', 'id'=>'edit_male_benefited', 'required' => 'true']) }}
                                {{ Form::label('male_benefited', 'Males', ['class' => 'form-control-placeholder', 'for' => 'edit_male_benefited']) }}
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                {{ Form::number('female_benefited', $institution->generalInformation->communityService->female_benefited, ['class'=>'form-control', 'id'=>'edit_female_benefited', 'required' => 'true']) }}
                                {{ Form::label('female_benefited', 'Females', ['class' => 'form-control-placeholder', 'for' => 'edit_female_benefited']) }}
                            </div>

                            <div class="col-md-6 p-3">
                                TVET's linked to the University
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::number('linked_tvets', $institution->generalInformation->communityService->linked_tvets, ['class'=>'form-control', 'id'=>'edit_linked_tvets', 'required' => 'true']) }}
                                {{ Form::label('linked_tvets', 'Middle Level Leaders', ['class' => 'form-control-placeholder', 'for' => 'edit_linked_tvets']) }}
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
                        {{ Form::label('number_of_libraries', 'Quantity', ['class' => 'form-control-placeholder', 'for' => 'edit_number_of_libraries']) }}
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {!! Form::select('status_of_libraries', $status_of_libraries , $institution->generalInformation->resource->status_of_libraries , ['class' => 'form-control', 'id' => 'edit_status_of_libraries']) !!}
                        {!! Form::label('status_of_libraries', 'Status', ['class' => 'form-control-placeholder', 'for' => 'edit_status_of_libraries']) !!}
                    </div>

                    <div class="col-md-4 p-3 mb-2">
                        Laboratories
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {{ Form::number('number_of_laboratories', $institution->generalInformation->resource->number_of_laboratories, ['class'=>'form-control', 'id'=>'edit_number_of_laboratories', 'required' => 'true']) }}
                        {{ Form::label('number_of_laboratories', 'Quantity', ['class' => 'form-control-placeholder', 'for' => 'edit_number_of_laboratories']) }}
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {!! Form::select('status_of_laboratories', $status_of_laboratories , $institution->generalInformation->resource->status_of_laboratories , ['class' => 'form-control', 'id' => 'edit_status_of_laboratories']) !!}
                        {!! Form::label('status_of_laboratories', 'Status', ['class' => 'form-control-placeholder', 'for' => 'edit_status_of_laboratories']) !!}
                    </div>

                    <div class="col-md-4 p-3 mb-2">
                        Workshops
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {{ Form::number('number_of_workshops', $institution->generalInformation->resource->number_of_workshops, ['class'=>'form-control', 'id'=>'edit_number_of_workshops', 'required' => 'true']) }}
                        {{ Form::label('number_of_workshops', 'Quantity', ['class' => 'form-control-placeholder', 'for' => 'edit_number_of_workshops']) }}
                    </div>
                    <div class="form-group col-md-4 col-sm-6 mb-2">
                        {!! Form::select('status_of_workshops', $status_of_workshops , $institution->generalInformation->resource->status_of_workshops , ['class' => 'form-control', 'id' => 'edit_status_of_workshops']) !!}
                        {!! Form::label('status_of_workshops', 'Status', ['class' => 'form-control-placeholder', 'for' => 'edit_status_of_workshops']) !!}
                    </div>

                </div>

                <div class="row mb-2">
                    <div class="col-md-4 row">
                        <div class="col-md-6 text-right">
                            Pupil : Teacher
                        </div>
                        <div class="form-inline col-md-6">
                            {{ Form::number('pupil_per_teacher', $institution->generalInformation->resource->pupil_per_teacher, ['class'=>'form-control form-control-sm w-50', 'id'=>'edit_pupil_per_teacher']) }}
                            {{ Form::label('pupil_per_teacher', ' : 1', ['class' => 'mx-2', 'for' => 'edit_pupil_per_teacher']) }}
                        </div>
                    </div>


                    <div class="col-md-4 row">
                        <div class="col-md-6 text-right">
                            Student : Text
                        </div>
                        <div class="form-inline col-md-6">
                            {{ Form::label('text_per_student', '1 : ', ['class' => 'mx-2', 'for' => 'edit_text_per_student']) }}
                            {{ Form::number('text_per_student', $institution->generalInformation->resource->text_per_student, ['class'=>'form-control form-control-sm w-50', 'id'=>'edit_text_per_student']) }}
                        </div>
                    </div>


                    <div class="form-group col-md">
                        {{ Form::number('rate_of_smart_classrooms', $institution->generalInformation->resource->rate_of_smart_classrooms, ['class'=>'form-control', 'id'=>'edit_rate_of_smart_classrooms', 'required' => 'true']) }}
                        {{ Form::label('rate_of_smart_classrooms', 'Smart Classrooms (%)', ['class' => 'form-control-placeholder', 'for' => 'edit_rate_of_smart_classrooms']) }}
                    </div>

                </div>
            </div>
        </fieldset>

        {!! Form::hidden('_method', 'PUT') !!}
        {!! Form::submit('Save', ['class' => 'btn btn-outline-secondary float-right my-1']) !!}
        {!! Form::close() !!}
    </div>
@endsection