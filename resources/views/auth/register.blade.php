@extends('layouts.app')

@section('title')
    Регистрация
@endsection
<style>
    .reg_form{
        text-align:left;
        padding: 15px 20px;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important;
    }
    .form-control{
        margin: auto;
        width: 90%!important;
    }
</style>
@section('content')
<div class="main-panel" style="width: 100%">
    <div class="content">
        <div class="row justify-content-center">
            <div class="card" style="width: 50%; text-align:center;">
                <div class="card-body" style="padding:0px; margin:0px;">
                    <div class="row">
                        <div class="col-md-6" style="white-space: nowrap;padding:0px; margin: 0px; overflow: hidden;">
                            <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                            src="../assets/img/create-account-office.jpeg" style="height: 100%;" alt="Office" />
                        </div>
                        <div class="col-md-6" style="padding: 30px;">
                            <div>
                                <div>
                                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                                </div>
                                <h5 class="text-center" style="margin-top: 30px;">
                                    Регистрация
                                </h5>
                                <div id="errorDiv" style="background: orange"></div>
                                <form class="flex flex-col pt-3 md:pt-8" action="/register" method="POST">
                                @csrf
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="surname"><b>Фамилия</b></label><br/>
                                    <input type="text" name="surname" id="surname" required value="" readonly="readonly" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="firstname"><b>Имя</b></label><br/>
                                    <input type="text" name="firstname" id="firstname" required readonly="readonly" value="" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="lastname"><b>Отчество</b></label><br/>
                                    <input type="text" name="lastname" id="lastname" required readonly="readonly" value="" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="telephone"><b>Телефон</b></label><br/>
                                    <input type="text" id="telephone" name="telephone" pattern="[0-9]{10}" title="Введите 10 цифр вашего номера" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="iin"><b>ИИН</b></label><br/>
                                    <input type="text" id="iin" name="iin" readonly="readonly" pattern="[0-9]{12}" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="bin"><b>БИН</b></label><br/>
                                    <input type="text" id="bin" name="bin" readonly="readonly" pattern="[0-9]{12}" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="email"><b>Email</b></label><br/>
                                    <input type="email" id="email" name="email" value="" required autocomplete="email" class="form-control"/>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="password"><b>Придумайте пароль</b></label><br/>
                                    <input type="password" id="password" name="password" required autocomplete="new-password" class="form-control"/ style="margin: 0px;width: 80%!important;">
                                    <small id="emailHelp" class="form-text text-muted" style="text-align: left;">1.Длина пароля должна быть не менее 8 символов</small>
                                    <small id="emailHelp" class="form-text text-muted" style="text-align: left;">2.Пароль должен состоять из букв латинского алфавита (A-z) и арабских цифр (0-9)</small>
                                    <small id="emailHelp" class="form-text text-muted" style="text-align: left;">3. Пароль должен содержать не менее одного из следующих символов:( !$#% ).</small>
                                </div>
                                <div class="md-form md-outline reg_form">
                                    <label data-error="wrong" data-success="right" for="confirm_password"><b>Повторите пароль</b></label>
                                    <input class="form-control" placeholder="***************" type="password" required id="confirm_password"  name="password_confirmation" / style="display: inline-block;width: 80%!important;">
                                    <img id="check_pass" src="" style="width: 0px;margin-left: 10px;"/>
                                </div>
                                <div class="md-form md-outline reg_form" style="padding: 25px;">
                                    <label class="form-check-label">
                                        <input type="checkbox" id="policy" value="1" name="policy" class="form-check-input">
                                        <span class="form-check-sign" style="float: left;">
                                            Я согласен
                                            <span class="underline"> с <a href="policy" target="_blank">условиями пользования</a></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="text-center pb-2 reg_form">
                                    <button type="submit" class="btn btn-primary form-control">{{ __('Зарегистрироваться') }}</button>
                                    <div>
                                        <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline"
                                       href="/login">
                                        Уже есть аккаунт? Авторизуйтесь
                                        </a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const check_pass = () => {
        var x = document.getElementById("password").value;
        var y = document.getElementById("confirm_password").value;
        if(y.length > 0){
            document.getElementById("check_pass").style.width = "25px";
            if(x == y){
                document.getElementById("check_pass").src = "images/done.png"
            }else{
                document.getElementById("check_pass").src = "images/warning.png"
            }
        }else{
            document.getElementById("check_pass").style.width = "0px";
        }
    }

    let source = document.getElementById("confirm_password");
    source.addEventListener('input', check_pass);
    source.addEventListener('propertychange', check_pass);
    let source2 = document.getElementById("password");
    source2.addEventListener('input', check_pass);
    source2.addEventListener('propertychange', check_pass);

    var url_string = window.location.href;
    var url = new URL(url_string);
    var first_name = url.searchParams.get("name");
    var last_name = url.searchParams.get("lastname");
    var sur_name = url.searchParams.get("surname");
    var iin = url.searchParams.get("iin");
    var bin = url.searchParams.get("bin");
    var email = url.searchParams.get("email");
    if(iin){
        document.getElementById("iin").value = iin;
    }
    if(bin){
        document.getElementById("bin").value = bin;   
    }
    document.getElementById("firstname").value = first_name;
    document.getElementById("surname").value = sur_name;
    document.getElementById("lastname").value = last_name;
    document.getElementById("email").value = email;
</script>
@append