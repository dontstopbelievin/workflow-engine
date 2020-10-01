@extends('layouts.master')

@section('title')
    Создание процесса
@endsection

@section('content')
    <div class="row w-75 mx-auto">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Создание процесса</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-9">
                            <form action="{{ route('processes.store') }}" method="POST"> 
                                @csrf
                                @empty($process)
                                <div class="form-group">
                                    <label for="name">Наименование</label>
                                    <input type="text" class="form-control" name="name" placeholder="Введите наименование проекта">
                                    <label class="my-3" for="duration">Срок(количество дней)</label>
                                    <input type="number" min="0" class="form-control" name="deadline" placeholder="Введите срок">
                                </div>
                                <button type="submit"  class="btn btn-info btn-lg my-2">Создать</button>
                                @endempty
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
