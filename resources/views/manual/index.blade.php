@extends('layouts.master')

@section('title')
   Справочник
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Справочник | Всего: {{$handbookCount}}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <label for="list">Название Полей</label>
                        <ul class="list-group" id="list">
                        @foreach($columns as $column)
                            <li class="list-group-item">{{$column}}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection