@extends('layouts.master')

@section('title')
    Процессы
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Список Процессов</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        
                        <a href="/process/create" class="btn btn-primary">Создать Процесс</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection