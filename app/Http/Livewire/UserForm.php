<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;


class UserForm extends Component
{
    public User $user;
    public bool $allow_edit;

    protected $rules =[
        'user.name' => 'required|min:5|max:100',
        'user.email' => 'required|email:rfc,dns',
    ];

//    public $allowEdit = false;

    /**
     * Render the View from the Model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {

       return view('livewire.user-form', [
                'user' => $this->user,
                'allow_edit' => $this->allow_edit,
            ]);
    }

    /**
     * @return void
     */
    public function save()
    {
//        dd($this->user);
        $this->validate();
        $this->user2->save();
        debugbar()->info('saved!');
    }
}
