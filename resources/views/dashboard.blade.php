@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcumb')
  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<div class="ecommerce-widget">
  <div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="text-muted">Total Revenue</h5>
          <div class="metric-value d-inline-block">
            <h1 class="mb-1">$12099</h1>
          </div>
          <div class="metric-label d-inline-block float-right text-success font-weight-bold">
            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>5.86%</span>
          </div>
        </div>
        <div id="sparkline-revenue"></div>
      </div>
    </div>
  </div>
</div>
@endsection