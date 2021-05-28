<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Определение делимости и неделимости земельных участков</title>
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
                            {{ $updatedFields['cadastral_number'] }}, расположенный по адресу: г. Нур-Султан, район «{{ $updatedFields['region'] }}»,
                            улица {{ $updatedFields['ulica_mestop_z_u'] }}, предназначенный для строительства и эксплуатации
                            {{ $updatedFields['object_name'] }} является {{ $updatedFields['division'] }}.
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
                            <barcode code="{{ implode(' ', [$QR_text]) }}" type="QR" class="barcode" size="1" error="M" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
