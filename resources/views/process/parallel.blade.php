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
            {{$it = $loop->iteration}}
            <h6>{{$role->name}}</h6>
            <select id="select_id" name="priority">
                @for($i = 1; $i <= $rolesLen; $i++)
                <option value="{{$i}}">{{$i}}</option>
                    @endfor
            </select>
            <select onchange="val({{$it}})" name="role" id="role">
                @foreach($roles as $r)
                <option id = "option" value="{{$r->name}}">{{$r->name}}</option>
                    @endforeach
            </select>

            <ul id="{{$it}}">

            </ul>
        @endforeach


    <script>
        function val(iteration) {
            console.log(iteration)
            // d = document.getElementById("role").value;
            var ul = document.getElementById(iteration);
            console.log(ul);
            // twoIterations = iteration + iteration;
            var li = document.createElement(li);
            li.innerHTML = document.getElementById("role").value;
            ul.appendChild(li);
        }
    </script>
</body>
</html>
