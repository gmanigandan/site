<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Backend\Auth\Login;
use App\Livewire\Backend\Dashboard\Index;
 
use App\Livewire\Backend\Auth\ForgotPassword;
use App\Livewire\Backend\Auth\ResetPassword;
use App\Http\Controllers\Backend\AdminCommonController;
Route::redirect('/', '/admin/login');

 
// Login route for guests
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/login', Login::class)->name('admin.login');
    Route::get('/forgot-password', ForgotPassword::class)->name('admin.forgotpassword');
    Route::get('/password-reset-{token}', ResetPassword::class)->name('admin.resetpassword');
});

// Routes for authenticated users
Route::middleware(['auth:admin'])->group(function () {
    Route::controller(AdminCommonController::class)->group(function () {
        Route::post('/change-profile-photo', 'changeProfilePhoto')->name('change-profile-photo');
    });

    Route::get('/logout', [Login::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', Index::class)->name('dashboard');
    Route::get('/my-profile', App\Livewire\Backend\MyProfile\Index::class)->name('admin.myprofile');
  
    Route::get('/all-permissions', App\Livewire\Backend\Roles\AllPermissions::class)->name('all.permissions')->middleware('can:all.permissions');
    Route::get('/all-roles', App\Livewire\Backend\Roles\AllRoles::class)->name('all.roles')->middleware('can:all.roles');
    Route::get('/all-roles-permissions', App\Livewire\Backend\Roles\AllRolesPermissions::class)->name('all.roles.permissions')->middleware('can:all.roles.permissions');
  

    Route::get('/admin-accounts', App\Livewire\Backend\Admin\Index::class)->name('all.admins')->middleware('can:all.admins');
    Route::get('/edit-admin/{id}', App\Livewire\Backend\Admin\AdminManager::class)->name('edit.admin')->middleware('can:edit.admin');

    Route::get('/add-admin', App\Livewire\Backend\Admin\AdminManager::class)->name('add.admin')->middleware('can:add.admin');

    Route::get('/settings', App\Livewire\Backend\Settings\Index::class)->name('settings')->middleware('can:settings');
    Route::get('/users', App\Livewire\Backend\Users\Index::class)->name('all.users')->middleware('can:users');

    Route::get('/edit-user/{id}', App\Livewire\Backend\Users\UserManager::class)->name('edit.user')->middleware('can:edit.user');

    Route::get('/add-user', App\Livewire\Backend\Users\UserManager::class)->name('add.user')->middleware('can:add.user');
   
});