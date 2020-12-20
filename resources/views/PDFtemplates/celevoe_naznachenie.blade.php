<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laravel 8 PDF File Download using JQuery Ajax Request Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:30px;
        padding:50px;
        background:#fff;
    }
    .pdf-btn{
        margin-top:30px;
    }
</style>
<body>
<div class="container">
    <div class="col-md-8 section offset-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>Laravel 8 PDF File Download using JQuery Ajax Request Example - NiceSnippets.com</h2>
            </div>
            <div class="panel-body">
                <div class="main-div">
                    <table class="header_table">
                        <tr class="header_top">
                            <td width="40%">
                                <b>"Привет как дела"</b>
                            </td>
                            <td width="20%" style="vertical-align: top; size: 30px;">
                                <img style="size: 30px;" src="https://pricom.kz/images/2019/03/GERBBB.jpg" alt="logo" />
                            </td>
                            <td width="40%">
                                <b>ММ ГУ «Управление архитектуры, градостроительства и земельных
                                    отношений города Нур-Султан»</b>
                            </td>
                        </tr>
                    </table>

                    <p style="text-align: center; padding-left: 10px;"><b>Выписка из постановления акимата города Нур-Султан</b></p>
                    <table>
                        <tr class="header_bottom">
                            <td>
                                № {{ $variable }}<br />
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                от «{{ $variable }}» {{ $variable }} года<br />
                            </td>
                            <td style="text-align: left;">
                                Об изменении целевого
                                назначения земельного участка
                                <br />
                            </td>
                        </tr>
                    </table>
                    <div>
                        В соответствии со статьей 49-1 Земельного кодекса Республики Казахстан от 20 июня 2003 года, статьей 37 Закона
                        Республики Казахстан от 23 января 2001 года «О местном государственном управлении и самоуправлении в Республике
                        Казахстан», на основании заключения Земельной комиссии акимата города Нур-Султан от «{{ $variable }}»
                        {{ $variable }} года №{{ $variable }},
                        акимат города Нур-Султан <b>ПОСТАНОВЛЯЕТ:</b>
                    </div>
                    <p style="text-indent: 5em;">
                        1. Изменить {{ $updatedFields["applicant_name"] }} целевое назначение земельногоучастка с кадастровым номером
                        21-{{ $updatedFields["cadastral_number"]}}, площадью {{ $updatedFields["area"] }} га с «Строительство и эксплуатация {{ $variable }}» на
                        «Строительство {{ $variable }}», расположенный по адресу: город Нур-Султан,
                        район «{{ $variable }}», ул. {{ $variable }}, участок № {{ $variable }}.
                    </p>
                    <p style="text-indent: 5em;">
                        получить акт на право собственности на земельный участок;
                    </p>
                    <p style="text-indent: 5em;">
                        обеспечить беспрепятственный проезд и доступ уполномоченным органам, смежным землепользователям, собственникам для
                        строительства и эксплуатации подземных и надземных коммуникаций в установленном законодательством Республики
                        Казахстан порядке.
                    </p>

                    <p style="text-align: left; padding-left: 5em;">
                        <b>Выписка верна</b>
                    </p>
                    <p style="text-align: left; padding-left: 5em;">
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
