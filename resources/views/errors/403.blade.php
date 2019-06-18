@if(Auth::id())
@include('pages.403')
@else
<h2>401</h2>
@endif