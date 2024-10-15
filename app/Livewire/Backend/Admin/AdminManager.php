<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Attributes\Validate;
use Illuminate\Http\Request;
use App\Models\Backend\Admin; 
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
#[Layout('components.layouts.admin-dashboard')] 
class AdminManager extends Component
{
    public $id;
    #[Validate('image|mimes:jpeg,png,jpg,gif|max:1024')]
    public $photo_file;
    public $admin;
    public $wireKey;
    public $name,$username,$email,$phone,$address;
    public $password, $password_confirmation;
    public $role = '';

    public function mount(Request $request)
    {
        $this->wireKey = Str::random();
        $this->id = $request->route('id');
        if($request->route('id')){
            $this->checkRowIfExists();
        }

    }
    public function checkRowIfExists()
    {
      
        $admin = Admin::findOrFail($this->id);
        if ($admin) {
            $this->admin = $admin;
            $this->fill($this->admin);
            if($this->admin->getRoleNames()->first()){
                $this->role = Role::where('name', $this->admin->getRoleNames()->first())->first()->id;
            }
        }else{
            session()->flash('error', 'Invalid token! request another reset password link.');
            return redirect()->route('all.admins'); // Same as above
        } 
    }
    public function submit()
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:admins,email,' . $this->id,
            'username' => 'required|min:3|unique:admins,username,' . $this->id,
            'role' => 'required'
        ];
        if (!$this->id) {
            $rules['password'] = 'required|min:5|max:45|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'required';
        } else {
            $rules['password'] = 'nullable|min:5|max:45|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'nullable|required_with:password';
        }
        $this->validate($rules);
        $data = $this->except(['password']);
        if ($this->id) {
            $this->admin->fill($data);
            if (!empty($this->password)) {
                $this->admin->password =  Hash::make($this->password);
            }
            $this->admin->save();
            session()->flash('message', 'Admin updated successfully.');
        } else {
            $data['password'] = Hash::make($this->password);
            $this->admin = Admin::create($data); 
            session()->flash('message', 'Admin added successfully.');
      
        }
        if($this->role){
            $role = Role::find($this->role);
            if ($role) {
                $this->admin->syncRoles($role); // Sync the role with the admin user
            }
        }
        return $this->redirect(route('all.admins') , navigate: true);
      

    }
    public function render()
    {
        $roles = Role::all();
        return view('livewire.backend.admin.admin-manager', compact("roles"));
    }
}
