@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Academic Staff</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="/institution/non-admin/create">Add<i
                                    class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table border dataTable table-striped table-hover" id="dataTable" width="100%"
                                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" width="15"
                                            style="width: 15%;">Education Level
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Male(Aggregate number)
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Male(Aggregate number)
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      {{-- @if (count($staffs) > 0)
                                        @foreach ($staffs as $staff)
                                            <tr role="row" class="odd" onclick="window.location='academic/{{$staff->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="academic/{{$staff->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0" action="/staff/academic/{{$staff->id}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="form-control form-control-plaintext text-danger p-0">
                                                                        <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>


                                                </td>
                                                <td class="sorting_1">{{$staff->general->name}}</td>
                                                <td>{{$staff->general->job_title}}</td>
                                                <td>{{$staff->general->dedication}}</td>
                                                <td>{{$staff->general->employment_type}}</td>
                                                @if ($staff->general->is_expatriate == 0)
                                                    <td>No</td>
                                                @else
                                                    <td>Yes</td>
                                                @endif
                                                <td>{{$staff->general->salary}}</td> 
                                                <td>{{$staff->general->academic_level}}</td>                                            
                                                <td>{{$staff->field_of_study}}</td>
                                                <td>{{$staff->staffRank}}</td>                                                                                          
                                            </tr>
                                        @endforeach
                                      @else
                                          
                                      @endif  --}}

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    @if ($data['page_name'] == 'institution.admin_and_non_academic_staff.create')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                        <form class="" action="/institution/non-admin/" method="POST">
                            @csrf
                            <h3 class="font-weight-bold text-primary">Add Admin(Non Academic) Staff Member</h3>
                            <div class="row">
                </div>
                <div class="modal-body row p-2">
                        <div class="col-12">
                                <fieldset class="card shadow h-100">
                                    <div class="card-header text-primary">
                                            Aggregate Information
                                    </div>

                                    <div class="form-row pt-3">
                                            <div class="col-md form-group">
                                                
                                                <select class="form-control" id="eduLevel" name="education_level">
                                                    @foreach ($data['education_levels'] as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="empType" class="form-control-placeholder pt-3">Employment Type</label>
                                            </div>
                                        </div>  

                                    <div class="card-body px-4">
                                        <div class="form-row ptt-1">
                                            <div class="col form-group">
                                                <input type="text" id="no_of_females" name="number_of_females" class="form-control" required>
                                                <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
                                            </div>
    
                                            <div class="col form-group">
                                                <input type="text" id="no_of_males" name="number_of_males" class="form-control" required>
                                                <label class="form-control-placeholder" for="no_of_males">Males(Aggregate)</label>
                                            </div>
                                        </div>
                                    </div>  
                                </fieldset>
                            </div>
                        </div>    
                </div>
                <div class="modal-footer">
                        <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
                </div>
            </div>

        </div>
    </div>
    @endif

    @if ($data['page_name'] == 'institution.admin_and_non_academic_staff.edit')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                        <form class="" action="/staff/academic" method="POST">
                            @csrf
                            <h3 class="font-weight-bold text-primary">Edit Admin(Non Academic) Staff Member Info</h3>
                            <div class="row">
                </div>
                <div class="modal-body row p-2">
                        <div class="col-12">
                                <fieldset class="card shadow h-100">
                                    <div class="card-header text-primary">
                                            Aggregate Information
                                    </div>

                                    <div class="form-row pt-3">
                                            <div class="col-md form-group">
                                                
                                                <select class="form-control" id="empType" name="employment_type">
                                                    @foreach ($data['education_levels'] as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="empType" class="form-control-placeholder pt-3">Employment Type</label>
                                            </div>
                                        </div>  

                                    <div class="card-body px-4">
                                        <div class="form-row ptt-1">
                                            <div class="col form-group">
                                                <input type="text" id="no_of_females" name="number_of_females" class="form-control" required>
                                                <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
                                            </div>
    
                                            <div class="col form-group">
                                                <input type="text" id="no_of_males" name="number_of_males" class="form-control" required>
                                                <label class="form-control-placeholder" for="no_of_males">Males(Aggregate)</label>
                                            </div>
                                        </div>
                                    </div>  
                                </fieldset>
                            </div>
                        </div>    
                </div>
                <div class="modal-footer">
                        <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
                </div>
            </div>

        </div>
    </div>
    @endif

    </div>
    
@endsection
