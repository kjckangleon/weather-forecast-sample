$(document).ready( function () {
  initTable();
});

function initTable() {

    if ($.fn.DataTable.isDataTable("#myTable")) {
        $('#myTable').DataTable().clear().destroy();
      }
    $('#myTable').DataTable({
        "order": [[ 0, "desc" ]], 
        ajax: {
          url: 'http://localhost:8000/api/weatherData',
          dataSrc: ''
      },
      columns: [
        { data: 'id' },
        { data: 'city' },
        { data: 'country' },
        { data: 'weather_data' }
    ]
    });
}

jQuery(document).ready(function($){
  jQuery('#btn-add').click(function () {
      jQuery('#btn-save').val("add");
      jQuery('#myForm').trigger("reset");
      jQuery('#formModal').modal('show');
  });

    $("#formModal").on("hidden.bs.modal", function () {
        $('#cityList').empty();
        $('#weatherData').empty();
        $("#cityList").append(`<option value="" selected disabled hidden>Choose here</option>`);
        document.getElementById('btn-save').disabled =true;
    });

  var listOfCountries = [];
  document.getElementById('btn-save').disabled =true;
  $.get("https://countriesnow.space/api/v0.1/countries/", function(result){
    document.getElementById('btn-add').disabled =true;
    listOfCountries.push(result);
    if (result) {
        $("#countryList").append(`<option value="" selected disabled hidden>Choose here</option>`);
        result.data.forEach((data, key) => {
            $("#countryList").append(`<option value=${data.country}>${data.country}</option>`);
        })
        document.getElementById('btn-add').disabled = false;
    }
});
    $('#countryList').change(function() { 
        var value = $(this).val();
        var list = listOfCountries[0].data.filter(res => res.country == value);
        $('#cityList').empty();

        if (list.length != 0) {
            $("#cityList").append(`<option value="" selected disabled hidden>Choose here</option>`);
            list[0].cities.forEach((data, key) => {
                $("#cityList").append(`<option value=${data}>${data}</option>`);
            });
        } else {
            alert('Cities not found');
        }
});

    $('#cityList').change(function() {
        
        var openWeatherAppId = 'be60ab4bbd940e8473317ca54d1286a6';
        var weatherApiAppId = '37a29c8df0f3498aaa6144806212604';
        var value = $(this).val();
        var openWeatherUrl = `http://api.openweathermap.org/data/2.5/weather?q=${value}&units=metric&appid=${openWeatherAppId}`;
        var weatherApiUrl = `http://api.weatherapi.com/v1/current.json?key=${weatherApiAppId}&q=${value}&aqi=yes`;
        
        let openWeatherAPITemp = 0;
        let weatherAPITemp = 0;

        $('#weatherData').empty();
        
        
        var openWeatherAPI = $.get(openWeatherUrl, function(result) {
            console.log(result);
            openWeatherAPITemp = result.main.temp;
        }).done(function () {
            console.log('Success call Open Weather API');
        }).fail(function() {
            console.log('Error Open Weather API');
            document.getElementById('btn-save').disabled = true;
            alert('Weather not found');
        });


        var weatherAPI = $.get(weatherApiUrl, function(result) {
            weatherAPITemp = result.current.temp_c;
            console.log(result);
        }).done(function() {
            console.log('Success call Weather API');
        }).fail(function () {
            console.log('Error call on Weather API')
            document.getElementById('btn-save').disabled = true;
            alert('Weather not found');
        });


        $.when(openWeatherAPI, weatherAPI).done(function(req1, req2) {
            console.log(req1, req2);
            if (req1[1] && req2[1] == 'success') {
                let totalTemp = (openWeatherAPITemp + weatherAPITemp) / 2;
                $('#weatherData').append(`
                    <label for='tempVal'>Temperature Value:</label>
                    <span id='tempVal'>${totalTemp.toFixed(2)}°C</span>
                `);
                document.getElementById('btn-save').disabled = false;
                console.log(totalTemp);
            } else {
                alert('No data found.');
            }
        });
    });

  $("#btn-save").click(function (e) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          }
      });
      e.preventDefault();
      var formData = {
          country: jQuery('#countryList option:selected').text(),
          city: jQuery('#cityList option:selected').text(),
          weather_data: jQuery('#tempVal').text(),
      };
      var state = jQuery('#btn-save').val();
      var type = "POST";
      var ajaxurl = 'http://localhost:8000/api/saveWeather';
      $.ajax({
          type: type,
          url: ajaxurl,
          data: formData,
          dataType: 'json',
          success: function (data) {
             console.log(data);
              jQuery('#myForm').trigger("reset");
              jQuery('#formModal').modal('hide')
          },
          error: function (data) {
                jQuery('#myForm').trigger("reset");
              console.log(data);
          }
      });
      initTable();
  });
});