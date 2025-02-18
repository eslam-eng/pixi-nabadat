<div class="d-flex justify-content-center">

    @can('view_package')
{{--    <a href="{{ route('packages.show', $package) }}" class="btn-sm btn-primary me-1">--}}
{{--        <i class="fa fa-eye  my-2"></i>--}}
{{--    </a>--}}
    @endcan

    @can('edit_package')
    <a href="{{ route('packages.edit', $package) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_package')
    <button role="button" onclick="destroy('{{ route('packages.destroy', $package->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan

</div>
