@extends('layouts.template')

@push('app-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-todo.css') }}">
@endpush

@section('app-content')
    @include('layouts.navbar')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row match-height">
                    <!-- Subscribers Chart Card starts -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start pb-0">
                                <div class="avatar bg-light-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i data-feather="users" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="font-weight-bolder mt-1">92.6k</h2>
                                <p class="card-text">Subscribers Gained</p>
                            </div>
                            <div id="gained-chart"></div>
                        </div>
                    </div>
                    <!-- Subscribers Chart Card ends -->

                    <!-- Orders Chart Card starts -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start pb-0">
                                <div class="avatar bg-light-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i data-feather="package" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="font-weight-bolder mt-1">38.4K</h2>
                                <p class="card-text">Orders Received</p>
                            </div>
                            <div id="order-chart"></div>
                        </div>
                    </div>
                    <!-- Orders Chart Card ends -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('app-js')
    <script src="{{ asset('app-assets/js/scripts/pages/app-todo.js') }}"></script>
@endpush
