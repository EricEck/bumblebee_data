<?php

namespace App\Http\Controllers;

use App\Models\Bumblebee;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    /**
     * VIEW: Show the Measurements Index View
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexView(){
        return view('measurements.index');
    }


    /**
     * Display a listing of all non calibration measurements
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Measurement::all()->where('calibration_value', false));
    }

    /**
     * Display a listing of all calibration measurements
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCalibration()
    {
        return response(Measurement::all()->where('calibration_value', true));
    }

    /**
     * Store a newly created measurement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bumblebee_id' => 'required|string',
            'measurement_timestamp' => 'required',
            'metric_sequence' => 'required|integer',
            'metric' => 'string|required',
            'method' => 'string|required',
            'process' => 'string|required',
            'value' => 'string|required',
            'unit' => 'string|nullable',
            'details' => 'string|nullable',
            'calibration_value' => 'exclude'
            ]);

        if (!Bumblebee::find($request['bumblebee_id'])){
            return response(['message' => 'Bumblebee unit not found'], 200);
        }
        $request['calibration_value'] = false;

        return response(Measurement::create($request->all()));
    }

    /**
     * Store a newly created calibration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCalibration(Request $request)
    {
        $request->validate([
            'bumblebee_id' => 'required|string',
            'measurement_timestamp' => 'required',
            'metric_sequence' => 'required|integer',
            'metric' => 'string|required',
            'method' => 'string|required',
            'process' => 'string|required',
            'value' => 'string|required',
            'unit' => 'string|nullable',
            'details' => 'string|nullable',
            'calibration_value' => 'exclude'
        ]);

        if (!Bumblebee::find($request['bumblebee_id'])){
            return response(['message' => 'Bumblebee unit not found'], 200);
        }
        $request['calibration_value'] = true;

        return response(Measurement::create($request->all()));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return Measurement::find($id);
        return response(Measurement::find($id),200);
    }
    /**
     * Display all the specified bumblebee calibrations
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCalibration($id)
    {
//        return Measurement::find($id);
        $m = Measurement::find($id);
        if ($m->calibration_value){
            return response($m, 200);
        }
        return response(['message' => 'Calibration record not found'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $measurement = Measurement::find($id);
        $measurement->update($request->all());

        return response($measurement, 200);

    }

    /**
     * Remove the specified measurement from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $m = Measurement::find($id);
        if($m) {
            if (!$m->calibration_value) {
                return response(Measurement::destroy($id), 200);
            } else {
                return response(["message" => "measurement not found"], 404);
            }
        }
        return response(["message" => "not found"], 404);
    }

    /**
     * Remove the specified calibration from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCalibration($id)
    {
        $m = Measurement::find($id);
        if($m) {
            if ($m->calibration_value) {
                return response(Measurement::destroy($id), 200);
            } else {
                return response(["message" => "calibration not found"], 404);
            }
        }
        return response(["message" => "not found"], 404);
    }


    /**
    * Find all Measurements when the bumblebee id matches
    *
    * @param  string  $bumblebee_id
    * @return \Illuminate\Http\Response
    */
    public function searchBumblebee($bumblebee_id)
    {
        return response(Measurement::where('bumblebee_id', 'like', '%'.$bumblebee_id.'%')
            ->where('calibration_value', false)
            ->get(), 200);
    }

    /**
     * Find all Calibrations when the bumblebee id matches
     *
     * @param  string  $bumblebee_id
     * @return \Illuminate\Http\Response
     */
    public function searchBumblebeeCalibration($bumblebee_id)
    {
        return response(Measurement::where('bumblebee_id', 'like', '%'.$bumblebee_id.'%')
            ->where('calibration_value', true)
            ->get(), 200);
    }


    /**
     * Find all measurements when the bumblebee id matches and metric matches
     *
     * @param  string  $bumblebee_id
     * @param string $metric
     * @return \Illuminate\Http\Response
     */
    public function searchBumblebeeMetric($bumblebee_id, $metric)
    {
//        $measurements = Measurement::where('bumblebee_id', 'like', '%'.$bumblebee_id.'%')->get();
        $measurements = Measurement::where('bumblebee_id', 'like', '%'.$bumblebee_id.'%')
            ->where('calibration_value', false)
            ->where('metric', 'like', '%'.$metric.'%')
            ->get();
        return response($measurements, 200);
    }

    /**
     * Find all calibrations when the bumblebee id matches and metric matches
     *
     * @param  string  $bumblebee_id
     * @param string $metric
     * @return \Illuminate\Http\Response
     */
    public function searchBumblebeeMetricCalibration($bumblebee_id, $metric)
    {
//        $measurements = Measurement::where('bumblebee_id', 'like', '%'.$bumblebee_id.'%')->get();
        $measurements = Measurement::where('bumblebee_id', 'like', '%'.$bumblebee_id.'%')
            ->where('calibration_value', true)
            ->where('metric', 'like', '%'.$metric.'%')
            ->get();
        return response($measurements, 200);
    }


}
