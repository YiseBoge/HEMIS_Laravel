@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Teachers on Special Program</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-3 m-3 text-center">
                        <a href="/department/special-program-teacher/create"
                           class="btn btn-outline-primary btn-sm mb-0">
                            Add<i class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>
                <div class="row">

                    {!! Form::open(['action' => 'Department\SpecialProgramTeacherController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                    <div class="form-row">
                        <div class="col-md-5 px-3 py-md-1 col">
                            <div class="form-group">
                                {!! Form::select('program_type', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramTypes') , $data['selected_type'] , ['class' => 'form-control', 'id' => 'add_program_type', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('program_type', 'Program Type', ['class' => 'form-control-placeholder', 'for' => 'add_program_type']) !!}
                            </div>
                        </div>
                        <div class="col-md-5 px-3 py-md-1 col">
                            <div class="form-group">
                                {!! Form::select('program_status', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramStats') , $data['selected_status'] , ['class' => 'form-control', 'id' => 'add_program_status', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('program_status', 'Program Status', ['class' => 'form-control-placeholder', 'for' => 'add_program_status']) !!}
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-5 px-3 py-md-1 col">
                            <select name="band_names" class="form-control" id="band_names" onchange = "this.form.submit()">
                                @foreach ($data['bands'] as $band)
                                @if ($band->id == $data['selected_band'])
                                <option value="{{ $band->id }}" selected>{{ $band->band_name }}</option>
                                @else
                                <option value="{{ $band->id }}">{{ $band->band_name }}</option>
                                @endif
                                    
                                @endforeach
                            </select>
                            <label for="dormitory_service_type" class="form-control-placeholder">
                                Band Name
                            </label>
                            {{--{!! Form::select('band_names',$data['bands'],null, ['class' => 'form-control', 'id' => 'add_band_ name', 'onchange' => 'this.form.submit()']) !!}--}}
                            {{--{!! Form::label('band','Band',['class'=> 'form-control-placeholder','for'=>'add_band']) !!}--}}

                        </div>
                        <div class="col-md-5 px-3 py-md-1 col">
                            <div class="form-group">
                                <select name="college_names" class="form-control" id="college_names" onchange = "this.form.submit()">
                                    @foreach ($data['colleges'] as $college)
                                    @if ($college->id == $data['selected_college'])
                                    <option value="{{ $college->id }}" selected>{{ $college->college_name }}</option>
                                    @else
                                    <option value="{{ $college->id }}">{{ $college->college_name }}</option>
                                    @endif
                                        
                                    @endforeach
                                </select>
                                <label for="dormitory_service_type" class="form-control-placeholder">
                                    College Name
                                </label>
                                {{--{!! Form::select('college_names',$data['colleges'],null, ['class' => 'form-control', 'id' => 'add_college_name', 'onchange' => 'this.form.submit()']) !!}--}}
                                {{--{!! Form::label('college','College',['class'=> 'form-control-placeholder','for'=>'add_college']) !!}--}}

                            </div>

                        </div>


                    </div>
                    {!! Form::close() !!}

                </div>

                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable table-striped table-hover"
                                           id="dataTable"
                                           width="100%"
                                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                           style="width: 100%;">

                                        <thead>
                                        <tr role="row">
                                            <th style="min-width: 50px; width: 50px"></th>

                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Department
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Male
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Female
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['special_program_teachers'] as $specialProgramTeacher)
                                            <tr>
                                                <td class="text-center">
                                                    <a href=""
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>

                                                <td>{{ $specialProgramTeacher->department->departmentName->department_name}}</td>
                                                <td>{{ $specialProgramTeacher->male_number }}</td>
                                                <td>{{ $specialProgramTeacher->female_number }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($data['page_name'] == 'institution.budget.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'Institution\BudgetsController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/institution/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', \App\Models\Institution\Budget::getEnum('budget_type') , null , ['class' => 'form-control', 'id' => 'add_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'add_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {{--TODO get from budget descriptions--}}
                            {!! Form::select('budget_description', \App\Models\Institution\BudgetDescription::all() , null , ['class' => 'form-control', 'id' => 'add_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'add_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', null, ['class' => 'form-control', 'id' => 'add_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'add_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', null, ['class' => 'form-control', 'id' => 'add_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'add_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', null, ['class' => 'form-control', 'id' => 'add_utilized', 'required' => 'true']) !!}
                            {!! Form::label('utilized', 'Utilized', ['class' => 'form-control-placeholder', 'for' => 'add_utilized']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    @endif


    @if ($data['page_name'] == 'institution.budget.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['Institution\BudgetsController@update', $data['budget']->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/institution/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', \App\Models\Institution\Budget::getEnum('budget_type') , $data['budget_type'], ['class' => 'form-control', 'id' => 'edit_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {{--TODO get from budget descriptions--}}
                            {!! Form::select('budget_description', \App\Models\Institution\BudgetDescription::all() , $data['budget_description'], ['class' => 'form-control', 'id' => 'edit_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', $data['budget']->allocated_budget, ['class' => 'form-control', 'id' => 'edit_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'edit_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', $data['budget']->additional_budget, ['class' => 'form-control', 'id' => 'edit_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'edit_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', $data['budget']->utilized_budget, ['class' => 'form-control', 'id' => 'edit_utilized', 'required' => 'true']) !!}
                            {!! Form::label('utilized', 'Utilized', ['class' => 'form-control-placeholder', 'for' => 'edit_utilized']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::hidden('_method', 'PUT') !!}
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    @endif

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you wish to delete?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/institution/budget/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection