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
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="../assets/js/init-alpine.js"></script>
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
                            <div class="form">
                                <div class="tab-content">
                                    <div id="signup">

                                        <button id="myBtn"
                                            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Выбрать
                                            ЭЦП</button>

                                    </div>
                                </div>

                            </div>
                            <hr class="my-8" />
                            <a class="flex flex-wrap text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                                href="/login">
                                Вход без ЭЦП
                            </a>
                            <a class="pt-2 text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                                href="/password/reset">
                                Забыли пароль?
                            </a>
                            <a class="pt-2 flex flex-wrap text-sm font-bold text-purple-600 dark:text-purple-400 hover:underline"
                                href="/register">
                                Зарегистрироваться
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script>
            // Code By Webdevtrick ( https://webdevtrick.com )
            $('.form').find('input, textarea').on('keyup blur focus', function(e) {

                var $this = $(this),
                    label = $this.prev('label');

                if (e.type === 'keyup') {
                    if ($this.val() === '') {
                        label.removeClass('active highlight');
                    } else {
                        label.addClass('active highlight');
                    }
                } else if (e.type === 'blur') {
                    if ($this.val() === '') {
                        label.removeClass('active highlight');
                    } else {
                        label.removeClass('highlight');
                    }
                } else if (e.type === 'focus') {

                    if ($this.val() === '') {
                        label.removeClass('highlight');
                    } else if ($this.val() !== '') {
                        label.addClass('highlight');
                    }
                }

            });

            $('.tab a').on('click', function(e) {

                e.preventDefault();

                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');

                target = $(this).attr('href');

                $('.tab-content > div').not(target).hide();

                $(target).fadeIn(600);

            });


            var file = "";
            var ready = false;
            var ecpData = {
                path: "",
                owner: "",
                data: ""
            }

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
                ecpData.owner = 'Yur';
                console.log('button');
                // modal.style.display = "block";
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

            // getDataNew('signXmls', args, callbackM);
            function handleSend() {
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
                if (typeof ecpData.data === 'string' || ecpData.data instanceof String) {
                    console.log('type is string')
                    sendRequest()
                }

                console.log('tut', ecpData.data1);
            };

            function sendRequest() {
                event.preventDefault();
                var modal = document.getElementById("myModal");
                $.post('/loginwithecp/bar', {
                        'data': ecpData.data,
                        'owner': ecpData.owner,
                        '_token': $('input[name=_token]').val()
                    })
                    .done(function(data, textStatus, jqXHR) {
                        if (data['fizdata']) {

                            console.log('fizdata')
                            let commonName = data['fizdata']['commonName'];
                            let surname = commonName.substr(0, commonName.indexOf(' '));
                            let name = commonName.substr(commonName.indexOf(' ') + 1);
                            document.getElementById('modal_sec_middle_name').value = data['fizdata']['lastName'];
                            document.getElementById('modal_sec_iin').value = data['fizdata']['iin'];
                            document.getElementById('modal_sec_name').value = name;
                            document.getElementById('modal_sec_surname').value = surname;
                            modal.style.display = "none";
                        } else {
                            console.log(data)
                            let commonName = data['yurdata']['commonName'];
                            let surname = commonName.substr(0, commonName.indexOf(' '));
                            let name = commonName.substr(commonName.indexOf(' ') + 1);
                            document.getElementById('modal_first_middle_name').value = data['yurdata']['lastName'];
                            document.getElementById('modal_first_iin').value = data['yurdata']['iin'];
                            document.getElementById('modal_first_bin').value = data['yurdata']['bin'];
                            document.getElementById('modal_first_email').value = data['yurdata']['email'];
                            document.getElementById('modal_first_name').value = name;
                            document.getElementById('modal_first_surname').value = surname;
                            modal.style.display = "none";
                        }

                    })
                    .fail(function(xhr, status, error) {
                        console.log(xhr)
                        console.log(status)
                        console.log(error)
                        var errorDiv = document.getElementById('errorDiv');
                        errorDiv.style.display = "block";
                        if (error === 'Internal Server Error') {
                            $p = document.getElementById('errorId');
                            console.log(
                                'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!'
                            );
                            $p.innerText =
                                'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!';
                        } else if (error === 'Not Found') {
                            console.log('Данный сертификат предназначен для Физ. лица!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Данный сертификат предназначен для Физ. лица!';
                        } else if (error === 'Conflict') {
                            console.log('Данный сертификат предназначен для Юр. лица!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Данный сертификат предназначен для Юр. лица!';
                        } else if (error === 'Bad Request') {
                            console.log('Ваш сертификат не актуален! Пожалуйста обновите сертификат!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Ваш сертификат не актуален! Пожалуйста обновите сертификат!';
                        } else if (error === 'Unauthorized') {
                            console.log('Ваш сертификат просрочен! Пожалуйста обновите сертификат!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Ваш сертификат просрочен! Пожалуйста обновите сертификат!';
                        } else if (error === 'Not Acceptable') {
                            console.log('Вы уже зарегистрированы на сервере!');
                            $p = document.getElementById('errorId');
                            $p.innerText = 'Вы уже зарегистрированы на сервере!';
                        } else {
                            console.log(
                                'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!'
                            );
                            $p = document.getElementById('errorId');
                            $p.innerText =
                                'Не правильный пароль для ЭЦП или не верный формат P12! Пожалуйста введите еще раз!';
                        }
                    });
            };

        </script>
    </body>

    </html>
@endsection
