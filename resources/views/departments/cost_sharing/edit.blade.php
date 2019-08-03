@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/student/cost-sharing/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <h3 class="font-weight-bold text-primary">Edit Cost Sharing Information</h3>
            <hr>
            <div class="row my-5">
                <div class="col-md-5">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Personal Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-row">
                                <div class="col-md form-group">
                                    <label class="" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required disabled
                                           value="{{$costSharings->name}}">
                                </div>
                            </div>

                            <div class="form-row pt-3">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label class="" for="student_id">Student ID</label>
                                        <input type="text" id="student_id" name="student_id" class="form-control"
                                               disabled
                                               value="{{ $costSharings->student_id}}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row pt-3">
                                <div class="col-md">
                                    <label class="" for="sex">Sex</label>
                                    <input type="text" id="sex" name="sex" class="form-control" disabled
                                           value="{{ $costSharings->sex }}"
                                           required>
                                </div>
                            </div>


                        </div>
                    </fieldset>

                </div>
                <div class="col-md-7">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Cost Sharing Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-row">
                                <div class="col-md form-group">
                                    <label class="" for="field_of_study">Field of Study</label>
                                    <input type="text" id="field_of_study" name="field_of_study" class="form-control"
                                           disabled
                                           value="{{ $costSharings->field_of_study }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="tin_number">TIN Number</label>
                                        <input type="text" id="tin_number" name="tin_number" class="form-control"
                                               disabled
                                               value="{{ $costSharings->tin_number }}"
                                               required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="receipt_number">Receipt
                                            Number</label>
                                        <input type="text" id="receipt_number" name="receipt_number" disabled
                                               value="{{ $costSharings->receipt_number }}"
                                               class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-md-6 form-group">
                                    <label for="registration_date" class="">
                                        Registration Date
                                    </label>
                                    <input class="form-control" id="registration_date" name="registration_date" disabled
                                           value="{{ $costSharings->registration_date}}"
                                           type="date" placeholder="2011-08-19">

                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="clearance_date" class="">
                                        Clearance Date From Campus
                                    </label>
                                    <input class="form-control" id="clearance_date" name="clearance_date" type="date"
                                           disabled
                                           value="{{ $costSharings->clearance_date}}"
                                           placeholder="2011-08-19">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>


            <fieldset class="card shadow h-100 my-5">
                <div class="card-header text-primary">
                    Financial Information
                </div>
                <div class="card-body px-4">
                    <div class="form-row pt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="number" id="tuition_fee" name="tuition_fee" class="form-control" required
                                       value="{{ $costSharings->tuition_fee }}">
                                <label class="form-control-placeholder" for="tuition_fee">Tuition Fee</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="number" id="food_expenses" name="food_expenses" class="form-control"
                                       value="{{ $costSharings->food_expense }}"
                                       required>
                                <label class="form-control-placeholder" for="food_expenses">Food Expenses</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="number" id="dormitory_expenses" name="dormitory_expenses"
                                       value="{{ $costSharings->dormitory_expense }}"
                                       class="form-control" required>
                                <label class="form-control-placeholder" for="dormitory_expenses">Dormitory
                                    Expenses</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row pt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" id="pre_payment_amount" name="pre_payment_amount"
                                       value="{{ $costSharings->pre_payment_amount }}"
                                       class="form-control" required>
                                <label class="form-control-placeholder" for="pre_payment_amount">Pre-Payment
                                    Amount</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" id="unpaid_amount" name="unpaid_amount" class="form-control"
                                       value="{{ $costSharings->unpaid_amount }}"
                                       required>
                                <label class="form-control-placeholder" for="unpaid_amount">Total Unpaid Cost Sharing
                                    Amount</label>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection

