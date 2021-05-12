@extends('layouts.app')

<style type="text/css">
	.export_shadow{
		box-shadow: 0px 5px green;
		border-radius: 15px;
		font-color: green;
	}
	.export_table{
		border: 1px solid green;
		box-shadow: 0px 2px 3px #1abf29, 
        -3px 2px 4px #1abf29, 3px 2px 4px #1abf29;
        background-color: #ddd;
	}
</style>
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="page-title">
                            <a href="{{ url('docs') }}" class="btn btn-primary" style="margin-right: 10px;">Назад</a>
                        </h4>
                    </div>
                    <div class="col-md-8">
                        <h4 class="page-title text-center">
                            
                        </h4>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" style="padding-bottom: 20px">
                	<div class="col-md-6 offset-md-3 export_table" style="padding: 0px;">
                		<div class="export_shadow" style="padding-top: 10px;">
	                		<h5 class="text-center"><b style="color:green">ЭКСПОРТИРОВАТЬ ОТЧЕТ ПО ЗАЯВКАМ</b></h5>
	                		<hr/>
	                	</div>
                		<form class="" action="{{ url('user/filter') }}" method="post" class="">
	                      	{{ csrf_field( )}}
	                      	{{ method_field('GET') }}
	                      	<div class="form-group" style="display: inline-block;">
	                        	<label for="date_from"><b>ИНТЕРВАЛ ВРЕМЕНИ: С ДАТЫ</b></label>
	                        	<input type="date" id="date_from" name="date_from">
	                      	</div>
                      		<div class="form-group" style="display: inline-block;">
                        		<label for="date_to"><b>ПО</b></label>
                        		<input type="date" id="date_to" name="date_to">
	                      	</div>
	                      	<div class="form-group">
	                        	<label for="days"><b>ВЫБЕРИТЕ ПРОЦЕСС</b></label>
	                        	<select class="form-control rounded px-3 py-2" name="process" required>
	                          	<option value="no" disabled selected>-</option>
	                          	@foreach($processes as $process)
	                            	<option value="{{$process->id}}">{{$process->name}}</option>
	                          	@endforeach
	                        	</select>
	                      	</div>
	                      	<div class="form-group">
	                        	<label for="days"><b>ВЫБЕРИТЕ СПЕЦИАЛИСТА</b></label>
	                        	<select class="form-control rounded px-3 py-2" name="role_id" required>
	                          	<option value="no" disabled selected>-</option>
	                          	@foreach($roles as $role)
	                            	<option value="{{$role->id}}">{{$role->name}}</option>
	                          	@endforeach
	                        	</select>
	                      	</div>
	                      	<div class="form-group">
	                        	<label for="days"><b>СТАТУС ЗАВЯКИ</b></label>
	                        	<select class="form-control rounded px-3 py-2" name="status_id" required>
	                          		<option value="no" disabled selected>-</option>
	                            	<option value="33">СОГЛАСОВАННЫЙ</option>
	                            	<option value="32">ОТКЛОНЕННЫЙ</option>
	                            	<option value="0">В ПРОЦЕССЕ</option>
	                        	</select>
	                      	</div>
	                      	<div class="form-group text-center">
		                        <button type="submit" name="filter" class="btn btn-primary">Экспортировать</button>
		                    </div>
	                    </form>
	                </div>
            	</div>
            </div>
        </div>
    	</div>
	</div>
</div>
@endsection