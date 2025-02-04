@extends('layouts.app')

@section('title', 'Production Lines')

@section('breadcrumbs')
<div class="breadcrumb mb-24">
    <ul class="flex-align gap-4">
        <li><a href="{{ route('home') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
        <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
        <li><a href="{{ route('home') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Master Data</a></li>
        <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
        <li><span class="text-main-600 fw-normal text-15">Production Lines</span></li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom border-gray-100 flex-align align-items-center justify-content-between">
            <h5 class="mb-0">Production Lines</h5>
            <button class="btn btn-outline-main bg-primary-100 border-primary-100 text-primary rounded-pill py-9 d-flex flex-row items-center gap-8" data-bs-toggle="modal" data-bs-target="#line-modal">
                <i class="ph ph-plus"></i>
                Add New Line
            </button>
        </div>
        <div class="card-body">
            @if (count($lines) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Line Code</th>
                                <th>Line Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @foreach ($lines as $line)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $line->code }}</td>
                                <td>{{ $line->line_name }}</td>
                                <td class="d-flex flex-row justify-content-center gap-8">
                                    <a class="btn btn-outline-main py-6 px-8" onclick="edit({{ $line->id }})" data-bs-toggle="tooltip" data-bs-title="Edit line details">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('master.lines.destroy', $line->id) }}" method="post" onsubmit="return confirm('Are you sure want to delete this production line? This action is irreversible!')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger py-6 px-8" data-bs-toggle="tooltip" data-bs-title="Delete this line">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-component />
            @endif
        </div>
    </div>
</div>
@endsection

@section('modal-section')
<div class="modal fade" id="line-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Production Line</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master.lines.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="d-flex flex-column gap-16">
                        <div>
                            <label for="line-code" class="form-label">Line Code</label>
                            <input type="text" id="line-code" name="code" class="form-control" placeholder="Enter line code" required>
                        </div>
                        <div>
                            <label for="line-name" class="form-label">Line Name</label>
                            <input type="text" id="line-name" name="line_name" class="form-control" placeholder="Enter line name" required>
                        </div>
                        <div class="d-flex flex-row justify-content-end gap-8">
                            <a data-bs-dismiss="modal" class="btn btn-outline-gray btn-sm">
                                <i class="ph ph-x"></i>
                                Cancel
                            </a>
                            <button class="btn btn-sm btn-success">
                                <i class="ph ph-floppy-disk"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-scripts')
<script>
    const edit = id => {
        let url = `{{ route('master.lines.edit', ':id') }}`
        url = url.replace(':id', id)
        
        $.get(url, data => {
            $('#line-modal .modal-title').text('Edit Production Line')
            $('#line-modal form').attr('action', `{{ route('master.lines.update', ':id') }}`.replace(':id', id))
            $('#line-modal form input[name="_method"]').val('patch')
            $('#line-code').val(data.code)
            $('#line-name').val(data.line_name)
            $('#line-modal').modal('show')
        })
    }
    
    const resetModal = () => {
        $('#line-modal .modal-title').text('Add Production Line')
        $('#line-modal form').attr('action', `{{ route('master.lines.store') }}`)
        $('#line-modal form input[name="_method"]').val('post')
        $('#line-code').val('')
        $('#line-name').val('')
    }
    
    $('#line-modal').on('hidden.bs.modal', () => {
        resetModal()
    })
</script>
@endsection