@extends('layouts.master')

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
                              <form action="{{ route('user-role.update', ['user' => $user]) }}" method="POST">
                                  @csrf
                                  {{ method_field('PUT') }}
                                  <div class="form-group">
                                      <label>Имя пользователя</label>
                                      <input type="text" name="username" value="{{ $user->name}}" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                      <label>Прикрепить роль</label>
                                      <select name="role_id" class="form-control">

                                          @isset($user->role)
                                              <option value="{{$user->role->id}}" selected>{{$user->role->name}}</option>
                                          @endisset
                                          @foreach($roles as $item)
                                              <option value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div>
                                      <button type="submit" class="btn btn-success">Изменить</button>
                                      <a href="{{ route('user-role.register') }}" class="btn btn-danger">Отмена</a>
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
<script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
@endsection