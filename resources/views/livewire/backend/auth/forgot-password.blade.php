 

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

              <span class="app-brand-text demo text-body fw-bold">{{ env('APP_NAME', 'radioquery')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Forgot Password? 🔒</h4>
          <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
          <div>
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
        </div>
          <form id="formAuthentication" class="mb-3" wire:submit.prevent='submit()'>
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus  wire:model="form.email">
              @error('form.email') <span class="form-text text-danger">{{ $message }}</span> @enderror
            </div>


            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Send Reset Link</button>
            </div>
          </form>
          <div class="text-center">
            <a href="{{route('admin.login')}}" wire:navigate class="d-flex align-items-center justify-content-center">
              <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
              Back to login
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
</div>
