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
            <div class="card">
              <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  @csrf
                  @foreach($arrayToFront as $item)
                      <label>{{$item["labelName"]}}</label>
                      @if($item["inputName"] === 'file')
                        <div class="form-group">
                          <input type="file" name={{$item["name"]}} multiple><br><br>
                        </div>
                      @elseif($item["inputName"] === 'text')
                        <div class="form-group">
                          <input type="text" name={{$item["name"]}} id={{$item["name"]}} class="form-control">
                        </div>
                      @elseif($item["inputName"] === 'url')
                      <div class="form-group">
                        <input type="text" name={{$item["name"]}} id={{$item["name"]}} class="form-control" >
                      </div>
                      @elseif($item["inputName"] === 'image')
                      <div class="">
                        <input type="file" name={{$item["name"]}} id={{$item["name"]}} class="form-control">
                      </div>
                      @else
                      <div class="form-group">
                        <select name="{{$item["name"]}}" id="{{$item["name"]}}" class="form-control" data-dropup-auto="false">
                            <option selected disabled>Выберите Ниже</option>
                            @foreach($item["inputName"] as $key=>$val)
                                <option>{{$val}}</option>
                            @endforeach
                        </select>
                      </div>
                      @endif
                  @endforeach
                </div>
                <div class="card-action">
                  <input type="hidden" name="process_id" value = {{$process->id}}>
                  <button type="submit" class="btn btn-primary">Создать</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
@endsection
