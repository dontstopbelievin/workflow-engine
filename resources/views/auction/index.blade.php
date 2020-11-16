@extends('layouts.master')

@section('title')
    Аукцион
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Аукцион</h3>
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
                                        <td class="text-left align-middle"><a href="{{route('auction.view', ['id' => $field->id])}}"><i class="fa fa-eye" style="font-size:36px"></i></a></td>
                                        <td class="text-left align-middle"><a href="{{route('auction.sender', ['id' => $field->id])}}"><i class="fa fa-upload" style="font-size:36px"></i></a></td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <a href="{{route('auction.create')}}"  class="btn btn-info btn-lg my-5">Создать Лот</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
@endsection
