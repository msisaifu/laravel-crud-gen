@extends('layouts.app')

@section('title', 'Cat Edit')
@section('pagetitle', 'Cat Edit')
@section('button')
<a href="{{route('cats.index')}}" class="float-right btn btn-sm btn-space btn-primary">All Cats</a>
@endsection

@section('breadcumb')
  <li class="breadcrumb-item">
    <a href="{{route('cats.index')}}" class="breadcrumb-link">All Cats</a>
  </li>
  <li class="breadcrumb-item">Cat Edit</li>
@endsection




@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('cats.update',$data->id) }}">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="name" class="@error('name') text-danger @enderror">
              Name
              @error('name')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="name" value="{{$data->name}}" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          </div>

          <div class="row">
            <div class="col-sm-6 ml-1">
              <p class="text-left">
                <button type="submit" class="btn btn-space btn-primary">Update</button>
              </p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
