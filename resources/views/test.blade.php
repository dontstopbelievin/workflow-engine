@foreach ($data as $key => $items)
	<p>{{$key}}:</p>
    @foreach ($items as $item)
    	<p>{{ $item }}</p>
	@endforeach
@endforeach