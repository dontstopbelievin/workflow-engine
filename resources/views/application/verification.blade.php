@extends('layouts.app')
@section('content')
<div class="main-panel" style="width: 100%">
    <div class="content">
        <div class="container-fluid">
            <div class="card col-md-6 mx-auto">
                <div class="card-body">
                    @if(isset($done))
                    <div>
                        <div class="text-center">Гос услуга: {{$process->name}}</div>
                        <div class="tab">
                            <button class="tablinks active" id="mybutton" onclick="openTab_4(event, 'user')">Заявитель</button>
                            <button class="tablinks" onclick="openTab_4(event, 'applicationInfo')">Заявление</button>
                            <button class="tablinks" onclick="openTab_4(event, 'template')">Данные документа</button>
                            <button class="tablinks" onclick="openTab_4(event, 'sign')">Подпись</button>
                        </div>
                        <div id="user" class="tabcontent" style="display: block;">
                            <ul class="list-group" id="list">
                                Данные заявителя:
                                <li class="list-group-item">ФИО: {{$user->sur_name}} {{$user->first_name}} {{$user->middle_name}}</li>
                                <li class="list-group-item">Телефон:{{$user->phone}}</li>
                                <li class="list-group-item">Email: {{$user->email}}</li>
                                @if(isset($user->iin))
                                    <li class="list-group-item">ИИН: {{$user->iin}}</li>
                                @else
                                    <li class="list-group-item">БИН: {{$user->bin}}</li>
                                @endif
                            </ul>
                        </div>
                        <div id="applicationInfo" class="tabcontent">
                            <ul class="list-group" id="list">
                                Данные заявления:
                                @if(isset($aRowNameRows) && count($application_arr) > 0)
                                   @foreach($aRowNameRows as $aRowNameRow)
                                        @if(array_key_exists($aRowNameRow->name, $application_arr))
                                            @if($aRowNameRow->inputName == 'file')
                                                <li class="list-group-item">{{$aRowNameRow->labelName}}: <a href="{{url('storage/' .$application_arr[$aRowNameRow->name])}}" target="_blank">Просмотр</a></li>
                                            @else
                                                <li class="list-group-item">{{$aRowNameRow->labelName}}: {{$application_arr[$aRowNameRow->name]}}</li>
                                            @endif
                                        @endif
                                   @endforeach
                                @else
                                    <li class="list-group-item">Заявка пустая.</li>
                                @endif
                            </ul>
                        </div>
                        <div id="template" class="tabcontent">
                            @isset($templateFields)
                                Данные документа "{{$templateFields->name}}":
                                <ul class="list-group" id="list">
                                    @if(count($templateFields->fields) > 0)
                                        @foreach($templateFields->fields as $key=>$value)
                                            @if(substr($value['value'], 0, 16) === 'application-docs')
                                                <li class="list-group-item">{{$value['label']}}: <a href="{{asset('storage/' .$value['value'] )}}" target="_blanc">Просмотр</a></li>
                                            @else
                                                @if($key == 'pdf_url')
                                                    <li class="list-group-item">Выходной документ: <a href="{{asset('storage/' .$value['value'] )}}" target="_blanc">Просмотр</a></li>
                                                @else
                                                    <li class="list-group-item">{{$value['label']}}: {{$value['value']}}</li>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        <li class="list-group-item">Данные не введены.</li>
                                    @endif
                                </ul>
                            @endisset
                        </div>
                        <div id="sign" class="tabcontent">
                        </div>
                    </div>
                    @else
                        @if(is_array('error'))
                            <div class="my_message alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                @foreach($error as $m)
                                    <strong>{{ $m }}</strong>
                                @endforeach
                            </div>
                        @else
                            <div class="my_message alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $error }}</strong>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function openTab_4(evt, tabName) {
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@append