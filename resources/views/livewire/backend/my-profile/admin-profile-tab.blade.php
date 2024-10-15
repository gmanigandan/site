<div>

    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3" role="tablist">

            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link {{ $tab == 'personalDetails' ? 'active' : '' }}" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                    aria-selected="false" tabindex="-1" wire:click.prevent='selectTab("personalDetails")'>Profile Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link {{ $tab == 'updatePassword' ? 'active' : '' }}" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-top-password" aria-controls="navs-pills-top-password"
                    aria-selected="false" tabindex="-1" wire:click.prevent='selectTab("updatePassword")'>Change Password</button>
            </li>
        </ul>
        <div class="tab-content">
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
            <div class="tab-pane {{ $tab == 'personalDetails' ? 'active show' : '' }}" id="navs-pills-top-profile" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-body">
                        <form wire:submit.prevent='updateAdminPersonalDetails()'  >
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label  class="form-label">Name</label>
                                    <input type="text" class="form-control" wire:model='name' placeholder="John Doe" aria-describedby="defaultFormControlHelp">
                                    @error('name')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label   class="form-label">Email</label>
                                    <input type="text" class="form-control"  wire:model="email"  placeholder="John@gmail.com" aria-describedby="defaultFormControlHelp">
                                    @error('email')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control"  wire:model="username"  placeholder="johndoe" aria-describedby="defaultFormControlHelp">
                                    @error('username')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                  </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'updatePassword' ? 'active show' : '' }}" id="navs-pills-top-password" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-body">
                        <form wire:submit.prevent='updatePassword()'  >
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label  class="form-label">Current Password</label>
                                    <input type="password" class="form-control"  wire:model="current_password" placeholder="Current Password" aria-describedby="defaultFormControlHelp">
                                    @error('current_password')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label  class="form-label">New Password</label>
                                    <input type="password" class="form-control"  wire:model="new_password" placeholder="New Password" aria-describedby="defaultFormControlHelp">
                                    @error('new_password')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label  class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control"  wire:model="new_password_confirmation" placeholder="Confirm New Password" aria-describedby="defaultFormControlHelp">
                                    @error('new_password_confirmation')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
