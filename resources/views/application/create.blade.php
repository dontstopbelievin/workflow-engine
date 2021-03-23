@extends('layouts.app')

@section('title')
    Создание Заявки
@endsection

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="page-title">
                    <a href="{{ url('docs/index/'.$process->id) }}" class="btn btn-info" style="margin-right: 10px;">Назад</a>Создание заявки "{{$process->name}}"
                </h4>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <div class="card-body">
              <div class="col-md-6">
                <form action="{{ url('docs/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach($arrayToFront as $item)
                        <label>{{$item->labelName}}</label>
                        @if($item->inputName === 'file')
                            <input type="file" name={{$item->name}} class="form-control" multiple>
                        @elseif($item->inputName === 'text')
                            {{--{{dd($egkn)}}--}}
                            <input type="text" name={{$item->name}} id={{$item->name}} value="{{$egkn->firstname ?? ''}}" class="form-control">
                        @elseif($item->inputName === 'url')
                            <input type="text" name={{$item->name}} id={{$item->name}} class="form-control">
                        @elseif($item->inputName === 'image')
                            <input type="file" name={{$item->name}} id={{$item->name}} class="form-control">
                        @else
                            <select name="{{$item->name}}" id="{{$item->name}}" class="form-control">
                                <label>$item->name</label>
                                <option selected disabled>Выберите Ниже</option>
                                @foreach($item->options as $val)
                                    <option value="{{$val->name_rus}}">{{$val->name_rus}}</option>
                                @endforeach
                            </select>
                        @endif
                    @endforeach
                    <input type="hidden" name="process_id" value = {{$process->id}}>
                    <div style="margin-top: 20px">
                        <button type="Submit" class="btn btn-secondary">Создать</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection