@extends('layouts.app')

@section('content')
    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="dashboard-sidebar">
                    <a href="#" class="active"><i class="fa-solid fa-gauge"></i> Overview</a>
                    <a href="#"><i class="fa-solid fa-bag-shopping"></i> Orders</a>
                    <a href="#"><i class="fa-solid fa-wallet"></i> Wallet</a>
                    <a href="#"><i class="fa-solid fa-recycle"></i> Recycle</a>
                    <a href="#"><i class="fa-solid fa-user"></i> Profile</a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row g-3 mb-4">
                    @foreach([
                        ['label' => 'Orders', 'value' => '16', 'icon' => 'fa-bag-shopping'],
                        ['label' => 'Wallet balance', 'value' => 'EGP 1,280', 'icon' => 'fa-wallet'],
                        ['label' => 'Recycle requests', 'value' => '3 active', 'icon' => 'fa-recycle'],
                    ] as $card)
                        <div class="col-md-4">
                            <div class="dashboard-card text-center">
                                <i class="fa-solid {{ $card['icon'] }} text-primary mb-2"></i>
                                <p class="text-muted mb-1">{{ $card['label'] }}</p>
                                <h4 class="fw-semibold">{{ $card['value'] }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Recent orders</h5>
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead><tr><th>#</th><th>Date</th><th>Status</th><th>Total</th></tr></thead>
                                <tbody>
                                @foreach([['ORD-2401','May 01','Completed','EGP 890'],['ORD-2388','Apr 21','Processing','EGP 1,210']] as $order)
                                    <tr>
                                        <td>{{ $order[0] }}</td>
                                        <td>{{ $order[1] }}</td>
                                        <td><span class="badge bg-{{ $loop->index ? 'warning' : 'success' }}">{{ $order[2] }}</span></td>
                                        <td>{{ $order[3] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Recycle requests</h5>
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead><tr><th>Item</th><th>Status</th><th>Credit</th></tr></thead>
                                <tbody>
                                @foreach([['Vintage tray','Reviewing','—'],['Glass jars','Approved','EGP 200'],['Mirror frame','Completed','EGP 450']] as $req)
                                    <tr>
                                        <td>{{ $req[0] }}</td>
                                        <td><span class="badge bg-info">{{ $req[1] }}</span></td>
                                        <td>{{ $req[2] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
