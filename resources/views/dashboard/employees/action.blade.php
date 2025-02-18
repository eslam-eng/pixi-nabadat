<div class="d-flex justify-content-center">

    @can('view_employee')
    <a href="{{ route('employees.show', $employee) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>
    @endcan

    @can('edit_employee')
    <a href="{{ route('employees.edit', $employee) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_employee')
    <button role="button" onclick="destroy('{{ route('employees.destroy', $employee->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan
</div>
