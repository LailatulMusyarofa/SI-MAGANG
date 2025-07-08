<x-modal modalId="MenuModal" modalTitle="" modalAction="" method="">
    <div class="mb-3">
        <label class="form-label">Nama Menu</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Icon</label>
        <input type="text" class="form-control" name="icon">
    </div>
    <div class="mb-3">
        <label class="form-label">Parent</label>
        <select class="form-select" name="parent_id" id="parent_id">
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">URL</label>
        <input type="text" class="form-control" name="url">
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" class="form-control" name="order">
    </div>
    <div class="mb-3">
        <label class="form-label">Match Segment</label>
        <input type="text" class="form-control" name="match_segment">
    </div>
    <div class="mb-3">
        <div class="form-label">Status</div>
        <label class="form-check form-switch form-switch-3">
            <input class="form-check-input" type="checkbox" name="is_active">
            <span class="form-check-label">Tidak Aktif</span>
        </label>
    </div>
</x-modal>
