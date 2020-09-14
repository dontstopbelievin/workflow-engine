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
                                @foreach($arrayToFront as $item)
                                    <label>{{$item["name"]}}</label>
                                    @if($item["inputName"] === 'file')
                                        <input type="file" name={{$item["name"]}} multiple><br><br>
                                    @elseif($item["inputName"] === 'text')
                                        <input type="text" name={{$item["name"]}} id={{$item["name"]}} class="form-control">
                                    @elseif($item["inputName"] === 'url')
                                        <input type="text" name={{$item["name"]}} id={{$item["name"]}} class="form-control" >
                                    @elseif($item["inputName"] === 'image')
                                        <input type="file" name={{$item["name"]}} id={{$item["name"]}} class="form-control">
                                    @else
                                        <select name="{{$item["name"]}}" id="{{$item["name"]}}" class="form-control">
                                            <option selected disabled>Выберите Ниже</option>
                                            @foreach($item["inputName"] as $key=>$val)
                                                <option>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                @endforeach
                                <input type="hidden" name="process_id" value = {{$process->id}}>
                                <button type="Submit" class="btn btn-secondary">Создать</button>
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
