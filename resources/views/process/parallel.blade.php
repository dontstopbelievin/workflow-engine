<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <button onclick="sendRequest()" type="submit" id="submitButton">Сохранить</button>
    {{csrf_field()}}
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
        var roles = new Map()
        function val(iteration) {
            //
            // console.log(iteration)
            // console.log(document.getElementById("role").value);
            let ul = document.getElementById(iteration);
            let li = document.createElement("li");
            // console.log(li)
            let e = document.getElementsByClassName("role")[iteration-1];
            let role = e.value;
            li.innerHTML = role;
            ul.appendChild(li);
            let rolesArr = [];
            rolesArr.push(role);
            if (roles.has(iteration)) {
                let existingArr = roles.get(iteration);
                existingArr.push(role);
            } else {
                roles.set(iteration, rolesArr);
            }

        }

        function sendRequest() {
            // let base_url = window.location.origin;
            // console.log(base_url);
            // let url = base_url+'/process/approve-in-parallel'
            // var xhr = new XMLHttpRequest();
            // xhr.setRequestHeader(
            //     'X-CSRF-TOKEN', ('meta[name="csrf-token"]').getAttribute('content'))
            // xhr.open("POST", url, true);
            // xhr.setRequestHeader('Content-Type', 'application/json');
            // xhr.send(JSON.stringify({
            //     value: roles
            // }));
        }



            $('#submitButton').click(function(event) {
                let base_url = window.location.origin;
                let url = base_url+'/process/approve-in-parallel'
                $.post(url, {'roles':roles,  '_token':$('input[name=_token]').val()}, function(data){
                    console.log('done');
                });
            });

        });


    </script>
</body>
</html>
