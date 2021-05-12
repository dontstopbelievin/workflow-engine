<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Согласование заявок за период с {{ $date_from }} по {{$date_to}}</title>
    <style type="text/css">
    @font-face {
          font-family: "DejaVu Sans";
          font-style: normal;
          font-weight: 400;
          src: url("/fonts/dejavu-sans/DejaVuSans.ttf");
          /* IE9 Compat Modes */
          src:
            local("DejaVu Sans"),
            local("DejaVu Sans"),
            url("/fonts/dejavu-sans/DejaVuSans.ttf") format("truetype");
        }
    body, h1, h2, h3, h4, h5, h6, th, td {
        font-family: DejaVu Sans;
        font-size: 12px;
    }
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
</style>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <img src="images/header.jpg" alt="logo" style="width:100%;">
                </div>
                @if(!isset($result))
                  <div class="panel-body" style="margin-top:10px; margin-left:10px;">
                    <div class="main-div">
                        <b>По этому процессу заявок за период с {{$date_from}} по {{$date_to}} не существует! </b>
                      </div>
                    </div>
                @else
                  <div class="panel-body" style="margin-top:10px; margin-left:10px;">
                      <div class="main-div">
                        <b>Процесс:</b>
                          <table style="margin-bottom: 15px; margin-top:10px;">
                            <thead>
                              <tr>
                                <th style="width:7%;">№</th>
                                @foreach($result as $key => $value)
                                  @if( $key == 'status')
                                    @break
                                  @else
                                    @if($key == 'id')
                                    <th>Номер заявки</th>
                                    @else
                                      <th>{{ $dictionary[$key] }}</th>
                                    @endif
                                  @endif
                                @endforeach
                                <th>Статус</th>
                                <th>Дата создания заявки</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($result as $num => $req)
                                <tr class="shadow p-3 mb-5 rounded">
                                  <td>{{ $num+1 }}</td>
                                  @foreach($req as $key => $value)
                                    @if( $key == 'status')
                                      @break
                                    @endif
                                    <td>{{ $value }}</td>
                                  @endforeach
                                  <td></td>
                                  <td>{{ date('d.m.Y H:i:s', strtotime($req->created_at)) }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                  </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
