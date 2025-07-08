<x-app-layout pageTitle="Menu">
    <x-page-header>
        <!-- Breadcrumb -->
        <x-breadcrumb pageTitle="Menu"></x-breadcrumb>
        <!-- Page action -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <button class="btn btn-flex btn-primary h-40px fs-7 fw-bold"
                    onclick="addForm(`{{ route('menu.store') }}`, 'Tambah Menu')" data-bs-toggle="modal"
                    data-bs-toggle="modal" data-bs-target="#MenuModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-2">
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tambah Menu
                </button>
            </div>
        </div>
    </x-page-header>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-2">
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Struktur Menu</h4>
                        </div>
                        <div class="card-body">
                            <div id="menu-structure">
                                <ul class="tree">
                                    @if (session()->has('sidebar_sess'))
                                        @php
                                            function renderMenu($menus)
                                            {
                                                $html = '';
                                                foreach ($menus as $menu) {
                                                    $hasChildren =
                                                        !empty($menu->children) && count($menu->children) > 0;

                                                    $html .= '<li>';
                                                    $html .=
                                                        '<span class="menu-item' .
                                                        ($hasChildren ? ' toggle' : '') .
                                                        '">';
                                                    $html .=
                                                        '<i class="mdi ' .
                                                        ($menu->icon ?? '') .
                                                        '"></i> ' .
                                                        ($menu->name ?? '');
                                                    $html .= '</span>';

                                                    if ($hasChildren) {
                                                        $html .= '<ul>';
                                                        $subMenus = array_map(function ($subMenu) {
                                                            return $subMenu;
                                                        }, $menu->children);
                                                        $html .= renderMenu($subMenus);
                                                        $html .= '</ul>';
                                                    }

                                                    $html .= '</li>';
                                                }
                                                return $html;
                                            }
                                        @endphp
                                        {!! renderMenu(session('sidebar_sess')) !!}
                                    @else
                                        <p class="text-muted">Tidak ada menu yang tersedia.</p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card p-2">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-vcenter card-table'], true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.menu.modal')
    @push('styles')
        <style>
            .tree,
            .tree ul {
                list-style: none;
                padding-left: 20px;
                position: relative;
            }

            .tree ul {
                display: none;
            }

            .tree li {
                margin: 0;
                padding: 10px 0 0 20px;
                position: relative;
                cursor: pointer;
            }

            .tree .toggle {
                font-weight: bold;
                display: flex;
                align-items: center;
            }

            .tree .toggle .toggle-icon {
                margin-right: 5px;
                transition: transform 0.2s ease;
            }

            .tree .expanded .toggle-icon {
                transform: rotate(90deg);
            }
        </style>
    @endpush
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

        @include('pages.menu.utils')
    @endpush
</x-app-layout>
