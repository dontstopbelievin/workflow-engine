@extends('layouts.app')

@section('title')
Государственные услуги
@endsection
<style type="text/css">
  .table td{
    font-size: 16px!important;
  }
  .gos_tabs{
    display: none;
    height: 90px;
    width: 390px;
    padding: 0px!important;
    margin: 0px!important;
  }
  .gos_content{
    width: 100%;
    height:100%;
    text-align: center;
    border: 1px solid black;
    margin: 0px;
  }
</style>
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    @if ((Auth::user()->role->name == 'Заявитель'))
                    <div class="card-header">
                        <h4 class="page-title text-center">ГОСУДАРСТВЕННЫЕ УСЛУГИ</h4>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>НАИМЕНОВАНИЕ УСЛУГИ</th>
                                    <th style="text-align:center;">СОЗДАТЬ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div class="row">
                                    <div class="col-md-4 gos_tabs">
                                        <div class="gos_content">
                                            asdf
                                        </div>
                                    </div>
                                    <div class="col-md-4 gos_tabs">
                                        <div class="gos_content">
                                            asdf
                                        </div>
                                    </div>
                                    <div class="col-md-4 gos_tabs">
                                        <div class="gos_content">
                                            asdf
                                        </div>
                                    </div>
                                </div>
                                @foreach ($processes as $process)
                                    <tr class="p-3 mb-5 rounded">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $process->name }}</td>
                                        @if ($process->name == 'Выдача выписки об учетной записи договора о долевом участии в жилищном строительства')
                                            <td class="text-center align-middle border">
                                                <button class="btn btn-simple-primary px-0 py-0"
                                                    style=" background-color: transparent;font-size:30px;"
                                                    onclick="window.location='http://qazreestr.kz:8180/rddu/private/cabinet.jsp'">
                                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td class="text-center align-middle border">
                                                <button class="btn btn-simple-primary px-0 py-0"
                                                    style=" background-color: transparent;font-size:30px;"
                                                    onclick="window.location='{{ url('docs/create', ['process' => $process]) }}'">
                                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="card-header">
                        <h4 class="page-title text-center">СПИСОК ПРЕДОСТАВЛЯЕМЫХ УСЛУГ ПОРТАЛОМ</h4>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>НАИМЕНОВАНИЕ УСЛУГИ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processes as $process)
                                    <tr class="p-3 mb-5 rounded">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $process->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @include('layouts.user_policies')
                </div>
            </div>
        </div>
    </div>
@endsection