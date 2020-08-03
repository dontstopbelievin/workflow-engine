@extends('layouts.master')

@section('title')
    Process Creation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создание заявки {{$process->name}}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>      
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('applications.store') }}" method="POST"> 
                                @csrf
                                @foreach ($field_keys as $field_key)
                                <div class="form-group">
                                    <label for="name">Please, enter {{$field_key}}</label>
                                    <input type="text" class="form-control" name="{{$field_key}}">
                                    
                                </div>
                                <input type="hidden" name="process_id" value = {{$process->id}}>
                                @endforeach
                                <button type="submit" class="btn btn-basic">Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection