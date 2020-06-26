@extends('layouts.master')

@section('title')
   Шаблоны
@endsection

@section('content')
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
                        <h4 class="card-title">Шаблоны одобрения</h4>
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Название Шаблона</th>
                                    <th>Дата создания</th>
                                    <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                    <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                            @isset($accepted_templates)
                                @foreach ($accepted_templates as $template)
                                    <tr>
                                        <td>{{$template->id}}</td>
                                        <td>{{$template->name}}</td>
                                        <td>{{$template->created_at->toDateString() }}</td>
                                        <td><a href="/manual-edit/{{$template->id}}" class="btn btn-success">Изменить</a></td>
                                        <td>
                                            <form action="/template-delete/{{$template->id}}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('Удалить')}}
                                                <button type="submit" class="btn btn-danger">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset

                            </tbody>
                        </tablе>
                        <table class="table" name="reject_table">
                        <h4 class="card-title">Шаблоны отказа</h4>
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Название Шаблона</th>
                                <th>Дата создания</th>
                                <th><button class="btn btn-success btn-sm px-auto" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                               
                                <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                        @isset($rejected_templates)
                            @foreach($rejected_templates as $template)
                                <tr>
                                    <td>{{$template->id}}</td>
                                    <td>{{$template->name}}</td>
                                    <td>{{$template->created_at->toDateString() }}</td>
                                    <td><a href="/template-edit/{{$template->id}}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                    <td>
                                        <form action="/template-delete/{{$template->id}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
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
@endsection

@section('scripts')
@endsection