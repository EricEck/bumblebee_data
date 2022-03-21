<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ContactModal extends Modal
{
    public User $user;

    public function mount(){
        debugbar()->info("Modal Mount");
        $this->user = new User;
        $this->user->name = "Test Subject";
    }

    public function render()
    {
        debugbar()->info("Modal Render");
        debugbar()->info($this->user->attributesToArray());
        return view('livewire.contact-modal',[
            "text" => "a through some data",
        ]);
    }

    public function clicked(){
        debugbar()->info('click');
    }
}
