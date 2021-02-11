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
                <a href="{{route('egknservice.load')}}"  class="btn btn-info btn-lg my-5">Обновить</a>
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
                                    <tr class="shadow p-3 mb-5 rounded">
                                        <td class="text-left align-middle"><h4>{{$field->id}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->egkn_reg_number}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->receipt_date}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->surname .' '. $field->firstname .' '. $field->middlename}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->egkn_status}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->execution_date}}</h4></td>

                                        <td class="text-left align-middle"><a href="{{route('egknservice.view', ['id' => $field->id])}}"><i class="fa fa-eye" style="font-size:36px"></i></a></td>
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
