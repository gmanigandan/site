 


 
@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
           
              <span class="app-brand-text demo text-body fw-bold">{{ env('APP_NAME', 'radioquery')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome to {{ env('APP_NAME', 'radioquery')}}! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>
          @if (Session::get('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::get('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
<form id="formAuthentication" class="mb-3" wire:submit.prevent='submit()'>
@csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email or Username</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus  wire:model="form.email">
              @error('form.email') <span class="form-text text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <a href="{{route('admin.forgotpassword')}}" wire:navigate>
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"  wire:model="form.password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

              </div>
              @error('form.password') <span class="form-text text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me"  wire:model="remember_me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>

           
          </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>