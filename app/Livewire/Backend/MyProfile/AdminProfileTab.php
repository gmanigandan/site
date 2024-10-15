<?php

namespace App\Livewire\Backend\MyProfile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Backend\Admin;
class AdminProfileTab extends Component
{
    public $tab = null;
    public $tabname = 'personalDetails';
    protected $queryString = ['tab'];
    public $name, $email, $username, $admin_id;
    public $current_password, $new_password, $new_password_confirmation;
    public function selectTab($tab)
    {
        $this->tab = $tab;
    }
    public function mount()
    {
        $this->tab = request()->tab ? request()->tab : $this->tabname;
        if (Auth::guard('admin')) {
            $admin = Admin::findOrFail(auth()->id());
            $this->name = $admin->name;
            $this->email = $admin->email;
            $this->username = $admin->username;
            $this->admin_id = $admin->id;
        }
    }
    public function updateAdminPersonalDetails()
    {
        $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:admins,email,' . $this->admin_id,
            'username' => 'required|min:3|unique:admins,username,' . $this->admin_id
        ]);
        Admin::where('id', $this->admin_id)
            ->update([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username
            ]);
        $this->dispatch('updateAdminHeaderInfo');
          
        session()->flash('success', 'Your personal details saved successfully!');
      
     
         
    }
    public function updatePassword(){
        $this->validate([
            'current_password'  => [
                    'required',function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Admin::find(auth('admin')->id())->password)) {
                            return $fail(__('The curent password is incorrect'));
                        }
                    }],
        'new_password'=> 'required|min:5|max:45|confirmed'
        ]);
        $updRes = Admin::findOrFail(auth('admin')->id())->update([
           'password'=> Hash::make($this->new_password)
        ]);
        if($updRes){
            $this->current_password = $this->new_password = $this->new_password_confirmation = null;
            session()->flash('success', 'Pasword saved successfully!');
        }else{
            session()->flash('error', 'Somthing went wrong!');
     
        }

    }
    public function render()
    {
        return view('livewire.backend.my-profile.admin-profile-tab');
    }
}
