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
                            @foreach($fields as $field)
                                <thead>
                                    <tr class="shadow p-3 mb-5 rounded text-secondary">
                                        <th class="text-left border-0"><h6>ИД</h6></th>
                                        <th class="text-left border-0"><h6>Имя</h6></th>
                                        <th class="text-left border-0"><h6>Фамилия</h6></th>
                                        <th class="text-left border-0"><h6>Кадастровый номер</h6></th>
                                        <th class="text-left border-0"><h6>Действия</h6></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="shadow p-3 mb-5 rounded">
                                        <td class="text-left align-middle"><h4>{{$field->id}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->first_name}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->surname}}</h4></td>
                                        <td class="text-left align-middle"><h4>{{$field->cadastre}}</h4></td>
                                        <td class="text-left align-middle"><i class="fa fa-caret-square-o-right" style="font-size:36px"></i></td>
                                    </tr>
                                </tbody>
                            @endforeach
                            </tablе>

                    </div>
                    <a href="{{route('auction.create')}}" class="btn btn-info btn-lg my-5">Создать Поля</a>
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
