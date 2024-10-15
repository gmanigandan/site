<?php

namespace App\Livewire\Backend\MyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Backend\Admin;
use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class Index extends Component
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
        $metaTitle = 'My Profile - '.website_setting('site_name');
        $metaDescription = 'Radioquery My Profile';
        $metaKeywords = 'Radioquery My Profile';
        // return view('livewire.backend.auth.login')->layout('components.layouts.backend'); or
        return view('livewire.backend.my-profile.index')->layoutData([
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ]);
       
    }
}
