<a href="{{ route('admin.brand.edit', $id) }}" class="btn btn-sm btn-primary">
    <i class="ti ti-pencil fs-1"></i>
</a>

<a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $id }}">
    <i class="ti ti-trash fs-1"></i>
</a>

<div class="modal modal-blur fade" id="modal-delete-{{ $id }}" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-alert-triangle text-danger" style="font-size: 64px"></i>
                <h3>
                    Cảnh báo
                </h3>
                <div class="text-secondary">
                    Dũ liệu sẽ bị xóa vĩnh viễn khỏi hệ thống và không thể khôi
                    phục. Bạn có chắc muốn xóa?
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Huỷ
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.brand.delete', $id) }}" class="btn btn-danger w-100 btn-delete"
                                data-bs-dismiss="modal">
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
