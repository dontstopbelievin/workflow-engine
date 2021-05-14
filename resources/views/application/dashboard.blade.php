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
    .table_gos_list{
        border-collapse: separate;
    }
    .table_gos_list td {
        border: 1px solid black;
        height: 90px!important;
        width: 33%;
        font-weight: bold;
        cursor: pointer;
    }
    .table_gos_list td:hover .td_1 {
        background-color: #31a93f;
    }
    .table_gos_list td:hover .td_2 {
        background-color: #1a9f29;
        color: white;
    }
    .td_1{
        padding: 15px;
        height: 100%;
        width: 90px;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        background: #f1f1f1;
    }
    .td_2{
        padding: 15px;
        height: 100%;
        width: calc(100% - 90px);
        display: inline-block;
        vertical-align: middle;
        background: #ebebeb;
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
                        <table class="table table_gos_list">
                            <tr>
                            @foreach ($processes as $process)
                                @if ($process->name == 'Выдача выписки об учетной записи договора о долевом участии в жилищном строительства')
                                    <?php $td_url = 'http://qazreestr.kz:8180/rddu/private/cabinet.jsp'; ?>
                                @else
                                    <?php $td_url = url('docs/create', ['process' => $process]); ?>
                                @endif
                                @if($loop->iteration%3 == 0)
                                    <td style="padding: 0px!important;" onclick="window.location='{{$td_url}}'">
                                    <div class="td_1"><img src="images/house.png" class="td_image"></div><div class="td_2">{{mb_strtoupper($process->name)}}</div></td>
                                    </tr><tr>
                                @else
                                    <td style="padding: 0px!important;" onclick="window.location='{{$td_url}}'">
                                        <div class="td_1"><img src="images/house.png" class="td_image"></div><div class="td_2">{{mb_strtoupper($process->name)}}</div></td>
                                @endif
                            @endforeach
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