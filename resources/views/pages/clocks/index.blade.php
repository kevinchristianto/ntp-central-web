@extends('layouts.app')

@section('title', 'NTP Clocks')

@section('breadcrumbs')
<div class="breadcrumb mb-24">
    <ul class="flex-align gap-4">
        <li><a href="{{ route('home') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
        <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
        <li><span class="text-main-600 fw-normal text-15">NTP Clocks</span></li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom border-gray-100 flex-align align-items-center justify-content-between">
            <h5 class="mb-0">NTP Clocks</h5>
            <button class="btn btn-main rounded-pill py-10 d-flex flex-row items-center gap-8" data-bs-toggle="modal" data-bs-target="#clock-modal">
                <i class="ph ph-plus"></i>
                Add New NTP Clock
            </button>
        </div>
        <div class="card-body">
            @if (count($data) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Line</th>
                                <th>Clock Name/Location</th>
                                <th>MAC Address</th>
                                <th>IP Address</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->line->line_name }}</td>
                                <td>{{ $item->clock_name }}</td>
                                <td>{{ $item->mac_address }}</td>
                                <td>{{ $item->ip_address }}</td>
                                <td class="d-flex flex-row justify-content-center gap-8">
                                    <a href="{{ route('clocks.configure', $item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success px-8 py-6" data-bs-toggle="tooltip" data-bs-title="Configure this clock">
                                        <i class="ph ph-arrow-square-out"></i>
                                    </a>
                                    <a class="btn btn-outline-main py-6 px-8" onclick="edit({{ $item->id }})" data-bs-toggle="tooltip" data-bs-title="Edit clock details">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('clocks.destroy', $item->id) }}" method="post" onsubmit="return confirm('Are you sure want to delete this NTP Clock? This action is irreversible!')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger py-6 px-8" data-bs-toggle="tooltip" data-bs-title="Delete this clock">
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
<div class="modal fade" id="clock-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add NTP Clock</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clocks.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="d-flex flex-column gap-16">
                        <div>
                            <label for="clock-id" class="form-label">Line</label>
                            <select name="line_id" id="line-id" class="form-control">
                                <option value disabled selected>--- Choose line ---</option>
                                @foreach ($lines as $line)
                                <option value="{{ $line->id }}">{{ $line->line_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="clock-name" class="form-label">Clock Name/Location</label>
                            <input type="text" id="clock-name" name="clock_name" class="form-control" placeholder="Enter clock name/location" required>
                        </div>
                        <div>
                            <label for="mac-address">MAC Address</label>
                            <input type="text" id="mac-address" name="mac_address" class="form-control" placeholder="Enter clock's MAC address" required>
                        </div>
                        <div>
                            <label for="ip-address">IP Address</label>
                            <input type="text" id="ip-address" name="ip_address" class="form-control" placeholder="Enter clock's IP address" required>
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
        let url = `{{ route('clocks.edit', ':id') }}`
        url = url.replace(':id', id)
        
        $.get(url, data => {
            $('#clock-modal .modal-title').text('Edit NTP Clock')
            $('#clock-modal form').attr('action', `{{ route('clocks.update', ':id') }}`.replace(':id', id))
            $('#clock-modal form input[name="_method"]').val('patch')
            $('#line-id').val(data.line_id).change()
            $('#clock-name').val(data.clock_name)
            $('#mac-address').val(data.mac_address)
            $('#ip-address').val(data.ip_address)
            $('#clock-modal').modal('show')
        })
    }
    
    const resetModal = () => {
        $('#clock-modal .modal-title').text('Add NTP Clock')
        $('#clock-modal form').attr('action', `{{ route('clocks.store') }}`)
        $('#clock-modal form input[name="_method"]').val('post')
        $('#line-id').val('').change()
        $('#clock-name').val('')
        $('#mac-address').val('')
        $('#ip-address').val('')
    }
    
    $('#clock-modal').on('hidden.bs.modal', () => {
        resetModal()
    })
</script>
@endsection