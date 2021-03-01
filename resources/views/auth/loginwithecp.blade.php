@extends('layouts.app')

@section('title')
    Авторизация
@endsection

@section('content')
<div class="main-panel" style="width: 100%">
    <div class="content">
        <div class="row justify-content-center">
            <div class="card" style="width: 50%; text-align:center;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" style="white-space: nowrap;">
                            <span style="display: inline-block;height: 100%;vertical-align: middle;"></span>
                            <img src="/images/shutterstock_1124764481.jpg" style="width: 100%;vertical-align: middle;" />
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div>
                                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                                </div>
                                <h5 class="mb-4 text-center text-xl font-semibold text-gray-700 dark:text-gray-200"
                                style="margin:40px;">
                                    Вход без ЭЦП
                                </h5>
                                <div id="errorDiv" style="background: orange"></div>
                                @csrf
                                <div class="g-recaptcha mt-4 text-sm" data-sitekey="6LcOIv4ZAAAAAOH6sKrJvbkej4SoRlrOI6dw0yeU" data-size="invisible"></div>
                                <div class="text-center pb-2">
                                    <button id="myBtn" onclick="buttonClick()" type="submit" class="btn btn-primary mb-4 text-center">
                                        Авторизоваться
                                    </button>
                                    <div>
                                        <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline"
                                       href="/login">
                                        Вход без ЭЦП
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
    var file = "";
    var ready = false;
    var ecpData = {
        path: "",
        owner: "",
        data: ""
    }
    // Get the <span> element that closes the modal
    // When the user clicks on the button, open the modal
    function buttonClick() {
        console.log('button');
        handleSend();
    }
    // When the user clicks on <span> (x), close the modal
    var websocket = new WebSocket("wss://127.0.0.1:13579/");
    websocket.onopen = function(e) {
        console.log("[open] Connection established");
        // console.log(websocket);
        ready = true;
    };
    websocket.onclose = (e) => {
        if (e.wasClean) {
            console.log("connection closed");
        } else {
            console.log(
                "connection error: [code]=" + e.code + ", [reason]=" + e.reason
            );
        }
    };

    function  handleSend() {
        if (!ready) {
            var errorDiv = document.getElementById('errorDiv');
            errorDiv.style.display = "block";
            $p = document.getElementById('errorDiv');
            $p.innerText = 'Убедитесь, что программа NCALayer запущена';
        } else {
            const data = {
                module: 'kz.gov.pki.knca.commonUtils',
                method: "signXml",
                args: [
                    "PKCS12",
                    "AUTHENTICATION",
                    "<login><sessionid>caacda70-fd36-45ed-8d94-45a88890f83a</sessionid></login>",
                    "", ""
                ]
            };

            websocket.send(JSON.stringify(data));
        }
    };

    websocket.onmessage = e => {
        const data = JSON.parse(e.data);
        ecpData.data = data.responseObject;
        if(typeof ecpData.data === 'string' || ecpData.data instanceof String) {
            console.log('type is string')
            sendRequest()
        }

        console.log('tut', ecpData.data);
    };

    function sendRequest() {
        event.preventDefault();
        $.post('/loginwithecp/bar', {'data':ecpData.data, '_token':$('input[name=_token]').val()})
            .done(function(data,textStatus, jqXHR){
                // console.log(data)
                window.location = 'docs';
            })
            .fail(function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                var errorDiv = document.getElementById('errorDiv');
                errorDiv.style.display = "block";
                if (error === 'Internal Server Error') {
                    $p = document.getElementById('errorDiv');
                    console.log('Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!');
                    $p.innerText = 'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!';
                } else if (error === 'Not Found') {
                    console.log('Ошибка авторизации!');
                    $p = document.getElementById('errorDiv');
                    $p.innerText = 'Ошибка авторизации!';
                } else if (error === 'Conflict') {
                    console.log('Ошибка авторизации!');
                    $p = document.getElementById('errorDiv');
                    $p.innerText = 'Ошибка авторизации!';
                } else if (error === 'Bad Request'){
                    console.log('Ваш сертификат не актуален! Пожалуйста обновите сертификат!');
                    $p = document.getElementById('errorDiv');
                    $p.innerText = 'Ваш сертификат не актуален! Пожалуйста обновите сертификат!';
                } else if (error === 'Unauthorized'){
                    console.log('Ваш сертификат просрочен! Пожалуйста обновите сертификат!');
                    $p = document.getElementById('errorDiv');
                    $p.innerText = 'Ваш сертификат просрочен! Пожалуйста обновите сертификат!';
                } else if (error === 'Not Acceptable') {
                    console.log('Вы уже зарегистрированы на сервере!');
                    $p = document.getElementById('errorDiv');
                    $p.innerText = 'Вы уже зарегистрированы на сервере!';
                } else {
                    console.log('Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!');
                    $p = document.getElementById('errorDiv');
                    $p.innerText = 'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!';
                }
            });
    };
</script>
@append