@if($userAccess['can_create'] ?? false)
    <!-- <span class="d-none d-sm-inline">
        <a href="#" class="btn btn-1">
            New view
        </a>
    </span> -->
    <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
        Tambah {{ $slot }}
    </a>
    <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" aria-label="Create new report">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
    </a>
@endif
