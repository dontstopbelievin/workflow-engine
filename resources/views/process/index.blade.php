@extends('layouts.master')

@section('title')
    Процессы
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Список Процессов </h3>
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
                                <tr class="p-3 mb-5 rounded text-secondary">
                                    <th class="text-center"><h6>№</h6></th>
                                    <th class=" w-25 text-center"><h6>Название</h6></th>
                                    <th class="text-center"><h6>Кол-во дней</h6></th>
                                    <th colspan="2" class="text-center"><h6>Действия</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($processes as $process)
                                    <tr class="p-3 mb-5 rounded">
                                        <td class="text-center border align-middle"><a href="{{ route('processes.view', ['process' => $process]) }}"><h4>{{$process->id}}</h4></a></td>
                                        <td class="w-25 text-center border align-middle"><h4>{{$process->name}}</h4></td>
                                        <td class="text-center border align-middle"><h4>{{$process->deadline}}</h4></td>
                                        <td class="text-right align-middle">
                                            <button class="rounded-circle bg-white" onclick="window.location='{{route('processes.edit', ['process' => $process])}}'">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill rounded cicrle" fill="blue" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                </svg>
                                            </button>
                                        </td>
                                        <td class="text-left align-middle">
                                            <form action="{{ route('processes.delete', ['process' => $process]) }}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="rounded-circle bg-white"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill border-light" fill="red" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                    </svg>
                                                </button>
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
    <a href="{{ route('processes.create') }}" class="btn btn-info btn-lg my-5">Создать Процесс</a>
@endsection

@section('scripts')

@endsection