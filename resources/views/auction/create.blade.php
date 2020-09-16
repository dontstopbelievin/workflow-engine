@extends('layouts.master')

@section('title')
    Создание Полей Аукциона
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создание полей для аукциона</h4>
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
                                    <h4>Тип, описывающий сведения о Физлице</h4>
                                    <br>
                                    <label for="IIN">ИИН</label>
                                    <input type="text" class="form-control" name="IIN" id="IIN" required>
                                    <label for="Surname">Фамилия</label>
                                    <input type="text" class="form-control" name="Surname" id="Surname" required>
                                    <label for="FirstName">Имя</label>
                                    <input type="text" class="form-control" name="FirstName" id="FirstName" required>
                                    <label for="MiddleName">Отчество</label>
                                    <input type="text" class="form-control" name="MiddleName" id="MiddleName" required>
                                    <label for="PhoneNumber">Телефон Заявителя</label>
                                    <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" required>
                                    <br>
                                    <h4>Прикрепленые документы</h4>
                                    <br>
                                    <label>Правоустанавливающие документы на земельный участок (копия решения акима о предоставлении земельного участка)</label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="LegalDoc" name="LegalDoc" required>
                                        <label class="custom-file-label" for="LegalDoc">Выберите Файл</label>
                                    </div>
                                    <br>
                                    <label>Копия государственного акта</label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="IdentificationDoc" name="IdentificationDoc" required>
                                        <label class="custom-file-label" for="IdentificationDoc">Выберите Файл</label>
                                    </div>
                                    <br>
                                    <label>Копия технического паспорта на объект недвижимости </label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="SketchProject" name="SketchProject" required>
                                        <label class="custom-file-label" for="SketchProject">Выберите Файл</label>
                                    </div>
                                    <br>
                                    <label>Ситуационная схема земельного участка</label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="SchemeZu" name="SchemeZu" required>
                                        <label class="custom-file-label" for="SchemeZu">Выберите Файл</label>
                                    </div>
                                    <br>
                                    <label>Акт определения кадастровой оценочной стоимости</label>
                                    <div class="custom-file mt-1 col-md-12">
                                        <input type="file" class="custom-file-input" id="ActCost" name="ActCost" required>
                                        <label class="custom-file-label" for="ActCost">Выберите Файл</label>
                                    </div>
                                    <h4>Тип, описывающий Данные земельного участка</h4>
                                    <label for="City">Город</label>
                                    <input type="text" class="form-control" name="City" id="City" required>
                                    <label for="PurposeUse">Цель Использования</label>
                                    <input type="text" class="form-control" name="PurposeUse" id="PurposeUse" required>
                                    <label for="Cadastre">Кадастровый номер</label>
                                    <input type="text" class="form-control" name="Cadastre" id="Cadastre" required>
                                    <label for="Area">Площадь, га</label>
                                    <input type="text" class="form-control" name="Area" id="Area" required>
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
