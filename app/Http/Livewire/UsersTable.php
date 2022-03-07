<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination; // must add for livewire

    public $usersPerPage = 15;
    public $searchString = '';
    public $orderAscending = true;
    public $orderBy = 'id';

    protected $listeners =[
        'openUserForm' => 'userForm'
    ];

    /**
     * All Users Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.users-table', [
            'users' => $this->renderSearch()]);
    }

    public function renderSearch(){
        return User::searchView($this->searchString)
            ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc')
            ->paginate($this->usersPerPage);
    }

    /**
     * Export currently found Users to Excel
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function excel(){

        return redirect('/export/users/search')->with([
            'searchString' => $this->searchString,
            'orderBy' => $this->orderBy,
            'orderAscending' => $this->orderAscending,
        ]) ;
    }



    /**
     * Redirect to the User Form URL Route to Show Only
     * @param int $userID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userFormShow(int $userID)
    {
        return redirect()->to('/user_form/show/'.$userID);
    }

    /**
     * Redirect to the User Form URL Route to Show Only
     * @param int $userID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userFormEdit(int $userID)
    {
        return redirect()->to('/user_form/edit/'.$userID);
    }
}
