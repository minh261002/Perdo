    <form action="" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm" name="q"
                value="{{ request()->get('q') }}">
            <button class="btn btn-3" type="submit" id="button-addon2">
                <i class="ti ti-search"></i>
            </button>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Khoảng giá</label>
            <div class="d-flex align-items-center justify-content-between gap-3 ">
                <input type="number" class="form-control" placeholder="Từ" name="min_price"
                    value="{{ request()->get('min_price') }}">
                <i class="ti ti-arrow-right fs-1"></i>
                <input type="number" class="form-control" placeholder="Đến" name="max_price"
                    value="{{ request()->get('max_price') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Sắp xếp theo</label>
            <select name="sort" class="form-select">
                <option value="default" {{ request()->get('sort') == 'default' ? 'selected' : '' }}>
                    Mặc định
                </option>
                <option value="price_asc" {{ request()->get('sort') == 'price_asc' ? 'selected' : '' }}>
                    Giá tăng dần
                </option>
                <option value="price_desc" {{ request()->get('sort') == 'price_desc' ? 'selected' : '' }}>
                    Giá giảm dần
                </option>
                <option value="name_asc" {{ request()->get('sort') == 'name_asc' ? 'selected' : '' }}>
                    Tên A-Z
                </option>
                <option value="name_desc" {{ request()->get('sort') == 'name_desc' ? 'selected' : '' }}>
                    Tên Z-A
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Đánh giá</label>

            @for ($i = 4; $i >= 0; $i--)
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="rating" id="rating-{{ $i + 1 }}"
                        value="{{ $i + 1 }}" {{ request()->get('rating') == $i + 1 ? 'checked' : '' }}>
                    <span class="form-check-label">
                        @for ($j = 0; $j <= $i; $j++)
                            <i class="ti ti-star-filled fs-2 text-warning"></i>
                        @endfor
                    </span>
                </label>
            @endfor

        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>
