@extends('layouts.app')

@section('title')
   Изменение Роли
@endsection

@section('content')
<div class="main-panel">
	<div class="content">
		<div class="container-fluid">
			<div class="card">
                <dir class="card-header">
                    <h4 class="page-title">Изменение Роли {{$role->name}}</h4>
                </dir>
                <form action="{{ url('role/update', ['role' => $role]) }}" method="POST">
                    {{ csrf_field( )}}
                    {{ method_field('PUT') }}
                <div class="card-body">
					<div class="form-group">
                        <label>Наиманование роли</label>
                        <input type="text" name="name" value="{{ $role->name}}" class="form-control">
					</div>
					<div class="form-group">
                        <label>Организация</label>
                        <select name="city_management_id" class="form-control">
                            @isset($role->cityManagement->id)
                                <option value="{{$role->cityManagement->id}}" selected>{{$role->cityManagement->name}}</option>
                            @endisset
                            @foreach($cityManagements as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
					</div>
				</div>
				<div class="card-action">
                    <button type="submit" class="btn btn-success">Изменить</button>
                    <a href="{{ url('role') }}" class="btn btn-danger">Отмена</a>
				</div>
            </form>
			</div>
		</div>
	</div>
</div>
@endsection