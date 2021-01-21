@foreach ($data as $key => $items)
	<p>{{$key}}:</p>
	<p>{{$items['data']}}</p>
@endforeach