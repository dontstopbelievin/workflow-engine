@extends('layouts.app')

@section('title')
    Добавить пользователя
@endsection
<style type="text/css">
  .table td{
    font-size: 16px!important;
  }
</style>
@section('content')
  <div class="main-panel">
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12">
                <h4 class="page-title text-center">Добавить пользователя</h4>
              </div>
            </div>
            @if(session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
            @endif
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 offset-md-3">
                  <form action="{{ url('admin/user/add') }}" method="POST">
                      @csrf
                      <div class="form-group" style="padding: 0px">
                          <label><b>Фамилия</b></label>
                          <input type="text" name="sur_name" class="form-control" required>
                      </div>
                      <div class="form-group" style="padding: 0px">
                          <label><b>Имя</b></label>
                          <input type="text" name="first_name" class="form-control" required>
                      </div>
                      <div class="form-group" style="padding: 0px">
                          <label><b>Отчество</b></label>
                          <input type="text" name="middle_name" class="form-control">
                      </div>
                      <div class="form-group" style="padding: 0px 0px 10px 0px">
                          <label><b>Роль</b></label>
                          <select name="role_id" class="form-control">
                              @foreach($roles as $item)
                                  <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group" style="padding: 0px">
                        <label data-error="wrong" data-success="right" for="telephone"><b>Телефон</b></label><br/>
                        <input type="text" id="telephone" name="telephone" pattern="[0-9]{10}" title="Введите 10 цифр вашего номера" class="form-control"/>
                      </div>
                      <div class="form-group" id="iin_form" style="padding: 0px">
                        <label data-error="wrong" data-success="right" for="iin"><b>ИИН</b></label><br/>
                        <input type="text" id="iin" name="iin" pattern="[0-9]{12}" class="form-control"/>
                      </div>
                      <div class="form-group" id="bin_form" style="padding: 0px">
                        <label data-error="wrong" data-success="right" for="bin"><b>БИН</b></label><br/>
                        <input type="text" id="bin" name="bin" pattern="[0-9]{12}" class="form-control"/>
                      </div>
                      <div class="form-group" style="padding: 0px">
                        <label data-error="wrong" data-success="right" for="email"><b>Email</b></label><br/>
                        <input type="email" id="email" name="email" required autocomplete="email" class="form-control"/>
                      </div>
                      <div class="form-group" style="padding: 0px;">
                        <label data-error="wrong" data-success="right" for="password"><b>Придумайте пароль</b></label><br/>
                        <input type="password" id="password" name="password" required autocomplete="new-password" class="form-control" style="margin: 0px;width: 80%!important;">
                        <small id="emailHelp" class="form-text text-muted" style="text-align: left;">1.Длина пароля должна быть не менее 8 символов</small>
                        <small id="emailHelp" class="form-text text-muted" style="text-align: left;">2.Пароль должен состоять из букв латинского алфавита (A-z) и арабских цифр (0-9)</small>
                        <small id="emailHelp" class="form-text text-muted" style="text-align: left;">3. Пароль должен содержать не менее одного из следующих символов:( !$@#% ).</small>
                      </div>
                      <div class="form-group" style="padding: 0px;">
                          <label data-error="wrong" data-success="right" for="confirm_password"><b>Повторите пароль</b></label><br/>
                          <input class="form-control" placeholder="***************" type="password" required id="confirm_password"  name="password_confirmation" style="display: inline-block;width: 80%!important;">
                          <img id="check_pass" src="" style="width: 0px;margin-left: 10px;"/>
                      </div>

                      <div style="margin-top: 20px;">
                          <button type="submit" class="btn btn-success">Добавить</button>
                          <a href="{{ url('admin/user_role/register') }}" class="btn btn-danger">Отмена</a>
                      </div>
                  </form>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
  const check_iin = () => {
    if(e_iin.value.length > 0){
      e_bin.disabled = true;
    }else{
      e_bin.disabled = false;
    }
  }
  const check_bin = () => {
    if(e_bin.value.length > 0){
      e_iin.disabled = true;
    }else{
      e_iin.disabled = false;
    }
  }
  let e_iin = document.getElementById("iin");
  let e_bin = document.getElementById("bin");
  e_iin.addEventListener('input', check_iin);
  e_iin.addEventListener('propertychange', check_iin);
  e_bin.addEventListener('input', check_bin);
  e_bin.addEventListener('propertychange', check_bin);
  
    $('#map_check').click(function(event) {
      if(document.getElementById("map_check").checked) {
        document.getElementById('hidden_map_check').disabled = true;
        document.getElementById('pass1').style.display = 'block';
        document.getElementById('pass2').style.display = 'block';
      }else{
        document.getElementById('hidden_map_check').disabled = false;
        document.getElementById('pass1').style.display = 'none';
        document.getElementById('pass2').style.display = 'none';
      }
    });

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
@append