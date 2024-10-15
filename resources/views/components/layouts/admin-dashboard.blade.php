<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $meta_title ?? 'RadioQuery' }}</title>

    <meta name="description" content="{{ $meta_description ?? 'RadioQuery' }}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'RadioQuery' }}">
    <!-- BEGIN: Theme CSS-->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />


    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/ijaboCropTool/ijaboCropTool.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/toastr/toastr.min.css') }}" />


    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.css') }}" />


    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/fileinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    @livewireScripts
    <!-- laravel style -->
    <script src="{{ asset('backend/assets/vendor/js/helpers.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('backend/assets/js/config.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- BEGIN: Vendor JS-->



    <style>
        .sweet-alert-container {
            z-index: 9999;
            /* Adjust the z-index as needed */
        }


        .tox-dialog__disable-scroll .offcanvas {
            visibility: hidden !important;
        }

        /* Custom CSS for large offcanvas */
        .offcanvas-xl-x {
            width: 90% !important;
            max-width: 100%;
        }

        .offcanvas-lg-x {
            width: 75% !important;
            max-width: 100%;
        }

        .offcanvas-md-x {
            width: 50% !important;
            max-width: 100%;
        }

        .full-page-loader {
            position: fixed;
            /* or absolute, depending on your layout */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Semi-transparent background */
            display: flex;
            /* Center the spinner */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            z-index: 9999;
            /* High z-index to ensure it covers everything */
            display: none;
            /* Hide by default */
        }

        .full-page-loader.show {
            display: flex;
            /* Show when active */
        }
    </style>

@laravelTelInputStyles
</head>

<body>
    <div class="layout-wrapper layout-content-navbar {{ true ? '' : 'layout-without-menu' }}">
        <div class="layout-container">
            @livewire(Backend\Header::class)
            <div class="layout-page">
                @livewire(Backend\Nav::class)
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{ $slot }}
                    </div>
                    @livewire(Backend\Footer::class)
                </div>

            </div>
        </div>
        <!-- / Layout page -->
    </div>

    <script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/js/cards-actions.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/themes/fa5/theme.min.js') }}"></script>

    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>



    <script></script>

    <script src="{{ asset('backend/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('updteAdminInfo', (event) => {
                console.log(event[0].adminName);
                //    $('#adminProfileName').html(event[0].adminName);
                //    $('#adminProfileEmail').html(event[0].adminEmail);
            });
        });
        document.addEventListener('livewire:load', function() {
            console.log('Script loaded 11dddd 1');
            Livewire.on('flash-message', event => {
                Swal.fire({
                    icon: event.type,
                    title: 'Success!',
                    text: event.message,
                    showConfirmButton: true,
                    timer: 3000 // Automatically closes after 3 seconds
                });
            });
        });
    </script>
    @stack('scripts')
    @laravelTelInputScripts
</body>

</html>
