@extends('layouts.app')

@section('title')
    Создание Шаблона
@endsection

@section('content')

<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <button id="addNew" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
            </div>
            <div class="col-md-6 text-center">
              <h5>Поле: {{$field->label_name}}</h5>
            </div>
          </div>
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
        </div>
        <div class="card-body">
          <table class="table table-hover" id="items">
            <thead>
              <tr>
                <th>Заголовок</th>
                <th>Текст</th>
                <th>Действие</th>
              </tr>
            </thead>
            <tbody>
              @foreach($def_values as $item)
                  <tr>
                      <td>{{$item->title}}</td>
                      <td>{{$item->text}}</td>
                      <td>
                      	<form action="{{ url('admin/template_field/def_val/delete', [$item->id]) }}" method="post">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-outline-danger btn-xs" style="margin:3px;">Удалить</button>
                      	</form>
                      </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          <a href="{{ url('admin/template_field/create', [$template])}}" class="btn btn-primary">Назад</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title" id="title">Добавить новое значение</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      	<form action="{{ url('admin/template_field/def_val/store') }}" method="POST">
            {{ csrf_field( )}}
            <input type="hidden" name="field_id" value="{{$field->id}}">
			<div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" id="title" class="form-control">
			</div>
			<div class="form-group">
	          <label for="default_value">Текст</label>
	            <textarea name="text" rows="3" class="form-control" id="default_value"></textarea>
	        </div>
			<div>
	            <button type="submit" class="btn btn-success">Добавить</button>
			</div>
    	</form>
      </div>
    </div>
  </div>
</div>
@endsection