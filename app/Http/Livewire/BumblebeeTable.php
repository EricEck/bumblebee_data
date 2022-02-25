<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use Livewire\Component;
use Livewire\WithPagination;

class BumblebeeTable extends Component
{
    use WithPagination; // must add for livewire

    public $bumblebeesPerPage = 15;
    public $searchString = '';
    public $orderAscending = true;
    public $orderBy = 'serial_number';

    /**
     * All Bumblebees Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.bumblebee-table',[
            'bumblebees' => Bumblebee::searchView($this->searchString)
                ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc')
                ->paginate($this->bumblebeesPerPage)]);
    }

    /**
     * Redirect to the Bumblebee Form URL Route to Show Only
     * @param int $bumblebeeID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bumblebeeFormShow(int $bumblebeeID)
    {
        return redirect()->to('/bumblebee_form/show/'.$bumblebeeID);
    }

    /**
     * Redirect to the Bumblebee Form URL Route to Show Only
     * @param int $bumblebeeID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bumblebeeFormEdit(int $bumblebeeID)
    {
        return redirect()->to('/bumblebee_form/edit/'.$bumblebeeID);
    }

    /**
     * Redirect to the Bumblebee Form URL Route to Create a New Bumblebee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bumblebeeFormNew()
    {
        return redirect()->to('/bumblebee_form/new');
    }

}
