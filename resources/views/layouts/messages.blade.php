@if ($message = Session::get('success'))
    <div class="my_message alert alert-success alert-block">
        <button type="button" class="close" data-item="success" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    {{session()->forget('success')}}
@endif


@if ($message = Session::get('error'))
    @if(is_array($message))
        <div class="my_message alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            @foreach($message as $m)
                <strong>{{ $m }}</strong><br/>
            @endforeach
        </div>
    @else
        <div class="my_message alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    {{session()->forget('error')}}
@endif


@if ($message = Session::get('warning'))
    <div class="my_message alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    {{session()->forget('warning')}}
@endif


@if ($message = Session::get('info'))
    <div class="my_message alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    {{session()->forget('info')}}
@endif


@if ($errors->any())
    <div class="my_message alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Please check the form below for errors
    </div>
@endif