<?php

namespace App\Http\Controllers;

use App\Exports\MeasurementsAllExport;
use App\Exports\MeasurementsExport;
use App\Models\BodiesOfWater;
use App\Models\Bumblebee;
use App\Models\Measurement;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class MeasurementController extends Controller
{
    /**
     * VIEW: Show the Measurements Index View
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexView(){
        debugbar()->info('Measurement Index');
        return view('measurements.index');
    }

    public function actualView(){
        debugbar()->info('Actual Measurement Index');
        return view('measurements.actual');
    }

    /**
     * Show all measurements for any body of water
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function measurementBow(){
        return view('measurements.measurement_bow', ['bow_id' => 0]);
    }

    /**
     * Show all measurements for a specific  body of water
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function measurementBowById(int $bow_id){
        return view('measurements.measurement_bow', ['bow_id' => $bow_id]);
    }

    /**
     * Show a summary of current measurements for a specific body of water
     * @param int $bow_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function bowSummaryById(int $bow_id){
        return view('bow.summary', ['bow_id' => $bow_id]);
    }

//    /**
//     * Load the Horizontal Time BoW Measurement View 2
//     * @param Request $request
//     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
//     */
//    public function measurementSearchTable(Request $request){
//        $params = $request->all();
//
//        if(isset($params["bow_id"])) {
//            $bow_id = urldecode($params["bow_id"]);
//
//            if ($bodyOfWater = BodiesOfWater::find($bow_id))
//                return view('measurements.bow', [
//                    'params' => $params]);
//        }
//
//        return view('measurements.bow', [
//            'params' => array()]);
//    }

    /**
     * VIEW: Show the Measurements View for one bumblebee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexViewOneBB($bumblebee_id){

        $bumblebee = Bumblebee::where('id', $bumblebee_id)->first();
        if (!isset($bumblebee)){
            abort(403, 'Bumblebee Unit ID Not Found');
        }

        return view('measurements.one',[
            'bumblebee_select' => $bumblebee,
        ]);
    }

    /**
     * Use CSV as it takes less memory.
     *
     * @TODO Solve 500 Error memory issue for excel
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCSV(){

        return Excel::download(new MeasurementsAllExport,
            'ellipticMeasurements.csv',
            \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export a specific list of Measurements
     *
     * parameters passed via Session and ->with() function
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportSearchCSV(){

//        dd(Session::all());

        $bumblebeeID = \Session::get('bumblebeeID');
        $metric = \Session::get('metric');
        $method = \Session::get('method');
        $types = \Session::get('types');
        $start_datetime = \Session::get('start_datetime');
        $end_datetime = \Session::get('end_datetime');
        $sort_by = \Session::get('sort_by');
        $orderAscending = \Session::get('orderAscending');

        debugbar()->info('exportSearchExcel():');
        debugbar()->info('$start_datetime: '.$start_datetime);
        debugbar()->info('$end_datetime: '.$end_datetime);

        return Excel::download(new MeasurementsExport($bumblebeeID, $metric, $method, $types, $start_datetime, $end_datetime, $sort_by, $orderAscending),
            'ellipticMeasurements.csv',
            \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Display an Existing Measurement
     *
     * @param $measurement_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function measurementFormShow($measurement_id){

        $measurement = Measurement::where('id', $measurement_id)->first();

        return view('measurements.measurement_form', [
            'showBack' => true,
            'measurement' => $measurement,
            'allow_edit' => false,
            'create_new' => false,
        ]);
    }

    /**
     * Create a new Measurement
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function measurementFormNew(){

        debugbar()->info('MeasurementController::measurementFormNew()');

        $measurement = new Measurement([
            'calibration_value' => 1,
            'bumblebee_id' => 0,
            'metric' => '',
            'unit' => '',
            'method' => '',
            'process' => '',
            'details' => '',
            'measurement_timestamp' => Carbon::now()->toDateTimeLocalString(),
        ]);

        debugbar()->info($measurement->attributesToArray());

        return view('measurements.measurement_form',[
            'showBack' => true,
            'allow_edit' => true,
            'create_new' => true,
            'measurement' => $measurement,
            ]);
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
     * Store a newly created measurement in the measurement table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bumblebee_id' => 'string',
            'measurement_timestamp' => 'required',
            'metric_sequence' => 'required|integer',
            'metric' => 'string|required',
            'method' => 'string|required',
            'process' => 'string|required',
            'value' => 'string|required',
            'unit' => 'string|nullable',
            'details' => 'string|nullable',
            'calibration_value' => 'exclude',
            'bodies_of_water_id' => 'string',
            ]);

        if(strlen($request['bumblebee_id'])) {
            $bb = Bumblebee::find($request['bumblebee_id']);
            if (!$bb) {
                return response(['message' => 'Bumblebee unit not found'], 200);
            }
            // Add the current body of water to the measurement if not already assigned/overridden
            if(strlen($request['bodies_of_water_id']) == 0){
                $request['bodies_of_water_id'] = $bb->bodyOfWater()->id;
            }
        }

        $request['calibration_value'] = false;

        // Calibrate the measurement if a calibration is available
        $newMeasurement = Measurement::create($request->all());  // todo: handle the possible failure
        $newMeasurement->calibrate(); // saves the measurement todo: handle the returned potential exception

        return response($newMeasurement);
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

        if(strlen($request['bumblebee_id'])) {
            $bb = Bumblebee::find($request['bumblebee_id']);
            if (!$bb) {
                return response(['message' => 'Bumblebee unit not found'], 200);
            }
            // Add the current body of water to the measurement if not already assigned/overridden
            if(strlen($request['bodies_of_water_id']) == 0){
                $request['bodies_of_water_id'] = $bb->bodyOfWater()->id;
            }
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
