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
            <div class="card-header border-bottom border-gray-100">
                <div class="flex-between mb-16">
                    <h5 class="mb-0">NTP Clocks</h5>
                    <button class="btn btn-outline-main bg-primary-100 border-primary-100 text-primary rounded-pill py-9 d-flex flex-row items-center gap-8" data-bs-toggle="modal" data-bs-target="#clock-modal">
                        <i class="ph ph-plus"></i>
                        Add New NTP Clock
                    </button>
                </div>
                <form class="p-0 row" style="row-gap: .5rem" method="GET" action="">
                    <div class="col">
                        <select class="form-control form-select h6 rounded-4 m-0 py-6 px-8" name="line">
                            <option {{ Request::get('line') == 'all' ? 'selected' : null }} value="all">All Lines</option>
                            @foreach ($lines as $line)
                                <option {{ Request::get('line') == $line->id ? 'selected' : null }} value="{{ $line->id }}">{{ $line->line_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="name" placeholder="Clock Name/Location" value="{{ Request::get('name') ?? null }}">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="ip" placeholder="IP Address" value="{{ Request::get('ip') ?? null }}">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="mac" placeholder="MAC Address" value="{{ Request::get('mac') ?? null }}">
                    </div>
                    <div class="col">
                        <select class="form-control form-select h6 rounded-4 m-0 py-6 px-8" name="status">
                            <option {{ Request::get('status') == 'all' ? 'selected' : null }} value="all">All Status</option>
                            <option {{ Request::get('status') == 't' ? 'selected' : null }} value="t">Online</option>
                            <option {{ Request::get('status') == 'f' ? 'selected' : null }} value="f">Offline</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-auto">
                        <button class="btn btn-outline-success bg-success-100 border-success-100 text-success w-100 py-9">
                            <i class="ph ph-funnel"></i>
                            Filter
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if (count($data) > 0)
                    <div class="row {{ count($data->links()->elements[0]) > 1 ? 'mb-20' : '' }}" style="row-gap: 1.5rem">
                        @foreach ($data as $item)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border border-{{ $item->is_online ? 'success' : 'danger' }}-400"> 
                                    <div class="card-body p-8">
                                        <div class="p-8">
                                            <span class="text-13 py-2 px-10 rounded-pill bg-main-50 text-main-600 mb-8">{{ $item->line->line_name }}</span>
                                            <h5 class="mb-8">{{ $item->clock_name }}</h5>

                                            <div class="gap-8">
                                                <div class="flex-align gap-4">
                                                    <span class="text-md text-main-600 d-flex"><i class="ph ph-address-book"></i></span>
                                                    <span class="text-13 text-gray-600">{{ $item->ip_address }}</span>
                                                </div>
                                                <div class="flex-align gap-4">
                                                    <span class="text-md text-main-600 d-flex"><i class="ph ph-hard-drives"></i></span>
                                                    <span class="text-13 text-gray-600">{{ $item->mac_address }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex-between mt-16">
                                                @if ($item->is_online)
                                                    <span class="text-13 py-3 px-16 rounded-pill bg-success-50 text-success-600 d-flex align-items-center gap-8">
                                                        <i class="ph ph-smiley text-lg"></i>
                                                        <span>Online</span>
                                                    </span>
                                                @else
                                                    <span class="text-13 py-3 px-16 rounded-pill bg-danger-50 text-danger-600 d-flex align-items-center gap-8">
                                                        <i class="ph ph-smiley-sad text-lg"></i>
                                                        <span>Offline</span>
                                                    </span>
                                                @endif
                                                
                                                <div class="d-flex flex-row justify-content-end gap-4 flex-wrap">
                                                    <a href="{{ route('clocks.configure', $item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success rounded-pill btn-sm px-8 py-8" data-bs-toggle="tooltip" data-bs-title="Configure this clock">
                                                        <i class="ph ph-arrow-square-out"></i>
                                                    </a>
                                                    <a class="btn btn-outline-main rounded-pill btn-sm py-8 px-8" onclick="edit({{ $item->id }})" data-bs-toggle="tooltip" data-bs-title="Edit clock details">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('clocks.destroy', $item->id) }}" method="post" onsubmit="return confirm('Are you sure want to delete this NTP Clock? This action is irreversible!')">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-outline-danger rounded-pill btn-sm py-8 px-8" data-bs-toggle="tooltip" data-bs-title="Delete this clock">
                                                            <i class="ph ph-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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