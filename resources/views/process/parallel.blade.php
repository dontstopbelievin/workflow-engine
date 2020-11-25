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
            <select onchange="val({{"$it"}})" name="role" id="role" class="role">
                @foreach($roles as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
            </select>

            <ul id="{{$it}}">

            </ul>
        @endforeach


    <script>

        function val(iteration) {
            let ul
            let li
            console.log(iteration)
            console.log(document.getElementById("role").value);
            ul = document.getElementById(iteration);
            li = document.createElement("li");
            console.log(li)
            let e = document.getElementsByClassName("role")[iteration-1]
            console.log(e)
            li.innerHTML = e.value;
            // console.log(li);
            ul.appendChild(li);

        }
    </script>
</body>
</html>
