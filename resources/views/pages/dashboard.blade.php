@extends('layouts.app')

@section('title', 'Dashboard')

@section('main-content')
    <div class="row">
        <div class="col-12">
            h5
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center gap-16">
                        <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-main-500 text-white text-4xl">
                            <i class="ph-fill ph-book-open"></i>
                        </span>
                        <div>
                            <h3 class="mb-2">155+</h3>
                            <span class="text-gray-600">Registered Clocks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center gap-16">
                        <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-success-400 text-white text-4xl" style="--bs-bg-opacity: 1;">
                            <i class="ph-fill ph-book-open"></i>
                        </span>
                        <div>
                            <h3 class="mb-2">155+</h3>
                            <span class="text-gray-600">Online Clocks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center gap-16">
                        <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-danger-400 text-white text-4xl">
                            <i class="ph-fill ph-book-open"></i>
                        </span>
                        <div>
                            <h3 class="mb-2">155+</h3>
                            <span class="text-gray-600">Offline Clocks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center gap-16">
                        <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-warning-300 text-white text-4xl">
                            <i class="ph-fill ph-book-open"></i>
                        </span>
                        <div>
                            <h3 class="mb-2">155+</h3>
                            <span class="text-gray-600">Clock Went Offline Today</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection