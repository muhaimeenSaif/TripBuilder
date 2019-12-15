<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Airport;
use App\Airline;
use App\Flight;
class TripsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        return view('pages.home')->with('result',[-20]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {   
        //---------------------------------MUTI CITY-----------------------
        if(count($request->departure_date)>1) {
            $results = array();
            $noOfCity = count($request->departure_date);
            for( $i = 1 ;$i <= $noOfCity; $i++){
                $search = ['departure_airport'=>$request->departure_airport[$i],
                    'arrival_airport'=> $request->arrival_airport[$i]             
                ];
                $flights = Flight::where($search)->get();
                if(count($flights)>0){
                    $f1Result = array();
                    $f1Result = $this->searchFlights($flights, $request);
                    array_push($results,$f1Result);
                }
            }
            if(count($results) == 0){
                return view('pages.home')->with('result',[-10]);
            }
            return view('pages.home')->with('result',$results);
        }
        // -------------------------------ONE WAY------------------------------------
        if($request->return_date[1] == null) {
            $search = ['departure_airport'=>$request->departure_airport,
                    'arrival_airport'=> $request->arrival_airport             
                ];
            $flights = Flight::where($search)->get();
            if(count($flights)>0){
                return view('pages.home')->with('result',$this->searchFlights($flights, $request));
            }
            else{
                
                return view('pages.home')->with('result',[-10]);
            }
        }
        // --------------------------------RoundTrip-----------------------------
        if ($request->has(['return_date','departure_date'])) {
            $search1 = ['departure_airport'=>$request->departure_airport,
            'arrival_airport'=> $request->arrival_airport
            ];
            $search2 = ['departure_airport'=>$request->arrival_airport,
            'arrival_airport'=> $request->departure_airport
            ];
            $flight1 = Flight::where($search1)->get();
            $flight2 = Flight::where($search2)->get();
            $f1Result = array();
            $f2Result = array();
            $f1Result = $this->searchFlights($flight1, $request);
            $f2Result =  $this->searchFlights($flight2, $request);
            $results = array();
            array_push($results,$f1Result);
            array_push($results,$f2Result);
            if(count($flight1)>0 && count($flight2)>0) {
                return view('pages.home')->with('result',$results);
            }
            else{
                $results = [-10];
                return view('pages.home')->with('result',[-10]);
            }
            
        }
       
    }

    public function searchFlights($flights, $request){
        $result = array();
        $results = array();
        foreach($flights as $flight){
            $result['airline'] = $flight->airline;
            $result['number'] = $flight->number;
            $result["departure_time"] = $flight->departure_time;
            $result["arrival_time"] = $flight->arrival_time;
            $result["price"] = $flight->price;
            $result['airline_name'] = $flight->airlines->name;

            foreach($flight->airport_depart as $departure) {
                $result['departure_city'] = $departure->city;
                $result['departure_airport_name'] = $departure->name;
                $result['departure_timeZone'] = $departure->timezone;
                $result['departure_date'] = $request->departure_date;
            }

            foreach($flight->airport_arrive as $arrive) {
                $result['arrival_city'] = $arrive->city;
                $result['arrival_airport_name'] = $arrive->name;
                $result['arrival_timeZone'] = $arrive->timezone;
                $result['arrival_date'] = $request->return_date;
            }

            array_push($results,$result);            
        }
        return $results;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
