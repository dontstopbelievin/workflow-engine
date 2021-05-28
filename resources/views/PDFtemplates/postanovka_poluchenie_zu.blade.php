<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Постановка на очередь на получение земельного участка</title>
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
                    {{-- <img src="{{ URL::asset('/images/header.jpg') }}" alt="logo"
                        height="185" /> --}}
                    <p style="text-align: right;"><b>{{ $updatedFields['applicant_name'] }}</b></p>
                    <p style="text-align: right;">{{ $updatedFields['applicant_address'] }}</p>
                    <table class="header_table">
                        <tr class="header_bottom">
                            <td>
                                На № {{ $updatedFields['id'] }}<br />
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
                        <p style="text-indent: 2em; padding-top: 15px;">
                            Рассмотрев Ваше заявление, касательно постановки на очередь на получение земельного участка,
                            Управление архитектуры, градостроительства и земельных отношений города Нур-Султан, сообщает
                            следующее.
                        </p>
                        <p style="text-indent: 2em;">
                            В соответствии с Правилами оказания государственной услуги «Постановка на очередь на
                            получение земельного участка», утвержденными приказом Министерства сельского хозяйства
                            Республики Казахстан от 01.10.2020г. № 301, уведомляем Вас о том, что Ваше заявление
                            поставлено на специальный учет под № {{ $updatedFields['id'] }}.
                        </p>
                        <p style="text-indent: 2em;">
                            Вместе с тем разъясняем, что в соответствии с требованиями действующего законодательства РК,
                            удовлетворение заявлений, взятых на учет, в том числе и для льготной категории граждан,
                            будет только по мере наличия в городе подготовленных площадок для отвода, обеспеченных всеми
                            необходимыми инженерными коммуникациями, в порядке строгой очередности.
                        </p>
                        <p style="text-indent: 2em; padding-top: 15px;">
                            <b>Заместитель руководителя</b>
                        </p>
                        <p style="display: none">{{ $role2 = utf8_encode('Серикбаев Нурхан Жандосович') }}</p>
                        <p style="display: none">{{ $role3 = utf8_encode('Сагнаев Арман') }}</p>
                        <p style="display: none">{{ $role4 = utf8_encode('Аяпова Альбина') }}</p>
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
