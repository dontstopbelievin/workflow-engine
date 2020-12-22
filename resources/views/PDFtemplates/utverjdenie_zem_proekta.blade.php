<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Утверждение землеустроительных проектов по формированию земельных участков</title>
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
                            1. Утвердить землеустроительный проект {{ $variable }}<!-- наименование заявителя -->
                            о предоставлении права общей долевой собственности, на земельный участок
                            площадью {{ $variable }}<!-- площадь --> , в том числе доля {{ $variable }} <!-- площадь2 --> га (неделимый),
                            расположенного по адресу: город Нур-Султан, район {{ $variable }}<!-- район -->, пр.
                            {{ $variable }}<!-- проспект -->, д. № {{ $variable }}<!-- номер дома -->, для эксплуатации {{ $variable }}<!-- наименование объекта -->.
                        </p>
                        <p style="text-indent: 2em;">
                            2. Контроль за исполнением настоящего приказа возложить на заместителя
                            руководителя Управления архитектуры, градостроительства и земельных
                            отношений города Нур-Султан Нуркенова Н.Ж.<!-- Заместитель руководителя -->.
                        </p>
                        <p style="padding-left: 2em; width: 200px;">
                            <b>Руководитель местного исполнительного органа</b>
                        </p>
                        <barcode code="{{ implode(' ', [$variable]) }}" type="QR" class="barcode" size="1" error="M" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
