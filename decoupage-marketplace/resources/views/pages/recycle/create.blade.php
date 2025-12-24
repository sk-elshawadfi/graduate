@extends('layouts.app')

@section('content')
    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h2 class="fw-semibold mb-3">Recycle & Earn Store Credit</h2>
                        <p class="text-muted">Upload your item, tell us its story, and choose whether to recycle or sell. Our team responds within 24h.</p>
                        <form class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Upload photo</label>
                                <div class="upload-preview rounded-4" id="recyclePreview">
                                    <span class="text-muted"><i class="fa-solid fa-cloud-arrow-up me-2"></i>Drop photo or click to upload</span>
                                    <input type="file" id="recycleImage" class="form-control" accept="image/*">
                                </div>
                            </div>
                            <div class="col-12 floating-label">
                                <textarea class="form-control" rows="4" placeholder=" " id="recycleDescription"></textarea>
                                <label for="recycleDescription">Describe condition, materials, or sentimental story</label>
                            </div>
                            <div class="col-12">
                                <p class="fw-semibold mb-2">Type</p>
                                <div class="d-flex gap-3">
                                    <label class="payment-option flex-grow-1">
                                        <input type="radio" name="type" value="recycle" checked>
                                        <div>
                                            <strong>Recycle</strong>
                                            <p class="mb-0 text-muted small">We repurpose & give you wallet credit</p>
                                        </div>
                                    </label>
                                    <label class="payment-option flex-grow-1">
                                        <input type="radio" name="type" value="sell">
                                        <div>
                                            <strong>Sell</strong>
                                            <p class="mb-0 text-muted small">We list on marketplace under your name</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="button" onclick="showToast('success', 'Request submitted!')">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                                    Submit request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="dashboard-card mb-4">
                    <h5 class="fw-semibold mb-2">Status tracker</h5>
                    <p class="text-muted">Once submitted, track your request here or via dashboard.</p>
                    <div class="timeline">
                        @foreach(['Submitted','Reviewing','Priced','Completed'] as $step)
                            <div class="d-flex gap-3 align-items-start {{ $loop->first ? 'active' : '' }}">
                                <span class="timeline-dot {{ $loop->first ? 'active' : '' }}"></span>
                                <div>
                                    <p class="fw-semibold mb-0">{{ $step }}</p>
                                    <small class="text-muted">Get notified instantly</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h6 class="fw-semibold">Tips for better quotes</h6>
                        <ul class="text-muted small mb-0">
                            <li>Upload photos from different angles.</li>
                            <li>Mention dimensions and materials.</li>
                            <li>Highlight any artisan techniques or damage.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
