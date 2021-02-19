@extends('layouts.app')

@section('title')
    Создание процесса
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h4 class="page-title">Создание процесса</h4>
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
        </div>
        <form action="{{ url('process/store') }}" method="POST">
          <div class="card-body">
            @csrf
            @empty($process)
            <div class="form-group">
              <label for="name">Наименование</label>
              <input type="text" class="form-control" name="name" placeholder="Введите наименование проекта">
            </div>
            <div class="form-group">
              <label class="my-3" for="duration">Срок(количество дней)</label>
              <input type="number" min="0" class="form-control" name="deadline" placeholder="Введите срок">
            </div>
            @endempty
          </div>
          <div class="card-action">
            <button type="submit" class="btn btn-success">Создать</button>
            <a href="{{ url('process') }}" class="btn btn-info">Назад</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection