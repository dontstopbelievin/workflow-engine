@extends('layouts.app')

@section('title')
    Изменение данных пользователя
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h4>Изменение данных пользователя</h4>
                  </div>
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-6">
                              <form action="{{ url('admin/user_role/update', ['user' => $user]) }}" method="POST">
                                  @csrf
                                  {{ method_field('PUT') }}
                                  <div class="form-group" style="padding: 0px">
                                      <label><b>Фамилия</b></label>
                                      <input type="text" name="sur_name" value="{{$user->sur_name}}" class="form-control" required>
                                  </div>
                                  <div class="form-group" style="padding: 0px">
                                      <label><b>Имя</b></label>
                                      <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" required>
                                  </div>
                                  <div class="form-group" style="padding: 0px">
                                      <label><b>Отчество</b></label>
                                      <input type="text" name="middle_name" value="{{$user->middle_name}}" class="form-control" required>
                                  </div>
                                  <div class="form-group" style="padding: 0px 0px 10px 0px">
                                      <label><b>Роль</b></label>
                                      <select name="role_id" class="form-control">
                                          @isset($user->role)
                                              <option value="{{$user->role->id}}" selected>{{$user->role->name}}</option>
                                          @endisset
                                          @foreach($roles as $item)
                                              <option value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="form-group" style="padding: 0px">
                                    <label data-error="wrong" data-success="right" for="telephone"><b>Телефон</b></label><br/>
                                    <input type="text" id="telephone" name="telephone" pattern="[0-9]{10}" title="Введите 10 цифр вашего номера" class="form-control"  value="{{$user->telephone}}"/>
                                  </div>
                                  @if($user->bin)
                                    <div class="form-group" style="padding: 0px">
                                      <label data-error="wrong" data-success="right" for="bin"><b>БИН</b></label><br/>
                                      <input type="text" id="bin" name="bin" pattern="[0-9]{12}" class="form-control" value="{{$user->bin}}"/>
                                    </div>
                                  @else
                                    <div class="form-group" style="padding: 0px">
                                      <label data-error="wrong" data-success="right" for="iin"><b>ИИН</b></label><br/>
                                      <input type="text" id="iin" name="iin" pattern="[0-9]{12}" class="form-control" value="{{$user->iin}}"/>
                                    </div>
                                  @endif
                                  <div class="form-group" style="padding: 0px">
                                    <label data-error="wrong" data-success="right" for="email"><b>Email</b></label><br/>
                                    <input type="email" id="email" name="email" required autocomplete="email" class="form-control" value="{{$user->email}}" />
                                  </div>
                                  <div class="form-group" style="padding: 0px; padding-top: 10px;">
                                    <label class="form-check-label py-0">
                                      <input type="hidden" id="hidden_map_check" name="change_pass" value="0" class="form-check-input">
                                      <input type="checkbox" id="map_check" name="change_pass" value="1" class="form-check-input">
                                      <span class="form-check-sign">Изменить пароль</span>
                                    </label>
                                  </div>
                                  <div class="form-group" id="pass1" style="padding: 0px;display: none;">
                                    <label data-error="wrong" data-success="right" for="password"><b>Придумайте пароль</b></label><br/>
                                    <input type="password" id="password" name="password" required autocomplete="new-password" class="form-control"/ style="margin: 0px;width: 80%!important;">
                                    <small id="emailHelp" class="form-text text-muted" style="text-align: left;">1.Длина пароля должна быть не менее 8 символов</small>
                                    <small id="emailHelp" class="form-text text-muted" style="text-align: left;">2.Пароль должен состоять из букв латинского алфавита (A-z) и арабских цифр (0-9)</small>
                                    <small id="emailHelp" class="form-text text-muted" style="text-align: left;">3. Пароль должен содержать не менее одного из следующих символов:( !$#% ).</small>
                                  </div>
                                  <div class="form-group" id="pass2" style="padding: 0px;display: none;">
                                      <label data-error="wrong" data-success="right" for="confirm_password"><b>Повторите пароль</b></label><br/>
                                      <input class="form-control" placeholder="***************" type="password" required id="confirm_password"  name="password_confirmation" / style="display: inline-block;width: 80%!important;">
                                      <img id="check_pass" src="" style="width: 0px;margin-left: 10px;"/>
                                  </div>

                                  <div style="margin-top: 20px;">
                                      <button type="submit" class="btn btn-success">Изменить</button>
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
  </div>
</div>
@endsection
@section('scripts')
<script>
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