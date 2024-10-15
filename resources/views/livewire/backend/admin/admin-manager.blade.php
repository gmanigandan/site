<div>
    <div class="card mb-4">
        <h5 class="card-header">Admin Details</h5>
        <!-- Account -->
        <form wire:submit.prevent='submit()'>
            {{-- <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">

                    <div wire:key="{{ $wireKey ?? 'default' }}">

                        @if (isset($form['photo_file']) && $form->photo_file != '' && !$errors->has('form.photo_file'))
                            <img wire:ignore.self wire:loading.remove height="100" width="100"class="d-block rounded-pill"
                            src="{{ $form->photo_file->temporaryUrl() }}"  wire:key="{{ $form->photo_file->temporaryUrl() ?? 'default-img'}}">
                            <span wire:loading wire:target="form.photo_file">Uploading...</span>
                        @elseif (isset($form['photo_file']) && $form->photo)
                            <img wire:ignore.self height="100" width="100" class="d-block rounded-pill" src="{{ $form->photo }}?{{ time() }}">
                        @endif
                    </div>



                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo </span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" wire:model.defer="form.photo_file" id="upload"
                                class="account-file-input" hidden="">
                        </label>
                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4" wire:click="resetImage">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                        </button>

                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        @error('form.photo_file')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div> --}}
            <hr class="my-0">
            <div class="card-body">


                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" wire:model="name" placeholder="Name">
                        @error('name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input class="form-control" type="text" wire:model.defer="username"
                            placeholder="Username">
                        @error('username')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" wire:model="password"
                            placeholder="New Password" aria-describedby="defaultFormControlHelp">
                        @error('password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" wire:model="password_confirmation"
                            placeholder="Confirm New Password" aria-describedby="defaultFormControlHelp">
                        @error('password_confirmation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control" type="text" wire:model.defer="email" placeholder="Email">
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" wire:model.defer="phone" placeholder="Phone">
                        @error('phone')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" wire:model.defer="address"
                            placeholder="Address">
                        @error('address')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3 col-md-6">

                        <label for="role" class="form-label">Role Name</label>
                        <select wire:model.defer="role" class="select2 form-select">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $admin && $admin->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save
                        <div wire:loading>
                            <i class="bx bx-loader bx-spin"></i>
                        </div>
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                </div>

            </div>
        </form>
        <!-- /Account -->
    </div>
</div>
