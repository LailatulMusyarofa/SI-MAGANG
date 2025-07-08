<div class="col">
    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item {{ $breadcrumbState }}">
            <a href="{{ route($currentRoute) }}" class="text-capitalize">{{ $pageTitle }}</a>
        </li>
    </ol>
</div>
