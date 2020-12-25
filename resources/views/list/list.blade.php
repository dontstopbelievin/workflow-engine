<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Project </title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Todo List <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                    </div>
                    <div class="panel-body" id="items">
                        <ul class="list-group">
                            @foreach($items as $item)
                            <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{$item->item}}
                                <input type="hidden" id="itemId" value = {{$item->id}}>
                            </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" name="item" id="searchItem" placeholder="Search">
                </div>
                <img src="images/header.jpg" alt="logo" height="200" />
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="title">Add New Item</h4>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" id="id">
                                <p><input type="text" placeholder="Write item here" id="addItem" class="form-control"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="delete" style="display:none" data-dismiss="modal">Delete</button>
                                <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none" >Save changes</button>
                                <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Add Item</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>

    {{csrf_field()}}
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '.ourItem', function(event) {
                    var text = $(this).text();
                    var id  = $(this).find('#itemId').val();
                    $('#title').text('Edit Item');
                    text = $.trim(text);
                    $('#addItem').val(text);
                    $('#delete').show('400');
                    $('#saveChanges').show('400');
                    $('#AddButton').hide('400');
                    $('#id').val(id);
                    console.log(text);
            });

            $(document).on('click', '#addNew', function(event) {
                    $('#title').text('Add New Item');
                    $('#addItem').val("");
                    $('#delete').hide('400');
                    $('#saveChanges').hide('400');
                    $('#AddButton').show('400');
            });

            $('#AddButton').click(function(event) {
                var text = $('#addItem').val();

                if (text == '') {
                    alert('Please type anything');
                }
                $.post('list', {'text':text, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });

            $('#delete').click(function(event) {
                var id = $('#id').val();
                $.post('list/delete', {'id':id, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });
            $('#saveChanges').click(function(event) {
                var id = $('#id').val();
                var value = $('#addItem').val();
                $.post('list/update ', {'id':id, 'value':value,'_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });
            $( function() {

                $( "#searchItem" ).autocomplete({
                    source: 'http://127.0.0.1:8000/list/search'
                });
            } );
        });
    </script>
</body>
</html>


{{--@extends('layouts.app')--}}

{{--@section('content')--}}

    {{--<div class="p-6 bg-indigo-900 min-h-screen flex justify-center items-center">--}}
        {{--<div class="w-full max-w-md">--}}
            {{--<!-- onsubmit = "handleEcpSubmit()" -->--}}
            {{--<!-- <h1 class="text-2xl text-center text-white">ГУ "Управление архитектуры, градостроительства и земельных отношений города Нур-Султан"</h1> -->--}}
            {{--<form method = "POST" onsubmit = "handleEcpSubmit()" name="myForm" id="myForm" class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">--}}
                {{--@csrf--}}
                {{--<div class="px-10 pb-12 pt-6">--}}
                    {{--<div>--}}
                        {{--<ul class="flex justify-center">--}}
                            {{--<li class="font-semibold text-center block border-b-4 border-indigo-900 p-4 rounded-t cursor-pointer">Авторизация с ЭЦП</li>--}}
                            {{--<li class="text-gray-600 text-center block border-b p-4 transition duration-300 hover:text-black hover:bg-gray-300 rounded-t cursor-pointer">Авторизация с Email</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="h-10 mt-10 flex items-baseline">--}}
                        {{--<div class="w-2/3 pr-2">--}}
                            {{--<input id="path" name="path" placeholder="Файл ЭЦП" class="form-input" value="">--}}
                            {{--<div class="form-error">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- <input class="btn btn-primary h-auto w-1/3 btn-indigo px-0 transition duration-300" type="file" name="ecpFile" id="ecpFile"></input> -->--}}
                        {{--<button class="btn btn-primary h-auto w-1/3 btn-indigo px-0 transition duration-300" type="button" onclick="handleSend()">Выбрать ЭЦП</button>--}}
                    {{--</div>--}}
                    {{--<div class="pt-4 w-full">--}}
                        {{--<label class="form-label" for="password">Пароль: <span class="text-red-600">*</span></label>--}}
                        {{--<input id="password" name="password" placeholder="Пароль" type="password" class="form-input" required>--}}
                        {{--<div class="form-error">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="px-10 py-4 bg-gray-100 border-t border-gray-200 flex items-center justify-end">--}}
                    {{--<button class="btn btn-primary btn-indigo transition duration-300" id="AddButton" type="submit">Войти</button>--}}
                    {{--<!-- <input type="submit" value="submit"> -->--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--<!-- <button type="button" class="btn btn-primary" id="AddButton">Add Item</button> -->--}}
            {{--<p class="result" style="color:green"></p>--}}
        {{--</div>--}}
    {{--</div>--}}



    {{--<script>--}}


        {{--var file = "";--}}
        {{--var ready = false;--}}
        {{--var ecpData = {--}}
            {{--path: "",--}}
            {{--password: "",--}}
        {{--}--}}
        {{--var errMsg = {--}}
            {{--errHeader: "",--}}
            {{--errBody: "",--}}
        {{--}--}}



        {{--var websocket = new WebSocket("wss://127.0.0.1:13579/");--}}
        {{--websocket.onopen = function(e) {--}}
            {{--console.log("[open] Connection established");--}}
            {{--console.log(websocket);--}}
            {{--ready = true;--}}
        {{--};--}}
        {{--websocket.onclose = (e) => {--}}
            {{--if (e.wasClean) {--}}
                {{--console.log("connection closed");--}}
            {{--} else {--}}
                {{--console.log(--}}
                    {{--"connection error: [code]=" + e.code + ", [reason]=" + e.reason--}}
                {{--);--}}
            {{--}--}}
        {{--};--}}
        {{--function  handleSend() {--}}
            {{--if (!ready) {--}}
                {{--errMsg({--}}
                    {{--errHeader: "Ошибка при подключении к прослойке",--}}
                    {{--errBody: "Убедитесь что программа NCALayer запущена"--}}
                {{--});--}}
            {{--} else {--}}
                {{--const data = {--}}
                    {{--method: "browseKeyStore",--}}
                    {{--args: ["PKCS12", "P12", ""]--}}
                {{--};--}}
                {{--websocket.send(JSON.stringify(data));--}}
            {{--}--}}
        {{--};--}}


        {{--websocket.onmessage = e => {--}}
            {{--const data = JSON.parse(e.data);--}}

            {{--if (typeof data.result === "string") {--}}
                {{--const fileArr = data.result.split("\\");--}}
                {{--file = fileArr[fileArr.length - 1];--}}
                {{--document.getElementById('path').value = file;--}}
                {{--ecpData = { ...ecpData, path: data.result };--}}
                {{--console.log(ecpData);--}}
                {{--var pass = document.getElementById("password").value;--}}
                {{--console.log(typeof(pass))--}}
            {{--}--}}
        {{--};--}}


        {{--var pass = document.getElementById("password").value;--}}
        {{--// console.log(typeof(pass));--}}
        {{--ecpData = { ...ecpData, password: pass };--}}

        {{--function handleEcpSubmit(e) {--}}
            {{--// alert(ecpData["path"]);--}}
            {{--// alert(ecpData["password"]);--}}
            {{--e.preventDefault();--}}

            {{--axios--}}
                {{--.post("/loginwithecp/bar", ecpData)--}}
                {{--.then(response => {--}}
                    {{--const newEmail = response.data.email;--}}
                    {{--const newPassword = response.data.password;--}}
                    {{--// setValues({ email: newEmail, password: newPassword });--}}
                    {{--// setFetching(true);--}}
                {{--})--}}
                {{--.catch(err => {--}}
                    {{--if (err.response) {--}}
                        {{--if (err.response.status === 401) {--}}
                            {{--errMsg({--}}
                                {{--errHeader: "Ошибка авторизации",--}}
                                {{--errBody:--}}
                                    {{--"Такого пользователя нет в системе. Обратитесь к администратору"--}}
                            {{--});--}}
                        {{--} else if (err.response.status === 500) {--}}
                            {{--errMsg({--}}
                                {{--errHeader: "Ошибка авторизации",--}}
                                {{--errBody:--}}
                                    {{--"Неправильный пароль для ЭЦП или неверный формат P12. Пожалуйста, введите еще раз"--}}
                            {{--});--}}
                        {{--}--}}
                    {{--}--}}
                {{--});--}}
        {{--};--}}


        {{--//   function sendJSON(){ --}}
        {{--//             // alert('hello world')--}}
        {{--//                let result = document.querySelector('.result'); --}}
        {{--//                let name = document.querySelector('#name'); --}}
        {{--//                let email = document.querySelector('#email'); --}}

        {{--//                // Creating a XHR object --}}
        {{--//                let xhr = new XMLHttpRequest(); --}}
        {{--//                let url = "/loginwithecp"; --}}

        {{--//                // open a connection --}}
        {{--//                xhr.open("POST", url, true); --}}

        {{--//                // Set the request header i.e. which type of content you are sending --}}
        {{--//                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content')); --}}

        {{--//                // Create a state change callback --}}
        {{--//                xhr.onreadystatechange = function () { --}}
        {{--//                    if (xhr.readyState === 4 && xhr.status === 200) { --}}

        {{--//                        // Print received data from server --}}
        {{--//                        result.innerHTML = this.responseText; --}}
        {{--//                     // console.log('nice');--}}

        {{--//                    } --}}
        {{--//                }; --}}

        {{--//                // Converting JSON data to string --}}
        {{--//                var data = JSON.stringify({ "path": ecpData.path, "password": ecpData.password }); --}}

        {{--//                // Sending data with the request --}}
        {{--//                xhr.send(data); --}}
        {{--//            } --}}



        {{--$('#AddButton').click(function(event) {--}}
            {{--event.preventDefault();--}}
            {{--var pass = document.getElementById("password").value;--}}

            {{--$.post('/loginwithecp/bar', {'path':ecpData.path, 'password':pass,'_token':$('input[name=_token]').val()}, function(data){--}}
                {{--console.log(data);--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}
