@extends('layouts.app')

@section('title', 'Dashboard')

@section('main-content')
    <div class="row" style="row-gap: 1rem">
        <div class="col-12">
            {{-- <h4>Summary</h4> --}}
            <div class="grettings-box position-relative rounded-16 bg-main-600 overflow-hidden gap-16 flex-wrap z-1">
                <img src="{{ asset('assets/images/bg/grettings-pattern.webp') }}" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                <div class="row gy-4">
                    <div class="col-sm-7">
                        <div class="grettings-box__content py-xl-4">
                            <h2 class="text-white mb-0">Hello, {{ explode(' ', auth()->user()->name)[0] }}! </h2>
                            <p class="text-15 fw-light text-white">It's <b id="time"></b>. How's your day?</p>
                            <p class="text-lg mt-16 text-white">Anyway, here's the summary of the all NTP Clocks installed in KGM</p>
                        </div>
                    </div>
                    <div class="col-sm-5 d-sm-block d-none">
                        <div class="text-center h-100 d-flex justify-content-end align-items-end">
                            <img src="{{ asset('assets/images/thumbs/welcome-illustration.svg') }}" alt="" width="75%" height="75%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body flex-align">
                    <a href="{{ route('clocks.index') }}">
                        <div class="d-flex flex-row align-items-center gap-16">
                            <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-primary-50 text-white text-4xl">
                                <i class="ph-fill ph-clock-user text-primary-500"></i>
                            </span>
                            <div>
                                <h2 class="mb-2">{{ $clocks->count() }}</h2>
                                <span class="text-gray-600">Registered Clocks</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body flex-align">
                    <a href="{{ route('clocks.index', ['status' => 't']) }}">
                        <div class="d-flex flex-row align-items-center gap-16">
                            <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-success-100 text-white text-4xl" style="--bs-bg-opacity: 1;">
                                <i class="ph-fill ph-smiley text-success-500"></i>
                            </span>
                            <div>
                                <h2 class="mb-2">{{ $online_clocks }}</h2>
                                <span class="text-gray-600">Online Clocks</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body flex-align">
                    <a href="{{ route('clocks.index', ['status' => 'f']) }}">
                        <div class="d-flex flex-row align-items-center gap-16">
                            <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-danger-100 text-white text-4xl">
                                <i class="ph-fill ph-smiley-x-eyes text-danger-500"></i>
                            </span>
                            <div>
                                <h2 class="mb-2">{{ $offline_clocks }}</h2>
                                <span class="text-gray-600">Offline Clocks</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body flex-align">
                    <a href="{{ route('logs.clock', ['type' => 'clock went offline', 'date_start' => date('Y-m-d'), 'date_end' => date('Y-m-d')]) }}">
                        <div class="d-flex flex-row align-items-center gap-16">
                            <span class="flex-shrink-0 w-72 h-72 flex-center rounded-circle bg-warning-100 text-white text-4xl">
                                <i class="ph-fill ph-smiley-nervous text-warning-500"></i>
                            </span>
                            <div>
                                <h2 class="mb-2">{{ $offline_clocks_today }}</h2>
                                <span class="text-gray-600">Clock Went Offline Today</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="alert alert-primary text-primary-800 d-flex align-items-center gap-6" role="alert">
                <i class="ph ph-info text-lg"></i>
                <span>
                    The NTP clocks will be checked again in about <b>{{ str_contains($next_due, 'minute') ? $next_due . ' and a few seconds' : $next_due }}</b> or at exactly <b>{{ date('H:i', strtotime($next_due . ' +1 minute')) }}</b>
                </span>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script>
    setInterval(() => {
        const time = moment().format('dddd, DD MMM YYYY, hh:mm:ss');
        document.getElementById('time').innerHTML = time;
    }, 1000);
</script>
@endsection