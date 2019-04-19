@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form" action="index.html" method="post">

            <div class="" id="formDiv">

                <div class="row">
                    <div class="col-sm">
                        <label for="institutionName">Institution Name</label>
                    </div>
                    <div class="col-sm">
                        <select class="" name="institutionName">
                            <option value="adigrat">Adigrat University</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <label for="currentSemester">Current currentSemester</label>

                    </div>

                    <div class="col-sm">
                        <select class="" name="currentSemester">
                            <option value="firstSemester">First</option>
                            <option value="secondSemester">Second</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        Bands

                    </div>
                    <div class="col-sm">
                        <input type="checkbox" name="engineeringAndTechnology" value="engineeringTechnology">
                        <label for="engineeringTechnology">Engineering & Technology</label>
                    </div>

                    <div class="col-sm">
                        <input type="checkbox" name="businessAndEconomics" value="businessAndEconomics">
                        <label for="businessAndEconomics">Business & Economins</label>

                    </div>

                    <div class="col-sm-3">

                    </div>



                </div>

                <div class="row">

                    <div class="col-sm">

                    </div>

                    <div class="col-sm">
                        <input type="checkbox" name="medicineAndHealthScience" value="medicineAndHealthScience">
                        <label for="medicineAndHealthScience">Medice & Health Science</label>

                    </div>

                    <div class="col-sm-4">
                        <input type="checkbox" name="naturalAndComputationalSciences" value="naturalAndComputationalSciences">
                        <label for="naturalAndComputationalSciences">Natural & Computational Sciences</label>
                    </div>



                    <div class="col-sm-2">

                    </div>

                </div>

                <div class="row">
                    <div class="col-sm">

                    </div>

                    <div class="col-sm">
                        <input type="checkbox" name="agricultureAndLifeSciences" value="agricultureAndLifeSciences">
                        <label for="agricultureAndLifeSciences">Agriculture & Sciences</label>

                    </div>

                    <div class="col-sm-4">
                        <input type="checkbox" name="socialSciencesAndHumanities" value="socialSciencesAndHumanities">
                        <label for="socialSciencesAndHumanities">Social Sciences & Humanities</label>

                    </div>

                    <div class="col-sm-2">

                    </div>

                </div>




            </div>

            <div class="row" id="addBandButtonRow">
                <div class="col-sm">
                </div>

                <div class="col-sm">
                    <input type="text" name="newBand" id="newBand">
                </div>

                <div class="col-sm">
                    <button type="button" name="bandButton" onclick="addBand(newBand)">Add</button>
                </div>

                <div class="col-sm">

                </div>

            </div>

            <div class="row">
                <p id="container"></p>

            </div>





        </form>
    </div>
@endsection
