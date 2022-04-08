<?php

namespace App\Http\Controllers;

use App\Models\BodiesOfWater;
use App\Models\BowComponent;
use Illuminate\Http\Request;

class BowComponentController extends Controller
{

    public function bowComponentsList(int $bod_id){
        $bow = BodiesOfWater::find($bod_id);
        if($bow == null) abort(404);    // not found

        return view('bow_components.bow_index', [
            'bow' => $bow,
            'showBack' => true,
        ]);
    }

    public function bowComponentNew(int $bow_id){

        $bowComponent = new BowComponent(["bodies_of_water_id" => $bow_id]);

        return view('bow_components.bow_component_form',[
            'bowComponent' => $bowComponent,
            'bow_id' => $bow_id,
            'showBack' => true,
            'allow_edit' => true,
            'create_new' => true,
        ]);
    }
}
