@extends('layouts.master')

@section('title')
    Заявки
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Заявка № {{$aFields[0]['request_number']}}</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($aFields[0]['egkn_status'] == 'Заявка создана')
                        <a href="{{route('egknservice.status', ['id' => $aFields[0]['id']])}}">Зарегистрировать</a>
                    @else
                        <a href="{{route('egknservice.act', ['id' => $aFields[0]['id']])}}">Создать акт выбора</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        {{--@php dd($aFields); @endphp--}}
                        @isset($aFields)
                            <div class="col-xs-6" style="width: 400px">
                                <h4>Заявление</h4>

                                <br> <label for="surname">Фамилия заявителя: </label>
                                {{$aFields[0]['surname']}}
                                <br> <label for="first_name">Имя заявителя: </label>
                                {{$aFields[0]['first_name']}}
                                <br> <label for="middle_name">Отчество заявителя: </label>
                                {{$aFields[0]['middle_name']}}
                                <br> <label for="IIN">ИИН заявителя: </label>
                                {{$aFields[0]['IIN']}}
                                <br> <label for="city">Город заявителя: </label>
                                {{$aFields[0]['city']}}
                                <br> <label for="phone_number">Телефон: </label>
                                {{$aFields[0]['phone_number']}}

                                <h4>Данные объекта</h4>
                                <br> <label for="city">Местоположение участка: </label>
                                {{$aFields[0]['city']}}
                                <br> <label for="pravo_ru">Право: </label>
                                {{$aFields[0]['pravo_ru']}}
                                {{--<br> <label for="area">Площадь: </label>--}}
                                {{--{{$aFields[0]['area']}}--}}
                                <br> <label for="functional_use_ru">Функциональное назначение: </label>
                                {{$aFields[0]['functional_use_ru']}}
                                <br> <label for="landcat_use_ru">Категория земель: </label>
                                {{$aFields[0]['landcat_use_ru']}}
                                {{--<br> <label for="cadastre">Кадастра: </label>--}}
                                {{--{{$aFields[0]['cadastre']}}--}}

                                <h4>Электроснабжение</h4>
                                <br> <label for="power">Выделяемая мощность (лимит) (кВт): </label>
                                {{$aFields[0]['power']}}
                                <br> <label for="one_phase_electricity">Характер нагрузки: Однофазная (кВт): </label>
                                {{$aFields[0]['one_phase_electricity']}}
                                <br> <label for="three_phase_electricity">Характер нагрузки: Трехфазная (кВт): </label>
                                {{$aFields[0]['three_phase_electricity']}}

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

                                <h4>Наличие телефонной связи</h4>
                                <br> <label for="telephone">Телефон: </label>
                                {{$aFields[0]['telephone']}}

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
