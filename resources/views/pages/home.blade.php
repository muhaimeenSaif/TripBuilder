  
@extends('layouts.mainLayout')
@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome to your personal trip builder</h1>
        <section>
            <nav>
                <div class="nav nav-tabs" style="margin-left: 17%;" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" onclick="roundTrip()"id="nav-round-trip" data-toggle="tab" href="#round-trip" role="tab" aria-controls="nav-home" aria-selected="true">Round Trip</a>
                    <a class="nav-item nav-link" onclick="oneWay()" id="nav-one-way" data-toggle="tab" href="#nav-one-way" role="tab" aria-controls="nav-profile" aria-selected="false">One Way</a>
                    <a class="nav-item nav-link" onclick="multiCity()" id="nav-multi-city" data-toggle="tab" href="#multi-city"  aria-controls="nav-contact" aria-selected="false">Multi-City</a>
                </div>
            </nav>
            <br>
            <div class="tab-content" id="nav-tabContent">
                {{-- Round Trip --}}
                <div class="tab-pane fade show active" id="nav-round-trip" role="tabpanel" aria-labelledby="nav-home-tab">
                    {!!Form::open(['action'=> 'TripsController@search','method'=> 'POST'])!!}
                <div id="dynamicAppend">
                    <div class="row">
                            <div class="input-group col-md-2">
                            </div>
                            <div class="input-group col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">From</span>
                                </div>
                                <input autocomplete="off" class="form-control autocomplete"  id="autocomplete" name="departure_airport[1]" type="text" placeholder="City name" required=""/>
                            </div>
                              
                            <div class="input-group col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">To</span>
                                </div>
                                <input autocomplete="off" class="form-control autocomplete" id="autocomplete2" name="arrival_airport[1]" type="text" placeholder="City name" required=""/>
                            </div>
                        </div>
                      
                        <br>
                        <div class="row">
                                <div class="input-group col-md-2">
                                </div>
                                <div class="input-group col-md-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text ">Departure</span>
                                    </div>
                                    <input type="text" autocomplete="off" class="form-control datePickerr"  name="departure_date[1]" id="departure_date" placeholder="Departure date" required="">
                                </div>
                                    <br>
                                <div class="input-group col-md-4" id="status">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text ">Return</span>
                                    </div>
                                    <input type="text" autocomplete="off" class="form-control datePickerr" name="return_date[1]" id="return_date" placeholder="Return date" >
                                </div>
                        </div>
                        <br>
                        <div>
                            <select class="bootstrap-select btn btn-secondary dropdown-toggle" name="passengers">
                                    <option value="1" selected="selected">Passenger 1</option>
                            </select>
                        </div>
                    </div>
                    <br>    <br>  
                        <div class="input_fields_wrap" id="input_fields_wrap" style="display:none">
                            <button class="btn btn-success add_field_button" style="float: right">Add More Fields</button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" style="float: left; margin-left: 17%" id="roundTrip">Search Flights</button>
                        </div>
                        
                        {!!Form::close()!!}
                </div>
        
            </div>
        </section>
    </div>


   {{---------------------------------- Results -------------------------------------------}}
    @if(count($result)>0 && $result[0]!=-10  && $result[0]!=-20)
    
    <div class="jumbotron text-center">
            <section>
            {{------------------------------- Round Trip search result output -------------------------}}
            @if (count($result)==2)
                @foreach ($result[0] as $f1)
                    @foreach ($result[1] as $f2)
                    
                    <div class="row">
                       <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <h5>{{$f1['airline_name']}}</h5>
                            </div>
                            <div class="col-md-3">
                                <h5>{{$f1['departure_time']}}</h5>
                                <h6>{{$f1['departure_city']}}</h6>
                                <p>{{$f1['departure_airport_name']}}</p>
                            </div>
                            <div class="col-md-2">
                                @php
                                    $dprTimeZone = $f1['departure_timeZone'];
                                    $dprDate = $f1['departure_date'];
                                    $dprTime = $f1['departure_time'];

                                    $avrTimeZone = $f1['arrival_timeZone'];
                                    $avrTime = $f1['arrival_time'];
                                   
                                    $dprDateTime = new DateTime("$dprDate[1] $dprTime", new DateTimeZone($dprTimeZone));
                                    $avrDateTime = new DateTime("$dprDate[1] $avrTime", new DateTimeZone($avrTimeZone));
                                    
                                    $timeDiff = $dprDateTime->diff($avrDateTime);
                                    $timeDiff2 = $timeDiff->format("%Hh %Im");
                                @endphp
                                    <p>{{$timeDiff2}}</p>
                                    <hr/>
                                    <p>Non-stop</p>
                            </div>
                            <div class="col-md-3">
                                <h5>{{$f1['arrival_time']}}</h5>
                                <h6>{{$f1['arrival_city']}}</h6>
                                <p>{{$f1['arrival_airport_name']}}</p>
                           </div>
                        </div>  
                        
                        <div class="row">
                                <div class="col-md-3">
                                    <h5>{{$f2['airline_name']}}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$f2['departure_time']}}</h5>    
                                    <h6>{{$f2['departure_city']}}</h6>
                                    <p>{{$f2['departure_airport_name']}}</p>
                                </div>
                                <div class="col-md-2">
                                    @php
                                        $dprTimeZone = $f2['departure_timeZone'];
                                        $dprDate = $f2['departure_date'];
                                        $dprTime = $f2['departure_time'];
    
                                        $avrTimeZone = $f2['arrival_timeZone'];
                                        $avrTime = $f2['arrival_time'];
                                       
                                        $dprDateTime = new DateTime("$dprDate[1] $dprTime", new DateTimeZone($dprTimeZone));
                                        $avrDateTime = new DateTime("$dprDate[1] $avrTime", new DateTimeZone($avrTimeZone));
                                        
                                        $timeDiff = $dprDateTime->diff($avrDateTime);
                                        $timeDiff2 = $timeDiff->format("%Hh %Im");
                                        
                                    @endphp
                                            <p>{{$timeDiff2}}</p>
                                            <hr/>
                                            <p>Non-stop</p>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$f2['arrival_time']}}</h5>
                                    <h6>{{$f2['arrival_city']}}</h6>
                                    <p>{{$f2['arrival_airport_name']}}</p>
                               </div>
                        </div>  
                       </div>
                

                        <div class="col-md-2">
                                @php
                                    $price = $f1['price'] + $f2['price']  
                                @endphp
                                <h4> C${{$price}} </h4>
                                <button type="button"  onclick="bookBtn()" id="bookBtn" class="btn btn-success">Book</button>
                        </div>
                    
                    </div> 
                    <hr/>
                    @endforeach
                
                @endforeach
            {{---------------------------------- Multi City ---------------------------------}}
            @elseif(count($result)>2) 
                @for ($i = 0; $i < count($result) ; $i++)
                    @foreach ($result[$i] as $item)
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>{{$item['airline_name']}}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$item['departure_time']}}</h5>    
                                    <h6>{{$item['departure_city']}}</h6>
                                    <p>{{$item['departure_airport_name']}}</p>
                                </div>
                                <div class="col-md-2">
                                    @php
                                        $dprTimeZone = $item['departure_timeZone'];
                                        $dprDate = $item['departure_date'];
                                        $dprTime = $item['departure_time'];

                                        $avrTimeZone = $item['arrival_timeZone'];
                                        $avrTime = $item['arrival_time'];
                                        
                                        $dprDateTime = new DateTime("$dprDate[1] $dprTime", new DateTimeZone($dprTimeZone));
                                        $avrDateTime = new DateTime("$dprDate[1] $avrTime", new DateTimeZone($avrTimeZone));
                                        
                                        $timeDiff = $dprDateTime->diff($avrDateTime);
                                        $timeDiff2 = $timeDiff->format("%Hh %Im");
                                        
                                    @endphp
                                            <p>{{$timeDiff2}}</p>
                                            <hr/>
                                            <p>Non-stop</p>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$item['arrival_time']}}</h5>
                                    <h6>{{$item['arrival_city']}}</h6>
                                    <p>{{$item['arrival_airport_name']}}</p>
                                </div>
                            </div>
                        </div>
                           <div class="col-md-2">
                                <h4>C${{$item['price']}} </h4>
                                <button type="button"  onclick="bookBtn()" id="bookBtn" class="btn btn-success">Book</button>
                           </div>
                    </div>  
                @endforeach   
                @endfor
              
            
            {{------------------------- Onway search results output ------------------------}}
            @else
                @foreach ($result as $item)
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>{{$item['airline_name']}}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$item['departure_time']}}</h5>    
                                    <h6>{{$item['departure_city']}}</h6>
                                    <p>{{$item['departure_airport_name']}}</p>
                                </div>
                                <div class="col-md-2">
                                    @php
                                        $dprTimeZone = $item['departure_timeZone'];
                                        $dprDate = $item['departure_date'];
                                        $dprTime = $item['departure_time'];

                                        $avrTimeZone = $item['arrival_timeZone'];
                                        $avrTime = $item['arrival_time'];
                                        
                                        $dprDateTime = new DateTime("$dprDate[1] $dprTime", new DateTimeZone($dprTimeZone));
                                        $avrDateTime = new DateTime("$dprDate[1] $avrTime", new DateTimeZone($avrTimeZone));
                                        
                                        $timeDiff = $dprDateTime->diff($avrDateTime);
                                        $timeDiff2 = $timeDiff->format("%Hh %Im");
                                        
                                    @endphp
                                            <p>{{$timeDiff2}}</p>
                                            <hr/>
                                            <p>Non-stop</p>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$item['arrival_time']}}</h5>
                                    <h6>{{$item['arrival_city']}}</h6>
                                    <p>{{$item['arrival_airport_name']}}</p>
                                </div>
                            </div>
                        </div>
                           <div class="col-md-2">
                                <h4>C${{$item['price']}} </h4>
                                <button type="button" onclick="bookBtn()" id="bookBtn" class="btn btn-success">Book</button>
                           </div>
                    </div>  
                @endforeach
           
            @endif
    
    @elseif($result[0]==-10)    
        <div class="jumbotron text-center">
            <h1>No Flights Found</h1>
        </div>
    
    </section> 
    </div>
    @endif
    {{--------------------------------- scripts --------------------------------------------}}
    <script type="text/javascript"> 
    function oneWay() {
        $("#status").hide();

        var hidemask = document.querySelectorAll(".removeAfterDone");
        for (var i = 0; i < hidemask.length; i++) {
            hidemask[i].remove();
        }

        document.getElementById("input_fields_wrap").style.display = "none";
    }
    function roundTrip() {
        $("#status").show();

       var hidemask = document.querySelectorAll(".removeAfterDone");
        for (var i = 0; i < hidemask.length; i++) {
            hidemask[i].remove();
        }

        document.getElementById("input_fields_wrap").style.display = "none";
    }
    function multiCity() {
        $("#status").hide();
        $("#add_field_button").show();
        document.getElementById("input_fields_wrap").style.display = "block";
    }
    function bookBtn(){
        alert("Your flight has been booked");
        $('#bookBtn').remove();
    }
    // DateTime 
    $(document).ready(function(){
  
        $("#departure_date").datepicker({
        startDate : new Date(),
        autoclose: true,
        todayHighlight: true,
        }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#return_date').datepicker('setStartDate', minDate);
        });

        $("#return_date").datepicker(
            {
                autoclose: true,
            })
        .on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#return_date').datepicker('setEndDate', minDate);
        });

    });
    
    </script>
@endsection