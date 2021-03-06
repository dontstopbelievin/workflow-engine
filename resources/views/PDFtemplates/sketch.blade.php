<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Согласование эскиза (эскизного проекта)</title>
</head>
<style type="text/css">
    body {
        font-family: Times New Roman;
        font-size: 14px;
    }

</style>

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <!-- <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo" height="200" /> -->
                    <img src="images/header.jpg" alt="logo" height="200" >
                    <table class="header_table">
                        <tr class="header_bottom">
                            <td>
                                Номер: KZ{{ $updatedFields["id"] }}<!-- номер документа/заявка -->
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                {{ $updatedFields["applicant_name"] }}<!-- наименование заявителя --> <br />
                            </td>
                            <td style="text-align: right;">
                                {{ $updatedFields["applicant_address"] }}<!-- адрес заявителя -->
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
                            от {{ $updatedFields["date"] }}<!-- дата подачи заявления --> года KZ{{ $updatedFields["id"] }}<!-- номер документа/заявка --> на согласование эскиза (эскизного проекта),
                            согласовывает эскиз (эскизный проект).
                        </p>
                        <p style="padding-left: 2em;">
                            Дата согласования: {{ $updatedFields["date"] }}<!-- дата согласование -->
                        </p>
                        <p style="text-indent: 2em;">
                            Заместитель руководителя: Жанбыршы Алмас Маликович<!-- ФИО -->
                        </p>
                        <p style="display: none">{{ $role1 = utf8_encode('Алтаев Данияр') }}</p>
                        <p style="display: none">{{ $role2 = utf8_encode('Жакупова Айгуль Ильясовна') }}</p>
                        <p style="display: none">{{ $role3 = utf8_encode('Абаев Анзор') }}</p>
                        <p style="display: none">{{ $role4 = utf8_encode('Жанбыршы Алмас Маликович') }}</p>
                        <div style="padding: 15px; align-content: center">
                            <barcode code="{{ implode(' ', [$QR_text]) }}" type="QR" class="barcode" size="1" error="M" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
