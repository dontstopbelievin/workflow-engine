@extends('layouts.master')

@section('title')
    Аукцион
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Аукцион</h4>
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
                                <thead class="text-primary">
                                <th>ИД</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Кадастровый номер</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$field->id}}</td>
                                    <td>{{$field->first_name}}</td>
                                    <td>{{$field->surname}}</td>
                                    <td>{{$field->cadastre}}</td>
                                    <td><i class="fa fa-caret-square-o-right" style="font-size:36px"></i></td>
                                </tr>
                                </tbody>
                            @endforeach
                            </tablе>

                    </div>
                    <a href="{{route('auction.create')}}" class="btn btn-primary">Создать Поля</a>
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
