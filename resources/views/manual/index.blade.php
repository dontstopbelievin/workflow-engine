@extends('layouts.master')

@section('title')
   Справочник
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Справочник</h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>ID</th>
                                <th>Field Name</th>
                                <th>Created At</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </thead>
                            <tbody>
                                @foreach($fieldValue as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->field_name}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td><a href="/manual-edit/{{$value->id}}" class="btn btn-success">EDIT</a></td>
                                    <td>
                                        <form action="/manual-delete/{{$value->id}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="/manual/create" class="btn btn-primary">Please, create a field</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection