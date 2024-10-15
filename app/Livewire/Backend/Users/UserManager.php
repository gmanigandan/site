<?php

namespace Victorybiz\LaravelTelInput;
namespace App\Livewire\Backend\Users;
use Livewire\Attributes\Validate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Backend\User;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class UserManager extends Component
{
    public $id;
    
    public $recordRow;
    public $wireKey;
    public $name,$username,$email,$phone,$address,$countryCode;
    public $password, $password_confirmation;
    public $inputs = [];
    public $i = 1;
    public $keywordTitle = []; 
    protected $messages = [
        'keywordTitle.*.required' => 'The keyword field is required.',
    ];
    public function mount(Request $request)
    {
        $this->wireKey = Str::random();
        $this->id = $request->route('id');
        if($request->route('id')){
            $this->checkRowIfExists();
        }
        $this->inputs[] = $this->i; 

    }
    public function addField()
    {
        $rules = [];
        foreach ($this->inputs as $key => $value) {
            $rules['keywordTitle.' . $key ] = 'required|string'; 
       
        }
        $this->validate( $rules);
 
        $this->i++;
        $this->inputs[] = $this->i;
    }

    public function removeField($index)
    {
        unset($this->inputs[$index]);
        unset($this->keywordTitle[$index]); 
        $this->inputs = array_values($this->inputs); 
        $this->keywordTitle = array_values($this->keywordTitle); 
    }

    public function checkRowIfExists()
    {
      
        $recordRow = User::findOrFail($this->id);
        if ($recordRow) {
            $this->recordRow = $recordRow;
            $this->fill($this->recordRow);

        }else{
            session()->flash('error', 'Invalid token! request another reset password link.');
            return redirect()->route('all.users'); 
        } 
    }
    
    protected function rules()
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required|unique:users,phone,' . $this->id,
        ];
        if (!$this->id) {
            $rules['password'] = 'required|min:5|max:45|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'required';
        } else {
            $rules['password'] = 'nullable|min:5|max:45|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'nullable|required_with:password';
        }
        foreach ($this->inputs as $key => $value) {
            $rules['keywordTitle.' . $key ] = 'required|string'; 
        }
        return $rules;
    }
    
    public function updatedPhone()
    {
        $this->dispatch('inputReset');
    }
    public function submit()
    {
        $this->dispatch('inputReset');
        $validatedData = $this->validate();
     
        $data = $this->except(['password']);
        if ($this->id) {
            $this->recordRow->fill($data);
            if (!empty($this->password)) {
                $this->recordRow->password =  Hash::make($this->password);
            }
            $this->recordRow->save();
            session()->flash('message', 'Admin updated successfully.');
        } else {
            $data['password'] = Hash::make($this->password);
            $this->recordRow = User::create($data); 
            session()->flash('message', 'Admin added successfully.');
        }
        return $this->redirect(route('all.admins') , navigate: true);

    }
    public function render()
    {
        return view('livewire.backend.users.user-manager');
    }
}
