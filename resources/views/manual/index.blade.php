@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usage Manuals</h6>
                </div>
                <div class="card-body">
                    <h5 class="text-primary p-3">Choose a role</h5>
                    <div id="accordion">
                        <div class="card rounded-0">
                            <div class="card-header collapsed" id="headingOne" data-toggle="collapse"
                                 data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="btn text-primary mb-0 collapsed">
                                    University Super Admin
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                 data-parent="#accordion">
                                <div class="card-body pl-5">
                                    Get manual <a target="_blank"
                                                  href="https://docs.google.com/document/d/1MZ6AmjLvvKnbcs346WQji6QiSLyaJeiwxgAQybkC7MU/edit?usp=sharing">here</a>.
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-0">
                            <div class="card-header collapsed" id="headingTwo" data-toggle="collapse"
                                 data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5 class="btn text-primary mb-0">
                                    College Super Admin
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                 data-parent="#accordion">
                                <div class="card-body pl-5">
                                    Get manual <a target="_blank"
                                                  href="https://docs.google.com/document/d/15eX_-drh514wKaVyMHnZB8pfXDEqiybVI80Eiupl2J4/edit?usp=sharing">here</a>.
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-0">
                            <div class="card-header collapsed" id="headingThree" data-toggle="collapse"
                                 data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h5 class="btn text-primary mb-0 collapsed">
                                    College Common Admin
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                 data-parent="#accordion">
                                <div class="card-body pl-5">
                                    Get manual <a target="_blank"
                                                  href="https://docs.google.com/document/d/1b9tAh7LDyQXnAPjGJ8c5qChZwSes0TXX6wOIQyFVJ-I/edit?usp=sharing">here</a>.
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-0">
                            <div class="card-header collapsed" id="headingFour" data-toggle="collapse"
                                 data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <h5 class="btn text-primary mb-0 collapsed">
                                    Department Common Admin
                                </h5>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                 data-parent="#accordion">
                                <div class="card-body pl-5">
                                    Get manual <a target="_blank"
                                                  href="https://docs.google.com/document/d/1MstSderJx6oJuB-FkTKnrYO4pWOBxLQNnw2btA7KbBQ/edit?usp=sharing">here</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
