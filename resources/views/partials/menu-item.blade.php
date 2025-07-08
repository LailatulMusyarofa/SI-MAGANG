@php
    $hasChildren = !empty($menuItem->children) && count($menuItem->children) > 0;
    $menuSlug = Str::slug($menuItem->name);
    $maxDepth = 3;
    //$loggedUser = Auth::user();
    
    //$checkMasterSekolah = DB::table('master_sklh')->where('id_user', $loggedUser->id)->get();
    //dd($checkMasterSekolah);

    // Fungsi untuk mengecek active state
    $isMenuActive = function($item) use (&$isMenuActive) {
        if (request()->routeIs($item->url)) {
            return true;
        }

        if (isset($item->children)) {
            foreach ($item->children as $child) {
                if ($isMenuActive($child)) {
                    return true;
                }
            }
        }
        return false;
    };

    $isActive = $isMenuActive($menuItem);
@endphp

<li class="nav-item {{ $hasChildren ? 'dropdown' : '' }}">
    @if($hasChildren)
        <a class="nav-link dropdown-toggle"
           href="#navbar-{{ $menuSlug }}"
           data-bs-toggle="dropdown"
           data-bs-auto-close="false"
           role="button"
           aria-expanded="{{ $isActive ? 'true' : 'false' }}">
            @if($menuItem->icon)
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    @svg($menuItem->icon)
                </span>
            @endif
            <span class="nav-link-title">{{ $menuItem->name }}</span>
        </a>
        <div class="dropdown-menu {{ $isActive ? 'show' : '' }}">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    @foreach($menuItem->children as $childItem)
                        @php
                            $isChildActive = $isMenuActive($childItem);
                            $hasGrandchildren = isset($childItem->children) && count($childItem->children) > 0;
                        @endphp

                        @if($hasGrandchildren)
                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle"
                                   href="#sidebar-{{ Str::slug($childItem->name) }}"
                                   data-bs-toggle="dropdown"
                                   data-bs-auto-close="false"
                                   role="button"
                                   aria-expanded="{{ $isChildActive ? 'true' : 'false' }}">
                                    {{ $childItem->name }}
                                </a>
                                <div class="dropdown-menu {{ $isChildActive ? 'show' : '' }}">
                                    @foreach($childItem->children as $grandChild)
                                        <a class="dropdown-item {{ $isMenuActive($grandChild) ? 'fw-bold active' : '' }}"
                                           href="{{ $grandChild->url ? route($grandChild->url) : '#' }}">
                                            {{ $grandChild->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a class="dropdown-item {{ $isChildActive ? 'fw-bold active' : '' }}"
                               href="{{ $childItem->url ? route($childItem->url) : '#' }}">
                                {{ $childItem->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <a class="nav-link {{ $isActive ? 'fw-bold active' : '' }}"
           href="{{ $menuItem->url ? route($menuItem->url) : '#' }}">
            @if($menuItem->icon)
                <span class="nav-link-icon d-md-none d-lg-inline-block color-black">
                    @svg($menuItem->icon)
                </span>
            @endif
            <span class="nav-link-title">{{ $menuItem->name }}</span>
        </a>
    @endif
</li>
