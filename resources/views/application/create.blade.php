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
                @if($process->name == 'Определение делимости и неделимости земельных участков')
                    @include('application.create_application.delimost')
                @else
                    @include('application.create_application.standard')
                @endif
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
                // console.log(xhr.responseText);
                location.reload();
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
    @if($process->name == 'Определение делимости и неделимости земельных участков')
        @include('application.maps.map_find')
    @else
        @include('layouts.map')
    @endif
@endif

@append