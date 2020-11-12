<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parallel Roles Creation</title>
</head>
<body>
    <h1>{{$process->name}}</h1>
    @foreach($parallelRoles as $role)
            <h6>{{$role->name}}</h6>
            <select name="priority" id="priority">
                @for($i = 1; $i <= $rolesLen; $i++)
                <option value="{{$i}}">{{$i}}</option>
                    @endfor
            </select>
            <select name="role" id="role">
                @foreach($roles as $r)
                <option value="{{$r->name}}">{{$r->name}}</option>
                    @endforeach
            </select>
        @endforeach
</body>
</html>
