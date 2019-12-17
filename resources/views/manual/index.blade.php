@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usage Manuals</h6>
                </div>
                <div class="card-body">
                    <h5 class="p-3">Choose a role to get its manual</h5>
                    <div id="accordion">
                        @if (Auth::user()->hasAnyRole(["Department Admin", "College Admin", "College Super Admin", "University Admin", "Super Admin"]))
                            @if (Auth::user()->hasAnyRole(["College Admin", "College Super Admin", "University Admin", "Super Admin"]))
                                @if (Auth::user()->hasAnyRole(["College Super Admin", "University Admin", "Super Admin"]))
                                    @if (Auth::user()->hasAnyRole(["University Admin", "Super Admin"]))
                                        <div class="card rounded-0">
                                            <div class="card-header collapsed">
                                                <a target="_blank"
                                                   href="https://docs.google.com/document/d/1MZ6AmjLvvKnbcs346WQji6QiSLyaJeiwxgAQybkC7MU/edit?usp=sharing"
                                                   class="d-block text-primary mb-0 collapsed">
                                                    University Super Admin
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card rounded-0">
                                        <div class="card-header collapsed">
                                            <a target="_blank"
                                               href="https://docs.google.com/document/d/15eX_-drh514wKaVyMHnZB8pfXDEqiybVI80Eiupl2J4/edit?usp=sharing"
                                               class="d-block text-primary mb-0 collapsed">
                                                College Super Admin
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="card rounded-0">
                                    <div class="card-header collapsed">
                                        <a target="_blank"
                                           href="https://docs.google.com/document/d/1b9tAh7LDyQXnAPjGJ8c5qChZwSes0TXX6wOIQyFVJ-I/edit?usp=sharing"
                                           class="d-block text-primary mb-0 collapsed">
                                            College Common Admin
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="card rounded-0">
                                <div class="card-header collapsed">
                                    <a target="_blank"
                                       href="https://docs.google.com/document/d/1MstSderJx6oJuB-FkTKnrYO4pWOBxLQNnw2btA7KbBQ/edit?usp=sharing"
                                       class="d-block text-primary mb-0 collapsed">
                                        Department Admin
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
