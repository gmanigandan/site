 
 
<div>
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
           
              <span class="app-brand-text demo text-body fw-bold">{{env('APP_NAME', 'radioquery')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Reset Password 🔒</h4>
         
          <form id="formAuthentication" class="mb-3" wire:submit.prevent='submit()'>
@csrf

<div class="mb-3">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" autofocus wire:model="form.new_password">
              @error('form.new_password') <div class="form-text text-danger">{{ $message }}</div>  @enderror
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" wire:model="form.new_password_confirmation" placeholder="Re-Type New Password" autofocus>
                @error('form.new_password_confirmation') <div class="form-text text-danger">{{ $message }}</div>  @enderror
              </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
            </div>
          </form>
          
        </div>
      </div>
    </div>
   
  </div>
</div>
</div>
</div>
