@extends('layouts.master')

@section('title')
    Создание процесса
@endsection
@section('content')

    <body>
        <div class="row mx-auto">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-9">
                                <h1>{{ $process->name }}</h1>
                                @foreach ($parallelRoles as $role)
                                    <h6 class="p-8">{{ $role->name }}</h6>
                                    <select name="priority" id="priority">
                                        @for ($i = 1; $i <= $rolesLen; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="role" id="role" class="w-75">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
