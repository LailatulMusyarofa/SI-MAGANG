<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0
* @link https://tabler.io
* Copyright 2018-2025 The Tabler Authors
* Copyright 2018-2025 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

@include('partials.head', ['pageTitle' => $pageTitle])
@stack('scripts')



<body class="{{ in_array($pageTitle, ['Login', 'Daftar Akun Baru']) ? 'd-flex flex-column' : 'layout-fluid' }}" data-bs-theme="light">
        <!-- Sidebar -->
        @if(!in_array($pageTitle, ['Login', 'Daftar Akun Baru', 'Reset Password', 'Lupa Password']))
            @include('partials.sidebar')
            @include('partials.navbar')
            <div class="page-wrapper">
        @endif
            <!-- Page body -->
            {{ $slot }}
            <!-- Footer -->
        @if(!in_array($pageTitle, ['Login', 'Daftar Akun Baru', 'Reset Password', 'Lupa Password']))
            @include('partials.footer')
            </div>
        @endif
    </div>
    <!-- Scripts -->
    @include('partials.scripts')
</body>

</html>
<!--  -->
