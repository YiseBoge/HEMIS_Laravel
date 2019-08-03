@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="row">
            <div class="col-md-10">
                <h1 class="text-primary">{{$institution->institutionName}}</h1>
            </div>
            <div class="col-md-2 pt-4 text-right">
                <a class="btn btn-primary mb-0 shadow-sm" href="/institution/general/{{$institution->id}}/edit">Modify<i
                            class="fas fa-pen text-white-50 fa-sm ml-2"></i></a>
            </div>
        </div>
        <hr>
        <div class="row my-3">
            <div class="col-md-3 col-sm-6 mb-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Campuses
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->campuses}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Colleges
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->colleges}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Schools
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->schools}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Institutes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->institutes}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-3 col-sm-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Board Members
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->board_members}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Vice Presidents
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->vice_presidents}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Middle Level Leaders
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->middle_level_leaders}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Hospitals
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institution->generalInformation->hospitals}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row my-4">
            <div class="col-md-7 py-2">
                <div class="card shadow h-100">
                    <div class="card-header text-primary font-weight-bold">Staff Numbers</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 p-3">
                                Academic Staff (On Local Duty)
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Males: <span class="font-weight-bold text-gray-800">
                                    {{$existing['academic_on_duty_male']}}
                                </span>
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Females: <span class="font-weight-bold text-gray-800">
                                    {{$existing['academic_on_duty_female']}}
                                </span>
                            </div>

                            <div class="col-md-6 p-3">
                                Academic Staff (On Study Leave)
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Males: <span class="font-weight-bold text-gray-800">
                                    {{$existing['academic_on_study_male']}}
                                </span>
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Females: <span class="font-weight-bold text-gray-800">
                                    {{$existing['academic_on_study_female']}}
                                </span>
                            </div>

                            <div class="col-md-6 p-3">
                                Administrative Staff
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Males: <span class="font-weight-bold text-gray-800">
                                    {{$existing['administrative_male']}}
                                </span>
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Females: <span class="font-weight-bold text-gray-800">
                                    {{$existing['administrative_female']}}
                                </span>
                            </div>

                            <div class="col-md-6 p-3">
                                Technical Staff
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Males: <span class="font-weight-bold text-gray-800">
                                    {{$existing['technical_male']}}
                                </span>
                            </div>
                            <div class="col-md-3 col-sm-6 p-3">
                                Females: <span class="font-weight-bold text-gray-800">
                                    {{$existing['technical_female']}}
                                </span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-5 py-2">
                <div class="card shadow h-100">
                    <div class="card-header text-primary font-weight-bold">Budget</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7 p-3">
                                Recurrent Budget
                            </div>
                            <div class="col-md-5 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{number_format($existing['recurrent_budget'], 2)}}
                                </span>
                            </div>

                            <div class="col-md-7 p-3">
                                Capital Budget
                            </div>
                            <div class="col-md-5 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{number_format($existing['capital_budget'], 2)}}
                                </span>
                            </div>

                            <div class="col-md-7 p-3">
                                From Internal Income
                            </div>
                            <div class="col-md-5 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{number_format($existing['internal_income'], 2)}}
                                </span>
                            </div>

                            <div class="col-md-7 p-3">
                                Unjustifiable Expenses
                            </div>
                            <div class="col-md-5 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{number_format($institution->generalInformation->resource->unjustifiable_expenses, 2)}}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-md-12 py-2">
                <div class="card shadow h-100">
                    <div class="card-header text-primary font-weight-bold">Community Service Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 p-3">
                                Number of Community Services Delivered
                            </div>
                            <div class="col-md-4 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->communityService->community_services}}
                                </span>
                            </div>

                            <div class="col-md-8 p-3">
                                Teachers who participated in community Service
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                Males: <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->communityService->male_teachers_participated}}
                                </span>
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                Females: <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->communityService->female_teachers_participated}}
                                </span>
                            </div>

                            <div class="col-md-8 p-3">
                                People who benefited from Community Service
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                Males: <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->communityService->male_benefited}}
                                </span>
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                Females: <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->communityService->female_benefited}}
                                </span>
                            </div>

                            <div class="col-md-8 p-3">
                                TVET's linked to the University
                            </div>
                            <div class="col-md-4 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->communityService->linked_tvets}}
                                </span>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12 p-3 h5 text-center">
                                This institution Has:
                            </div>
                        </div>
                        <div class="px-5 text-center">
                            @if ($institution->generalInformation->communityService->has_spd)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    Strategic Plan Document
                                </div>
                            @endif
                            @if ($institution->generalInformation->communityService->has_incubation)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    Incubation Center
                                </div>
                            @endif
                            @if ($institution->generalInformation->communityService->has_hdp_lead)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    HDP Lead
                                </div>
                            @endif
                            @if ($institution->generalInformation->communityService->has_ccpd_coordinator)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    CCPD coordinator
                                </div>
                            @endif
                            @if ($institution->generalInformation->communityService->has_elip_teachers)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    ELIP center (for teachers)
                                </div>
                            @endif
                            @if ($institution->generalInformation->communityService->has_elip_students)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    ELIP center (for students)
                                </div>
                            @endif
                            @if ($institution->generalInformation->communityService->has_career_center)
                                <div class="p-2 mx-2 alert alert-secondary d-inline-block text-gray-700">
                                    Career Center
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-md-6 py-2">
                <div class="card shadow h-100">
                    <div class="card-header text-primary font-weight-bold">Rates</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9 p-3">
                                Pupil : Teacher Ratio
                            </div>
                            <div class="col-3 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->pupil_per_teacher}} : 1
                                </span>
                            </div>

                            <div class="col-9 p-3">
                                Student : Text (References) ratio
                            </div>
                            <div class="col-3 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    1 : {{$institution->generalInformation->resource->text_per_student}}
                                </span>
                            </div>

                            <div class="col-9 p-3">
                                Graduation Rate (Undergraduates)
                            </div>
                            <div class="col-3 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$existing['undergraduate_graduation']}} %
                                </span>
                            </div>

                            <div class="col-9 p-3">
                                Graduation Rate (Postgraduates)
                            </div>
                            <div class="col-3 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$existing['postgraduate_graduation']}} %
                                </span>
                            </div>

                            <div class="col-9 p-3">
                                Graduation Rate (Females)
                            </div>
                            <div class="col-3 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$existing['female_graduation']}} %
                                </span>
                            </div>

                            <div class="col-9 p-3">
                                Percentage of Smart Classrooms
                            </div>
                            <div class="col-3 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->rate_of_smart_classrooms}} %
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6 py-2">
                <div class="card shadow">
                    <div class="card-header text-primary font-weight-bold">Resources</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 p-3">
                                Libraries
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->number_of_libraries}}
                                </span>
                            </div>
                            <div class="col-md-5 col-sm-6 p-3">
                                Status:
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->status_of_libraries}}
                                </span>
                            </div>

                            <div class="col-md-5 p-3">
                                Laboratories
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->number_of_laboratories}}
                                </span>
                            </div>
                            <div class="col-md-5 col-sm-6 p-3">
                                Status:
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->status_of_laboratories}}
                                </span>
                            </div>

                            <div class="col-md-5 p-3">
                                Workshops
                            </div>
                            <div class="col-md-2 col-sm-6 p-3">
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->number_of_workshops}}
                                </span>
                            </div>
                            <div class="col-5 p-3">
                                Status:
                                <span class="font-weight-bold text-gray-800">
                                    {{$institution->generalInformation->resource->status_of_workshops}}
                                </span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection