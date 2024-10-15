<?php

namespace App\Livewire\Backend\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Http\Request;
use DB; 
use Carbon\Carbon;
use constDefaults;
use App\Models\Backend\Admin; 
use Hash;
#[Layout('components.layouts.backend')] 
class ResetPassword extends Component
{
    public $token;
    public $form = [
        'new_password'   => '',
        'new_password_confirmation'=> '',
       
    ];
    public function mount(Request $request)
    {
        $this->token = $request->route('token');
        $this->checkToken();
    }
    public function checkToken()
    {
        $checkToken = DB::table('password_reset_tokens')->where(['token' => $this->token, 'guard' => 'admin'])->first();

        if ($checkToken) {
            $diffInMin = Carbon::createFromFormat('Y-m-d H:i:s', $checkToken->created_at)->diffInMinutes(Carbon::now());

            if ($diffInMin > constDefaults::tokensExpiredMinutes) {
                session()->flash('error', 'Token Expired! request another reset password link.');
                return redirect()->route('admin.forgotpassword'); // Removed ['token' => $token] as it is not defined here
            }
        } else {
            session()->flash('error', 'Invalid token! request another reset password link.');
            return redirect()->route('admin.forgotpassword'); // Same as above
        }
    }

    public function render()
    {

        $metaTitle = 'Radioquery Reset Password';
        $metaDescription = 'Radioquery Reset Password';
        $metaKeywords = 'Radioquery Reset Password';
        return view('livewire.backend.auth.reset-password')->layoutData([
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ]);
 
    }
    public function submit()
    {

        $this->validate([
            'form.new_password' => 'required|min:5|max:45|required_with:form.new_password_confirmation|same:form.new_password_confirmation',
            'form.new_password_confirmation' => 'required',
        ], [
            'form.new_password.required' => 'New password is required.',
            'form.new_password.min' => 'New password must be at least :min characters.',
            'form.new_password.max' => 'New password must not exceed :max characters.',
            'form.new_password.required_with' => 'New password confirmation is required when entering a new password.',
            'form.new_password_confirmation.required' => 'Confirm password is required.',
            'form.new_password.same' => 'New password and confirmation must match.',
        ]);
        $token = DB::table('password_reset_tokens')->where(['token' => $this->token, 'guard' => 'admin'])->first();
        if ($token) {
            $diffInMin = Carbon::createFromFormat('Y-m-d H:i:s', $token->created_at)->diffInMinutes(Carbon::now());
            if ($diffInMin > constDefaults::tokensExpiredMinutes) {
                session()->flash('error', 'Token Expired! request another reset password link.');
                return redirect()->route('admin.forgotpassword'); 
            }
        } else {
            session()->flash('error', 'Invalid token! request another reset password link.');
            return redirect()->route('admin.forgotpassword');
        }
        $admin = Admin::where('email', $token->email)->first();
        Admin::where('email', $admin->email)->update(['password' => Hash::make($this->form['new_password'])]);
        DB::table('password_reset_tokens')->where(['email' => $admin->email, 'token' => $this->token])->delete();
        return redirect()->route('admin.login')->with('success', 'Your password has been changed. Use new password to login into system');
      
    }
}
