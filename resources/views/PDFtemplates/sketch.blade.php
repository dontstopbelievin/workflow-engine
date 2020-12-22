<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Согласование эскиза (эскизного проекта)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    body {
        font-family: times;
        font-size: 14px;
    }

</style>

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo" height="185" />
                    <table class="header_table">
                        <tr class="header_bottom">
                            <td>
                                Номер: KZ{{ $variable }}<!-- номер документа/заявка -->
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                {{ $variable }}<!-- наименование заявителя --> <br />
                            </td>
                            <td style="text-align: right;">
                                {{ $variable }}<!-- адрес заявителя -->
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="main-div">
                        <p style="padding-top: 15px; text-align: center;">
                            <b>СОГЛАСОВАНИЕ ЭСКИЗА (ЭСКИЗНОГО ПРОЕКТА)</b>
                        </p>
                        <p style="padding-top: 15px; text-indent: 2em;">
                            ГУ «Управление архитектуры, градостроительства и земельных отношений города Нур -Султан»
                            рассмотрев Ваше заявление
                            от {{ $variable }}<!-- дата подачи заявления --> года KZ{{ $variable }}<!-- номер документа/заявка --> на согласование эскиза (эскизного проекта),
                            согласовывает эскиз (эскизный проект).
                        </p>
                        <p style="padding-left: 2em;">
                            Дата согласования: {{ $variable }}<!-- дата согласование -->
                        </p>
                        <p style="text-indent: 2em;">
                            Заместитель руководителя: {{ $variable }}<!-- ФИО -->
                        </p>   
                        <barcode code="{{ implode(' ', [$variable]) }}" type="QR" class="barcode" size="1" error="M" />                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
