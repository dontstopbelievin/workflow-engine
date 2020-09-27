@extends('layouts.master')

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
                        <div class="col-md-6">
                            <form action="{{ route('auction.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <br>

                                    <label for="LotID">Идентификатор лота (id)</label>
                                    <input type="text" class="form-control" name="LotID" id="LotID" required>

                                    <label for="LotStatus">Статус лота</label>
                                    <select name="LotStatus" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">Предстоящий</option>
                                        <option value="2">Несостоявшийся</option>
                                        <option value="3">Состоявшийся</option>
                                    </select>

                                    <label for="LotNumber">№ лота</label>
                                    <input type="text" class="form-control" name="LotNumber" id="LotNumber" required>

                                    <label for="EgknID">EGKNID</label>
                                    <input type="text" class="form-control" name="EgknID" id="EgknID" required>

                                    <label for="StatusZU">Статус ЗУ</label>
                                    <select name="StatusZU" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="free">свободный ЗУ</option>
                                        <option value="auction">аукцион/торги</option>
                                    </select>

                                    <label for="PublishDate">Дата публикации в газете</label>
                                    <input type="date" class="form-control" name="PublishDate" id="PublishDate" required>

                                    <label for="RentLease">Срок аренды, дата. Напоимер, до 01.01.2025</label>
                                    <input type="date" class="form-control" name="RentLease" id="RentLease" required>

                                    <label for="RentConditionsRus">Условия аренды рус.яз.</label>
                                    <input type="text" class="form-control" name="RentConditionsRus" id="RentConditionsRus" required>

                                    <label for="RentConditionsKaz">Условия аренды каз.яз.</label>
                                    <input type="text" class="form-control" name="RentConditionsKaz" id="RentConditionsKaz" required>

                                    <label for="Area">Площадь, га.</label>
                                    <input type="text" class="form-control" name="Area" id="Area" required>

                                    <label for="CadastreCost">Кадастровая стоимость, тг.</label>
                                    <input type="number" class="form-control" name="CadastreCost" id="CadastreCost" required>

                                    <label for="StartCost">Начальная стоимость, тг.</label>
                                    <input type="number" class="form-control" name="StartCost" id="StartCost" required>

                                    <label for="TaxCost">Налоговая стоимость, тг.</label>
                                    <input type="number" class="form-control" name="TaxCost" id="TaxCost" required>

                                    <label for="ParticipationCost">Гарантийный взнос, тг.</label>
                                    <input type="number" class="form-control" name="ParticipationCost" id="ParticipationCost" required>

                                    <label for="AuctionMethod">Метод аукциона</label>
                                    <select name="AuctionMethod" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">английский</option>
                                        <option value="2">голландский</option>
                                    </select>

                                    <label for="AuctionDateTime">Дата. время аукциона. Пр наличии РГИС - дату аукицона определяет РГИС, затем при создании торга в ЭТП - отправляется время в ЕГКН</label>
                                    <input type="datetime-local" class="form-control" name="AuctionDateTime" id="AuctionDateTime" required>

                                    <label for="AuctionPlaceRus">Место проведения аукциона рус.яз.</label>
                                    <input type="text" class="form-control" name="AuctionPlaceRus" id="AuctionPlaceRus" required>

                                    <label for="AuctionPlaceKaz">Место проведения аукциона рус.яз.</label>
                                    <input type="text" class="form-control" name="AuctionPlaceKaz" id="AuctionPlaceKaz" required>

                                    <label for="RequestAddressRus">Адрес приема заявок рус.яз.</label>
                                    <input type="text" class="form-control" name="RequestAddressRus" id="RequestAddressRus" required>

                                    <label for="RequestAddressKaz">Адрес приема заявок каз.яз.</label>
                                    <input type="text" class="form-control" name="RequestAddressKaz" id="RequestAddressKaz" required>

                                    <label for="CommentRus">Описание рус.яз.</label>
                                    <input type="text" class="form-control" name="CommentRus" id="CommentRus" required>

                                    <label for="CommentKaz">Описание каз.яз.</label>
                                    <input type="text" class="form-control" name="CommentKaz" id="CommentKaz" required>

                                    <label for="AteID">Идентификатор населенного пункта (ИС АР)</label>
                                    <input type="text" class="form-control" name="AteID" id="AteID" required>

                                    <label for="AddressRus">Месторасположение ЗУ рус.яз.</label>
                                    <input type="text" class="form-control" name="AddressRus" id="AddressRus" required>

                                    <label for="AddressKaz">Месторасположение ЗУ каз.яз.</label>
                                    <input type="text" class="form-control" name="AddressKaz" id="AddressKaz" required>

                                    <label for="Coordinates">Координаты</label>
                                    <input type="text" class="form-control" name="Coordinates" id="Coordinates" required>

                                    <label for="CoordinateSystem">Система координат</label>
                                    <input type="text" class="form-control" name="CoordinateSystem" id="CoordinateSystem" required>

                                    <label for="NoteRus">Примечание рус для ЭТП. Например: Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)</label>
                                    {{--<input type="text" class="form-control" name="NoteRus" id="NoteRus" required>--}}

                                    <label for="NoteKaz">Примечание каз для ЭТП. Например: Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)</label>
                                    {{--<input type="text" class="form-control" name="NoteKaz" id="NoteKaz" required>--}}

                                    <label for="RestrictionsAndBurdensRus">Ограничения и обременения при наличии кроме ТУ на рус</label>
                                    <input type="text" class="form-control" name="RestrictionsAndBurdensRus" id="RestrictionsAndBurdensRus" required>

                                    <label for="RestrictionsAndBurdensKaz">Ограничения и обременения при наличии кроме ТУ на каз</label>
                                    <input type="text" class="form-control" name="RestrictionsAndBurdensKaz" id="RestrictionsAndBurdensKaz" required>

                                    <label for="Coordinates">Координаты</label>
                                    <input type="text" class="form-control" name="Coordinates" id="Coordinates" required>

                                    <label for="Coordinates">Координаты</label>
                                    <input type="text" class="form-control" name="Coordinates" id="Coordinates" required>

                                    <label for="Coordinates">Координаты</label>
                                    <input type="text" class="form-control" name="Coordinates" id="Coordinates" required>

                                    <label for="InstalmentSelling">Метод аукциона</label>
                                    <select name="InstalmentSelling" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">Да</option>
                                        <option value="2">Нет</option>
                                    </select>

                                    <label for="InstallmentPeriod">Срок рассрочки, мес</label>
                                    <input type="number" class="form-control" name="InstallmentPeriod" id="InstallmentPeriod" required>
                                    <br>

                                    <h4>Технические условия (Тип описывающий формат технических условий)</h4>
                                    <br>

                                    <label for="ElektrPower">Выделяемая мощность (лимит) (кВт)</label>
                                    <input type="number" class="form-control" name="ElektrPower" id="ElektrPower" required>

                                    <label for="ElektrFaza1">Характер нагрузки: Однофазная (кВт)</label>
                                    <input type="number" class="form-control" name="ElektrFaza1" id="ElektrFaza1" required>

                                    <label for="ElektrFaza3">Характер нагрузки: Трехфазная (кВт)</label>
                                    <input type="number" class="form-control" name="ElektrFaza3" id="ElektrFaza3" required>

                                    <label for="WaterPower">Общая потребность в воде (лимит) (м3/час)</label>
                                    <input type="number" class="form-control" name="WaterPower" id="WaterPower" required>

                                    <label for="WaterHoz">На хозпитьевые нужды (м3/час)</label>
                                    <input type="number" class="form-control" name="WaterHoz" id="WaterHoz" required>

                                    <label for="WaterProduction">На производственные нужды (м3/час)</label>
                                    <input type="number" class="form-control" name="WaterProduction" id="WaterProduction" required>

                                    <label for="SeweragePower">Общее количество сточных вод (м3/час)</label>
                                    <input type="number" class="form-control" name="SeweragePower" id="SeweragePower" required>

                                    <label for="SewerageFecal">Фекальных (м3/час)</label>
                                    <input type="number" class="form-control" name="SewerageFecal" id="SewerageFecal" required>

                                    <label for="SewerageProduction">Производственно-загрязненных (м3/час)</label>
                                    <input type="number" class="form-control" name="SewerageProduction" id="SewerageProduction" required>

                                    <label for="SewerageClean">Условно-чистых сбрасываемых на городскую канализацию (м3/час)</label>
                                    <input type="number" class="form-control" name="SewerageClean" id="SewerageClean" required>

                                    <label for="HeatPower">Общая тепловая нагрузка (лимит) (Гкал/час)</label>
                                    <input type="number" class="form-control" name="HeatPower" id="HeatPower" required>

                                    <label for="HeatFiring">Отопление (Гкал/час)</label>
                                    <input type="number" class="form-control" name="HeatFiring" id="HeatFiring" required>

                                    <label for="HeatVentilation">Вентиляция (Гкал/час)</label>
                                    <input type="number" class="form-control" name="HeatVentilation" id="HeatVentilation" required>

                                    <label for="HeatHotWater">Горячее водоснабжение (Гкал/час)</label>
                                    <input type="number" class="form-control" name="HeatHotWater" id="HeatHotWater" required>

                                    <label for="StormWater">Ливневая канализация</label>
                                    <input type="number" class="form-control" name="StormWater" id="StormWater" required>

                                    <label for="Telekom">Телефонизация</label>
                                    <input type="number" class="form-control" name="Telekom" id="Telekom" required>

                                    <label for="GasPower">Общая потребность (лимит) (м3/час)</label>
                                    <input type="number" class="form-control" name="GasPower" id="GasPower" required>

                                    <label for="GasOnCooking">На приготовление пищи (м3/час)</label>
                                    <input type="number" class="form-control" name="GasOnCooking" id="GasOnCooking" required>

                                    <label for="GasHeating">Отопление</label>
                                    <input type="number" class="form-control" name="GasHeating" id="GasHeating" required>

                                    <label for="GasVentilation">Вентиляция (м3/час)</label>
                                    <input type="number" class="form-control" name="GasVentilation" id="GasVentilation" required>

                                    <label for="GasConditioning">Кондиционирование (м3/час)</label>
                                    <input type="number" class="form-control" name="GasConditioning" id="GasConditioning" required>

                                    <label for="GasHotWater">Горячее водоснабжение при газификации многоэтажных домов (м3/час)</label>
                                    <input type="number" class="form-control" name="GasHotWater" id="GasHotWater" required>
                                    <br>

                                    <h4>Продавец (Тип описывающий формат продавца)</h4>
                                    <br>

                                    <label for="IINBIN">ИИН/БИН</label>
                                    <input type="text" class="form-control" name="IINBIN" id="IINBIN" required>

                                    <label for="NameRus">ФИО/Наименование рус.яз.</label>
                                    <input type="text" class="form-control" name="NameRus" id="NameRus" required>

                                    <label for="NameKaz">ФИО/Наименование каз.яз.</label>
                                    <input type="text" class="form-control" name="NameKaz" id="NameKaz" required>

                                    <label for="IsFl">ФЛ? Обязательноо поле = true or false</label>
                                    <input type="radio" class="form-control" name="IsFl" checked value="true">Да
                                    <input type="radio" class="form-control" name="IsFl" checked value="false">Нет
                                    <br>

                                    {{--<h4>Покупатель (Тип описывающий формат покупателя)</h4>--}}
                                    {{--<br>--}}
                                    {{--<label for="IINBIN">ИИН/БИН</label>--}}
                                    {{--<input type="text" class="form-control" name="IINBIN" id="IINBIN" required>--}}

                                    {{--<label for="NameRus">ФИО/Наименование рус.яз.</label>--}}
                                    {{--<input type="text" class="form-control" name="NameRus" id="NameRus" required>--}}

                                    {{--<label for="NameKaz">ФИО/Наименование каз.яз.</label>--}}
                                    {{--<input type="text" class="form-control" name="NameKaz" id="NameKaz" required>--}}

                                    {{--<label for="IsFl">ФЛ? Обязательноо поле = true or false</label>--}}
                                    {{--<input type="radio" class="form-control" name="IsFl" checked value="true">Да--}}
                                    {{--<input type="radio" class="form-control" name="IsFl" checked value="false">Нет--}}
                                    {{--<br>--}}

                                    <h4>Справочники</h4>
                                    <br>
                                    <label for="Target">Целевое назначение (справочник ЕГКН)</label>
                                    <select name="Target" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">английский</option>
                                        <option value="2">голландский</option>
                                    </select>

                                    <label for="Purpose">Цель использования (справочник ЕГКН)</label>
                                    <select name="Purpose" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">английский</option>
                                        <option value="2">голландский</option>
                                    </select>

                                    <label for="RightType">Вид права (справочник ЕГКН)</label>
                                    <select name="RightType" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">английский</option>
                                        <option value="2">голландский</option>
                                    </select>

                                    <label for="LandDivisibility">Делимость ЗУ (спарвочник ЕГКН)</label>
                                    <select name="LandDivisibility" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">английский</option>
                                        <option value="2">голландский</option>
                                    </select>

                                    <br>

                                    <h4>Прикрепленые документы</h4>
                                    <br>
                                    <label>Документы</label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="Files" name="Files" required>
                                        <label class="custom-file-label" for="Files ">Выберите Файл</label>
                                    </div>
                                    <br>
                                </div>
                                <button type="submit" class="btn btn-success">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
