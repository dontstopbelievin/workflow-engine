<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Определение делимости и неделимости земельных участков</title>
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
                    <!-- <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo" height="200" /> -->
                    <img src="images/header.jpg" alt="logo" height="200" >
                    <table class="header_table">
                        <tr class="header_bottom">
                            <td>
                                <p style="text-align: right;"><b>{{ $updatedFields['applicant_name'] }}</b></p>
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                <p style="text-align: right;">{{ $updatedFields['applicant_address'] }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="main-div">
                        <p style="padding-top: 15px; text-indent: 2em;">
                            Рассмотрев Ваше заявление от {{ $updatedFields['date'] }} № {{ $updatedFields['id'] }},
                            об определении делимости земельного участка, сообщаем следующее.
                        </p>
                        <p style="padding-left: 2em;">
                            Согласно проекта детальной планировки {{ $updatedFields['pdp_name'] }}
                            <!-- ПДП наименование -->, утвержденного
                            постановлением акимата города от {{ $updatedFields['date'] }}  №
                            {{ $updatedFields['id'] }}, где предусмотрено размещение
                            {{ $updatedFields['object_name'] }}.
                        </p>
                        <p style="text-indent: 2em;">
                            В этой связи, сообщаем, что земельный участок с кадастровым номером
                            21-__________________________, расположенный по адресу: г. Нур-Султан, район «____________»,
                            улица __________________, предназначенный для строительства и эксплуатации
                            ______________________ является _____________________.
                        </p>
                        <p style="text-indent: 2em;">
                            При этом отмечаем, что для перепечатки идентификационного документа, Вам необходимо
                            обратиться в филиал некоммерческого акционерного общества «Государственная корпорация
                            «Правительство для граждан» по городу Нур-Султан, поскольку, в соответствии с п.7 ст.43
                            Кодекса, изготовление и выдача идентификационного документа на земельный участок
                            осуществляются государственной корпорацией.
                        </p>
                        <p style="text-indent: 2em;">
                            Сообщается в порядке информации.
                        </p>
                        <p style="padding-left: 2em; width: 200px;">
                            <b>Руководитель местного
                                исполнительного органа
                            </b>
                        </p>
                        <p style="display: none">{{ $role1 = utf8_encode('Алтаев Данияр') }}</p>
                        <p style="display: none">{{ $role2 = utf8_encode('Жакупова Айгуль Ильясовна') }}</p>
                        <p style="display: none">{{ $role3 = utf8_encode('Абаев Анзор') }}</p>
                        <p style="display: none">{{ $role4 = utf8_encode('Жанбыршы Алмас Маликович') }}</p>
                        <div style="padding: 15px; align-content: center">
                            <div style="padding: 15px; display: inline">
                                <img src="data:image/png;base64, {!!  base64_encode(
                                    QrCode::format('svg')
                                        ->size(200)
                                        ->errorCorrection('H')
                                        ->generate($role1),
                                ) !!}" height="100">
                            </div>
                            <div style="padding: 15px; display: inline">
                                <img src="data:image/png;base64, {!!  base64_encode(
                                    QrCode::format('svg')
                                        ->size(200)
                                        ->errorCorrection('H')
                                        ->generate($role2),
                                ) !!}" height="100">
                            </div>
                            <div style="padding: 15px; display: inline">
                                <img src="data:image/png;base64, {!!  base64_encode(
                                    QrCode::format('svg')
                                        ->size(200)
                                        ->errorCorrection('H')
                                        ->generate($role3),
                                ) !!}" height="100">
                            </div>
                            <div style="padding: 15px; display: inline">
                                <img src="data:image/png;base64, {!!  base64_encode(
                                    QrCode::format('svg')
                                        ->size(200)
                                        ->errorCorrection('H')
                                        ->generate($role4),
                                ) !!}" height="100">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
