@extends('layouts.app')

@section('title')
    Процессы
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card bg-white">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-3">
                        <a href="{{ url('process/create') }}" class="btn btn-info float-left">Добавить процесс</a>
                      </div>
                      <div class="col-md-6">
                        <h4 class="page-title text-center">
                          Список Процессов
                        </h4>
                      </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @elseif (session('failure'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('failure') }}
                        </div>
                    @endif
                  </div>
  							<!-- <div class="card-header">
  				        <div class="card-title">Table</div>
  				      </div> -->
  							<div class="card-body">
  								<table class="table table-hover">
  									<thead>
  										<tr>
  											<th style="width:7%;">№</th>
  											<th style="width:60%;">НАЗВАНИЕ</th>
  											<th style="width:20%;">КОЛ-ВО ДНЕЙ</th>
  											<th style="width:13%;">ДЕЙСТВИЯ</th>
  										</tr>
  									</thead>
  									<tbody>
                      @foreach($processes as $process)
                        <tr>
                            <td><a href="{{ url('process/view', ['process' => $process]) }}">{{$loop->iteration}}</a></td>
                            <td>{{$process->name}}</td>
                            <td>{{$process->deadline}}</td>
                            <td>
                              <div class="row">
                                <button class="btn btn-link btn-simple-primary" data-original-title="Изменить" onclick="window.location='{{url('process/edit', ['process' => $process])}}'">
                                    <i class="la la-edit"></i>
                                </button>
                                <form action="{{ url('process/delete', ['process' => $process]) }}" method="post">
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
    </div>
  </div>
@endsection