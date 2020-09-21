@extends('layouts.master')

@section('title')
    Process Creation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создание процесса</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('processes.store') }}" method="POST"> 
                                @csrf
                                @empty($process)
                                <div class="form-group">
                                        <label for="name">Наименование</label>
                                        <input type="text" class="form-control" name="name" placeholder="Введите наименование проекта">
                                        <label for="duration">Срок(количество дней)</label>
                                        <input type="number" min="0" class="form-control" name="deadline" placeholder="Введите срок">
                                </div>
                                <button type="submit" class="btn btn-basic">Сохранить</button>
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
