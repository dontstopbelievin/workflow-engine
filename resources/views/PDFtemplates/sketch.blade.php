<html>
<table class="header_table">
    <tr class="header_top">
        <td width="40%">
            <b>«Нұр-Сұлтан қаласының сәулет, қала құрылысы және жер қатынастары
                басқармасы»</b>
        </td>
        <td width="20%" style="vertical-align: top; size: 30px;">
            <img style="size: 30px;" src="https://pricom.kz/images/2019/03/GERBBB.jpg" alt="logo" />
        </td>
        <td width="40%">
            <b>ММ ГУ «Управление архитектуры, градостроительства и земельных
                отношений города Нур-Султан»</b>
        </td>
    </tr>
    <tr class="header_bottom">
        <td>
            г.Нур-Султан, Азербайжан Мамбетов, дом № 24<br />
            тел.: (727) 279-57-38, 279-54-90<br />
            тел./факс: (727) 279-58-24<br />
            e-mail: uaigkz@mail.ru
            <p style="font-size: 14px; margin-top: 10px;">
                Номер: {{ $variable }}<br />
                Наименование заявителя: {{ $variable }}<br />
                Адрес: {{ $variable }}<br />
            </p>
        </td>
        <td></td>
        <td style="text-align: right;">
            Нур-Султан қ., Азербайжан Мамбетов, № 24 үй<br />
            тел.: (727) 279-57-38, 279-54-90<br />
            тел./факс: (727) 279-58-24<br />
            e-mail: uaigkz@mail.ru
            <p style="font-size: 14px; margin-top: 10px;">
                Номері: {{ $variable }}<br />
                Өтініш беруші: {{ $variable }}<br />
                Мекен жай: {{ $variable }}<br />
            </p>
        </td>
    </tr>
</table>

<p style="text-align: center; padding-left: 10px;"><b>СОГЛАСОВАНИЕ ЭСКИЗА (ЭСКИЗНОГО ПРОЕКТА)</b></p>
<!-- <p style="padding-left: 20px;"><b>{{ $variable }}</b></p> -->

<p style="text-indent: 5em;">
    ГУ «Управление архитектуры, градостроительства и земельных отношений города Нур -Султан» рассмотрев Ваше заявление
    от «{{ $variable }}» года KZ{{ $variable }} на согласование эскиза (эскизного проекта), согласовывает
    эскиз (эскизный проект).
</p>

<p style="text-align: left; padding-left: 5em;">
    Дата согласования: {{ $variable }}
</p>
<p style="text-align: left; padding-left: 5em;">
    Заместитель руководителя: {{ $variable }}
</p>

<barcode code="{{ implode(' ', [$variable]) }}" type="QR" class="barcode" size="1" error="M" />
