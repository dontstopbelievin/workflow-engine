@extends('layouts.app')

@section('title')
    Создание Полей Аукциона
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Добавить/редактировать аукцион</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        @isset($aAuctionRaws)
                            <div class="col-xs-6" style="width: 400px">
                                <h4>Поля для аукциона</h4>
                                <br> <label for="LotID">Идентификатор лота (id)</label> {{$aAuctionRaws[0]['lot_id']}}
                                <br> <label for="LotNumber">№ лота</label> {{$aAuctionRaws[0]['lot_number']}}
                                <br> <label for="EgknID">EGKNID</label> {{$aAuctionRaws[0]['egkn_id']}}
                                <br> <label for="StatusZU">Статус ЗУ</label> {{$aAuctionRaws[0]['status_zu'] == 'free' ? 'свободный ЗУ' : 'аукцион/торги'}}
                                <br> <label for="PublishDate">Дата публикации в газете</label> {{$aAuctionRaws[0]['publish_date']}}
                                <br> <label for="RentLease">Срок аренды, дата. Напоимер, до 01.01.2025</label> {{$aAuctionRaws[0]['rent_lease']}}
                                <br> <label for="RentConditionsRus">Условия аренды рус.яз.</label> {{$aAuctionRaws[0]['rent_conditions_rus']}}
                                <br> <label for="RentConditionsKaz">Условия аренды каз.яз.</label> {{$aAuctionRaws[0]['rent_conditions_kaz']}}
                                <br> <label for="Area">Площадь, га.</label> {{$aAuctionRaws[0]['area']}}
                                <br> <label for="CadastreCost">Кадастровая стоимость, тг.</label> {{$aAuctionRaws[0]['cadastre_cost']}}
                                <br> <label for="StartCost">Начальная стоимость, тг.</label> {{$aAuctionRaws[0]['start_cost']}}
                                <br> <label for="TaxCost">Налоговая стоимость, тг.</label> {{$aAuctionRaws[0]['tax_cost']}}
                                <br> <label for="ParticipationCost">Гарантийный взнос, тг.</label> {{$aAuctionRaws[0]['participation_cost']}}
                                <br> <label for="AuctionMethod">Метод аукциона</label> {{$aAuctionRaws[0]['auction_method']}}
                                <br> <label for="AuctionDateTime">Дата. время аукциона. Пр наличии РГИС - дату аукицона определяет РГИС, затем при создании торга в ЭТП - отправляется время в ЕГКН</label> {{$aAuctionRaws[0]['auction_date_time']}}
                                <br> <label for="AuctionPlaceRus">Место проведения аукциона рус.яз.</label> {{$aAuctionRaws[0]['auction_place_rus']}}
                                <br> <label for="AuctionPlaceKaz">Место проведения аукциона рус.яз.</label> {{$aAuctionRaws[0]['auction_place_kaz']}}
                                <br> <label for="RequestAddressRus">Адрес приема заявок рус.яз.</label> {{$aAuctionRaws[0]['request_address_rus']}}
                                <br> <label for="RequestAddressKaz">Адрес приема заявок каз.яз.</label> {{$aAuctionRaws[0]['request_address_kaz']}}
                                <br> <label for="CommentRus">Описание рус.яз.</label> {{$aAuctionRaws[0]['comment_rus']}}
                                <br> <label for="CommentKaz">Описание каз.яз.</label> {{$aAuctionRaws[0]['comment_kaz']}}
                                <br> <label for="AteID">Идентификатор населенного пункта (ИС АР)</label>{{$aAuctionRaws[0]['ate_id']}}
                                <br> <label for="AddressRus">Месторасположение ЗУ рус.яз.</label>{{$aAuctionRaws[0]['address_rus']}}
                                <br> <label for="AddressKaz">Месторасположение ЗУ каз.яз.</label> {{$aAuctionRaws[0]['address_kaz']}}
                                <br> <label for="RestrictionsAndBurdensRus">Ограничения и обременения при наличии кроме ТУ на рус</label> {{$aAuctionRaws[0]['restrictions_and_burdens_rus']}}
                                <br> <label for="RestrictionsAndBurdensKaz">Ограничения и обременения при наличии кроме ТУ на каз</label> {{$aAuctionRaws[0]['restrictions_and_burdens_kaz']}}
                                <br> <label for="InstallmentPeriod">Срок рассрочки, мес</label> {{$aAuctionRaws[0]['installment_period']}}
                                <br> <label for="InstalmentSelling">Продажа в рассчроку</label> {{$aAuctionRaws[0]['is_fl']}}

                                <h4>Продавец (Тип описывающий формат продавца)</h4>
                                <br> <label for="IINBIN">ИИН/БИН</label> {{$aAuctionRaws[0]['iin_bin']}}
                                <br> <label for="NameRus">ФИО/Наименование рус.яз.</label> {{$aAuctionRaws[0]['name_rus']}}
                                <br> <label for="NameKaz">ФИО/Наименование каз.яз.</label> {{$aAuctionRaws[0]['name_kaz']}}
                                <br> <label for="IsFl">ФЛ? Обязательноe поле = true or false</label> {{$aAuctionRaws[0]['is_fl'] == '1' ? 'Да' : 'Нет'}}

                                <h4>Справочники</h4>
                                <br> <label for="Target">Целевое назначение (справочник ЕГКН)</label> {{$aAuctionRaws[0]['target']}}
                                <br> <label for="Purpose">Цель использования (справочник ЕГКН)</label> {{$aAuctionRaws[0]['purpose']}}
                                <br> <label for="RightType">Вид права (справочник ЕГКН)</label> {{$aAuctionRaws[0]['right_type']}}
                                <br> <label for="LandDivisibility">Делимость ЗУ (спарвочник ЕГКН)</label> {{$aAuctionRaws[0]['land_divisibility']}}
                                <br> <label for="LandCategory">Категория земель (спарвочник ЕГКН)</label> {{$aAuctionRaws[0]['land_category']}}

                            </div>
                            <div class="col-xs-6">
                                <div style="width: 600px; height: 400px">@include('auction.map')</div>
                                <br> <label for="Coordinates">Координаты</label> {{$aAuctionRaws[0]['coordinates']}}
                                <br> <label for="CoordinateSystem">Система координат</label> {{$aAuctionRaws[0]['coordinate_system']}}

                                <h4>Технические условия (Тип описывающий формат технических условий)</h4>
                                <br> <label for="ElektrPower">Выделяемая мощность (лимит) (кВт)</label> {{$aAuctionRaws[0]['elektr_power']}}
                                <br> <label for="ElektrFaza1">Характер нагрузки: Однофазная (кВт)</label> {{$aAuctionRaws[0]['elektr_faza_1']}}
                                <br> <label for="ElektrFaza3">Характер нагрузки: Трехфазная (кВт)</label> {{$aAuctionRaws[0]['elektr_faza_3']}}
                                <br> <label for="WaterPower">Общая потребность в воде (лимит) (м3/час)</label> {{$aAuctionRaws[0]['water_power']}}
                                <br> <label for="WaterHoz">На хозпитьевые нужды (м3/час)</label> {{$aAuctionRaws[0]['water_hoz']}}
                                <br> <label for="WaterProduction">На производственные нужды (м3/час)</label> {{$aAuctionRaws[0]['water_production']}}
                                <br> <label for="SeweragePower">Общее количество сточных вод (м3/час)</label> {{$aAuctionRaws[0]['sewerage_power']}}
                                <br> <label for="SewerageFecal">Фекальных (м3/час)</label> {{$aAuctionRaws[0]['sewerage_fecal']}}
                                <br> <label for="SewerageProduction">Производственно-загрязненных (м3/час)</label> {{$aAuctionRaws[0]['sewerage_production']}}
                                <br> <label for="SewerageClean">Условно-чистых сбрасываемых на городскую канализацию (м3/час)</label> {{$aAuctionRaws[0]['sewerage_clean']}}
                                <br> <label for="HeatPower">Общая тепловая нагрузка (лимит) (Гкал/час)</label> {{$aAuctionRaws[0]['heat_power']}}
                                <br> <label for="HeatFiring">Отопление (Гкал/час)</label> {{$aAuctionRaws[0]['heat_firing']}}
                                <br> <label for="HeatVentilation">Вентиляция (Гкал/час)</label> {{$aAuctionRaws[0]['heat_ventilation']}}
                                <br> <label for="HeatHotWater">Горячее водоснабжение (Гкал/час)</label> {{$aAuctionRaws[0]['heat_hot_water']}}
                                <br> <label for="StormWater">Ливневая канализация</label> {{$aAuctionRaws[0]['storm_water']}}
                                <br> <label for="Telekom">Телефонизация</label> {{$aAuctionRaws[0]['telekom']}}
                                <br> <label for="GasPower">Общая потребность (лимит) (м3/час)</label> {{$aAuctionRaws[0]['gas_power']}}
                                <br> <label for="GasOnCooking">На приготовление пищи (м3/час)</label> {{$aAuctionRaws[0]['gas_on_cooking']}}
                                <br> <label for="GasHeating">Отопление</label> {{$aAuctionRaws[0]['gas_heating']}}
                                <br> <label for="GasVentilation">Вентиляция (м3/час)</label> {{$aAuctionRaws[0]['gas_ventilation']}}
                                <br> <label for="GasConditioning">Кондиционирование (м3/час)</label> {{$aAuctionRaws[0]['gas_conditioning']}}
                                <br> <label for="GasHotWater">Горячее водоснабжение при газификации многоэтажных домов (м3/час)</label> {{$aAuctionRaws[0]['gas_hot_water']}}

                                <h4>Итоги</h4>
                                <br> <label for="NoteRus">Примечание рус для ЭТП.</label> "' Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)'"
                                <br> <label for="NoteKaz">Примечание каз для ЭТП.</label> "' Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)'"
                                <br> <label for="LotStatus">Статус лота</label>
                                @switch($aAuctionRaws[0]['lot_status'])
                                    @case(1)
                                        Предстоящий
                                        @break
                                    @case(2)
                                        Несостоявшийся
                                        @break
                                    @case(3)
                                        Состоявшийся
                                        @break
                                 @endswitch
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
