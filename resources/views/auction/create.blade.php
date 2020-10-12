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
                        <div>
                            <form action="{{ route('auction.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-xs-6">
                                    <h4>Поля для аукциона</h4>
                                    <label style="display:none" for="LotID">Идентификатор лота (id)</label>
                                    <input type="hidden" class="form-control" name="LotID" id="LotID" >

                                    <label for="LotNumber">№ лота</label>
                                    <input type="text" class="form-control" name="LotNumber" id="LotNumber" >

                                    <label for="EgknID">EGKNID</label>
                                    <input type="text" class="form-control" name="EgknID" id="EgknID" disabled>

                                    <label for="StatusZU">Статус ЗУ</label>
                                    <select name="StatusZU" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="free">свободный ЗУ</option>
                                        <option value="auction">аукцион/торги</option>
                                    </select>

                                    <label for="PublishDate">Дата публикации в газете</label>
                                    <input type="date" class="form-control" name="PublishDate" id="PublishDate" >

                                    <label for="RentLease">Срок аренды, дата. Напоимер, до 01.01.2025</label>
                                    <input type="date" class="form-control" name="RentLease" id="RentLease" >

                                    <label for="RentConditionsRus">Условия аренды рус.яз.</label>
                                    <input type="text" class="form-control" name="RentConditionsRus" id="RentConditionsRus" >

                                    <label for="RentConditionsKaz">Условия аренды каз.яз.</label>
                                    <input type="text" class="form-control" name="RentConditionsKaz" id="RentConditionsKaz" >

                                    <label for="Area">Площадь, га.</label>
                                    <input type="number" step="0.01" class="form-control" name="Area" id="Area" >

                                    <label for="CadastreCost">Кадастровая стоимость, тг.</label>
                                    <input type="number" class="form-control" name="CadastreCost" id="CadastreCost" >

                                    <label for="StartCost">Начальная стоимость, тг.</label>
                                    <input type="number" class="form-control" name="StartCost" id="StartCost" >

                                    <label for="TaxCost">Налоговая стоимость, тг.</label>
                                    <input type="number" class="form-control" name="TaxCost" id="TaxCost" >

                                    <label for="ParticipationCost">Гарантийный взнос, тг.</label>
                                    <input type="number" class="form-control" name="ParticipationCost" id="ParticipationCost" >

                                    <label for="AuctionMethod">Метод аукциона</label>
                                    <select name="AuctionMethod" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">английский</option>
                                        <option value="2">голландский</option>
                                    </select>

                                    <label for="AuctionDateTime">Дата. время аукциона. Пр наличии РГИС - дату аукицона определяет РГИС, затем при создании торга в ЭТП - отправляется время в ЕГКН</label>
                                    <input type="datetime-local" class="form-control" name="AuctionDateTime" id="AuctionDateTime" >

                                    <label for="AuctionPlaceRus">Место проведения аукциона рус.яз.</label>
                                    <input type="text" class="form-control" name="AuctionPlaceRus" id="AuctionPlaceRus" >

                                    <label for="AuctionPlaceKaz">Место проведения аукциона рус.яз.</label>
                                    <input type="text" class="form-control" name="AuctionPlaceKaz" id="AuctionPlaceKaz" >

                                    <label for="RequestAddressRus">Адрес приема заявок рус.яз.</label>
                                    <input type="text" class="form-control" name="RequestAddressRus" id="RequestAddressRus" >

                                    <label for="RequestAddressKaz">Адрес приема заявок каз.яз.</label>
                                    <input type="text" class="form-control" name="RequestAddressKaz" id="RequestAddressKaz" >

                                    <label for="CommentRus">Описание рус.яз.</label>
                                    <input type="text" class="form-control" name="CommentRus" id="CommentRus" >

                                    <label for="CommentKaz">Описание каз.яз.</label>
                                    <input type="text" class="form-control" name="CommentKaz" id="CommentKaz" >

                                    <label for="AteID">Идентификатор населенного пункта (ИС АР)</label>
                                    <input type="text" class="form-control" name="AteID" id="AteID" >

                                    <label for="AddressRus">Месторасположение ЗУ рус.яз.</label>
                                    <input type="text" class="form-control" name="AddressRus" id="AddressRus" >

                                    <label for="AddressKaz">Месторасположение ЗУ каз.яз.</label>
                                    <input type="text" class="form-control" name="AddressKaz" id="AddressKaz" >

                                    <label for="RestrictionsAndBurdensRus">Ограничения и обременения при наличии кроме ТУ на рус</label>
                                    <input type="text" class="form-control" name="RestrictionsAndBurdensRus" id="RestrictionsAndBurdensRus" >

                                    <label for="RestrictionsAndBurdensKaz">Ограничения и обременения при наличии кроме ТУ на каз</label>
                                    <input type="text" class="form-control" name="RestrictionsAndBurdensKaz" id="RestrictionsAndBurdensKaz" >

                                    <label for="InstallmentPeriod">Срок рассрочки, мес</label>
                                    <input type="number" class="form-control" name="InstallmentPeriod" id="InstallmentPeriod" >

                                    <label for="InstalmentSelling">Продажа в рассчроку</label>
                                    <select name="InstalmentSelling" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">Да</option>
                                        <option value="2">Нет</option>
                                    </select>
                                    <br>

                                    <h4>Продавец (Тип описывающий формат продавца)</h4>
                                    <label for="IINBIN">ИИН/БИН</label>
                                    <input type="text" class="form-control" name="IINBIN" id="IINBIN" >

                                    <label for="NameRus">ФИО/Наименование рус.яз.</label>
                                    <input type="text" class="form-control" name="NameRus" id="NameRus" >

                                    <label for="NameKaz">ФИО/Наименование каз.яз.</label>
                                    <input type="text" class="form-control" name="NameKaz" id="NameKaz" >

                                    <label for="IsFl">ФЛ? Обязательноe поле = true or false</label>
                                    <br>
                                    <input type="radio" name="IsFl" checked value="1">Да
                                    <input type="radio" name="IsFl" checked value="2">Нет
                                    <br>
                                    <br>

                                    {{--<h4>Покупатель (Тип описывающий формат покупателя)</h4>--}}
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
                                    <label for="Target">Целевое назначение (справочник ЕГКН)</label>
                                    <select name="Target" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="г. Нурсултан">г. Нурсултан</option>
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
                                    <label>Документы</label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="Files" name="Files">
                                        <label class="custom-file-label" for="Files ">Выберите Файл</label>
                                    </div>
                                    <br>

                                </div>

                                <div class="col-xs-6">

                                    <h4>Координаты</h4>
                                    <label for="Coordinates1">Координаты 1</label>
                                    <input type="text" class="form-control" name="Coordinates1" id="Coordinates1" >

                                    <label for="Coordinates2">Координаты 2</label>
                                    <input type="text" class="form-control" name="Coordinates2" id="Coordinates2" >

                                    <label for="Coordinates3">Координаты 3</label>
                                    <input type="text" class="form-control" name="Coordinates3" id="Coordinates3" >

                                    <label for="Coordinates4">Координаты 4</label>
                                    <input type="text" class="form-control" name="Coordinates4" id="Coordinates4" >

                                    {{--<label for="Coordinates">Координаты</label>--}}
                                    {{--<input type="text" class="form-control" name="Coordinates" id="Coordinates" >--}}

                                    <label for="CoordinateSystem">Система координат</label>
                                    <input type="text" class="form-control" name="CoordinateSystem" id="CoordinateSystem" >
                                    <br>


                                    <h4>Технические условия (Тип описывающий формат технических условий)</h4>
                                    <label for="ElektrPower">Выделяемая мощность (лимит) (кВт)</label>
                                    <input type="number" step="0.01" class="form-control" name="ElektrPower" id="ElektrPower" >

                                    <label for="ElektrFaza1">Характер нагрузки: Однофазная (кВт)</label>
                                    <input type="number" step="0.01" class="form-control" name="ElektrFaza1" id="ElektrFaza1" >

                                    <label for="ElektrFaza3">Характер нагрузки: Трехфазная (кВт)</label>
                                    <input type="number" step="0.01" class="form-control" name="ElektrFaza3" id="ElektrFaza3" >

                                    <label for="WaterPower">Общая потребность в воде (лимит) (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="WaterPower" id="WaterPower" >

                                    <label for="WaterHoz">На хозпитьевые нужды (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="WaterHoz" id="WaterHoz" >

                                    <label for="WaterProduction">На производственные нужды (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="WaterProduction" id="WaterProduction" >

                                    <label for="SeweragePower">Общее количество сточных вод (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="SeweragePower" id="SeweragePower" >

                                    <label for="SewerageFecal">Фекальных (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="SewerageFecal" id="SewerageFecal" >

                                    <label for="SewerageProduction">Производственно-загрязненных (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="SewerageProduction" id="SewerageProduction" >

                                    <label for="SewerageClean">Условно-чистых сбрасываемых на городскую канализацию (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="SewerageClean" id="SewerageClean" >

                                    <label for="HeatPower">Общая тепловая нагрузка (лимит) (Гкал/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="HeatPower" id="HeatPower" >

                                    <label for="HeatFiring">Отопление (Гкал/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="HeatFiring" id="HeatFiring" >

                                    <label for="HeatVentilation">Вентиляция (Гкал/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="HeatVentilation" id="HeatVentilation" >

                                    <label for="HeatHotWater">Горячее водоснабжение (Гкал/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="HeatHotWater" id="HeatHotWater" >

                                    <label for="StormWater">Ливневая канализация</label>
                                    <select name="StormWater" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">Да</option>
                                        <option value="2">Нет</option>
                                    </select>

                                    <label for="Telekom">Телефонизация</label>
                                    <select name="Telekom" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">Да</option>
                                        <option value="2">Нет</option>
                                    </select>

                                    <label for="GasPower">Общая потребность (лимит) (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="GasPower" id="GasPower" >

                                    <label for="GasOnCooking">На приготовление пищи (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="GasOnCooking" id="GasOnCooking" >

                                    <label for="GasHeating">Отопление</label>
                                    <input type="number" step="0.01" class="form-control" name="GasHeating" id="GasHeating" >

                                    <label for="GasVentilation">Вентиляция (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="GasVentilation" id="GasVentilation" >

                                    <label for="GasConditioning">Кондиционирование (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="GasConditioning" id="GasConditioning" >

                                    <label for="GasHotWater">Горячее водоснабжение при газификации многоэтажных домов (м3/час)</label>
                                    <input type="number" step="0.01" class="form-control" name="GasHotWater" id="GasHotWater" >
                                    <br>

                                    <h4>Итоги</h4>
                                    <label for="NoteRus">Примечание рус для ЭТП.</label>
                                    <input type="text" class="form-control" name="NoteRus" id="NoteRus" disabled value=" Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)" required>

                                    <label for="NoteKaz">Примечание каз для ЭТП.</label>
                                    <input type="text" class="form-control" name="NoteKaz" id="NoteKaz" disabled value=" Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)" required>

                                    <label for="LotStatus">Статус лота</label>
                                    <select name="LotStatus" class="form-control">
                                        <option value="">Не выбран</option>
                                        <option value="1">Предстоящий</option>
                                        <option value="2">Несостоявшийся</option>
                                        <option value="3">Состоявшийся</option>
                                    </select>
                                    <br>

                                </div>
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-success">Отправить</button>
                                </div>
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
