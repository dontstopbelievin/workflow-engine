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
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" id="templateFieldsId">
                        @foreach($arrayToFront as $item)
                            @if($item->inputName === 'file')
                                <label class="in_label">{{$item->labelName}}</label>
                                <input type="file" name={{$item->name}} class="form-control" multiple>
                            @elseif($item->inputName === 'text')
                                <label class="in_label">{{$item->labelName}}</label>
                                <input type="text" name={{$item->name}} id={{$item->name}} value="{{Auth::user()->{$item->name} ?? ''}}" class="form-control">
                            @elseif($item->inputName === 'hidden')
                                <input type="hidden" name={{$item->name}} id={{$item->name}} class="form-control">
                            @elseif($item->inputName === 'select')
                                <label class="in_label">{{$item->labelName}}</label>
                                <select name="{{$item->name}}" id="{{$item->name}}" class="form-control">
                                    <label>$item->name</label>
                                    <option selected disabled>Выберите Ниже</option>
                                    @foreach($item->options as $val)
                                        <option value="{{$val->name_rus}}">{{$val->name_rus}}</option>
                                    @endforeach
                                </select>
                            @else
                                ne eby
                            @endif
                        @endforeach
                        <input type="hidden" name="process_id" value={{$process->id}}>
                        <div style="margin-top: 20px">
                            <button type="submit" onclick="create_applic()" class="btn btn-primary">Подать заявку</button>
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

    const create_applic = () => {
        // form the formData
        let formData = new FormData();
        formData.append('_token', $('input[name=_token]').val());
        let inputs = $('#templateFieldsId :input');

        inputs.each(function() {
            if ('files' in $(this)[0] && $(this)[0].files != null) {
                var file = $('input[type=file]')[0].files[0];
                if(file!==undefined) {
                    formData.append(this.name, file);
                }
            } else {
             formData.append(this.name, $(this).val());
            }
        });
        // end of forming the formData

        // send to corresponding function of ApplicationController
        var xhr = new XMLHttpRequest();
        xhr.open("post", "/docs/store", true);
        xhr.setRequestHeader("Authorization", "Bearer " + $('input[name=_token]').val());
        xhr.onload = function () {
            if(xhr.status == 200){
                let res = JSON.parse(xhr.responseText);
                location.replace("http://workflow.back/docs/services/mydocs/view/"+res.proc_id+"/"+res.app_id+"?deadline="+res.deadline);
                // location.reload();
            }else{
                console.log(xhr.responseText);
                alert('Ошибка');
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
    @include('application.maps.map_find')
@endif

@append