@extends('layouts.app')

@section('title')
Государственные услуги
@endsection

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
                        @if(Auth::user()->has_not_accepted_agreement === 1 && Auth::user()->name !== 'Admin')
                            <div id="acceptModalId" class="modal" data-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Внимание!</h5>

                                        </div>
                                        <div class="modal-body">
                                            <p>Ведется логирование вашей учетной записи. Ваши действия записываются в базу данных. За любые противоправные действия на Портале, вы несете ответственность в соответствии с законодательством Республики Казахстан.
                                        </div>
                                        <div class="modal-footer" style="display: flex;justify-content: space-between;">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-info btn-lg" id="acceptModalButton">Я согласен</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>НАИМЕНОВАНИЕ УСЛУГИ</th>
                                    <th style="text-align:center;">СОЗДАТЬ</th>
                                </tr>
                            </thead>
                            <tbody>
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
                        @if ($modalPopup && Auth::user()->name === 'Admin')
                            <div id="acceptModal" class="modal" data-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Пользовательское соглашение</h5>

                                        </div>
                                        <div class="modal-body">
                                            <p>1.1. Ответственность Администратора. <br>

                                                1.1.1. Администратор обязуется обеспечить стабильную работу Сервисов,
                                                постепенное их совершенствование, максимально быстрое исправление ошибок в
                                                работе Сервисов, однако Сервисы предоставляются Пользователю по принципу
                                                «как есть». Это означает, что Администратор:<br>

                                                а) не гарантирует отсутствие ошибок в работе Сервисов; не несет
                                                ответственность за их бесперебойную работу, их совместимость с программным
                                                обеспечением и техническими средствами Пользователя и иных лиц; не несет
                                                ответственность за потерю Материалов или за причинение любых убытков,
                                                которые возникли или могут возникнуть в связи с или при пользовании
                                                Сервисами; не несет ответственности, связанной с любым искажением,
                                                изменением, оптической иллюзией изображений, фото−, видео− и иных Материалов
                                                Пользователя, которое может произойти или производится при пользовании
                                                Сервисами, даже если это вызовет насмешки, скандал, осуждение или
                                                пренебрежение;<br>

                                                б) не несет ответственность за неисполнение, либо ненадлежащее исполнение
                                                своих обязательств вследствие сбоев в телекоммуникационных и энергетических
                                                сетях, действий вредоносных программ, а также недобросовестных действий
                                                третьих лиц, направленных на несанкционированный доступ и (или) выведение из
                                                строя программного и (или) аппаратного комплекса Администратора.<br>

                                                1.1.2. Пользователь принимает тот факт, что Администратор ни при каких
                                                обстоятельствах не несет ответственности за содержание опубликованных,
                                                отправленных Пользователем или полученных им от других Пользователей
                                                Материалов.<br>

                                                1.1.3. Администратор не обязуется контролировать содержание Материалов и ни
                                                при каких обстоятельствах не несет ответственность за соответствие их
                                                требованиям законодательства, а также за возможное нарушение прав третьих
                                                лиц в связи с размещением Материалов при/или в связи с использованием
                                                Сервисов.<br>
                                        </div>
                                        <div class="modal-footer" style="display: flex;justify-content: space-between;">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-info btn-lg" id="acceptButton">Я
                                                    согласен</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->has_not_accepted_agreement === 1 && Auth::user()->name !== 'Admin')
                            <div id="acceptModalId" class="modal" data-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Внимание!</h5>

                                        </div>
                                        <div class="modal-body">
                                            <p>Ведется логирование вашей учетной записи. Ваши действия записываются в базу
                                                данных. За любые противоправные действия на Портале, вы несете
                                                ответственность в соответствии с законодательством Республики Казахстан.
                                        </div>
                                        <div class="modal-footer" style="display: flex;justify-content: space-between;">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-info btn-lg" id="acceptModalButton">
                                                    Я согласен</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('input[type="checkbox"]').click(function() {
                var inputCheck = $('input[type="checkbox"]').prop("checked");
                if (inputCheck == false) {
                    $('#acceptButton').prop("disabled","true");
                } else if(inputCheck == true){

                    $('#acceptButton').removeAttr("disabled");
                    // $('#acceptButton').prop("disabled","false");
                };
            });
            $("#acceptModal").modal('show');
            $("#acceptModalId").modal('show');

            $('#acceptButton').click(function(event) {

                $.post('/agreement_accept', {accepted:true, '_token':$('input[name=_token]').val()}, function(data){
                    $('#acceptModal').modal('hide');
                    if(data.message)
                    {location.reload();}
                    else{
                      alert('Ошибка');  
                    }
                });
            });

            $('#acceptModalButton').click(function(event) {

                $.post('/agreement_accept', {accepted:true, '_token':$('input[name=_token]').val()}, function(data){
                    $('#acceptModalId').modal('hide');
                    if(data.message)
                    {location.reload();}
                    else{
                      alert('Ошибка');  
                    }
                });
            });
        });
    </script>
@append