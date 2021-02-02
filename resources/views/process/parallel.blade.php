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
    <div>
        <label for="roleToJoin">Выберите роль, где встречаются параллельные согласования</label>
        <select name="roleToJoin" id="roleToJoin">
            @foreach($roles as $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
        </select>
        
    </div>
    
    
    @foreach($parallelRoles as $role)
            {{$it = $loop->iteration}}
            <h4>{{$role->name}}</h4>
            <input type="hidden" id="process" name="process" value="{{$process->id}}">
            <select id="priority" name="priority" class="priority">
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

        <button type="submit" id="submitButton">Сохранить</button>
    {{csrf_field()}}
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        var roles = new Map()
        function val(iteration) {
            let ePriority = document.getElementsByClassName("priority")[iteration-1];
            let priority = ePriority.value;
            console.log(priority)
            let ul = document.getElementById(iteration);
            let li = document.createElement("li");
            // console.log(li)
            let e = document.getElementsByClassName("role")[iteration-1];
            let role = e.value;
            li.innerHTML = role;
            ul.appendChild(li);
            let rolesArr = [];

            if (roles.has(iteration)) {
                let existingArr = roles.get(iteration);
                existingArr.push(role);
            } else {
                rolesArr.push(priority);
                rolesArr.push(role);
                roles.set(iteration, rolesArr);
            }

        }
        $(document).ready(function() {
            $('#submitButton').click(function(event) {
                var process = $('#process').val();
                var roleToJoin = $('#roleToJoin').val();
                const objectRoles = Object.fromEntries(roles);
                let base_url = window.location.origin;
                let url = base_url+'/process/approve-in-parallel';
                $.post(url, {'allRoles':objectRoles,'process':process,'roleToJoin': roleToJoin  ,'_token':$('input[name=_token]').val()}, function(data){
                    console.log('done');
                    window.location.href = '/processes-edit/' + process;
                });
            });

        });


    </script>
</body>
</html>
