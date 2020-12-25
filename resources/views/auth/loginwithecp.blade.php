@extends('layouts.app')

@section('title')
    Авторизация
@endsection

@section('content')

    <html :class="{ 'theme-dark': dark } bg-gray-50 dark:bg-gray-900" x-data="data()" lang="en">

    <head>
        <title>Вход по ЭЦП</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
              rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/tailwind.output.css" />
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    </head>

    <body class="pt-8">
    <div class="flex items-center min-h-screen p-6">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-contain w-full h-full dark:hidden"
                         src="/images/shutterstock_1124764481.jpg" alt="Office" />
                    <img aria-hidden="true" class="hidden object-contain w-full h-full dark:block"
                         src="../assets/img/login-office-dark.jpeg" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <div class="flex justify-center md:justify-start">
                            <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                        </div>
                        <h1 class="mb-4 text-center text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Вход по ЭЦП
                        </h1>

                        <!-- You should use a button here, as the anchor is only used for the example  -->

                            {{ csrf_field() }}
                            <button id="myBtn" onclick="buttonClick()" type="submit"
                                    class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-900 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue"
                                    >
                                Авторизоваться
                            </button>


                        <hr class="my-8" />
                        <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline"
                           href="/login">
                            Вход без ЭЦП
                        </a>
                        @if (Route::has('password.request'))
                            <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Сменить пароль') }}
                            </a>
                        @endif
                        {{--<a class="pt-2 flex flex-wrap text-sm font-bold text-purple-600 dark:text-purple-400 hover:underline"--}}
                           {{--href="/register">--}}
                            {{--Зарегистрироваться--}}
                        {{--</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                console.log(websocket);
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
                    $p = document.getElementById('errorId');
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
                const data1 = JSON.parse(e.data);
                ecpData.data = data1.responseObject;
                if(typeof ecpData.data === 'string' || ecpData.data instanceof String) {
                    console.log('type is string')
                    sendRequest()
                }

                console.log('tut', ecpData.data1);
            };

            function sendRequest() {
                event.preventDefault();
                $.post('/loginwithecp/bar', {'data':ecpData.data, '_token':$('input[name=_token]').val()})
                    .done(function(data,textStatus, jqXHR){
                        window.location = 'services';
                    })
                    .fail(function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        var errorDiv = document.getElementById('errorDiv');
                        errorDiv.style.display = "block";
                        if (error === 'Internal Server Error') {
                            $p = document.getElementById('errorId');
                            console.log('Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!');
                            $p.innerText = 'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!';
                        } else if (error === 'Not Found') {
                            console.log('Данный сертификат предназначен для Физ. лица!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Данный сертификат предназначен для Физ. лица!';
                        } else if (error === 'Conflict') {
                            console.log('Данный сертификат предназначен для Юр. лица!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Данный сертификат предназначен для Юр. лица!';
                        } else if (error === 'Bad Request'){
                            console.log('Ваш сертификат не актуален! Пожалуйста обновите сертификат!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Ваш сертификат не актуален! Пожалуйста обновите сертификат!';
                        } else if (error === 'Unauthorized'){
                            console.log('Ваш сертификат просрочен! Пожалуйста обновите сертификат!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Ваш сертификат просрочен! Пожалуйста обновите сертификат!';
                        } else if (error === 'Not Acceptable') {
                            console.log('Вы уже зарегистрированы на сервере!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Вы уже зарегистрированы на сервере!';
                        } else {
                            console.log('Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!';
                        }
                    });
            };
        </script>
    </body>
    </html>
@endsection
