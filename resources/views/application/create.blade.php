@extends('layouts.master')

@section('title')
    Создание Заявки
@endsection

@section('content')
  <div class="main-panel">
    <div class="content">
      <div class="container-fluid">
        <h4 class="page-title">Создание заявки "{{$process->name}}"</h4>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @foreach($arrayToFront as $item)
                    <label>{{$item["labelName"]}}</label>
                    @if($item["inputName"] === 'file')
                        <input type="file" name={{$item["name"]}}  multiple><br><br>
                    @elseif($item["inputName"] === 'text')
                        {{--{{dd($egkn)}}--}}
                        <input type="text" name={{$item["name"]}} id={{$item["name"]}} value="{{$egkn->firstname ?? ''}}" class="form-control">
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
@endsection

@section('scripts')
@endsection
