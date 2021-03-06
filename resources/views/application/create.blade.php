@extends('layouts.app')

@section('title')
    Создание Заявки
@endsection

@if($process->need_map)
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/css/main.css">
<style type="text/css">
    #viewDiv{
        padding: 0;
        margin: 0;
        min-height: 400px;
        height: 100%!important;
        width: 100%;
    }
    .esri-search{
        width: 400px!important;
    }
    .esri-popup__main-container{
        resize: horizontal;
        max-height: 666px!important;
        overflow: scroll;
    }
    .esri-view-width-less-than-medium .esri-popup__main-container,
    .esri-view-width-xlarge .esri-popup__main-container,
    .esri-view-width-large .esri-popup__main-container,
    .esri-view-width-medium .esri-popup__main-container,
    .esri-view-height-less-than-medium .esri-popup__main-container{
        height: 300px!important;
        width: 466px!important;
    }
    .esri-popup__content{
        margin: 0px 0px 0px 10px!important;
        overflow: visible!important;
    }
    .esri-popup__footer{
        display:none!important;
    }
    .attrName {
        font-weight: bold;
    }
</style>
@endif
<style type="text/css">
    .in_label{
        font-weight: bold!important;
    }
</style>

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="page-title">
                            <a href="{{ url('docs') }}" class="btn btn-primary" style="margin-right: 10px;">Назад</a>
                        </h4>
                    </div>
                    <div class="col-md-8">
                        <h4 class="page-title text-center">
                            Создание заявки "{{$process->name}}"
                        </h4>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="alert alert-danger" id="error_box" style="display:none;">
                  <!-- errors HERE -->
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" id="templateFieldsId">
                        @foreach($arrayToFront as $item)
                            @if($item->inputName === 'file')
                                <label class="in_label">{{$item->labelName}}</label>
                                <input type="file" name={{$item->name}} class="form-control" multiple>
                            @elseif($item->inputName === 'text')
                                <label class="in_label" id={{'label'.$item->name}}>{{$item->labelName}}</label>
                                <input type="text" name={{$item->name}} id={{$item->name}} value="{{Auth::user()->{$item->name} ?? ''}}" class="form-control">
                            @elseif($item->inputName === 'hidden')
                                <input type="hidden" name={{$item->name}} id={{$item->name}} class="form-control">
                            @elseif($item->inputName === 'radio_button')
                                <div style="padding-top:10px;">
                                @foreach($item->options as $key => $val)
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="{{$item->name}}" value="{{$val->name_rus}}">
                                        <span class="form-radio-sign">{{$val->name_rus}}</span>
                                    </label>
                                @endforeach
                                </div>
                            @elseif($item->inputName === 'select')
                                <label class="in_label">{{$item->labelName}}</label>
                                <select name="{{$item->name}}" id="{{$item->name}}" class="form-control">
                                    <label>$item->name</label>
                                    <option selected disabled>Выберите Ниже</option>
                                    @foreach($item->options as $val)
                                        <option value="{{$val->name_rus}}">{{$val->name_rus}}</option>
                                    @endforeach
                                </select>
                            @elseif($item->inputName === 'checkbox')
                            <div class="form-group" style="padding-left: 0px;">
                                <label class="form-check-label py-0">
                                    <input type="checkbox" id="{{$item->name}}" name="{{$item->name}}" value="1" class="form-check-input">
                                    <span class="form-check-sign" style="color: black;">{{$item->labelName ?? ''}}</span>
                                </label>
                            </div>
                            @else
                                Неправильный формат поля
                            @endif
                        @endforeach
                        <input type="hidden" name="process_id" value={{$process->id}}>
                        <div style="margin-top: 20px">
                            @if($process->name == 'Предоставление земельного участка для строительства объекта в черте населенного пункта')
                                <button type="submit" onclick="submit_form()" class="btn btn-primary">Подать заявку</button>
                            @else
                                <button type="submit" onclick="create_applic()" class="btn btn-primary">Подать заявку</button>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($process->need_map)
                            <!-- <button class="btn btn-primary" onclick="add_land()" style="margin:10px 0px;">Добавить</button> -->
                            <div id="viewDiv" style="height: 0px"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">


    document.addEventListener("DOMContentLoaded", () => {
        let radio_btns = document.getElementsByName("zakaz4ik_fiz_ur");
        for (var i = 0; i < radio_btns.length; i++) {
            radio_btns[i].addEventListener('click', check_zayavitel_type);
        }
        let radio_btns2 = document.getElementsByName("zakaz4ik_drugoi");
        for (var i = 0; i < radio_btns2.length; i++) {
            radio_btns2[i].addEventListener('click', check_zakaz4ik);
        }
    });

    const check_zakaz4ik = () => {
        if(document.getElementsByName("zakaz4ik_drugoi")[0].checked){
            if(document.getElementById("name_organization")){
                document.getElementById("name_organization").style.display = 'none'
                document.getElementById("labelname_organization").style.display = 'none'
            }
            if(document.getElementById("name_ur_zakaz4ika")){
                document.getElementById("name_ur_zakaz4ika").style.display = 'none'
                document.getElementById("labelname_ur_zakaz4ika").style.display = 'none'
            }
            if(document.getElementById("bin_zakaz4ika")){
                document.getElementById("bin_zakaz4ika").style.display = 'none'
                document.getElementById("labelbin_zakaz4ika").style.display = 'none'
            }
            if(document.getElementById("iin_zakaz4ika")){
                document.getElementById("iin_zakaz4ika").style.display = 'none'
                document.getElementById("labeliin_zakaz4ika").style.display = 'none'
            }
            if(document.getElementById("name_fiz_zakaz4ika")){
                document.getElementById("name_fiz_zakaz4ika").style.display = 'none'
                document.getElementById("labelname_fiz_zakaz4ika").style.display = 'none'
            }
        }else{
            if((document.getElementsByName("zakaz4ik_fiz_ur")[1] !== undefined && document.getElementsByName("zakaz4ik_fiz_ur")[1].checked)
                || document.getElementsByName("zakaz4ik_fiz_ur")[1] === undefined){
                if(document.getElementById("name_organization")){
                    document.getElementById("name_organization").style.display = 'block'
                    document.getElementById("labelname_organization").style.display = 'block'
                }
                if(document.getElementById("name_ur_zakaz4ika")){
                    document.getElementById("name_ur_zakaz4ika").style.display = 'block'
                    document.getElementById("labelname_ur_zakaz4ika").style.display = 'block'
                }
                if(document.getElementById("bin_zakaz4ika")){
                    document.getElementById("bin_zakaz4ika").style.display = 'block'
                    document.getElementById("labelbin_zakaz4ika").style.display = 'block'
                }
                if(document.getElementById("iin_zakaz4ika")){
                    document.getElementById("iin_zakaz4ika").style.display = 'none'
                    document.getElementById("labeliin_zakaz4ika").style.display = 'none'
                }
                if(document.getElementById("name_fiz_zakaz4ika")){
                    document.getElementById("name_fiz_zakaz4ika").style.display = 'none'
                    document.getElementById("labelname_fiz_zakaz4ika").style.display = 'none'
                }
            }
            if((document.getElementsByName("zakaz4ik_fiz_ur")[0] !== undefined && document.getElementsByName("zakaz4ik_fiz_ur")[0].checked) || document.getElementsByName("zakaz4ik_fiz_ur")[0] === undefined){
                if(document.getElementById("iin_zakaz4ika")){
                    document.getElementById("iin_zakaz4ika").style.display = 'block'
                    document.getElementById("labeliin_zakaz4ika").style.display = 'block'
                }
                if(document.getElementById("name_fiz_zakaz4ika")){
                    document.getElementById("name_fiz_zakaz4ika").style.display = 'block'
                    document.getElementById("labelname_fiz_zakaz4ika").style.display = 'block'
                }
                if(document.getElementById("name_organization")){
                    document.getElementById("name_organization").style.display = 'none'
                    document.getElementById("labelname_organization").style.display = 'none'
                }
                if(document.getElementById("name_ur_zakaz4ika")){
                    document.getElementById("name_ur_zakaz4ika").style.display = 'none'
                    document.getElementById("labelname_ur_zakaz4ika").style.display = 'none'
                }
                if(document.getElementById("bin_zakaz4ika")){
                    document.getElementById("bin_zakaz4ika").style.display = 'none'
                    document.getElementById("labelbin_zakaz4ika").style.display = 'none'
                }
            }
        }
    }

    const check_zayavitel_type = () => {
        if(document.getElementsByName("zakaz4ik_fiz_ur")[0].checked){
            if(document.getElementById("bin")){
                document.getElementById("bin").style.display = 'none'
                document.getElementById("labelbin").style.display = 'none'
            }
            if(document.getElementById("iin")){
                document.getElementById("iin").style.display = 'block'
                document.getElementById("labeliin").style.display = 'block'
            }
            check_zakaz4ik()
        }else{
            if(document.getElementById("bin")){
                document.getElementById("bin").style.display = 'block'
                document.getElementById("labelbin").style.display = 'block'
            }
            if(document.getElementById("iin")){
                document.getElementById("iin").style.display = 'none'
                document.getElementById("labeliin").style.display = 'none'
            }
            check_zakaz4ik()
        }
    }

    const submit_form = () => {
        if(!to_add_graphic){
            alert('Вы не выбрали землю');
            return 0;
        }
        add_land()
    }

    const create_applic = () => {
        // form the formData
        let formData = new FormData();
        formData.append('_token', $('input[name=_token]').val());
        let inputs = $('#templateFieldsId :input');
        inputs.each(function() {
            if ('files' in $(this)[0] && $(this)[0].files != null) {
                var file = $(this)[0].files[0];
                if(file!==undefined) {
                    formData.append(this.name, file);
                }
            }else if(this.type === 'radio') {
              // console.log(this.value);
              if(!formData.has(this.name)){
                if(this.checked){
                  formData.append(this.name, this.value);
                } else {
                  formData.append(this.name, "");
                }
              }else{
                if(formData.get(this.name) == "" && this.checked){
                  formData.set(this.name, this.value);
                }
              }
            }else{
             formData.append(this.name, $(this).val());
            }
        });
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }
        // end of forming the formData
        // send to corresponding function of ApplicationController
        var xhr = new XMLHttpRequest();
        xhr.open("post", "/docs/store", true);
        xhr.setRequestHeader("Authorization", "Bearer " + $('input[name=_token]').val());
        xhr.onload = function () {
            if(xhr.status == 200){
                let res = JSON.parse(xhr.responseText);
                location.replace(window.location.origin+"/docs/services/mydocs/view/"+res.proc_id+"/"+res.app_id+"?deadline="+res.deadline);
                $('#error_box').hide('400');
                // location.reload();
            }else{
              console.log(xhr);
              var errors = JSON.parse(xhr.responseText);
              var errorString = '';
              $.each(errors.error, function( key, value) {
                  errorString += '<li>' + value + '</li>';
              });
              document.getElementById("error_box").innerHTML = errorString;
              $('#error_box').show('400');
            }
        }.bind(this)
        xhr.send(formData);
    }

    // const show_hide_map = () => {
    //     @if($process->name == 'Определение делимости и неделимости земельных участков')
    //         if(document.getElementById('viewDiv').style.height == '0px'){
    //           document.getElementById('viewDiv').style.height = '400px';
    //           document.getElementById('s_h_but').innerHTML = 'Скрыть карту';
    //           document.getElementById('s_point').style.display = 'inline-block';
    //         }else{
    //           document.getElementById('viewDiv').style.height = '0px';
    //           document.getElementById('s_h_but').innerHTML = 'Показать карту';
    //           document.getElementById('s_point').style.display = 'none';
    //         }
    //     @else
    //         if(document.getElementById('viewDiv').style.height == '0px'){
    //             document.getElementById('viewDiv').style.height = '400px';
    //             document.getElementById('s_h_but').innerHTML = 'Скрыть карту';
    //         }else{
    //             document.getElementById('viewDiv').style.height = '0px';
    //             document.getElementById('s_h_but').innerHTML = 'Показать карту';
    //         }
    //     @endif
    // }
</script>
@if($process->need_map)
    @if($process->name == 'Предоставление земельного участка для строительства объекта в черте населенного пункта')
        @include('application.maps.map_draw_polygon')
    @else
        @include('application.maps.map_find')
    @endif
@endif

@append
