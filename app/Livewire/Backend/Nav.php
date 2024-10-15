<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Admin;
class Nav extends Component
{
    public $admin;

    public $listeners   = ['updateAdminHeaderInfo' => '$refresh'];
    public function mount(){
        if(Auth::guard('admin')){
            $this->admin = Admin::findOrFail(auth()->id());
        }

    }
    public function render()
    {
        return view('livewire.backend.nav');
    }
}
