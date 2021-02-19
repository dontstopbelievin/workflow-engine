@extends('layouts.app')

@section('title')
    Аукцион
@endsection

@section('content')
    <div class="main-panel">
    	<div class="content">
    		<div class="container-fluid">
    			<h4 class="page-title">Торги · <a href="#">Прямое предоставление ЗУ</a></h4>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
    			<a href="{{url('auction/create')}}" class="btn btn-info">Добавить лот</a><br><br>
    			<div class="card">
    				<div class="card-body">
    					<table class="table table-hover">
                            <thead class="text-primary">
                                <th>Номер лота</th>
                                <th>Местоположение земельного участка</th>
                                <th>Целевое назначение земельного участка</th>
                                <th>Площадь земельного участка (га)</th>
                                <th>Дата и время проведения аукциона</th>
                                <th>Статус</th>
                                <th>Дата публикации</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                </thead>
                            @foreach($fields as $field)
                                <tbody>
                                    <tr class="shadow p-3 mb-5 rounded">
                                        <td class="text-left align-middle"><h4>{{$field->lot_number}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->address_rus}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->purpose}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->area}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->auction_date_time}}</h4></td>
                                        <td class="text-left align-middle"><h4>@switch($field->lot_status)
                                                    @case(1)
                                                    Предстоящий
                                                    @break
                                                    @case(2)
                                                    Несостоявшийся
                                                    @break
                                                    @case(3)
                                                    Состоявшийся
                                                    @break
                                                @endswitch</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->publish_date}}</h4></td>
                                        <td class="text-left align-middle"><a href="{{url('auction/view', ['id' => $field->id])}}"><i class="fa fa-eye" style="font-size:36px"></i></a></td>
                                        <td class="text-left align-middle"><a href="{{url('auction/send', ['id' => $field->id])}}"><i class="fa fa-upload" style="font-size:36px"></i></a></td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <a href="{{url('auction/create')}}"  class="btn btn-info btn-lg my-5">Создать Лот</a>
                </div>
            </div>
        </div>
    </div>
@endsection