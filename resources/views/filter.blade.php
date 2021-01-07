<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Согласование заявок за срок в {{ $requirement }} дней</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
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

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <img src="images/header.jpg" alt="logo" style="width:100%;">
                </div>
                <div class="panel-body" style="margin-top:10px; margin-left:10px;">
                    <div class="main-div">
                        @foreach($result as $processName => $process)
                          <b>Процесс:</b> {{ $processName }}
                            <table style="margin-bottom: 15px; margin-top:10px;">
                              <thead>
                                <tr>
                                  @foreach($process[0] as $key => $value)
                                    @if( $key == 'process_id')
                                      @break
                                    @else
                                      @if($key == 'id')
                                      <th style="width:7%;">№</th>
                                      @else
                                        <th>{{ $dictionary[$key] }}</th>
                                      @endif
                                    @endif
                                  @endforeach
                                  <th>Дата последнего доступа</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($process as $req)
                                  <tr class="shadow p-3 mb-5 rounded">
                                    @foreach($req as $key => $value)
                                      @if( $key == 'process_id')
                                        @break
                                      @endif
                                      <td>{{ $value }}</td>
                                    @endforeach
                                    <td>{{ date('d.m.Y H:i', strtotime($req->updated_at)) }}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
