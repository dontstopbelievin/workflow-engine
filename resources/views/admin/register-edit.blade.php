@extends('layouts.master')

@section('title')
    Изменение данных пользователя
@endsection

@section('content')

      <div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Изменение данных пользователя</h4>
						<div class="card">
              <form action="{{ route('user-role.update', ['user' => $user]) }}" method="POST">
                {{ csrf_field( )}}
                {{ method_field('PUT') }}
  							<div class="card-body">
  								<div class="form-group">
  									<label for="lotNumber">Имя пользователя</label>
                    <input type="text" name="username" value="{{ $user->name}}" class="form-control">
  								</div>
  								<div class="form-group">
  									<label for="lotNumber">Присвоить роль</label>
                    <select name="role_id" class="form-control" data-dropup-auto="false">
                        @foreach($roles as $role)
                          @if($role->id == Auth::user()->role->id)
                            <option selected value="{{$role->id}}">{{$role->name}}</option>
                          @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                          @endif
                        @endforeach
                    </select>
  								</div>
  							</div>
  							<div class="card-action">
                  <button type="submit" class="btn btn-success">Изменить</button>
                  <a href="{{ route('user-role.register') }}" class="btn btn-danger">Отмена</a>
  							</div>
              </form>
						</div>
					</div>
				</div>
			</div>

@endsection
