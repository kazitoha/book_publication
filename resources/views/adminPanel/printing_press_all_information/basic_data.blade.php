@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <h2 class="section-title">Card Variants</h2>
    <p class="section-lead">
        Basically, the Bootstrap card can be given a color variant.
    </p>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Card Header</h4>
                </div>
                <div class="card-body">
                    <p>Card <code>.card-primary</code></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <h4>Card Header</h4>
                </div>
                <div class="card-body">
                    <p>Card <code>.card-secondary</code></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h4>Card Header</h4>
                </div>
                <div class="card-body">
                    <p>Card <code>.card-danger</code></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h4>Card Header</h4>
                </div>
                <div class="card-body">
                    <p>Card <code>.card-warning</code></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-info">
                <div class="card-header">
                    <h4>Card Header</h4>
                </div>
                <div class="card-body">
                    <p>Card <code>.card-info</code></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-success">
                <div class="card-header">
                    <h4>Card Header</h4>
                </div>
                <div class="card-body">
                    <p>Card <code>.card-success</code></p>
                </div>
            </div>
        </div>
    @endsection
