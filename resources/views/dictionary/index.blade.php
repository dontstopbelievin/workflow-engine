@extends('layouts.app')

@section('title')
    Создание Полей
@endsection

@section('content')
  <div class="main-panel">
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-3">
                <button type="button" id="addNew" class="btn btn-info" data-toggle="modal" data-target="#myModal">Добавить</button>
              </div>
              <div class="col-md-6">
                <h4 class="page-title text-center">Справочник</h4>
              </div>
            </div>
            <div class="alert alert-danger" id="error_box" style="display:none;">
              <!-- errors HERE -->
            </div>
          </div>
          <div class="card-body">
            <table class="table table-hover" id="items">
            <thead>
              <tr>
                <th style="width:7%;">#</th>
                <th style="width:20%;">НАИМЕНОВАНИЕ УСЛУГИ</th>
                <th style="width:20%;">ТИП ВВОДИМОГО</th>
                <th style="width:20%;">ТИП СОХРАНЯЕМОГО</th>
                <th style="width:13%;">Действия</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dictionaries as $item)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$item->labelName}}</td>
                  <td>{{$item->inputName}}</td>
                  <td>{{$item->insertName}}</td>
                  <td>
                    <div class="row">
                      <button class="btn btn-link btn-simple-primary" data-original-title="Изменить" data-toggle="modal" data-target="#">
                          <i class="la la-edit"></i>
                      </button>
                      <button class="btn btn-link btn-simple-danger">
                        <i class="la la-times"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header bg-primary">
                  <h6 class="modal-title" id="title">Добавить справочник</h6>
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
          <label>Select options:</label>
          <div class="form-group" id="add_sel_opt">
            <input type="text" class="form-control" name="selectedOptions[]">
            <input type="text" class="form-control" name="selectedOptions[]">
          </div>
          <button class="btn btn-info add_option">Добавить option</button>
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
@endsection
@section('scripts')
  <script>
      $(document).ready(function() {

          $(document).on('click', '.add_option', function(event) {
            var option = '<input type="text" class="form-control" name="selectedOptions[]">\r\n';
            document.getElementById('add_sel_opt').innerHTML += option;
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

          $(document).on('click', '#addNew', function(event) {
                  $('#title').text('Добавить справочник');
                  $('#addItem').val("");
                  $('#delete').hide('400');
                  $('#saveChanges').hide('400');
                  $('#AddButton').show('400');
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
              var selectedOptions = $("input[name='selectedOptions[]']")
              .map(function(){return $(this).val();}).get();

              if (text == '') {
                  alert('Введите название поля');
                  return;
              }
              if (inputItem === null) {
                  alert('Выберите тип вводимого');
                  return;
              }
              if (insertItem === null) {
                  alert('Выберите тип сохранения');
                  return;
              }
              $.post("{{url('admin/dictionary/create')}}", {'fieldName':text,'labelName': labelName,'inputItem': inputItem, 'insertItem': insertItem, 'processId': processId, 'selectedOptions':selectedOptions, '_token':$('input[name=_token]').val()})
              .done(function(data){
                $('#error_box').hide('400');
                $('#items').load(location.href + ' #items');
              })
              .fail(function(xhr, textStatus, errorThrown){
                var response = JSON.parse(xhr.responseText);
                var errorString = '';
                $.each( response.error, function( key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                console.log(errorString);
                document.getElementById("error_box").innerHTML = errorString;
                $('#error_box').show('400');
              });
          });

          $('#delete').click(function(event) {
              var id = $('#id').val();
              $.post('admin/list/delete', {'id':id, '_token':$('input[name=_token]').val()})
              .done(function(data){
                $('#error_box').hide('400');
                $('#items').load(location.href + ' #items');
              })
              .fail(function(xhr, textStatus, errorThrown){
                var response = JSON.parse(xhr.responseText);
                var errorString = '';
                $.each( response.error, function( key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                console.log(errorString);
                document.getElementById("error_box").innerHTML = errorString;
                $('#error_box').show('400');
              });
          });
          $('#saveChanges').click(function(event) {
              var id = $('#id').val();
              var value = $('#addItem').val();
              $.post('admin/list/update ', {'id':id, 'value':value,'_token':$('input[name=_token]').val()})
              .done(function(data){
                $('#error_box').hide('400');
                $('#items').load(location.href + ' #items');
              })
              .fail(function(xhr, textStatus, errorThrown){
                var response = JSON.parse(xhr.responseText);
                var errorString = 'Error: ';
                $.each( response.error, function( key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                console.log(errorString);
                document.getElementById("error_box").innerHTML = errorString;
                $('#error_box').show('400');
              });
          });

      });
  </script>
@append
