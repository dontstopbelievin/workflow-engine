@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Все заявки по услуге {{$process->name}}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ route('applications.create', ['process' => $process]) }}" class="btn btn-primary">Создать Заявку</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>#</th>
                                <th>Имя заявителя</th>
                                <th>Статус заявки</th>
                            </thead>
                            <tbody>
                            @foreach($arrayApps as $app)
                                  <tr>
                                    <td><a href="{{ route('applications.view', ['process_id' => $process["id"] , 'application_id' => $app["id"]]) }}">{{$app["id"]}}</a></td>
                                    <td>{{$app["name"] ?? '' }}</td>
                                    <td>{{$app["status"] ?? ''}}</td>
                                  </tr>
                            @endforeach
                            </tbody>

                        </tablе>

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
