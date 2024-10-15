<?php

namespace App\Livewire\Backend;

use Livewire\Component;

class Submenu extends Component
{

    public $menu;

    public function mount($menu)
    {
        $this->menu = $menu;
    }
    
    public function render()
    {
        return view('livewire.backend.submenu',['menu' => $this->menu]);
    }
}
