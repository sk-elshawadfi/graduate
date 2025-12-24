@extends('admin.layouts.app')

@section('page-title', 'Record Transaction')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Manual transaction</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.transactions.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="wallet_id">Wallet</label>
                            <select name="wallet_id" id="wallet_id" class="form-control" required>
                                @foreach($wallets as $id => $label)
                                    <option value="{{ $id }}" @selected(old('wallet_id', request('wallet_id')) == $id)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="credit" @selected(old('type') === 'credit')>Credit</option>
                                <option value="debit" @selected(old('type') === 'debit')>Debit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                @foreach(['pending','completed','failed'] as $status)
                                    <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="reference">Reference</label>
                            <input type="text" name="reference" id="reference" class="form-control" value="{{ old('reference') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subject_type">Subject type (optional)</label>
                            <input type="text" name="subject_type" id="subject_type" class="form-control" value="{{ old('subject_type') }}" placeholder="App\Models\Order">
                        </div>
                        <div class="form-group mt-2">
                            <label for="subject_id">Subject ID</label>
                            <input type="number" name="subject_id" id="subject_id" class="form-control" value="{{ old('subject_id') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Record transaction</button>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
