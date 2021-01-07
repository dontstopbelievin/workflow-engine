@extends('layouts.master')

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
				<a href="{{route('auction.create')}}" class="btn btn-info">Добавить лот</a><br><br>
				<div class="card">
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Номер лота</th>
									<th>Местоположение земельного участка</th>
									<th>Целевое назначение земельного участка</th>
									<th>Площадь земельного участка (га)</th>
									<th>Дата и время проведения аукциона</th>
									<th>Статус</th>
									<th>Дата публикации</th>
									<th>Действия</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($fields as $field)
                                  <tr class="shadow p-3 mb-5 rounded">
                                      <td>{{$field->lot_number}}</td>
                                      <td>{{$field->address_rus}}</td>
                                      <td>{{$field->purpose}}</td>
                                      <td>{{$field->area}}</td>
                                      <td>{{$field->auction_date_time}}</td>
                                      <td>{{$field->lot_status}}</td>
                                      <td>{{$field->publish_date}}</td>
                                      <td>

                                        <a href="{{route('auction.sender', ['id' => $field->id])}}"><i class="fa fa-caret-square-o-right" style="font-size:36px"></i></a>
                                      </td>
                                  </tr>
                                @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
