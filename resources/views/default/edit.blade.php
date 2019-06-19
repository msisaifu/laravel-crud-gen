@extends("layouts.app")

@section("title", "{$model} Edit")
@section("pagetitle", "{$model} Edit")
@section("button")
<a href="{{route(str_plural(strtolower($model)).".index")}}" class="float-right btn btn-sm btn-space btn-primary">All {{str_plural($model)}}</a>
@endsection

@section("breadcumb")
  <li class="breadcrumb-item">
    <a href="{{route(str_plural(strtolower($model)).".index")}}" class="breadcrumb-link">All {{str_plural($model)}}</a>
  </li>
  <li class="breadcrumb-item">{{$model}} Edit</li>
@endsection




@section("content")
<div class="row">
  <div class="col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route(str_plural(strtolower($model)).".update",$data->id) }}">
          @csrf
          @method("PUT")

          @foreach($fields as $field)
          @php $val = $field['field'] @endphp

          <div class="form-group">
            <label for="{{$val}}" class="@error($val) text-danger @enderror">
              {{$field['title'] ?? ucfirst($val)}}
              @error($val)
              <br>{{ $message }}
              @enderror
            </label>
            <input id="{{$val}}" type="{{$field['type']}}" class="form-control @error($val) is-invalid @enderror" placeholder="{{$field['placeholder'] ?? ucfirst($val)}}" name="{{$val}}" value="{{ $data->$val }}">
          </div>

          @endforeach

          <div class="row">
            <div class="col-sm-6 ml-1">
              <p class="text-left">
                <button type="submit" class="btn btn-space btn-success">Update</button>
              </p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
