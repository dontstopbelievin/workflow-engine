@extends('layouts.app')

@section('title')
    Зарегистрированные пользователи
@endsection

@section('content')
  <div class="main-panel">
  	<div class="content">
  		<div class="container-fluid">
  			<div class="card">
  				<div class="card-header">
            <div class="row">
              <div class="col-md-3">
                <button type="button" id="addNew" class="btn btn-info">Добавить пользователя</button>
              </div>
              <div class="col-md-6">
                <h4 class="page-title text-center">Пользователи</h4>
              </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
  	      </div>
  				<div class="card-body">
  					<table class="table table-hover">
              <thead>
                <tr>
                  <th style="width: 7%">№</th>
                  <th style="width: 20%">ИМЯ</th>
                  <th style="width: 15%">ТЕЛЕФОН</th>
                  <th style="width: 15%">ПОЧТА</th>
                  <th style="width: 30%">РОЛЬ</th>
                  <th style="width: 12%">ДЕЙСТВИЯ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->email}}</td>
                        @if ($user->role)
                        <td>{{$user->role->name}}</td>
                        @else
                        <td>-</td>
                        @endif
                        <td>
                          <div class="row">
                            <button class="btn btn-link btn-simple-primary" data-original-title="Изменить" onclick="window.location='{{url('admin/user_role/edit', ['user' => $user])}}'">
                              <i class="la la-edit"></i>
                            </button>
                            <form action="{{ url('admin/user_role/delete', ['user' => $user]) }}" method="post">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-link btn-danger" data-original-title="Удалить">
                                  <i class="la la-times"></i>
                                </button>
                            </form>
                          </div>
                        </td>
                    </tr>
                @endforeach
  						</tbody>
  					</table>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
@endsection