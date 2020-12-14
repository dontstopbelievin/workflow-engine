
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
                <div class="card-body" id="items">

                    @if($modalPopup && Auth::user()->name === 'Admin')
                        <div id="acceptModal" class="modal" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Пользовательское соглашение</h5>

                                    </div>
                                    <div class="modal-body">
                                        <p>1.1. Ответственность Администратора. <br>

                                            1.1.1. Администратор обязуется обеспечить стабильную работу Сервисов, постепенное их совершенствование, максимально быстрое исправление ошибок в работе Сервисов, однако Сервисы предоставляются Пользователю по принципу «как есть». Это означает, что Администратор:<br>

                                            а) не гарантирует отсутствие ошибок в работе Сервисов; не несет ответственность за их бесперебойную работу, их совместимость с программным обеспечением и техническими средствами Пользователя и иных лиц; не несет ответственность за потерю Материалов или за причинение любых убытков, которые возникли или могут возникнуть в связи с или при пользовании Сервисами; не несет ответственности, связанной с любым искажением, изменением, оптической иллюзией изображений, фото−, видео− и иных Материалов Пользователя, которое может произойти или производится при пользовании Сервисами, даже если это вызовет насмешки, скандал, осуждение или пренебрежение;<br>

                                            б) не несет ответственность за неисполнение, либо ненадлежащее исполнение своих обязательств вследствие сбоев в телекоммуникационных и энергетических сетях, действий вредоносных программ, а также недобросовестных действий третьих лиц, направленных на несанкционированный доступ и (или) выведение из строя программного и (или) аппаратного комплекса Администратора.<br>

                                           1.1.2. Пользователь принимает тот факт, что Администратор ни при каких обстоятельствах не несет ответственности за содержание опубликованных, отправленных Пользователем или полученных им от других Пользователей Материалов.<br>

                                            1.1.3. Администратор не обязуется контролировать содержание Материалов и ни при каких обстоятельствах не несет ответственность за соответствие их требованиям законодательства, а также за возможное нарушение прав третьих лиц в связи с размещением Материалов при/или в связи с использованием Сервисов.<br>
                                    </div>
                                    <div class="modal-footer" style="display: flex;justify-content: space-between;">
                                        {{--<div class="checkbox pull-left">--}}
                                            {{--<label><input type="checkbox" id="acceptId" value="">Я согласен</label>--}}
                                        {{--</div>--}}
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-info btn-lg" id="acceptButton">Я согласен</button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                            {{--<div class="checkbox pull-left">--}}
                                                {{--<label><input type="checkbox" id="acceptId" value="">Я согласен</label>--}}
                                            {{--</div>--}}
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-info btn-lg" id="acceptModalButton">Я согласен</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
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
    {{csrf_field()}}
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
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

                $.post('/agreement-accept', {accepted:true, '_token':$('input[name=_token]').val()}, function(data){
                    $('#acceptModal').modal('hide');
                });
            });

            $('#acceptModalButton').click(function(event) {

                $.post('/agreement-accept', {accepted:true, '_token':$('input[name=_token]').val()}, function(data){
                    $('#acceptModalId').modal('hide');
                });
            });
        });
    </script>
@endsection

@section('scripts')

@endsection
