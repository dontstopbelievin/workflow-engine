<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Приобретение прав на земельные участки, которые находятся в государственной собственности, не требующее
        проведения торгов (конкурсов, аукционов) 2 часть</title>
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
                    <p style="text-align: center;"><b>ВЫПИСКА</b></p>
                    <hr style="height:1px;border-width:0; background-color:#008cff;">
                    <p style="text-align: center;"><b>из протокола заседания земельной комиссии
                            акимата города Нур-Султан</b></p>
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
                            О предоставлении права временного
                            возмездного землепользования
                            на земельный участок
                        </p>
                        <p style="text-indent: 2em; padding-top: 15px;">
                            В соответствии со статьей 43 Земельного кодекса Республики Казахстан от 20 июня 2003 года,
                            статьей 37 Закона
                            Республики Казахстан от 23 января 2001 года «О местном государственном управлении и
                            самоуправлении в Республике
                            Казахстан», на основании заключения Земельной комиссии акимата города Нур-Султан от
                            «{{ $updatedFields['date'] }}»
                            № «{{ $updatedFields['id'] }}», акимат города Нур-Султан <b>ПОСТАНОВЛЯЕТ:</b>
                        </p>
                        <p style="text-indent: 2em;">
                            1. Предоставить {{ $updatedFields['applicant_name'] }} (далее − землепользователь) право временного
                            возмездного землепользования на земельный участок площадью «{{ $updatedFields['area'] }}» га, на новый
                            срок – «{{ $updatedFields['duration'] }}», для эксплуатации «{{ $updatedFields['object_name'] }}», расположенный по
                            адресу: город Нур-Султан, район «{{ $updatedFields['square'] }}», ул. {{ $updatedFields['street'] }}, дом
                            «{{ $updatedFields['house_number'] }}».
                        </p>
                        <p style="text-indent: 2em;">
                            2. Землепользователю:<br />
                            в течение 10-ти рабочих дней заключить договор о временном возмездном землепользовании на
                            земельный участок с Государственным учреждением «Управление архитектуры, градостроительства
                            и земельных отношений города Нур-Султан» и получить идентификационный документ;<br />
                            обеспечить беспрепятственный проезд и доступ уполномоченным органам, смежным
                            землепользователям (собственникам) для строительства и эксплуатации подземных и надземных
                            коммуникаций в установленном порядке законодательством Республики Казахстан.<br />
                            3. В случае незаключения договора в указанный срок настоящее постановление считать утратившим силу.<br />
                            4. Контроль за исполнением настоящего постановления возложить на заместителя акима города Нур-Султан Нуркенова Н.Ж.<br />
                        </p>
                        <p style="text-indent: 2em; padding-top: 15px;">
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
