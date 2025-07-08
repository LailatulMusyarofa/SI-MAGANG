<div class="btn-list flex-nowrap">
    <div class="dropdown">
        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
            Aksi
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <button class="dropdown-item" onclick="editForm(`{{ route('menu.update', ['menu' => $menu->id]) }}`, 'Edit Menu', {{ json_encode($menu) }})">
                Ubah
            </button>
            <button class="dropdown-item text-danger" onclick="deleteData(`{{ route('menu.destroy', ['menu' => $menu->id]) }}`)">
                Hapus
            </button>
        </div>
    </div>
</div>
