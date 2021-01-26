<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Выдача решения на проведение комплекса работ по постутилизации объектов (снос строений)</title>
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
                    <p style="text-align: center;"><b>Решение № {{ $updatedFields['id'] }}</b></p>
                    <p style="text-align: center;"><b>на проведение комплекса работ по
                            постутилизации объектов (сноса строений)
                        </b></p>
                    <p style="text-align: right;">
                        выдано {{ $updatedFields['date'] }}
                    </p>
                </div>
                <div class="panel-body">
                    <div class="main-div">
                        <p style="padding-top: 15px;text-indent: 2em;">
                            Руководитель местного исполнительного органа {{ $updatedFields['name'] }}
                            <!-- имя заместителя -->
                            наименование органа выдавшего решения и фамилия, имя, отчество (при его наличии)
                            руководителя на основании предоставленных документов разрешает
                            {{ $updatedFields['applicant_name'] }} заказчика проведение комплекса работ по
                            постутилизации объектов (сноса строений) по объекту {{ $updatedFields['object_name'] }}
                            {{ $updatedFields['object_address'] }}
                        </p>
                        <p style="text-indent: 2em;">
                            Генподрядчик (если снос объекта осуществлялся подрядным способом)
                            {{ $updatedFields['podryad_name'] }}
                        </p>
                        <p style="text-indent: 2em;">
                            Примечание:<br />
                            1. За нарушение требований законодательства в сфере архитектурной, градостроительной и
                            строительной деятельности, а также проектной документации
                            причастные лица несут ответственность в соответствии с действующими законодательствами
                            Республики Казахстан.
                            <br />
                            2. Решение на проведение комплекса работ по постутилизации объектов (сноса строений)
                            действует на весь срок нормативной продолжительности постутилизации объектов (сноса
                            строений).<br />
                        </p>

                        <p style="padding-left: 2em; width: 200px;">
                            <b>Руководитель местного
                                исполнительного органа
                            </b>
                        </p>
                        <p style="display: none">{{ $role2 = utf8_encode('Серикбаев Нурхан Жандосович') }}</p>
                        <p style="display: none">{{ $role3 = utf8_encode('Сагнаев Арман') }}</p>
                        <p style="display: none">{{ $role4 = utf8_encode('Аяпова Альбина') }}</p>
                        <div style="padding: 15px; align-content: center">
                            <barcode code="{{ implode(' ', [$role3]) }}" type="QR" class="barcode" size="1" error="M" />
                            <barcode code="{{ implode(' ', [$role3]) }}" type="QR" class="barcode" size="1" error="M" />
                            <barcode code="{{ implode(' ', [$role3]) }}" type="QR" class="barcode" size="1" error="M" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
