<ul class="menu-sub">

    @if (isset($menu))
        @foreach ($menu->submenu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $active = 'active open';
                $currentRouteName = Route::currentRouteName();
                // var_dump($currentRouteName);exit;
                if ($currentRouteName === $submenu->slug) {
                    $activeClass = 'active';
                } elseif (isset($submenu->submenu)) {
                    if (gettype($submenu->slug) === 'array') {
                        foreach ($submenu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (
                            str_contains($currentRouteName, $submenu->slug) and
                            strpos($currentRouteName, $submenu->slug) === 0
                        ) {
                            $activeClass = $active;
                        }
                    }
                }
            @endphp
            @if (auth()->guard('admin')->user()->can($submenu->slug))
                <li class="menu-item {{ $activeClass }}">
                    <a {{ isset($submenu->url) ? '' : '' }} href="{{ isset($submenu->url) ? route($submenu->url) : 'javascript:void(0)' }}"
                        class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                        @if (isset($submenu->icon))
                            <i class="{{ $submenu->icon }}"></i>
                        @endif
                        <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                        @isset($submenu->badge)
                            <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}
                            </div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @if (isset($submenu->submenu))
                        @livewire(Backend\Submenu::class, ['menu' => $submenu->submenu])
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>
