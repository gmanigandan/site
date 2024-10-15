<div>
    <h4 class="py-3 mb-4">
        Settings
    </h4>
    <div class="row g-2">
        <div class="col-12 col-lg-2">
            <div class="d-flex justify-content-between flex-column mb-3 mb-md-0">
                <ul class="nav nav-align-left nav-pills flex-column">
                    <li class="nav-item mb-1">
                        <button type="button" wire:click.prevent='selectTab("GeneralSettings")'
                            class="nav-link {{ $tab == 'GeneralSettings' ? 'active' : '' }}" role="tab"
                            data-bs-toggle="tab" data-bs-target="#GeneralSettings" aria-controls="GeneralSettings"
                            aria-selected="false" tabindex="-1"> <i class="bx bx-store me-2"></i>
                            <span class="d-none d-sm-block"> General Settings</span>
                        </button>

                    </li>
                    <li class="nav-item mb-1">
                        <button type="button" wire:click.prevent='selectTab("LogoFavicon")'
                            class="nav-link {{ $tab == 'LogoFavicon' ? 'active' : '' }}" role="tab"
                            data-bs-toggle="tab" data-bs-target="#LogoFavicon" aria-controls="LogoFavicon"
                            aria-selected="false" tabindex="-1">
                            <i class="bx bx-image me-2"></i>
                            <span class="d-none d-sm-block">Logo & Favicon</span>
                        </button>

                    </li>
                    <li class="nav-item mb-1">
                        <button type="button" wire:click.prevent='selectTab("SocialNetworks")'
                            class="nav-link {{ $tab == 'SocialNetworks' ? 'active' : '' }}" role="tab"
                            data-bs-toggle="tab" data-bs-target="#SocialNetworks" aria-controls="SocialNetworks"
                            aria-selected="false" tabindex="-1"> <i class="bx bx-link me-2"></i>
                            <span class="d-none d-sm-block">Social Networks</span>
                        </button>
                    </li>
                    {{-- <li class="nav-item mb-1">
                        <button type="button" wire:click.prevent='selectTab("PaymentMethods")'
                            class="nav-link {{ $tab == 'PaymentMethods' ? 'active' : '' }}" role="tab"
                            data-bs-toggle="tab" data-bs-target="#PaymentMethods" aria-controls="PaymentMethods"
                            aria-selected="false" tabindex="-1"> <i class="bx bx-dollar-circle me-2"></i>
                            <span class="d-none d-sm-block">Payment Methods</span>
                        </button>
                    </li> --}}
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-10  pt-lg-0">
            <div class="tab-content pt-0">
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
                <div class="tab-pane {{ $tab == 'GeneralSettings' ? 'active show' : '' }}" id="GeneralSettings"
                    role="tabpanel">
                    <form wire:submit.prevent='updateGeneralSettings()'>
                        <div class="card mb-4">

                            <div class="card-body">
                                <div class="row mb-3 g-3">
                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Site Name</label>
                                        <input type="text" class="form-control" wire:model.defer='site_name'
                                            placeholder="Enter your site name">
                                        @error('site_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Site Email</label>
                                        <input type="text" class="form-control" wire:model.defer='site_email'
                                            placeholder="Enter your site email">
                                        @error('site_email')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Site Phone</label>
                                        <input type="text" class="form-control" wire:model.defer='site_phone'
                                            placeholder="Enter your site phone">
                                        @error('site_phone')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Site Address</label>
                                        <textarea class="form-control" cols="2" rows="2" wire:dirty.class="form-control-warning"
                                            placeholder="Site Address " wire:model.defer='site_address'></textarea>
                                        @error('site_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Meta Title</label>
                                        <textarea class="form-control" cols="2" rows="2" wire:dirty.class="form-control-warning"
                                            placeholder="Site Meta Title" wire:model.defer='site_meta_title'></textarea>
                                        @error('site_meta_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Meta Keywords
                                            Seperated by comma(,)</label>
                                        <textarea class="form-control" cols="2" rows="2" wire:dirty.class="form-control-warning"
                                            placeholder="Site Meta Keywords" wire:model.defer='site_meta_keywords'></textarea>
                                        @error('site_meta_keywords')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12"><label class="form-label mb-0">Meta
                                            Description</label>
                                        <textarea class="form-control" cols="2" rows="2" wire:dirty.class="form-control-warning"
                                            placeholder="Site Meta Description" wire:model.defer='site_meta_description'></textarea>
                                        @error('site_meta_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" class="btn btn-label-secondary">Discard</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>

                </div>
                <div class="tab-pane fade {{ $tab == 'LogoFavicon' ? 'active show' : '' }} " id="LogoFavicon"
                    role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <h5>Site Logo</h5>
                                    <div class="mb-2 mt-1" style="max-width: 200px;">
                                        <img wire:ignore
                                            src="{{ File::exists('storage/uploads/images/' . $site_logo) ? asset('storage/uploads/images/' . $site_logo) : '' }}"
                                            alt="" class="img-thumbnail" id="site_logo_img">
                                    </div>
                                    <form wire:submit.prevent='updateLogo()'>
                                        <div class="form-group mb-2" wire:dirty.remove>
                                            <input type="file" wire:model="site_logo" class="form-control"
                                                id="site_logo">
                                            @error('site_logo')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Logo</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <h5>Site Favicon</h5>
                                    <div class="mb-2 mt-1" style="max-width: 200px;">
                                        <img wire:ignore
                                            src="{{ File::exists('storage/uploads/images/' . $site_favicon) ? asset('storage/uploads/images/' . $site_favicon) : '' }}"
                                            alt="" class="img-thumbnail" id="site_favicon_img">
                                    </div>
                                    <form wire:submit.prevent='updateFavicon()'>
                                        <div class="form-group mb-2">
                                            <input type="file" wire:model="site_favicon" id="site_favicon"
                                                accept="image/png, image/gif, image/jpeg" class="form-control">
                                            @error('site_favicon')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Favicon</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ $tab == 'SocialNetworks' ? 'active show' : '' }}" id="SocialNetworks"
                    role="tabpanel">
                    <form wire:submit.prevent='updateSocialNetworks()'>
                        <div class="card mb-4">

                            <div class="card-body">
                                <div class="row mb-3 g-3">
                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Facebook URL</label>
                                        <input type="text" class="form-control" wire:model.defer='facebook_url'
                                            placeholder="Enter Facebook URL">
                                        @error('facebook_url')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Twitter URL</label>
                                        <input type="text" class="form-control" wire:model.defer='twitter_url'
                                            placeholder="Enter Twitter URL">
                                        @error('twitter_url')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Youtube URL</label>
                                        <input type="text" class="form-control" wire:model.defer='youtube_url'
                                            placeholder="Enter Youtube URL">
                                        @error('youtube_url')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6"><label class="form-label mb-0">Linkedin URL</label>
                                        <input type="text" class="form-control" wire:model.defer='linkedin_url'
                                            placeholder="Enter Linkedin URL">
                                        @error('linkedin_url')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" class="btn btn-label-secondary">Discard</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>
                </div>
                <div class="tab-pane fade {{ $tab == 'PaymentMethods' ? 'active show' : '' }}" id="PaymentMethods"
                    role="tabpanel">
                    Payment Methods Soon...
                </div>

            </div>

        </div>
    </div>
</div>
