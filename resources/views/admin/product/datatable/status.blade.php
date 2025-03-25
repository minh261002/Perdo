<div class="w-100 d-flex align-items-center justify-content-center">
    <label class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox"
            {{ $status == \App\Enums\ActiveStatus::Active->value ? 'checked' : '' }} data-id="{{ $id }}"
            style="transform: scale(1.5);" />
    </label>

</div>
