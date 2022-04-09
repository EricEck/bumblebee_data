<?php

namespace App\Http\Controllers;

use App\Models\EllipticProduct;
use Illuminate\Http\Request;

class EllipticProductController extends Controller
{
    //

    public function ellipticProductsList(){

        return view('elliptic_products.elliptic_products_index', [
            'showBack' => false,
        ]);
    }

    public function ellipticProductNew(){

        $ellipticProduct = new EllipticProduct();

        return view('elliptic_products.elliptic_product_form', [
            'showBack' => false,
            'create_new' => true,
            'allow_edit' => true,
            'ellipticProduct' => $ellipticProduct,
        ]);
    }

    public function ellipticProductShow($id){

        $ellipticProduct = EllipticProduct::find($id);

        if(!$ellipticProduct) abort(403);

        return view('elliptic_products.elliptic_product_form', [
            'showBack' => false,
            'create_new' => false,
            'allow_edit' => false,
            'ellipticProduct' => $ellipticProduct,
        ]);
    }

    public function ellipticProductEdit($id){

        $ellipticProduct = EllipticProduct::find($id);

        if(!$ellipticProduct) abort(403);

        return view('elliptic_products.elliptic_product_form', [
            'showBack' => false,
            'create_new' => false,
            'allow_edit' => true,
            'ellipticProduct' => $ellipticProduct,
        ]);
    }
}
