<div class="d-flex justify-content-center">

    @can('edit_cancel_reason')
    <a href="{{ route('cancelReasons.edit', $cancelReason) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan
    
    @can('delete_cancel_reason')
    <button role="button" onclick="destroy('{{ route('cancelReasons.destroy', $cancelReason->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan
    
</div>
