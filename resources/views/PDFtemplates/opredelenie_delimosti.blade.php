<table class="header_table">
    <tr class="header_top">
        <td width="40%">
            <b>«НҰР-СҰЛТАН ҚАЛАСЫНЫҢ СӘУЛЕТ, ҚАЛА ҚҰРЫЛЫСЫ ЖӘНЕ ЖЕР ҚАТЫНАСТАРЫ БАСҚАРМАСЫ» МЕМЛЕКЕТТІК МЕКЕМЕСІ</b>
        </td>
        <td width="20%" style="vertical-align: top; size: 30px;">
            <img style="size: 30px;" src="https://pricom.kz/images/2019/03/GERBBB.jpg" alt="logo" />
        </td>
        <td width="40%">
            <b>ГОСУДАРСТВЕННОЕ УЧРЕЖДЕНИЕ «УПРАВЛЕНИЕ АРХИТЕКТУРЫ, ГРАДОСТРОИТЕЛЬСТВА И ЗЕМЕЛЬНЫХ ОТНОШЕНИЙ ГОРОДА НУР-СУЛТАН»</b>
        </td>
    </tr>
    <tr class="header_bottom">
        <td>
            010000, Нұр-Сұлтан қаласы, А. Мамбетов көшесі, 24<br />
            тел.: (8-717-2) 55-74-57<br />
            № {{ $variable }}<br />
        </td>
        <td></td>
        <td style="text-align: right;">
            010000, город Нур-Султан, улица А. Мамбетова, 24,<br />
            тел.: (8-717-2) 55-74-57<br />
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
