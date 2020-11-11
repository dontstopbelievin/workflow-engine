@extends('layouts.master')

@section('title')
    Поступившие заявки
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Поступившие заявки</h3>
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
