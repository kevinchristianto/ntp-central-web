@extends('layouts.app')

@section('title', 'Users')

@section('breadcrumbs')
<div class="breadcrumb mb-24">
    <ul class="flex-align gap-4">
        <li><a href="{{ route('home') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
        <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
        <li><span class="text-main-600 fw-normal text-15">Manage Users</span></li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom border-gray-100 flex-align align-items-center justify-content-between">
            <h5 class="mb-0">Users</h5>
            <button class="btn btn-main rounded-pill py-10 d-flex flex-row items-center gap-8" data-bs-toggle="modal" data-bs-target="#user-modal">
                <i class="ph ph-plus"></i>
                Add New User
            </button>
        </div>
        <div class="card-body">
            @if (count($data) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge bg-success-subtle text-success-emphasis" data-bs-toggle="tooltip" data-bs-title="Active">
                                            <i class="ph ph-check"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger-emphasis" data-bs-toggle="tooltip" data-bs-title="Inactive">
                                            <i class="ph ph-x"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="d-flex flex-row justify-content-center gap-8">
                                    <form action="{{ route('users.toggle_status', $item->id) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="is_active" value="{{ intval(!$item->is_active) }}">
                                        <button class="btn btn-outline-{{ $item->is_active ? 'danger' : 'success' }} py-6 px-8" data-bs-toggle="tooltip" data-bs-title="{{ $item->is_active ? 'Deactivate this user' : 'Activate this user' }}">
                                            <i class="ph ph-{{ $item->is_active ? 'x' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <a class="btn btn-outline-main py-6 px-8" onclick="edit({{ $item->id }})" data-bs-toggle="tooltip" data-bs-title="Edit user details">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $item->id) }}" method="post" onsubmit="return confirm('Are you sure want to delete this user? This action is irreversible!')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger py-6 px-8" data-bs-toggle="tooltip" data-bs-title="Delete this user">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $data->links() }}
            @else
                <x-empty-component />
            @endif
        </div>
    </div>
</div>
@endsection

@section('modal-section')
<div class="modal fade" id="user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="d-flex flex-column gap-16">
                        <div>
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter 3 digit username" required>
                        </div>
                        <div>
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        <div>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                            <small id="password-hint" class="text-secondary invisible">Leave blank to keep it as-is. Only input if you want to change the password.</small>
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
        let url = `{{ route('users.edit', ':id') }}`
        url = url.replace(':id', id)
        
        $.get(url, data => {
            $('#user-modal .modal-title').text('Edit User')
            $('#user-modal form').attr('action', `{{ route('users.update', ':id') }}`.replace(':id', id))
            $('#user-modal form input[name="_method"]').val('patch')
            $('#username').val(data.username)
            $('#name').val(data.name)
            $('#password-hint').removeClass('invisible')
            $('#user-modal').modal('show')
        })
    }
    
    const resetModal = () => {
        $('#user-modal .modal-title').text('Add User')
        $('#user-modal form').attr('action', `{{ route('users.store') }}`)
        $('#user-modal form input[name="_method"]').val('post')
        $('#username').val('')
        $('#name').val('')
        $('#password-hint').addClass('invisible')
    }
    
    $('#user-modal').on('hidden.bs.modal', () => {
        resetModal()
    })
</script>
@endsection