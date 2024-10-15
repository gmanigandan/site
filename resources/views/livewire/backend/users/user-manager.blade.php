<div>
    <div class="card mb-4">
        <h5 class="card-header">User Details</h5>
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
                            <input type="file" wire:model.lazy="form.photo_file" id="upload"
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
                        <input class="form-control" type="text" wire:model.lazy="name" placeholder="Name">
                        @error('name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control" type="text" wire:model.lazy="email" placeholder="Email">
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="phone" class="form-label">Phone</label>

                        <input type="hidden" name="phone" autocomplete="off">
                     
                        <span wire:ignore>
                            <input type="tel" class="  form-control "
                                id="phone" data-phone-input-name="phone"
                                data-phone-input="phone" wire:model="phone"
                                phone-country-input="#countryCode" autocomplete="off">
                        </span>
                        <input wire:model="countryCode" type="hidden" id="countryCode" name="countryCode">

                      
                        <div>
                            <strong>Phone:</strong> {{ $phone }} <br>
                            <strong>Country Code:</strong> {{ $countryCode }}
                        </div>

                        @error('phone')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" wire:model.lazy="password"
                            placeholder="New Password" aria-describedby="defaultFormControlHelp">
                        @error('password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" wire:model.lazy="password_confirmation"
                            placeholder="Confirm New Password" aria-describedby="defaultFormControlHelp">
                        @error('password_confirmation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3 col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" wire:model.lazy="address" placeholder="Address">
                        @error('address')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>





                </div>


                <div class="my-4">
                    <h6>Search Keywords</h6>
                    <hr class="my-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th>Keyword</th>
                                <th>
                                    <button class="btn btn-primary btn-sm" wire:click.prevent="addField">
                                        <i class="bx bx-plus"></i> Add Keyword
                                        <div wire:loading wire:target="addField">
                                            <i class="bx bx-loader bx-spin"></i>
                                        </div>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inputs as $key => $value)
                                <tr>


                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model="keywordTitle.{{ $key }}" placeholder="Enter keyword">
                                        @error('keywordTitle.' . $key)
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    @if ($key != '0')
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                                wire:click.prevent="removeField({{ $key }})"> <i
                                                    class="bx bx-trash"></i>
                                                <div wire:loading wire:target="removeField({{ $key }})">
                                                    <i class="bx bx-loader bx-spin"></i>
                                                </div>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save
                        <div wire:loading wire:target="submit">
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('#phone');
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true, // To get only the national number
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Listen for number input changes
        input.addEventListener('input', function () {
            // Get the full number, including the dial code
            const validNumber = iti.getNumber();
            // Get the dial code
            const dialCode = iti.getSelectedCountryData().dialCode;

           
    //         console.log(e.detail.valid); // Boolean: Validation status of the number
    // console.log(e.detail.validNumber); // Returns internationally formatted number if number is valid and empty string if invalid
    // console.log(e.detail.number); // Returns the user entered number, maybe auto-formatted internationally
    // console.log(e.detail.country); // Returns the phone country iso2
    // console.log(e.detail.countryName); // Returns the phone country name
    // console.log(e.detail.dialCode); // Returns the dial code


            // Set values in Livewire
            @this.set('phone', validNumber);
            @this.set('countryCode', dialCode);
        });

        // Listen for country change event
        input.addEventListener('countrychange', function () {
            // Update the country code
            const validNumber = iti.getNumber();
            const dialCode = iti.getSelectedCountryData().dialCode;
            const countryName = iti.getSelectedCountryData().name;
            const country = iti.getSelectedCountryData().iso2;
            console.log(iti.getSelectedCountryData());
            console.log(dialCode);
            console.log(countryName);
            console.log(country);
            // Set the country code in Livewire
            @this.set('countryCode', dialCode);
        });
    });
</script>
@endpush
