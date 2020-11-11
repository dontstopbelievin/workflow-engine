@extends('layouts.master')

@section('title')
    Заявки
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Заявка № {{$aFields[0]['egkn_reg_number']}}</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($aFields[0]['egkn_status'] == 'Заявка создана')
                        <a href="{{route('egknservice.status', ['id' => $aFields[0]['id']])}}">Зарегистрировать</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        @isset($aFields)
                            <div class="col-xs-6" style="width: 400px">
                                <h4>Заявление</h4>

                                <br> <label for="surname">Фамилия заявителя: </label>
                                {{$aFields[0]['surname']}}
                                <br> <label for="firstname">Имя заявителя: </label>
                                {{$aFields[0]['firstname']}}
                                <br> <label for="middlename">Отчество заявителя: </label>
                                {{$aFields[0]['middlename']}}
                                <br> <label for="iin">ИИН заявителя: </label>
                                {{$aFields[0]['iin']}}
                                <br> <label for="city">Город заявителя: </label>
                                {{$aFields[0]['city']}}
                                <br> <label for="phonenumber">Телефон: </label>
                                {{$aFields[0]['phonenumber']}}

                                <h4>Данные объекта</h4>
                                <br> <label for="city">Местоположение участка: </label>
                                {{$aFields[0]['city']}}
                                <br> <label for="right_type">Право: </label>
                                {{$aFields[0]['right_type']}}
                                <br> <label for="area">Площадь: </label>
                                {{$aFields[0]['area']}}
                                <br> <label for="functional_use">Функциональное назначение: </label>
                                {{$aFields[0]['functional_use']}}
                                <br> <label for="land_cat">Категория земель: </label>
                                {{$aFields[0]['land_cat']}}
                                <br> <label for="cadastre">Кадастра: </label>
                                {{$aFields[0]['cadastre']}}
                                <br> <label for="land_cat">Категория земель: </label>
                                {{$aFields[0]['land_cat']}}

                                <h4>Электроснабжение</h4>
                                <br> <label for="power">Выделяемая мощность (лимит) (кВт): </label>
                                {{$aFields[0]['power']}}
                                <br> <label for="one_phase_elec">Характер нагрузки: Однофазная (кВт): </label>
                                {{$aFields[0]['one_phase_elec']}}
                                <br> <label for="three_phase_elec">Характер нагрузки: Трехфазная (кВт): </label>
                                {{$aFields[0]['three_phase_elec']}}

                                <h4>Водоснабжение</h4>
                                <br> <label for="total_need_water_amount">Общая потребность в воде (лимит) (м3/час): </label>
                                {{$aFields[0]['total_need_water_amount']}}
                                <br> <label for="household_water_amount">На хозпитьевые нужды (м3/час): </label>
                                {{$aFields[0]['household_water_amount']}}
                                <br> <label for="industrial_water_amount">На производственные нужды (м3/час): </label>
                                {{$aFields[0]['industrial_water_amount']}}
                                <br> <label for="water_disposal">Водоотведение: </label>
                                {{$aFields[0]['water_disposal']}}

                                <h4>Канализация</h4>
                                <br> <label for="central_sewerage">Центральная канализация: </label>
                                {{$aFields[0]['central_sewerage']}}

                                <h4>Теплоснабжение</h4>
                                <br> <label for="central_heating">Центральное отопление: </label>
                                {{$aFields[0]['central_heating']}}
                                <br> <label for="central_hot_water">Центральная горячая вода: </label>
                                {{$aFields[0]['central_hot_water']}}

                                <h4>Газификация</h4>
                                <br> <label for="gazification">Газ: </label>
                                {{$aFields[0]['gazification']}}
                            </div>
                            <div class="col-xs-6">
                                <h4>Карта</h4>
                                <div style="width: 600px; height: 400px">@include('auction.map')</div>
                                <br> <label for="coordinates">Координаты: </label>
                                {{$aFields[0]['coordinates']}}
                            </div>
                        @endisset
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
