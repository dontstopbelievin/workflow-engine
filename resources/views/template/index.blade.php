@extends('layouts.master')

@section('title')
   Шаблоны
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" name="accepted_table">
                        <label for="accepted_table"><h2>Шаблоны одобрения</h2></label>
                            <thead>
                                <tr>
                                    <th>ИД</th>
                                    <th>Название Шаблона</th>
                                    <th>Дата создания</th>
                                    <th>ИЗМЕНИТЬ</th>
                                    <th>УДАЛИТЬ</th>
                                </tr>
                            </thead>
                            <tbody>
                            @isset($accepted_templates)
                                @foreach ($accepted_templates as $template)
                                    <tr>
                                        <td>{{$template->id}}</td>
                                        <td>{{$template->name}}</td>
                                        <td>{{$template->created_at->toDateString() }}</td>
                                        <td><a href="/manual-edit/{{$template->id}}" class="btn btn-success">EDIT</a></td>
                                        <td>
                                            <form action="/manual-delete/{{$template->id}}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-danger">DELETE</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset

                            </tbody>
                        </tablе>
                        <table class="table" name="reject_table">
                        <label for="reject_table"><h2>Шаблоны отказа</h2></label>
                        <thead>
                            <tr>
                            <th>ИД</th>
                            <th>Название Шаблона</th>
                            <th>Дата создания</th>
                            <th>ИЗМЕНИТЬ</th>
                            <th>УДАЛИТЬ</th>
                            </tr>
                        </thead>
                        <tbody>
                        @isset($rejected_templates)
                            @foreach($rejected_templates as $template)
                                <tr>
                                <td>{{$template->id}}</td>
                                        <td>{{$template->name}}</td>
                                        <td>{{$template->created_at->toDateString() }}</td>
                                        <td><a href="/manual-edit/{{$template->id}}" class="btn btn-success">EDIT</a></td>
                                        <td>
                                            <form action="/manual-delete/{{$template->id}}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-danger">DELETE</button>
                                            </form>
                                        </td>
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                        </table>
                        <a href="/templates/create" class="btn btn-primary">Создать Шаблон</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                    

@endsection

@section('scripts')
@endsection