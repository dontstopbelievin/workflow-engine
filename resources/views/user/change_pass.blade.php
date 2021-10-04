@extends('layouts.app')

@section('title')
    Личный Кабинет
@endsection

@section('content')

    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-center">Изменение пароля</h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body col-md-6" id="items">
                        <form action="{{ url('password/change_password',  ['user' => $user]) }}" method="POST">
                            @csrf
                            <div class="form-group" style="padding: 0px;">
                                <label data-error="wrong" data-success="right" for="cur_password"><b>Текущий пароль</b></label><br/>
                                <input type="password" id="cur_password" name="cur_password" required autocomplete="new-password" class="form-control" style="margin: 0px;width: 80%!important;">
                            </div>
                            <div class="form-group" style="padding: 0px;">
                                <label data-error="wrong" data-success="right" for="password"><b>Придумайте пароль</b></label><br/>
                                <input type="password" id="password" name="password" required autocomplete="new-password" class="form-control" style="margin: 0px;width: 80%!important;">
                                <small id="emailHelp" class="form-text text-muted" style="text-align: left;">1. Длина пароля должна быть не менее 8 символов</small>
                                <small id="emailHelp" class="form-text text-muted" style="text-align: left;">2. Пароль должен состоять из букв латинского алфавита (A-z) и арабских цифр (0-9)</small>
                                <small id="emailHelp" class="form-text text-muted" style="text-align: left;">3. Пароль должен содержать не менее одного из следующих символов:( !$@#% ).</small>
                            </div>
                            <div class="form-group" style="padding: 0px;">
                                <label data-error="wrong" data-success="right" for="confirm_password"><b>Повторите пароль</b></label><br/>
                                <input class="form-control" placeholder="***************" type="password" required id="confirm_password"  name="password_confirmation" style="display: inline-block;width: 80%!important;">
                                <img id="check_pass" src="" style="width: 0px;margin-left: 10px;"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Изменить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    const check_pass = () => {
        var x = document.getElementById("password").value;
        var y = document.getElementById("confirm_password").value;
        if(y.length > 0){
            document.getElementById("check_pass").style.width = "25px";
            if(x == y){
                document.getElementById("check_pass").src = "{{url('images/done.png')}}"
            }else{
                document.getElementById("check_pass").src = "{{url('images/warning.png')}}"
            }
        }else{
            document.getElementById("check_pass").style.width = "0px";
        }
    }
    let source = document.getElementById("confirm_password");
    source.addEventListener('input', check_pass);
    source.addEventListener('propertychange', check_pass);
    let source2 = document.getElementById("password");
    source2.addEventListener('input', check_pass);
    source2.addEventListener('propertychange', check_pass);
</script>
@endsection
