<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Sign-Up/Login Form</title>
    <link href="https://fonts.googleapis.com/css?family=Manjari&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
</head>
<body>

<div class="form">

    <ul class="top-area">
        <li class="tab active"><a href="#signup">Log In with ECP</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
    </ul>

    <div class="tab-content">
        <div id="signup">

            <button id="myBtn" class="button button-block">Выбрать ЭЦП</button>

        </div>

        <div id="login">

            <form action="/" method="post">
                @csrf
                <div class="label-field">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email"required autocomplete="off"/>
                </div>

                <div class="label-field">
                    <label>
                        Password<span class="req">*</span>
                    </label>
                    <input type="password"required autocomplete="off"/>
                </div>

                <p class="forgot"><a href="#">Forgot Password?</a></p>

                <button class="button button-block">Log In</button>

            </form>

        </div>

    </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>


    // Code By Webdevtrick ( https://webdevtrick.com )
    $('.form').find('input, textarea').on('keyup blur focus', function (e) {

        var $this = $(this),
            label = $this.prev('label');

        if (e.type === 'keyup') {
            if ($this.val() === '') {
                label.removeClass('active highlight');
            } else {
                label.addClass('active highlight');
            }
        } else if (e.type === 'blur') {
            if( $this.val() === '' ) {
                label.removeClass('active highlight');
            } else {
                label.removeClass('highlight');
            }
        } else if (e.type === 'focus') {

            if( $this.val() === '' ) {
                label.removeClass('highlight');
            }
            else if( $this.val() !== '' ) {
                label.addClass('highlight');
            }
        }

    });

    $('.tab a').on('click', function (e) {

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
        var modal = document.getElementById("myModal");
        $.post('/loginwithecp/bar', {'data':ecpData.data, 'owner':ecpData.owner,'_token':$('input[name=_token]').val()})
            .done(function(data,textStatus, jqXHR){
                if (data['fizdata']) {

                    console.log('fizdata')
                    let commonName = data['fizdata']['commonName'];
                    let surname = commonName.substr(0,commonName.indexOf(' '));
                    let name = commonName.substr(commonName.indexOf(' ')+1);
                    document.getElementById('modal_sec_middle_name').value = data['fizdata']['lastName'];
                    document.getElementById('modal_sec_iin').value = data['fizdata']['iin'];
                    document.getElementById('modal_sec_name').value = name;
                    document.getElementById('modal_sec_surname').value = surname;
                    modal.style.display = "none";
                } else {
                    console.log(data)
                    let commonName = data['yurdata']['commonName'];
                    let surname = commonName.substr(0,commonName.indexOf(' '));
                    let name = commonName.substr(commonName.indexOf(' ')+1);
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


<style>
    /* Code By Webdevtrick ( https://webdevtrick.com ) */
    *, *:before, *:after {
        box-sizing: border-box;
    }
    html {
        overflow-y: scroll;
    }
    body {
        background: #f3f3f3;
        font-family: 'Manjari', sans-serif;
    }
    a {
        text-decoration: none;
        color: #1da1f2;
        transition: .5s ease;
    }
    a:hover {
        color: #0080ff;
    }
    .form {
        background: rgb(22,19,54, 0.9);
        padding: 40px;
        max-width: 600px;
        margin: 40px auto;
        border-radius: 4px;
        box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
    }
    .top-area {
        list-style: none;
        padding: 0;
        margin: 0 0 40px 0;
    }
    .top-area:after {
        content: "";
        display: table;
        clear: both;
    }
    .top-area li a {
        display: block;
        text-decoration: none;
        padding: 15px;
        background: rgba(160, 179, 176, 0.25);
        color: #a0b3b0;
        font-size: 20px;
        float: left;
        width: 50%;
        text-align: center;
        cursor: pointer;
        transition: .5s ease;
    }
    .top-area li a:hover {
        background: #0080ff;
        color: #ffffff;
    }
    .top-area .active a {
        background: #1da1f2;
        color: #ffffff;
    }

    .tab-content > div:last-child {
        display: none;
    }

    h1 {
        text-align: center;
        color: #ffffff;
        font-weight: 300;
        margin: 0 0 40px;
    }
    label {
        position: absolute;
        -webkit-transform: translateY(6px);
        transform: translateY(6px);
        left: 13px;
        color: rgba(255, 255, 255, 0.5);
        transition: all 0.25s ease;
        -webkit-backface-visibility: hidden;
        pointer-events: none;
        font-size: 22px;
    }
    label .req {
        margin: 2px;
        color: #1da1f2;
    }
    label.active {
        -webkit-transform: translateY(50px);
        transform: translateY(50px);
        left: 2px;
        font-size: 14px;
    }
    label.active .req {
        opacity: 0;
    }
    label.highlight {
        color: #ffffff;
    }
    input, textarea {
        font-size: 22px;
        display: block;
        width: 100%;
        height: 100%;
        background: none;
        background-image: none;
        border: 1px solid #a0b3b0;
        color: #ffffff;
        border-radius: 0;
        transition: border-color .25s ease, box-shadow .25s ease;
    }
    input:focus, textarea:focus {
        outline: 0;
        border-color: #1da1f2;
    }
    textarea {
        border: 2px solid #a0b3b0;
        resize: vertical;
    }
    .label-field {
        position: relative;
        margin-bottom: 40px;
    }
    .top-row:after {
        content: "";
        display: table;
        clear: both;
    }
    .top-row > div {
        float: left;
        width: 48%;
        margin-right: 4%;
    }
    .top-row > div:last-child {
        margin: 0;
    }
    .button {
        border: 0;
        outline: none;
        border-radius: 0;
        padding: 15px 0;
        font-size: 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
        background: #1da1f2;
        color: #ffffff;
        transition: all 0.5s ease;
        -webkit-appearance: none;
    }
    .button:hover, .button:focus {
        background: #0080ff;
    }
    .button-block {
        display: block;
        width: 100%;
    }
    .forgot {
        margin-top: -20px;
        text-align: right;
    }
    @media (max-width: 765px) {
        label {
            left: 0;
        }    }
    }


</style>
