<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Утверждение землеустроительных проектов по формированию земельных участков</title>
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
                <div class="panel-body">
                    <div class="main-div">
                        <p style="padding-top: 15px;" width="40%">
                            Об утверждении <br />
                            землеустроительного проекта
                        </p>
                        <p style="padding-top: 15px; text-indent: 2em;">
                            В соответствии с Земельным кодексом Республики Казахстан от 20 июня 2003 года, Законом
                            Республики Казахстан «О государственных услугах» от 15 апреля 2013 года, приказом
                            исполняющего обязанности Министра национальной экономики Республики Казахстан от 27 марта
                            2015 года № 272 «Об утверждении стандартов государственных услуг в сфере земельных
                            отношений, геодезии и картографии», <b>ПРИКАЗЫВАЮ:</b>
                        </p>
                        <p style="text-indent: 2em;">
                            1. Утвердить землеустроительный проект {{ $updatedFields['applicant_name'] }}<!-- наименование заявителя -->
                            о предоставлении права общей долевой собственности, на земельный участок
                            площадью {{ $updatedFields['area'] }} га<!-- площадь --> , в том числе доля {
                        </p>
                        <p style="text-indent: 2em;">
                            2. Контроль за исполнением настоящего приказа возложить на заместителя
                            руководителя Управления архитектуры, градостроительства и земельных
                            отношений города Нур-Султан Нуркенова Н.Ж.<!-- Заместитель руководителя -->.
                        </p>
                        <p style="padding-left: 2em; width: 200px;">
                            <b>Руководитель местного исполнительного органа</b>
                        </p>
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
