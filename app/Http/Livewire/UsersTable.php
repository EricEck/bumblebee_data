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
            'users' => User::searchView($this->searchString)
                ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc')
                ->paginate($this->usersPerPage)]);
    }

//    public $likes = 0;
//
//    public function like()
//    {
//        $this->likes++;
//        debugbar()->info('Liked '.$this->likes);
//
//    }

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
