@extends('layouts.master')

@section('title')
    Создание Ролей
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12" >
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Создать Роль</h4>
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif
                  </div>
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-6">
                              <form action="{{ route('role.store') }}" method="POST">
                                  @csrf
                                  <div class="form-group">
                                      <label for="name">Роль</label>
                                      <input type="text" class="form-control" name="name" placeholder="Введите название роли">
                                      <small id="emailHelp" class="form-text text-muted">Убедитесь, что вводимой Вами роли нет в списке ролей</small>
                                  </div>
                                  <select name="city_management_id" class="form-control">
                                      @foreach($cityManagements as $item)
                                          <option value="{{$item->id}}">{{$item->name}}</option>
                                      @endforeach
                                  </select>
                                  <button type="submit" class="btn btn-success">Создать</button>
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

@section('scripts')
@endsection
