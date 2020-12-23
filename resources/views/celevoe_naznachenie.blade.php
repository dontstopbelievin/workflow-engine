<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Выдача решения на изменение целевого назначения</title>
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
                    {{-- <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo" height="185" /> --}}
                    <p style="text-align: center;"><b>Выписка из постановления акимата города
                            Нур-Султан</b></p>
                    <hr style="height:1px;border-width:0; background-color:#008cff;">
                    <table class="header_table">
                        <tr class="header_bottom">
                            <td>
                                № {{ $updatedFields["id"] }}<br />
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                от «{{ $updatedFields["date"] }}» <br />
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="main-div">
                        <p style="padding-top: 15px;" width="40%">
                            Об изменении целевого <br />
                            назначения земельного участка
                        </p>
                        <p style="padding-top: 15px; text-indent: 2em;">
                            В соответствии со статьей 49-1 Земельного кодекса Республики Казахстан от 20 июня 2003 года,
                            статьей 37 Закона
                            Республики Казахстан от 23 января 2001 года «О местном государственном управлении и
                            самоуправлении в Республике
                            Казахстан», на основании заключения Земельной комиссии акимата города Нур-Султан от
                            «{{ $updatedFields["date"] }}»
                             №{{ $updatedFields["id"] }},
                            акимат города Нур-Султан <b>ПОСТАНОВЛЯЕТ:</b>
                        </p>
                        <p style="text-indent: 2em;">
                            1. Изменить {{ $updatedFields['applicant_name'] }} целевое назначение земельногоучастка с
                            кадастровым номером
                            21-{{ $updatedFields['cadastral_number'] }}, площадью
                            {{ $updatedFields['area'] }} с « {{ $updatedFields['construction_name_before'] }}»
                            на
                            « {{  $updatedFields['construction_name_after'] }}», расположенный по адресу: город Нур-Султан,
                            район «{{ $updatedFields['square'] }}», ул. {{ $updatedFields['street'] }}, участок № {{ $updatedFields['area_number'] }}.
                        </p>
                        <p style="text-indent: 2em;">
                            получить акт на право собственности на земельный участок;
                        </p>
                        <p style="text-indent: 2em;">
                            обеспечить беспрепятственный проезд и доступ уполномоченным органам, смежным
                            землепользователям, собственникам для
                            строительства и эксплуатации подземных и надземных коммуникаций в установленном
                            законодательством Республики
                            Казахстан порядке.
                        </p>

                        <p style="text-indent: 2em;">
                            <b>Выписка верна</b>
                        </p>
                        <p style="padding-left: 2em; width: 200px;">
                            <b>Руководитель Управления
                                архитектуры, градостроительства
                                и земельных отношений
                                города Нур-Султан</b>
                        </p>
                    </div>

                    <p style="display: none">{{ $role1 = utf8_encode('Алтаев Данияр') }}</p>
                    <p style="display: none">{{ $role2 = utf8_encode('Жакупова Айгуль Ильясовна') }}</p>
                    <p style="display: none">{{ $role3 = utf8_encode('Абаев Анзор') }}</p>
                    <p style="display: none">{{ $role4 = utf8_encode('Жанбыршы Алмас Маликович') }}</p>
                    <div style="padding: 15px; align-content: center">
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role1)) !!}" height="100">
                        </div>
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role2)) !!}" height="100">
                        </div>
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role3)) !!}" height="100">
                        </div>
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role4)) !!}" height="100">
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
