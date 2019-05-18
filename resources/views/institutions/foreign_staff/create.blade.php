@extends('layouts.app')

@section('content')
    <div class="container-fluid">
            @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
            @endif
        <form class="pb-5" action="/institution/foreign-staff/" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add Foreign Staff Member</h3>
            <div class="row my-5">
                <div class="col-md-5">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Personal Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="full_name" name="full_name" class="form-control" required>
                                    <label class="form-control-placeholder" for="full_name">Full Name</label>
                                </div>
                            </div>
                        <hr>
                        <div class="form-row pt-3">
                            <div class="col-md-6">
                                <div class="form-group">                                                                        
                                    <div id="sex">
                                        <label class="radio-inline"><input class="form-check-inline" type="radio"
                                                                            name="sex" value="Male" id="male">Male</label>
                                        <label class="radio-inline"><input class="form-check-inline" type="radio"
                                                                            name="sex" value="Female">Female</label>
                                    </div>
                                    {{-- <label class="form-control-placeholder" for="male">Sex</label> --}}
                                </div>     
                            </div>   
                        </div>
                        <hr>
                            <div class="col">      
                                <div class="form-group">
                                    <input type="text" id="orig" name="origin" class="form-control" required>
                                    <label class="form-control-placeholder" for="orig">Origin</label>
                                </div>
                            </div>       
                                
                            <div class="col">
                            {{-- This input must be replaced with a drop down  --}}
                                <div class="form-group">
                                    <select class="form-control" id="dept" name="department">
                                        @foreach ($data['department'] as $dept)
                                            <option value="{{$dept->department_name}}">{{$dept->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-7">
                    <fieldset class="card shadow mt-md-0 mt-5 h-100">
                        <div class="card-header text-primary">
                                Employment Information
                        </div>
                        <div class="card-body px-5">
                        <div class="form-row pt-3">
                            {{-- dont forget to convert these in to a dropdown too --}}
                            <div class="col-md form-group">
                                <select class="form-control" id="eduLevel" name="education_level">
                                    @foreach ($data['education_levels'] as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md form-group">
                                <input type="text" id="specializn" name="specialization" class="form-control" required>
                                <label class="form-control-placeholder" for="specializn">Specialization</label>
                            </div>
                        </div>
        
                        <hr>

                            <div class="form-row mt-2 pt-3">
                            <div class="col form-group">
                                <div class="col">
                                <div class="form-group">
                                    <input class="form-control" id="employment_date" name="date_of_employment"
                                           type="date" placeholder="2011-08-19">
                                    <label for="employment_date" class="form-control-placeholder">Employment
                                        Date</label>
                                </div>
                                </div> 
                            </div> 
        
                            <div class="col-md form-group">
                                 <div class="col">
                                <div class="form-group">
                                    <input class="form-control" id="contract_start" name="start_of_contract" type="date"
                                           placeholder="2011-08-19">
                                    <label for="contract_start" class="form-control-placeholder">Start of
                                        Contract</label>
                                </div>
        
                            <div class="col-md form-group">
                                 <div class="col">
                                <div class="form-group">
                                    <input class="form-control" id="contract_end" name="end_of_contract" type="date"
                                           placeholder="2011-08-19">
                                    <label for="contract_end" class="form-control-placeholder">End of contract</label>
                                </div>
                                 </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            
            <fieldset id="academic-staff" class="card shadow">
                    <div class="card-header text-primary">
                        Remark
                    </div>
                <div class="form-row pt-3">
                    <div class="col form-group">                       
                        <textarea class="form-control" id="additional_remarks" name="additional_remark" rows="3"></textarea>
                        <label for="additional_remarks" class="form-control-placeholder">Additional Remarks</label>
                    </div>
                </div>
            </fieldset>      
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection