@extends('layouts.app')

@section('content')
    <div class="container w-75">
        <h1 class="font-weight-bold text-primary">Staff Attrition</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Qualification</label>
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
                    <thead class="thead-light">
                        <tr>
                                <th class="text-primary">Staff Member</th>
                                <th></th>
                        </tr>                       
                    </thead>
                    <tbody>
                        <tr onclick="window.location='staff/academic/details'">
                            <td>Airi Satou Airi</td>
                            <td><a href="#" class="text-primary">Remove</a></td>
                        </tr>
                        <tr onclick="window.location='staff/academic/details'">
                            <td>Airi Satou Airi</td>
                            <td><a href="#" class="text-primary">Remove</a></td>
                        </tr>                        
                    </tbody>
                </table>
                <div class="form-group row mt-3">
                    <label class="col-md-3 col-form-label">Add Staff Member</label>
                    <div class="col-md-8">
                        <select class="form-control">
                            <option>Name</option>
                            <option>Name</option>
                                                  
                        </select>
                    </div>
                    <div class="col-md-1">
                        <input type="submit" class="btn btn-outline-secondary" value="Add">
                    </div>
                </div> 

            </div>
        </div>
        
    </div>
@endSection