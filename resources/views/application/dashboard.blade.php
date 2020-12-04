
@extends('layouts.master')

@section('title')
    Услуги
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Все услуги</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="p-3 mb-5 rounded text-secondary">
                                    <th class="text-center border-0"><h6>№</h6></th>
                                    <th class="text-left border-0"><h6>Наименование услуги</h6></th>
                                    <th class="text-center border-0"><h6>Действия</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($processes as $process)
                                <tr class="p-3 mb-5 rounded">
                                    <td class="text-center align-middle border"><h5>{{$loop->iteration}}</h5></td>
                                    <td class="text-left align-middle border"><h5>{{$process->name}}</h5></td>
                                    @if($process->name == 'Выдача выписки об учетной записи договора о долевом участии в жилищном строительства')
                                        <td class="text-center align-middle border">
                                            <button class="rounded-circle bg-white active:border-0" onclick="window.location='http://qazreestr.kz:8180/rddu/private/cabinet.jsp'">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                </svg>
                                            </button>
                                        </td>
                                        @else
                                    <td class="text-center align-middle border">
                                        <button class="rounded-circle bg-white active:border-0" onclick="window.location='{{route('applications.index', ['process' => $process])}}'">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                            </svg>
                                        </button>
                                    </td>
                                        @endif
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
