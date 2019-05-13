@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="font-weight-bold text-primary">Student Attrition</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Band</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Diploma</option>
                                    <option>Advanced Diploma</option>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Department</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Diploma</option>
                                    <option>Advanced Diploma</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Program</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Diploma</option>
                                    <option>Advanced Diploma</option>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Education Level</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Diploma</option>
                                    <option>Advanced Diploma</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Year Level</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Diploma</option>
                                    <option>Advanced Diploma</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Type</label>
                                    <div class="col-md-8">
                                        <select class="form-control">
                                            <option>Diploma</option>
                                            <option>Advanced Diploma</option>
                                        </select>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Case</label>
                                    <div class="col-md-8">
                                        <select class="form-control">
                                            <option>Government Appointment</option>
                                            <option>Transfer to other Higher Education Institutions</option>
                                            <option>Transfer to other gov't Agencies </option>
                                            <option>Resignation</option>
                                            <option>Retirement</option>
                                            <option>Death</option>
                                            <option>Discipline</option>
                                            <option>Other</option>                                
                                        </select>
                                    </div>
                                </div> 
                                
                            </div>
                        </div>
        
                        <table class="table border dataTable table-hover" width="100%"
                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                        style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Staff Member</th>
                                    <th>Number of Male Students</th>
                                    <th>Number of Female Students</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Airi Satou Airi</td>
                                    <td><a href="#" class="text-primary">Remove</a></td>
                                </tr>
                                <tr>
                                    <td>Airi Satou Airi</td>
                                    <td><a href="#" class="text-primary">Remove</a></td>
                                </tr>                        
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
@endSection