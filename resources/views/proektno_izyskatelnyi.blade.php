<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Проведение обследования, изыскательских и проектных работ объекта</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    body {
        font-family: times;
        font-size: 14px;
        line-height: normal;
        letter-spacing: 0.5px
    }
</style>

<body>
    <div class="panel panel-primary">
        <div class="panel-heading">
            {{-- <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo"
                height="185" /> --}}
            <p style="text-align: center;"><b>Выписка из постановления акимата города қазақ
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
                    <b>О разрешении на проведение
                        изыскательских и проектных
                        работ объекта промышленно-
                        гражданского назначения
                        на земельном участке</b>
                </p>
                <p style="padding-top: 15px; text-indent: 2em;">
                    В соответствии со статьей 71 Земельного кодекса Республики Казахстан от 20 июня 2003 года,
                    статьей 37 Закона
                    Республики Казахстан от 23 января 2001 года «О местном государственном управлении и
                    самоуправлении в Республике
                    Казахстан», акимат города Нур-Султан <b>ПОСТАНОВЛЯЕТ:</b>
                </p>
                <p style="text-indent: 2em;">
                    1. Разрешить «{{ $updatedFields['applicant_name'] }} <!-- Наименование застройщика -->» (далее - застройщик) в течение «{{ $updatedFields['duration'] }} месяцев<!-- Срок предоставления -->»
                    проведение:<br />
                    изыскательских работ на земельном участке площадью {{ $updatedFields['area'] }} га<!-- Площадь -->, расположенном по
                    адресу: город Нур-Султан, район «{{ $updatedFields['square'] }}<!-- Район -->», улица {{ $updatedFields['street'] }}<!-- Улица -->;
                    проектных работ объекта «{{ $updatedFields['object_name'] }}<!-- Наименование объекта -->» (далее – объект).
                </p>
                <p style="text-indent: 2em;">
                    2. Застройщику:<br />
                    1) в течение 10-ти рабочих дней заключить договор об условиях проведения изыскательских и
                    проектных работ объекта на
                    земельном участке с Государственным учреждением «Управление архитектуры, градостроительства
                    и земельных отношений
                    города Нур-Султан»;<br />
                    2) получить сведения о наличии либо отсутствии собственников и землепользователей в границах
                    проектируемого
                    земельного участка в Департаменте земельного кадастра и технического обследования
                    недвижимости филиала
                    некоммерческого акционерного общества «Государственная корпорация «Правительство для
                    граждан» по городу
                    Нур-Султан;<br />
                    3) в случае наличия собственников и землепользователей в границах проектируемого земельного
                    участка, заключить
                    договор об условиях компенсации убытков с каждым из собственников недвижимости, находящейся
                    на данном земельном
                    участке;<br />
                    4) проектные работы по объекту осуществить при условии выполнения подпункта 3) пункта 2
                    настоящего
                    постановления.<br />
                </p>
                <p style="text-indent: 2em;">
                    3. В случае незаключения договора в срок, указанный в подпункте 1) пункта 2, настоящее
                    постановление считать утратившим силу.<br />
                    4. Контроль за исполнением настоящего постановления оставляю за собой.
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
</body>

</html>
