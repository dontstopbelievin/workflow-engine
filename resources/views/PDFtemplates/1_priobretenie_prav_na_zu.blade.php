<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Приобретение прав на земельные участки, которые находятся в государственной собственности, не требующее
        проведения торгов (конкурсов, аукционов) 1 часть</title>
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
                                Протокол № {{ $updatedFields['id'] }}<br />
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
                        <p style="padding-top: 15px; text-indent: 2em;">
                            <i>
                                <b>4. Рассмотрение обращений физических и юридических лиц о предоставлении право
                                    собственности,
                                    аренды и постоянного землепользования на земельные участки для эксплуатации объектов
                                    промышленно-гражданского назначения, в частности:
                                </b>
                            </i>
                        </p>
                        <p style="text-indent: 2em;">
                            1) по поводу рассмотрения обращений физических и юридических лиц о предоставлении право
                            собственности, аренды и
                            постоянного землепользования на земельные участки для эксплуатации объектов
                            промышленно-гражданского назначения,
                            комиссия решила данные обращения «{{ $updatedFields['object_name'] }}» и вынести соответствующее заключение,
                            согласно приложению 7. Результаты голосования – большинством голосов.
                        </p>
                        <p style="text-indent: 2em;">
                            Срок действия данного заключения согласно пункту 2 статьи 43 Земельного кодекса Республики
                            Казахстан составляет один год со дня его принятия
                        </p>
                        <p style="text-indent: 2em; width: 200px;">
                            <b>Председатель комиссии –
                                Заместитель акима
                                города Нур-Султан</b>
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
