

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img   src="{{  File::exists('storage/uploads/images/'.website_setting('site_logo')) ? asset('storage/uploads/images/'.website_setting('site_logo')) : asset('backend/assets/img/logo/logo.png') }}" alt=""
                class="img-thumbnail" >
                {{-- style="width:40%" --}}
            </span>

        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                </li>
            @else
                {{-- active menu method --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();

                    if ($currentRouteName === $menu->slug || (isset($menu->slug_alias) and  str_contains( $menu->slug_alias,$currentRouteName))) {

                        $activeClass = 'active open';
                    } elseif (isset($menu->submenu)) {

                        if (gettype($menu->submenu) === 'array') {
                            foreach ($menu->submenu as $submenu) {
                                if (str_contains($currentRouteName, $submenu->slug) and strpos($currentRouteName, $submenu->slug) === 0) {
                                    $activeClass = 'active open';

                                }
                            }
                        } else {
                            if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                $activeClass = 'active open';
                            }
                        }
                    }else if (isset($menu->slug_alias) and  str_contains( $menu->slug_alias,$currentRouteName) and strpos($menu->slug_alias,$currentRouteName) !== false) {
                        $activeClass = 'active';
                    }

                @endphp

                {{-- main menu --}}
                @if (!isset($menu->can) || auth()->guard('admin')->user()->can($menu->can))
                <li class="menu-item {{ $activeClass }}">
                    <a  {{ isset($menu->url) ? '' : '' }}  href="{{ isset($menu->url) ? route($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        @isset($menu->badge)
                            <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @isset($menu->submenu)
                        @livewire(Backend\Submenu::class,['menu' => $menu])
                    @endisset
                </li>
                @endif

            @endif
        @endforeach
    </ul>

</aside>


