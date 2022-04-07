<?php

namespace App\Http\Controllers;

use App\Models\BodiesOfWater;
use Illuminate\Http\Request;

class BodiesOfWaterController extends Controller
{

    public function indexView(){
        debugbar()->info('BoW Index');
        return view('bow.index');
    }

    /**
     * Make a new Body of Water
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function bodyOfWaterFormNew(){

        debugbar()->info('BodiesOfWaterController::bodyOfWaterFormNew()');

        $bodyOfWater = new BodiesOfWater();

        return view('bow.body_of_water_form',[
            'allow_edit' => true,
            'create_new' => true,
            'bodyOfWater' => $bodyOfWater,
            'showBack' => false,
        ]);
    }
    public function bodyOfWaterFormEdit(int $bow_id){

        debugbar()->info('BodiesOfWaterController::bodyOfWaterFormEdit()');

        $bodyOfWater = BodiesOfWater::find($bow_id);

        return view('bow.body_of_water_form',[
            'allow_edit' => true,
            'create_new' => false,
            'bodyOfWater' => $bodyOfWater,
            'showBack' => true,
        ]);
    }
    public function bodyOfWaterFormShow(int $bow_id){

        debugbar()->info('BodiesOfWaterController::bodyOfWaterFormShow()');

        $bodyOfWater = BodiesOfWater::find($bow_id);

        return view('bow.body_of_water_form',[
            'showBack'  => true,
            'allow_edit' => false,
            'create_new' => false,
            'bodyOfWater' => $bodyOfWater,
        ]);
    }

}
