<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

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
            'users' => User::search($this->searchString)
                ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc')
                ->paginate($this->usersPerPage)]);
    }

    public function userForm(int $userID)
    {
        $user = User::where('id', $userID)->first();


        return redirect()->to('/user', [
            'user' => User::where('id', $userID)->first(),
        ]);
    }
}
