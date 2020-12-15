@extends('layouts.master')

@section('title')
    Создание процесса
@endsection

@section('content')
    <div class="row w-75 mx-auto">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Логи сервиса</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-9">
                            {{--@foreach($logsArr as $arr)--}}
                                {{--<h6>{{$loop->iteration}} {{$arr}}</h6>--}}
                            {{--@endforeach--}}

                            @for($i = sizeof($logsArr)-1; $i >= 0; $i-- )
                                <h6>{{sizeof($logsArr) - $i }}. {{$logsArr[$i]}}</h6>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
