@extends('layouts.app')

@section('title', 'User Logs')

@section('breadcrumbs')
<div class="breadcrumb mb-24">
    <ul class="flex-align gap-4">
        <li><a href="{{ route('home') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
        <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
        <li><span class="text-gray-200 fw-normal text-15 hover-text-main-600">Logs</span></li>
        <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
        <li><span class="text-main-600 fw-normal text-15">User Logs</span></li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom border-gray-100">
            <h5>User Logs</h5>
            <form class="p-0 row" style="row-gap: .5rem" method="GET" action="">
                <div class="col">
                    <select class="form-control form-select h6 rounded-4 m-0 py-6 px-8" name="type">
                        <option {{ Request::get('type') == 'all' ? 'selected' : null }} value="all">All</option>
                        <option {{ Request::get('type') == 'sign in' ? 'selected' : null }} value="sign in">Sign In</option>
                        <option {{ Request::get('type') == 'sign out' ? 'selected' : null }} value="sign out">Sign Out</option>
                        <option {{ Request::get('type') == 'add user' ? 'selected' : null }} value="add user">Add User</option>
                        <option {{ Request::get('type') == 'remove user' ? 'selected' : null }} value="remove user">Remove User</option>
                        <option {{ Request::get('type') == 'update user' ? 'selected' : null }} value="update user">Update User</option>
                        <option {{ Request::get('type') == 'activate user' ? 'selected' : null }} value="activate user">Activate User</option>
                        <option {{ Request::get('type') == 'deactivate user' ? 'selected' : null }} value="deactivate user">Deactivate User</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="actor" placeholder="Actor" value="{{ Request::get('actor') ?? null }}">
                </div>
                <div class="col">
                    <input type="text" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="ip_address" placeholder="IP Address" value="{{ Request::get('ip_address') ?? null }}">
                </div>
                <div class="col d-flex flex-row align-items-center gap-4">
                    <input type="date" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="date_start" placeholder="From" value="{{ Request::get('date_start') ?? null }}" max="{{ date('Y-m-d') }}">
                    <span>-</span>
                    <input type="date" class="form-control h6 rounded-4 mb-0 py-6 px-8" name="date_end" placeholder="To" value="{{ Request::get('date_end') ?? date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
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
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Actor</th>
                                <th>Description</th>
                                <th>IP Address</th>
                                <th>Timestamps</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem() @endphp
                            @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $no++ }}</td>
                                <td>{!! $item->actor ? $item->actor_detail->username ?? '<i class="text-gray-200">deleted user</i>' : '-' !!}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->ip_address }}</td>
                                <td>{{ date('H:i:s d M Y', strtotime($item->created_at)) }}</td>
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