@extends('layouts.master')

@section('title')
    Услуги
@endsection

@section('content')
    dd($arrayApps);
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Все заявки по услуге {{$process->name}}</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{--{{dd(Auth::user()->role)}}--}}
                    @if (Auth::user()->role->name === 'Заявитель')
                        <a href="{{ route('applications.create', ['process' => $process]) }}" class="btn btn-info btn-lg my-5">Создать Заявку</a>

                        <form action="{{ route('applications.search')}}" method="POST">
                            @csrf
                            <input type="hidden" name="processId" value="{{$process->id}}">
                            <button type="submit">Обновить</button>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="p-3 mb-5 rounded text-secondary">
                                    <th class="text-center border-0"><h6>№</h6></th>
                                    <th class="text-left border-0"><h6>Имя заявителя</h6></th>
                                    <th class="text-left border-0"><h6>Статус заявки</h6></th>
                                    <th class="text-center border-0"><h6>Действия</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($arrayApps as $app)
                                <tr class="p-3 mb-5 rounded">
                                    <td class="text-center align-middle border"><h5>{{$loop->iteration}}</h5></td>
                                    <td class="text-left align-middle border"><h5>{{$app["name"] ?? '' }}</h5></td>
                                    @if($app["status"] === 'Отправлено заявителю на согласование')
                                        <td class="text-left align-middle border"><h5>Отправлено заявителю</h5></td>
                                    @else
                                        <td class="text-left align-middle border"><h5>{{$app["status"] ?? ''}}</h5></td>
                                        @endif
                                        <td class="text-center align-middle border">
                                        <button class="rounded-circle bg-white" onclick="window.location='{{route('applications.view', ['process_id' => $process["id"] , 'application_id' => $app["id"]])}}'">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                            </svg>
                                        </button>
                                    </td>
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
