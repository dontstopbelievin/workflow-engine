<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Продажа земельного участка в частную собственность единовременно либо в рассрочку</title>
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
                    {{-- <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo"
                        height="185" /> --}}
                    <p style="text-align: center;"><b>Выписка из постановления акимата города
                            Нур-Султан</b></p>
                    <hr style="height:1px;border-width:0; background-color:#008cff;">
                    <table class="header_table">
                        <tr class="header_bottom">
                            <td>
                                № {{ $updatedFields['id'] }}<br />
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                от «{{ $updatedFields['date'] }}» <br />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="main-div">
                        <p style="padding-top: 15px; width: 200px;">
                            О предоставлении права общей
                            долевой собственности на
                            земельный участок
                        </p>
                        <p style="padding-top: 15px; text-indent: 2em;">
                            В соответствии со статьей 47 Земельного кодекса Республики Казахстан от 20 июня 2003 года,
                            статьей 37 Закона Республики Казахстан от 23 января 2001 года «О местном государственном
                            управлении и самоуправлении в Республике Казахстан», акимат города Нур-Султан
                            <b>ПОСТАНОВЛЯЕТ:</b>
                        </p>
                        <p style="text-indent: 2em;">
                            1. Предоставить {{ $updatedFields['applicant_name'] }} (далее − собственники) право общей долевой
                            собственности на земельный участок площадью {{ $updatedFields['area'] }} га, из них условная доля
                            {{ $updatedFields['area2'] }} га, для
                            эксплуатации «{{ $updatedFields['object_name'] }}», кадастровой (оценочной) стоимостью «{{ $updatedFields['cadastral_name'] }}» тенге,
                            расположенный по адресу: город Нур-Султан, р-н «{{ $updatedFields['square'] }}», улица {{ $updatedFields['street'] }}, дом
                            {{ $updatedFields['house_number'] }}, кв {{ $updatedFields['flat_number'] }}.
                        </p>
                        <p style="text-indent: 2em;">
                            2. Собственникам:<br />
                            1) в течение 10-ти рабочих дней заключить договор купли-продажи земельного участка с
                            Государственным учреждением «Управление архитектуры, градостроительства и земельных
                            отношений города Нур-Султан» и с момента заключения договора купли-продажи в течение 30-ти
                            календарных дней произвести полную оплату и получить идентификационный документ на земельный
                            участок;<br />
                            2) обеспечить беспрепятственный проезд и доступ уполномоченным органам, смежным
                            землепользователям (собственникам) для строительства и эксплуатации подземных и надземных
                            коммуникаций в установленном законодательством Республики Казахстан порядке.<br />
                            3. В случае незаключения договора в указанный срок настоящее постановление считать
                            утратившим силу.<br />
                            4. Контроль за исполнением настоящего постановления возложить на заместителя акима города
                            Нур-Султан .<br />
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
                        <p style="display: none">{{ $role2 = utf8_encode('Серикбаев Нурхан Жандосович') }}</p>
                        <p style="display: none">{{ $role3 = utf8_encode('Сагнаев Арман') }}</p>
                        <p style="display: none">{{ $role4 = utf8_encode('Аяпова Альбина') }}</p>
                        <div style="padding: 15px; align-content: center">
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
