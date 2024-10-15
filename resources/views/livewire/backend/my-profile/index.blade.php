<div>
    <h4 class="py-3 mb-4">
        My Profile
    </h4>


    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">

            <div class="card mb-4">

                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ $admin->photo }}" alt="user-avatar" class="d-block rounded-pill" height="150"  width="150" id="uploadedAvatar" />
                        <div class="button-wrapper">

                            <label for="adminProfilePhotoFile" class="badge badge-center rounded-pill bg-primary me-2 mb-4" tabindex="0" wire:ignore>
                                <i class="bx bx-edit"></i>
                                <input type="file" id="adminProfilePhotoFile" name="adminProfilePhotoFile"  class="account-file-input" hidden accept="image/png, image/jpeg" />
                            </label>
                            <span class="fw-medium d-block" id="adminProfileName">{{ $admin->name }}</span>
                            <small class="text-muted" id="adminProfileEmail">{{ $admin->email }}</small>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-xl-8 col-lg-7 col-md-7">

            @livewire('backend.my-profile.admin-profile-tab')

        </div>

    </div>

</div>
@push('scripts')
<script>
    function initializeIjaboCropTool() {
        console.log('Initializing ijaboCropTool');

        // Ensure the element exists
        let fileInput = $('#adminProfilePhotoFile');

        if (fileInput.length > 0 && typeof fileInput.ijaboCropTool === 'function') {
            fileInput.ijaboCropTool({
                preview: '#uploadedAvatar',
                setRatio: 1,
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                buttonsText: ['CROP', 'QUIT'],
                buttonsColor: ['#30bf7d', '#ee5155', -15],
                processUrl: '{{ route('change-profile-photo') }}',
                withCSRF: ['_token', '{{ csrf_token() }}'],
                onSuccess: function(message, element, status) {
                    Livewire.dispatch('updateAdminHeaderInfo');
                    toastr.success(message);
                },
                onError: function(message, element, status) {
                    toastr.error(message);
                }
            });
        } else {
            console.error('ijaboCropTool plugin is not available or file input not found');
        }
    }

    // Ensure jQuery and the plugin are loaded and trigger initialization
    function reinitializeCropToolAfterLivewire() {
        if (typeof $ !== 'undefined' && $.fn.ijaboCropTool) {
            initializeIjaboCropTool();
        } else {
            console.error('jQuery or ijaboCropTool not loaded');
        }
    }

    // Trigger on initial DOMContentLoaded and Livewire events
    document.addEventListener('DOMContentLoaded', reinitializeCropToolAfterLivewire);
    document.addEventListener('livewire:load', function() {
        setTimeout(reinitializeCropToolAfterLivewire, 500); // Add delay for DOM update
    });
    document.addEventListener('livewire:navigate', function() {
        setTimeout(reinitializeCropToolAfterLivewire, 500); // Add delay for DOM update
    });
</script>
@endpush
