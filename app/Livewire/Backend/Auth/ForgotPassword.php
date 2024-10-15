<?php

namespace App\Livewire\Backend\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Mail\Backend\AdminForgotMail;
use DB; 
use Carbon\Carbon; 
use App\Models\Backend\Admin; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
#[Layout('components.layouts.backend')] 
class ForgotPassword extends Component
{
    public $form = [
        'email'   => '',
       
    ];
    public function render()
    {
        $metaTitle = 'Radioquery Forgot Password';
        $metaDescription = 'Radioquery Forgot Password';
        $metaKeywords = 'Radioquery Forgot Password';
        // return view('livewire.backend.auth.login')->layout('components.layouts.backend'); or
        return view('livewire.backend.auth.forgot-password')->layoutData([
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ]);
       
    }
    public function submit()
    {
        $fieldType = filter_var($this->form['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $this->validate([
            'form.email' => 'required|email|exists:admins,email',
        ], [
            'form.email.required' => 'Email  is required',
            'form.email.email' => 'Invalid email address',
            'form.email.exists' => 'Email is not exists in our system',
         
        ]);
        $token = Str::random(64);
        $admin = Admin::where('email', $this->form['email'])->first();
        $oldToken = DB::table('password_reset_tokens')->where(['email' => $this->form['email']])->first();
        if ($oldToken) {
            DB::table('password_reset_tokens')->where(['email' => $this->form['email']])->update(['token' => $token,'guard' => 'admin', 'created_at' => Carbon::now()]);
        } else {
            DB::table('password_reset_tokens')->insert(['email' => $this->form['email'], 'token' => $token,'guard' => 'admin', 'created_at' => Carbon::now()]);
        }


        $reset_link = route('admin.resetpassword', ['token' => $token]);
 
        Mail::to($admin->email)->send(new AdminForgotMail($admin,$reset_link));
        session()->flash('success', 'We have e-mailed your reset password link');
       
        
      
    }
}
