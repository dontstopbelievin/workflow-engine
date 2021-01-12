@extends('layouts.master')

@section('title')
    Создание Полей Аукциона
@endsection

@section('content')
      <div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Добавить/редактировать лот</h4>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('auction.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <div class="card-title">Поля для лота</div>
                      </div>
                      <div class="card-body">
                        <label style="display:none" for="LotID">Идентификатор лота (id)</label>
                        <input type="hidden" class="form-control" name="LotID" id="LotID" >
                        <div class="form-group">
                          <label for="LotNumber">№ лота</label>
                          <input type="text" class="form-control" id="LotNumber" name="LotNumber" >
                        </div>
                        <div class="form-group">
                          <label for="EgknID">EGKNID</label>
                          <input type="text" class="form-control" name="EgknID" id="EgknID" disabled>
                        </div>
                        <div class="form-group">
                          <label for="StatusZU">Статус ЗУ</label>
                          <select name="StatusZU" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="free">свободный ЗУ</option>
                              <option value="auction">аукцион/торги</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="PublishDate">Дата публикации в газете</label>
                          <input type="date" class="form-control" name="PublishDate" id="PublishDate" >
                        </div>
                        <div class="form-group">
                          <label for="RentLease">Срок аренды, дата. Напоимер, до 01.01.2025</label>
                          <input type="date" class="form-control" name="RentLease" id="RentLease" >
                        </div>
                        <div class="form-group">
                          <label for="RentConditionsRus">Условия аренды рус.яз.</label>
                          <input type="text" class="form-control" name="RentConditionsRus" id="RentConditionsRus" >
                        </div>
                        <div class="form-group">
                          <label for="RentConditionsKaz">Условия аренды каз.яз.</label>
                          <input type="text" class="form-control" name="RentConditionsKaz" id="RentConditionsKaz" >
                        </div>
                        <div class="form-group">
                          <label for="Area">Площадь, га.</label>
                          <input type="number" step="0.01" class="form-control" name="Area" id="Area" >
                        </div>
                        <div class="form-group">
                          <label for="CadastreCost">Кадастровая стоимость, тг.</label>
                          <input type="number" class="form-control" name="CadastreCost" id="CadastreCost" >
                        </div>
                        <div class="form-group">
                          <label for="StartCost">Начальная стоимость, тг.</label>
                          <input type="number" class="form-control" name="StartCost" id="StartCost" >
                        </div>
                        <div class="form-group">
                          <label for="TaxCost">Налоговая стоимость, тг.</label>
                          <input type="number" class="form-control" name="TaxCost" id="TaxCost" >
                        </div>
                        <div class="form-group">
                          <label for="ParticipationCost">Гарантийный взнос, тг.</label>
                          <input type="number" class="form-control" name="ParticipationCost" id="ParticipationCost" >
                        </div>
                        <div class="form-group">
                          <label for="AuctionMethod">Метод аукциона</label>
                          <select name="AuctionMethod" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">английский</option>
                              <option value="2">голландский</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="AuctionDateTime">Дата. время аукциона. Пр наличии РГИС - дату аукицона определяет РГИС, затем при создании торга в ЭТП - отправляется время в ЕГКН</label>
                          <input type="datetime-local" class="form-control" name="AuctionDateTime" id="AuctionDateTime" >
                        </div>
                        <div class="form-group">
                          <label for="AuctionPlaceRus">Место проведения аукциона рус.яз.</label>
                          <input type="text" class="form-control" name="AuctionPlaceRus" id="AuctionPlaceRus" >
                        </div>
                        <div class="form-group">
                          <label for="AuctionPlaceKaz">Место проведения аукциона каз.яз.</label>
                          <input type="text" class="form-control" name="AuctionPlaceKaz" id="AuctionPlaceKaz" >
                        </div>
                        <div class="form-group">
                          <label for="RequestAddressRus">Адрес приема заявок рус.яз.</label>
                          <input type="text" class="form-control" name="RequestAddressRus" id="RequestAddressRus" >
                        </div>
                        <div class="form-group">
                          <label for="RequestAddressKaz">Адрес приема заявок каз.яз.</label>
                          <input type="text" class="form-control" name="RequestAddressKaz" id="RequestAddressKaz" >
                        </div>
                        <div class="form-group">
                          <label for="CommentRus">Описание рус.яз.</label>
                          <input type="text" class="form-control" name="CommentRus" id="CommentRus" >
                        </div>
                        <div class="form-group">
                          <label for="CommentKaz">Описание каз.яз.</label>
                          <input type="text" class="form-control" name="CommentKaz" id="CommentKaz" >
                        </div>
                        <div class="form-group">
                          <label for="AteID">Идентификатор населенного пункта (ИС АР)</label>
                          <input type="text" class="form-control" name="AteID" id="AteID" >
                        </div>
                        <div class="form-group">
                          <label for="AddressRus">Месторасположение ЗУ рус.яз.</label>
                          <input type="text" class="form-control" name="AddressRus" id="AddressRus" >
                        </div>
                        <div class="form-group">
                          <label for="AddressKaz">Месторасположение ЗУ каз.яз.</label>
                          <input type="text" class="form-control" name="AddressKaz" id="AddressKaz" >
                        </div>
                        <div class="form-group">
                          <label for="RestrictionsAndBurdensRus">Ограничения и обременения при наличии кроме ТУ на рус</label>
                          <input type="text" class="form-control" name="RestrictionsAndBurdensRus" id="RestrictionsAndBurdensRus" >
                        </div>
                        <div class="form-group">
                          <label for="RestrictionsAndBurdensKaz">Ограничения и обременения при наличии кроме ТУ на каз</label>
                          <input type="text" class="form-control" name="RestrictionsAndBurdensKaz" id="RestrictionsAndBurdensKaz" >
                        </div>
                        <div class="form-group">
                          <label for="InstallmentPeriod">Срок рассрочки, мес</label>
                          <input type="number" class="form-control" name="InstallmentPeriod" id="InstallmentPeriod" >
                        </div>
                        <div class="form-group">
                          <label for="InstalmentSelling">Продажа в рассрочку</label>
                          <select name="InstalmentSelling" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">Да</option>
                              <option value="2">Нет</option>
                          </select>
                        </div>
                        <div class="card-header">
                          <div class="card-title">Продавец (Тип описывающий формат продавца)</div>
                        </div>
                        <div class="form-group">
                          <label for="IINBIN">ИИН/БИН</label>
                          <input type="text" class="form-control" name="IINBIN" id="IINBIN" >
                        </div>
                        <div class="form-group">
                          <label for="NameRus">ФИО/Наименование рус.яз.</label>
                          <input type="text" class="form-control" name="NameRus" id="NameRus" >
                        </div>
                        <div class="form-group">
                          <label for="NameKaz">ФИО/Наименование каз.яз.</label>
                          <input type="text" class="form-control" name="NameKaz" id="NameKaz" >
                        </div>
                        <div class="form-check">
                          <label for="IsFl">ФЛ? Обязательноe поле = true or false</label><br/>
                          <label class="form-radio-label">
                            <input class="form-radio-input" type="radio" name="IsFl" checked value="1" required>
                            <span class="form-radio-sign">Да</span>
                          </label>
                          <label class="form-radio-label ml-3">
                            <input class="form-radio-input" type="radio" name="IsFl" checked value="2" required>
                            <span class="form-radio-sign">Нет</span>
                          </label>
                        </div>
                        <div class="card-header">
                          <div class="card-title">Справочники</div>
                        </div>
                        <div class="form-group">
                          <label for="Target">Целевое назначение (справочник ЕГКН)</label>
                          <select name="Target" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="г. Нурсултан">г. Нурсултан</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="Purpose">Цель использования (справочник ЕГКН)</label>
                          <select name="Purpose" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">английский</option>
                              <option value="2">голландский</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="RightType">Вид права (справочник ЕГКН)</label>
                          <select name="RightType" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">английский</option>
                              <option value="2">голландский</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="LandDivisibility">Делимость ЗУ (спарвочник ЕГКН)</label>
                          <select name="LandDivisibility" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">английский</option>
                              <option value="2">голландский</option>
                          </select>
                        </div>
                        <div class="card-header">
                          <div class="card-title">Прикрепленые документы</div>
                        </div>
                        <div class="form-group">
                          <label>Документы</label>
                          <div class="custom-file mt-1 col-md-12">
                              <input type="file" class="custom-file-input" id="Files" name="Files">
                              <label class="custom-file-label" for="Files ">Выберите Файл</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <div class="card-title">Координаты</div>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="Coordinates">Координаты</label>
                          <input type="text" class="form-control" name="Coordinates" id="Coordinates" >
                        </div>
                        <div class="form-group">
                          <label for="CoordinateSystem">Система координат</label>
                          <input type="text" class="form-control" name="CoordinateSystem" id="CoordinateSystem" >
                        </div>
                        <div class="card-header">
                          <div class="card-title">Технические условия (Тип описывающий формат технических условий)</div>
                        </div>
                        <div class="form-group">
                          <label for="ElektrPower">Выделяемая мощность (лимит) (кВт)</label>
                          <input type="number" step="0.01" class="form-control" name="ElektrPower" id="ElektrPower" >
                        </div>
                        <div class="form-group">
                          <label for="ElektrFaza1">Характер нагрузки: Однофазная (кВт)</label>
                          <input type="number" step="0.01" class="form-control" name="ElektrFaza1" id="ElektrFaza1" >
                        </div>
                        <div class="form-group">
                          <label for="ElektrFaza3">Характер нагрузки: Трехфазная (кВт)</label>
                          <input type="number" step="0.01" class="form-control" name="ElektrFaza3" id="ElektrFaza3" >
                        </div>
                        <div class="form-group">
                          <label for="WaterPower">Общая потребность в воде (лимит) (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="WaterPower" id="WaterPower" >
                        </div>
                        <div class="form-group">
                          <label for="WaterHoz">На хозпитьевые нужды (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="WaterHoz" id="WaterHoz" >
                        </div>
                        <div class="form-group">
                          <label for="WaterProduction">На производственные нужды (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="WaterProduction" id="WaterProduction" >
                        </div>
                        <div class="form-group">
                          <label for="SeweragePower">Общее количество сточных вод (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="SeweragePower" id="SeweragePower" >
                        </div>
                        <div class="form-group">
                          <label for="SewerageFecal">Фекальных (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="SewerageFecal" id="SewerageFecal" >
                        </div>
                        <div class="form-group">
                          <label for="SewerageProduction">Производственно-загрязненных (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="SewerageProduction" id="SewerageProduction" >
                        </div>
                        <div class="form-group">
                          <label for="SewerageClean">Условно-чистых сбрасываемых на городскую канализацию (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="SewerageClean" id="SewerageClean" >
                        </div>
                        <div class="form-group">
                          <label for="HeatPower">Общая тепловая нагрузка (лимит) (Гкал/час)</label>
                          <input type="number" step="0.01" class="form-control" name="HeatPower" id="HeatPower" >
                        </div>
                        <div class="form-group">
                          <label for="HeatFiring">Отопление (Гкал/час)</label>
                          <input type="number" step="0.01" class="form-control" name="HeatFiring" id="HeatFiring" >
                        </div>
                        <div class="form-group">
                          <label for="HeatVentilation">Вентиляция (Гкал/час)</label>
                          <input type="number" step="0.01" class="form-control" name="HeatVentilation" id="HeatVentilation" >
                        </div>
                        <div class="form-group">
                          <label for="HeatHotWater">Горячее водоснабжение (Гкал/час)</label>
                          <input type="number" step="0.01" class="form-control" name="HeatHotWater" id="HeatHotWater" >
                        </div>
                        <div class="form-group">
                          <label for="StormWater">Ливневая канализация</label>
                          <select name="StormWater" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">Да</option>
                              <option value="2">Нет</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="Telekom">Телефонизация</label>
                          <select name="Telekom" class="form-control" data-dropup-auto="false">
                              <option value="">Не выбран</option>
                              <option value="1">Да</option>
                              <option value="2">Нет</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="GasPower">Общая потребность (лимит) (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="GasPower" id="GasPower" >
                        </div>
                        <div class="form-group">
                          <label for="GasOnCooking">На приготовление пищи (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="GasOnCooking" id="GasOnCooking" >
                        </div>
                        <div class="form-group">
                          <label for="GasHeating">Отопление</label>
                          <input type="number" step="0.01" class="form-control" name="GasHeating" id="GasHeating" >
                        </div>
                        <div class="form-group">
                          <label for="GasVentilation">Вентиляция (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="GasVentilation" id="GasVentilation" >
                        </div>
                        <div class="form-group">
                          <label for="GasConditioning">Кондиционирование (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="GasConditioning" id="GasConditioning" >
                        </div>
                        <div class="form-group">
                          <label for="GasHotWater">Горячее водоснабжение при газификации многоэтажных домов (м3/час)</label>
                          <input type="number" step="0.01" class="form-control" name="GasHotWater" id="GasHotWater" >
                        </div>
                        <div class="card-header">
                          <div class="card-title">Итоги</div>
                        </div>
                        <div class="form-group">
                          <label for="NoteRus">Примечание рус для ЭТП.</label>
                          <input type="text" class="form-control" name="NoteRus" id="NoteRus" disabled value=" Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)" required>
                        </div>
                        <div class="form-group">
                          <label for="NoteKaz">Примечание каз для ЭТП.</label>
                          <input type="text" class="form-control" name="NoteKaz" id="NoteKaz" disabled value=" Начальная цена рассчитана в соответствии с п.п 3, п. 1, Постановления правительства Республики Казахстан от 2 сентября 2003 года №890 "Об установлении базовых ставок платы на земельные участки" в размере 6 процент (2х3 года) от кадастровой (оценочной) стоимости земельного участка (с уменьшением пропорционально площади сервитута)" required>
                        </div>
                        <div class="form-group">
                          <label for="LotStatus">Статус лота</label>
                          <select name="LotStatus" class="form-control" data-dropup-auto="false">
                            <option value="">Не выбран</option>
                            <option value="1">Предстоящий</option>
                            <option value="2">Несостоявшийся</option>
                            <option value="3">Состоявшийся</option>
                          </select>
                        </div>
                      </div>
                      <div class="card-action">
                        <button type="submit" class="btn btn-success">Отправить</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
					</div>
				</div>
			</div>
@endsection

@section('scripts')
@endsection
