@extends('layouts.master')

@section('title')
    Процессы
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Список Процессов | Всего: {{$processesCount}}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>№</th>
                                <th>Название</th>
                                <th>Кол-во дней</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </thead>
                            <tbody>
                            
                                @foreach($processes as $process)
                              <tr>
                                <td><a href="{{ route('processes.view', ['process' => $process]) }}">{{$process->id}}</a></td>
                                <td>{{$process->name}}</td>
                                <td>{{$process->deadline}}</td>

                                <td><a href="{{ route('processes.edit', ['process' => $process]) }}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                <td>
                                    <form action="{{ route('processes.delete', ['process' => $process]) }}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                    </form>
                                </td>  
                              </tr>   
                              @endforeach                             
                            </tbody>
                        </tablе>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('processes.create') }}" class="btn btn-primary">Создать Процесс</a>
@endsection

@section('scripts')

@endsection