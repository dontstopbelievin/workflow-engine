@extends('layouts.master')

@section('title')
    Создание Шаблона
@endsection

@section('content')
<div class="sidebar">
  <div class="scrollbar-inner sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item">
        <a class="" role="button" data-toggle="collapse" href="#settings" aria-expanded="false">
          <i class="la la-navicon"></i>
          <p>Настройки</p>
        </a>
      </li>
      <div class="collapse" id="settings">
        <ul class="nav">
        <li class="nav-item">
                            <a href="{{ route('user.personalArea') }}">
                                <span class="link-collapse">Личный Кабинет</span>
                            </a>
                        </li>
          <li class="nav-item">
            <a href="#">
              <span class="link-collapse">Edit Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#">
              <span class="link-collapse">Settings</span>
            </a>
          </li>
        </ul>
      </div>
      <li class="nav-item ">
        <a href="{{ route('auction.index') }}">
          <i class="la la-table"></i>
          <p>Аукцион</p>
        </a>
      </li>
      <li class="nav-item active">
        <a href="{{ route('processes.index') }}">
          <i class="la la-keyboard-o"></i>
          <p>Процессы</p>
          <span class="badge badge-count">{{ $processesCount }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('role.index') }}">
          <i class="la la-th"></i>
          <p>Роли</p>
          <span class="badge badge-count">{{ $rolesCount }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('city.index') }}">
          <i class="la la-bell"></i>
          <p>Организации</p>
          <span class="badge badge-count">{{ $cityManagementCount }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('user-role.register') }}">
          <i class="la la-font"></i>
          <p>Пользователи</p>
          <span class="badge badge-count">{{ $usersCount }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('dictionary') }}">
          <i class="la la-fonticons"></i>
          <p>Справочник</p>
          <span class="badge badge-count">{{ $dictionariesCount }}</span>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{ route('applications.service') }}">
          <i class="la la-dashboard"></i>
          <p>Все услуги</p>
        </a>
      </li>
    </ul>
  </div>
</div>

<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="d-flex justify-content-between">
        <div class="">
          <h4 class="page-title">Поле шаблонов </h4>
        </div>
        <div class="">
          <button id="addNew" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
        </div>
      </div>
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif
      <div class="card">
        <!-- <div class="card-header">
          <div class="card-title">Table</div>
        </div> -->
        <div class="card-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Наименование поля</th>
                <th>Тип вводимого</th>
                <th>Тип сохраняемого</th>
              </tr>
            </thead>
            <tbody>
              @foreach($oTemplateFields as $item)
                  <tr>
                      <td>{{$item["labelName"]}}</td>
                      <td>{{$item["inputName"]}}</td>
                      <td>{{$item["insertName"]}}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <a href="{{route('processes.edit', ['process' => $processId])}}" class="btn btn-primary">Продолжить</a>
    </div>
  </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title" id="title">Добавить новое поле</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <input type="hidden" id="id">
        <div class="form-group">
          <input type="text" class="form-control" id="addItem" placeholder="Введите название поля">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="addLabelName" placeholder="Введите ярлык поля(label name)">
        </div>
        <input type="hidden" id="processId" value="1">
        <input type="hidden" id="tempId" name="tempId" value="{{$id}}">
        @isset($inputTypes)
          <div class="form-group">
            <label for="inputType">Выберите Тип Вводимого</label>
            <select class="form-control" name="inputType" id="inputType" data-dropup-auto="false">
              <option selected disabled>Выберите Ниже</option>
              @foreach($inputTypes as $type)
                <option value="{{$type->name}}">{{$type->name}}</>
              @endforeach
            </select>
          </div>
        @endisset
        <div id="hidden_div" style="display: none;">
          @isset($options)
              @foreach ($options as $option)
                  <div class="checkbox">
                      <label><input class="get_value" type="checkbox" value="{{$option->name}}">{{$option->name}}</label>
                  </div>
              @endforeach
          @endisset
        </div>
        @isset($insertTypes)
          <div class="form-group">
            <label for="insertType">Выберите Тип Сохранения</label>
            <select class="form-control" id="insertType" name="insertType" data-dropup-auto="false">
              <option selected disabled>Выберите Ниже</option>
              @foreach($insertTypes as $type)
                  <option value="{{$type->name}}">{{$type->name}}</option>
              @endforeach
            </select>
          </div>
        @endisset
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" id="delete" style="display:none" data-dismiss="modal">Удалить</button>
          <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none" >Сохранить изменения</button>
          <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Добавить</button>
        </div>
      </div>
    </div>
  </div>
</div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
          $(document).on('click', '#addNew', function(event) {
              $('#title').text('Добавить ');
              $('#addItem').val("");
              $('#delete').hide('400');
              $('#saveChanges').hide('400');
              $('#AddButton').show('400');
          });
          
            $(document).on('click', '.ourItem', function(event) {
                var text = $(this).text();
                var id  = $(this).find('#itemId').val();
                $('#title').text('Edit Item');
                text = $.trim(text);
                $('#addItem').val(text);
                $('#delete').show('400');
                $('#saveChanges').show('400');
                $('#AddButton').hide('400');
                $('#id').val(id);
                console.log(text);
            });


            $(document).on('change', '#inputType', function(event) {
                var input = $(this).val();
                if (input === 'select') {
                    document.getElementById('hidden_div').style.display = "block";
                } else {
                    document.getElementById('hidden_div').style.display = "none";
                }
            });

            $('#AddButton').click(function(event) {
                var labelName = $('#addLabelName').val();
                var text = $('#addItem').val();
                var inputItem = $('#inputType').val();
                var insertItem = $('#insertType').val();
                var processId = $('#processId').val();
                var selectedOptions = [];
                var id = $('#tempId').val();
                $('.get_value').each(function(){
                    if($(this).is(":checked"))
                    {
                        selectedOptions.push($(this).val());
                    }
                });

                if (text == '') {
                    alert('Введите название поля');
                    alert(selectedOptions);
                }
                if (inputItem === null) {
                    alert('Выберите тип вводимого');
                }
                if (insertItem === null) {
                    alert('Выберите тип сохранения');
                }
                $.post('/template-field-create', {'tempId':id,'fieldName':text,'labelName': labelName,'inputItem': inputItem, 'insertItem': insertItem, 'processId': processId, 'selectedOptions':selectedOptions, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    console.log($('#items').load(location.href + ' #items'));
                    $('#items').load(location.href + ' #items');
                });
            });

            $('#delete').click(function(event) {
                var id = $('#id').val();
                $.post('list/delete', {'id':id, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });
            $('#saveChanges').click(function(event) {
                var id = $('#id').val();
                var value = $('#addItem').val();
                $.post('list/update ', {'id':id, 'value':value,'_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });

        });
    </script>
@endsection

@section('scripts')
@endsection
