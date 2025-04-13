@extends('admin.layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white">
                        <h3 class="mt-2">
                            Dashboard
                        </h3>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="row mb-2">
                            {{-- today card --}}
                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    {{-- header card --}}
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-black">
                                                Today's Order
                                            </strong>
                                            <span class="badge bg-dark">
                                                {{ $todayOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    {{-- content card --}}
                                    <div class="card-footer text-center bg-white">
                                        <strong>
                                            {{ $todayOrders->sum('total') }} Pcs
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            {{-- yesterday card --}}
                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    {{-- header card --}}
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-success">
                                                Yesterday's Order
                                            </strong>
                                            <span class="badge bg-success">
                                                {{ $yesterdayOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    {{-- content card --}}
                                    <div class="card-footer text-center bg-white">
                                        <strong>
                                            {{ $yesterdayOrders->sum('total') }} Pcs
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            {{-- month card --}}
                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    {{-- header card --}}
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-primary">
                                                Months Order
                                            </strong>
                                            <span class="badge bg-primary">
                                                {{ $monthOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    {{-- content card --}}
                                    <div class="card-footer text-center bg-white">
                                        <strong>
                                            {{ $monthOrders->sum('total') }} Pcs
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            {{-- year card --}}
                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    {{-- header card --}}
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-danger">
                                                Years Order
                                            </strong>
                                            <span class="badge bg-danger">
                                                {{ $yearOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    {{-- content card --}}
                                    <div class="card-footer text-center bg-white">
                                        <strong>
                                            {{ $yearOrders->sum('total') }} Pcs
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
