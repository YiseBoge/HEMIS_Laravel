@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/student/cost-sharing" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Cost Sharing</h3>
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
                                    <input type="text" id="name" name="name" class="form-control" required
                                           value=“{{ old('name') }}">
                                    <label class="form-control-placeholder" for="name">Name</label>
                                </div>
                            </div>

                            <div class="form-row pt-3">
                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="text" id="student_id" name="student_id" class="form-control"
                                               value=“{{ old('student_id') }}"
                                               required>
                                        <label class="form-control-placeholder" for="student_id">Student ID</label>

                                    </div>
                                </div>
                            </div>

                            <div class="form-row pt-3">
                                <div class="col-md">
                                    <div class="form-group">
                                        <div>
                                            <label class="radio-inline"><input
                                                        class="d-inline-block m-2 form-check-inline" type="radio"
                                                        {{ old('sex')=='Male' ? 'checked='.'"'.'checked'.'"' : '' }}
                                                        name="sex" value="Male">Male</label>
                                            <label class="radio-inline"><input
                                                        class="d-inline-block m-2 form-check-inline" type="radio"
                                                        {{ old('sex')=='Female' ? 'checked='.'"'.'checked'.'"' : '' }}
                                                        name="sex" value="Female">Female</label>
                                        </div>
                                    </div>
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
                                    <input type="text" id="field_of_study" name="field_of_study" class="form-control"
                                           value=“{{ old('field_of_study') }}"
                                           required>
                                    <label class="form-control-placeholder" for="field_of_study">Field of Study</label>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="tin_number" name="tin_number" class="form-control"
                                               value=“{{ old('tin_number') }}"
                                               required>
                                        <label class="form-control-placeholder" for="tin_number">TIN Number</label>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="receipt_number" name="receipt_number"
                                               value=“{{ old('receipt_number') }}"
                                               class="form-control" required>
                                        <label class="form-control-placeholder" for="receipt_number">Receipt
                                            Number</label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-md-6 form-group">
                                    <input class="form-control" id="registration_date" name="registration_date"
                                           value=“{{ old('registration_date') }}"
                                           type="date" placeholder="2011-08-19">
                                    <label for="registration_date" class="form-control-placeholder">
                                        Registration Date
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input class="form-control" id="clearance_date" name="clearance_date" type="date"
                                           value=“{{ old('clearance_date') }}"
                                           placeholder="2011-08-19">
                                    <label for="clearance_date" class="form-control-placeholder">
                                        Clearance Date From Campus
                                    </label>
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
                                       value=“{{ old('tuition_fee') }}">
                                <label class="form-control-placeholder" for="tuition_fee">Tuition Fee</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="number" id="food_expenses" name="food_expenses" class="form-control"
                                       value=“{{ old('food_expenses') }}"
                                       required>
                                <label class="form-control-placeholder" for="food_expenses">Food Expenses</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="number" id="dormitory_expenses" name="dormitory_expenses"
                                       value=“{{ old('dormitory_expenses') }}"
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
                                       value=“{{ old('pre_payment_amount') }}"
                                       class="form-control" required>
                                <label class="form-control-placeholder" for="pre_payment_amount">Pre-Payment
                                    Amount</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" id="unpaid_amount" name="unpaid_amount" class="form-control"
                                       value=“{{ old('unpaid_amount') }}"
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

