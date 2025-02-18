<div class="d-flex justify-content-center">

    @can('show_device')
    <a href="{{ route('devices.show', $device) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>
    @endcan

    @can('edit_device')
    <a href="{{ route('devices.edit', $device) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_device')
    <button role="button" onclick="destroy('{{ route('devices.destroy', $device->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan
</div>
