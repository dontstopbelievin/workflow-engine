@extends('layouts.master')

@section('title')
    Создание Ролей
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <h4 class="page-title">Создать Роль</h4>
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif
      <div class="card">
        <form action="{{ route('role.store') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name">Роль</label>
              <input type="text" class="form-control" name="name" placeholder="Введите название роли">
              <span id="emailHelp">Убедитесь, что вводимой Вами роли нет в списке ролей</span>
            </div>
            <div class="form-group">
              <select name="city_management_id" class="form-control" data-dropup-auto="false">
                  @foreach($cityManagements as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="card-action">
            <button type="submit" class="btn btn-success">Создать</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
@endsection
