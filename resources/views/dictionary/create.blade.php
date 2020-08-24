@extends('layouts.master')

@section('title')
    Process Creation
@endsection



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Создание полей</h3>
                        </div>
                        <div class="panel-body" id="items">

                            <form action="/dictionary/saveToTable" method="POST">
                                @csrf

                                @foreach($dictionariesWithOptions as $item)
                                    @if($item["inputName"] === 'text')
                                        <label for="{{$item["name"]}}">{{$item["name"]}}</label>
                                        <input type="text" name={{$item["name"]}} id = {{$item["name"]}} class="form-control">
                                    @elseif($item["inputName"] === 'file')
                                        <label for="{{$item["name"]}}">{{$item["name"]}}</label>
                                        <input type="file" name={{$item["name"]}} id = {{$item["name"]}} class="form-control">
                                    @elseif($item["inputName"] === 'select')
                                        <label for="{{$item["name"]}}">{{$item["name"]}}</label>
                                        <input type="file" name={{$item["name"]}} id = {{$item["name"]}} class="form-control">
                                        @else
                                        <label for="{{$item["name"]}}">{{$item["name"]}}</label>
                                        <select name="{{$item["name"]}}" id="{{$item["name"]}}" class="form-control">
                                            <option selected disabled>Выберите Ниже</option>
                                            @foreach($item["inputName"] as $key=>$val)
                                                <option>{{$val}}</option>
                                            @endforeach
                                        </select>

                                    @endif

                                @endforeach
                                <button type="Submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


