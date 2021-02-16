@extends('layouts.app')

@section('title')
    Поступившие заявки
@endsection

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Поступившие заявки</h4>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <a href="{{route('egknservice.load')}}"  class="btn btn-info btn-md my-5">Обновить</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary">
                            <th>№</th>
                            <th>Рег. номер заявки</th>
                            <th>Дата поступления</th>
                            <th>Заявитель</th>
                            <th>Статус заявки</th>
                            <th>Срок исполнения</th>
                            <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                        </thead>
                        @isset($aFields)
                            @foreach($aFields as $field)
                                <tbody>
                                    <tr class="shadow-sm p-3 mb-5 rounded">
                                        <td class="text-left align-middle">{{$field->id}}</td>
                                        <td class="text-left align-middle">{{$field->egkn_reg_number}}</td>
                                        <td class="text-left align-middle">{{$field->receipt_date}}</td>
                                        <td class="text-left align-middle">{{$field->surname .' '. $field->firstname .' '. $field->middlename}}</td>
                                        <td class="text-left align-middle">{{$field->egkn_status}}</td>
                                        <td class="text-left align-middle">{{$field->execution_date}}</td>

                                        <td class="text-left align-middle"><a href="{{route('egknservice.view', ['id' => $field->id])}}"><i class="fa fa-eye" style="font-size:24px"></i></a></td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @endisset
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
