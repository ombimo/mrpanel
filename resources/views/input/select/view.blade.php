@if(empty($url))
  {{ $data }}
@else
  <a href="{{ $url }}">{{ $data }}</a>
@endif