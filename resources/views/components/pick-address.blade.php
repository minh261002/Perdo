<div class="d-flex justify-content-between align-items-center">
    <label class="form-label">
        {{ $label }}</label>
    <div id="getCurrentLocation" class="text-danger d-flex align-items-center">
        <div class="spinner-border text-danger me-1" role="status" style="display: none;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="cursor-pointer">Địa chỉ hiện tại</span>
    </div>
</div>
<div class="input-group mb-2">
    <input type="text" class="form-control" name="address"
        value="{{ $value }}"
        readonly data-parsley-errors-container="#erroraddress" />
    <button type="button" id="openModalPickAddress" class="btn text-danger fw-normal"
        data-input="input[name={{ $name }}]" data-lat="input[name=lat]" data-lng="input[name=lng]"
        data-address-detail="input[name=address_detail]" data-bs-toggle="modal"
        data-bs-target="#modalPickAddress">
    Chọn địa chỉ</button>
</div>
<div id="error{{ $name }}"></div>
