@extends('layouts.app')

@section('title')
    Изменение данных пользователя
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h4>Изменение данных пользователя</h4>
                  </div>
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-6">
                              <form action="{{ url('admin/user_role/update', ['user' => $user]) }}" method="POST">
                                  @csrf
                                  {{ method_field('PUT') }}
                                  <div class="form-group">
                                      <label>Имя пользователя</label>
                                      <input type="text" name="username" value="{{ $user->name}}" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                      <label>Прикрепить роль</label>
                                      <select name="role_id" class="form-control">

                                          @isset($user->role)
                                              <option value="{{$user->role->id}}" selected>{{$user->role->name}}</option>
                                          @endisset
                                          @foreach($roles as $item)
                                              <option value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div>
                                      <button type="submit" class="btn btn-success">Изменить</button>
                                      <a href="{{ url('admin/user_role/register') }}" class="btn btn-danger">Отмена</a>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection