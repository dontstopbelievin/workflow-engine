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
                            <td width="50%">
                                <b>№ {{ $variable }}<br /></b>
                            </td>
                            <td width="50%" style="horizontal-align: right;">
                                <b>от «{{ $variable }}» {{ $variable }} года<br /></b>
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
                            «{{ $variable }}»
                            {{ $variable }} года №{{ $variable }},
                            акимат города Нур-Султан <b>ПОСТАНОВЛЯЕТ:</b>
                        </p>
                        <p style="text-indent: 2em;">
                            1. Изменить {{ $updatedFields['cadastral_number'] }} целевое назначение земельногоучастка с
                            кадастровым номером
                            21-{{ $updatedFields['cadastral_number'] }}, площадью
                            {{ $updatedFields['cadastral_number'] }} га с «Строительство и эксплуатация {{ $variable }}»
                            на
                            «Строительство {{ $variable }}», расположенный по адресу: город Нур-Султан,
                            район «{{ $variable }}», ул. {{ $variable }}, участок № {{ $variable }}.
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>
