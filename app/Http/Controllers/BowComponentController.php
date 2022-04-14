<?php

namespace App\Http\Controllers;

use App\Models\BodiesOfWater;
use App\Models\BowComponent;
use Illuminate\Http\Request;

class BowComponentController extends Controller
{
    public function bowComponentsListAll(){
        return view('bow_components.index');
    }

    public function bowComponentsList(int $bow_id){
        $bow = BodiesOfWater::find($bow_id);
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

    public function bowComponentShow(int $bow_component_id){

        $bowComponent = BowComponent::find($bow_component_id);
        $bow_id = $bowComponent->bodyOfWater->id;

        return view('bow_components.bow_component_form',[
            'bowComponent' => $bowComponent,
            'bow_id' => $bow_id,
            'showBack' => true,
            'allow_edit' => false,
            'create_new' => false,
        ]);
    }

    public function bowComponentEdit(int $bow_component_id){

        $bowComponent = BowComponent::find($bow_component_id);
        $bow_id = $bowComponent->bodyOfWater->id;

        return view('bow_components.bow_component_form',[
            'bowComponent' => $bowComponent,
            'bow_id' => $bow_id,
            'showBack' => true,
            'allow_edit' => true,
            'create_new' => false,
        ]);
    }
}
