@extends('layouts.master')

@section('title')
   Справочник
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Список Полей | Всего: {{$handbookCount}}</h3>
                        </div>
                        <div class="panel-body" id="items">
                            <ul class="list-group">
                                @foreach($columns as $item)
                                    <li class="list-group-item ourItem">{{$item}}
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
