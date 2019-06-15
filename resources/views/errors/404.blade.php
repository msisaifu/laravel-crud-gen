@if(Auth::id())
@include('pages.404')
@else
<h2>404</h2>
@endif