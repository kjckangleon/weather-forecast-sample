@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex bd-highlight mb-4">
        <div class="p-2 w-100 bd-highlight">
            <h2>Weather Forecast</h2>
        </div>
        <div class="p-2 flex-shrink-0 bd-highlight">
            <button class="btn btn-success" id="btn-add">
                Add weather
            </button>
        </div>
    </div>

    <div>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Weather Data.</th>
                </tr>
            </thead>
        </table>
        <div class="modal fade" id="formModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="formModalLabel">Select a country for Temperature</h4>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select id="countryList" class="form-select" aria-label="Default select example">
                                    <option value="" selected disabled hidden>Choose here</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="country" class="form-select" aria-label="Default select example">Cities</label>
                                <select id="cityList">
                                    <option value="" selected disabled hidden>Choose here</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600">Weather info:</label>
                                <div id="weatherData"> 

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                        </button>
                        <input type="hidden" id="todo_id" name="todo_id" value="0">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection