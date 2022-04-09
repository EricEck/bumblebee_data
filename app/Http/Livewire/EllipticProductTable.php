<?php

namespace App\Http\Livewire;

use App\Models\EllipticProduct;
use Livewire\Component;
use Livewire\WithPagination;

class EllipticProductTable extends Component
{
    use WithPagination;

    public $ellipticProducts;
    public $productsPerPage = 15;

    public function mount(){
        $this->ellipticProducts = EllipticProduct::query()
            ->where('id' ,'>', 0)
            ->orderBy('id', 'asc')
            ->get();
//            ->paginate($this->productsPerPage);
    }

    public function render()
    {
        return view('livewire.elliptic-product-table');
    }

}
