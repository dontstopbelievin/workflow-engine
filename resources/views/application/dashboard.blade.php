@extends('layouts.master')

@section('title')
    Услуги
@endsection

@section('content')
    <div class="sidebar">
        <div class="scrollbar-inner sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item">
                    <a class="" role="button" data-toggle="collapse" href="#settings" aria-expanded="false">
                        <i class="la la-navicon"></i>
                        <p>Настройки</p>
                    </a>
                </li>
                <div class="collapse" id="settings">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ route('user.personalArea') }}">
                                <span class="link-collapse">Личный Кабинет</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#">
                                <span class="link-collapse">Edit Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#">
                                <span class="link-collapse">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a href="{{ route('auction.index') }}">
                        <i class="la la-table"></i>
                        <p>Аукцион</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('processes.index') }}">
                        <i class="la la-keyboard-o"></i>
                        <p>Процессы</p>
                        <span class="badge badge-count">{{ $processesCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('role.index') }}">
                        <i class="la la-th"></i>
                        <p>Роли</p>
                        <span class="badge badge-count">{{ $rolesCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('city.index') }}">
                        <i class="la la-bell"></i>
                        <p>Организации</p>
                        <span class="badge badge-count">{{ $cityManagementCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-role.register') }}">
                        <i class="la la-font"></i>
                        <p>Пользователи</p>
                        <span class="badge badge-count">{{ $usersCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dictionary') }}">
                        <i class="la la-fonticons"></i>
                        <p>Справочник</p>
                        <span class="badge badge-count">{{ $dictionariesCount }}</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="{{ route('applications.service') }}">
                        <i class="la la-dashboard"></i>
                        <p>Все услуги</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Все услуги</h4>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <!-- <div class="card-header">
               <div class="card-title">Table</div>
               </div> -->
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
                                            {{--<div class="checkbox pull-left">
                                                --}}
                                                {{--<label><input type="checkbox"
                                                        id="acceptId" value="">Я
                                                    согласен</label>--}}
                                                {{--</div>--}}
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
                                            {{--<div class="checkbox pull-left">
                                                --}}
                                                {{--<label><input type="checkbox"
                                                        id="acceptId" value="">Я
                                                    согласен</label>--}}
                                                {{--</div>--}}
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-info btn-lg" id="acceptModalButton">
                                                    Я согласен</button>
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>НАИМЕНОВАНИЕ УСЛУГИ</th>
                                    <th>ДЕЙСТВИЯ</th>
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
                                                    <i class="la la-arrow-circle-o-right"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td class="text-center align-middle border">
                                                <button class="btn btn-simple-primary px-0 py-0"
                                                    style=" background-color: transparent;font-size:30px;"
                                                    onclick="window.location='{{ route('applications.index', ['process' => $process]) }}'">
                                                    <i class="la la-arrow-circle-o-right"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
