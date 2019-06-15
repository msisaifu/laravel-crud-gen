@extends('layouts.app')
@section('title', '404')
@push('custom-css')
<link rel="stylesheet" href="{{asset('assets/libs/css/notfound.css')}}">
@endpush
@section('breadcumb')
  <li class="breadcrumb-item">
    <a href="{{route('dashboard')}}" class="breadcrumb-link">Dashboard</a>
  </li>
  <li class="breadcrumb-item">404</li>
@endsection

@section('content')
<div class="ecommerce-widget">
  <div class="clearfix"></div>
  <div id="notfound">
    <div class="notfound">
      <div class="notfound-404">
        <h1>4<span>0</span>4</h1>
      </div>
      <h2>the page you requested could not found</h2>
    </div>
  </div>
</div>
@endsection