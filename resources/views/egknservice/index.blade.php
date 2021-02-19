@extends('layouts.app')

@section('title')
    Поступившие заявки
@endsection

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-white">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ url('admin/egknservice/load') }}"
                                            class="btn btn-info float-left">Обновить</a>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="page-title text-center">Поступившие заявки</h4>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
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
                                            <th><button class="btn btn-success btn-sm rounded-0" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Изменить"><i
                                                        class="fa fa-edit"></i></button></th>
                                        </thead>
                                        @isset($aFields)
                                            @foreach ($aFields as $field)
                                                <tbody>
                                                    <tr class="p-3 mb-5 rounded">
                                                        <td class="text-left align-middle">{{ $field->id }}</td>
                                                        <td class="text-left align-middle">{{ $field->egkn_reg_number }}</td>
                                                        <td class="text-left align-middle">{{ $field->receipt_date }}</td>
                                                        <td class="text-left align-middle">
                                                            {{ $field->surname . ' ' . $field->firstname . ' ' . $field->middlename }}
                                                        </td>
                                                        <td class="text-left align-middle">{{ $field->egkn_status }}</td>
                                                        <td class="text-left align-middle">{{ $field->execution_date }}</td>

                                                        <td class="text-left align-middle"><a
                                                                href="{{ url('admin/egknservice/view', ['id' => $field->id]) }}"><i
                                                                    class="fa fa-eye" style="font-size:24px"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            @endforeach
                                        @endisset
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
