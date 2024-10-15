<?php

namespace App\Livewire\Backend\Auth;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
#[Layout('components.layouts.backend')] 
class Login extends Component
{
    public $form = [
        'email'   => '',
        'password'=> '',
        'remember_me' => ''
    ];
 
    public function render()
    {
        $metaTitle = 'Radioquery Login';
        $metaDescription = 'Radioquery Login';
        $metaKeywords = 'Radioquery Login';
        // return view('livewire.backend.auth.login')->layout('components.layouts.backend'); or
        return view('livewire.backend.auth.login')->layoutData([
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ]);
    }
    public function submit()
    {
     
        $fieldType = filter_var($this->form['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType == 'email') {
            $this->validate([
                'form.email' => 'required|email|exists:admins,email',
                'form.password' => 'required'
            ], [
                'form.email.required' => 'Email or Username is required',
                'form.email.email' => 'Invalid email address',
                'form.email.exists' => 'Email is not exists in our system',
                'form.password.required' => 'Password is required'
            ]);
        } else {
            $this->validate([
                'form.email' => 'required|exists:admins,username',
                'form.password' => 'required|min:5|max:45'
            ], [
                'form.email.required' => 'Email or Username is required',
                'form.email.exists' => 'Username is not exists in our system',  
                'form.password.required' => 'Password is required'
            ]);
        }
        $creds = [$fieldType => $this->form['email'], 'password' => $this->form['password']];
        $remember_me = $this->form['remember_me'] ? true : false;
 
        if (Auth::guard('admin')->attempt($creds, $remember_me)) {
            return redirect()->route('dashboard');
        } else {
            throw ValidationException::withMessages([
                'form.email' => __('The provided credentials are incorrect.'),
            ]);
        }
      
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Successfully logged out.');
    }
}
