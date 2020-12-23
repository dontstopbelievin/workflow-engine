<?php
/**
 * @var \App\landinlocality $landinlocality
 * @var \App\landinlocalityStateHistory $state
 */
?>
<table class="header_table">
    <tr class="header_top">
        <td width="40%"><b>«НУР-СУЛТАН ҚАЛАСЫ СӘУЛЕТ ЖӘНЕ ҚАЛА ҚҰРЫЛЫСЫ БАСҚАРМАСЫ»</b><br />КОММУНАЛДЫҚ МЕМЛЕКЕТТІК МЕКЕМЕСІ</td>
        <td width="20%" style="vertical-align: top;"><img src="https://pricom.kz/images/2019/03/GERBBB.jpg" alt="logo"></td>
        <td width="40%">КОМУНАЛЬНОЕ ГОСУДАРСТВЕННОЕ УЧРЕЖДЕНИЕ<br /><b>«УПРАВЛЕНИЕ ГОРОДСКОГО ПЛАНИРОВАНИЯ И УРБАНИСТИКИ ГОРОДА НУР-СУЛТАН»</b></td>
    </tr>
    <tr class="header_bottom">
        <td>
            050000 Нур-Султан қаласы, Абай даңғылы, 90<br />
            тел.: (727) 279-57-38, 279-54-90<br />
            тел./факс: (727) 279-58-24<br />
            e-mail: uaigkz@mail.ru
            {{--<p style="font-size: 14px; margin-top: 10px">--}}
            {{--____________________№____________________<br />--}}
            {{--__________________________________________--}}
            {{--</p>--}}
        </td>
        <td></td>
        <td style="text-align: right;">
            050000 г. Нур-Султан, пр. Абая, 90<br />
            тел.: (727) 279-57-38, 279-54-90<br />
            тел./факс: (727) 279-58-24<br />
            e-mail: uaigkz@mail.ru
        </td>
    </tr>
</table>
<p style="text-align: right;"><b>Приказываю:</b></p>
<p style="text-align: right;"><b>Утверждение землеустроительных проектов по формированию земельных участков</b></p>

<p style="text-align: left; padding-left :10px;">Приказ</p>
<p style="padding-left: 20px;"><b>{{$variable}}</b></p>


<p style="text-indent: 5em;">До начало строительных работ и благоустройства прилегающей территории необходимо составить договор с мусоровывозящими организациями.</p>
<p style="text-indent: 5em;">Срок действия данного заключения действителен в составе проектной (проектно-сметной) документации, установленным нормативным сроком на весь срок строительства.</p>
<p style="text-indent: 5em;">Согласование эскизного проекта не дает право на начало строительно-монтажных работ без экспертизы проекта и уведомления о начале строительства.</p>

<barcode code="{{ implode(' ', [$variable]) }}" type="QR" class="barcode" size="1" error="M" />

