@extends('layouts.app')

@section('title')
    Создание Шаблона
@endsection

@section('content')

<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <button id="addNew" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
            </div>
            <div class="col-md-6 text-center">
              <h5>Поля шаблона: {{$template->table_name}}</h5>
            </div>
          </div>
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
        </div>
        <div class="card-body">
          <table class="table table-hover" id="items">
            <thead>
              <tr>
                <th>Наименование поля</th>
                <th>Имя поля в базе</th>
                <th>Тип вводимого</th>
                <th>Тип сохраняемого</th>
                <th>Имя select</th>
                <th>Действие</th>
              </tr>
            </thead>
            <tbody>
              @foreach($temp_fields as $item)
                  <tr>
                      <td>{{$item->label_name}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->inputName}}</td>
                      <td>{{$item->insertName}}</td>
                      <td>{{$item->dic_name}}</td>
                      <td>
                        <a href="{{ url('admin/template_field/def_val/create', [$item->id]) }}" class="btn btn-outline-danger btn-xs">Добавить значения по умолчанию</a>
                      </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          <a href="{{url('admin/process/edit', ['process' => $processId])}}" class="btn btn-primary">Назад</a>
        </div>
      </div>
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
          <input type="text" class="form-control" id="addLabelName" placeholder="Введите label">
        </div>
        <input type="hidden" id="temp_id" name="temp_id" value="{{$template->id}}">
        @isset($inputTypes)

          <div class="form-group">
            <label for="inputType">Выберите Тип Вводимого</label>
            <select class="form-control" name="inputType" id="inputType" data-dropup-auto="false">
              <option selected disabled>Выберите Ниже</option>
              @foreach($inputTypes as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group" id="hidden_div" style="display: none;">
              @isset($dictionaries)
                  <label for="select_dic">Выберите Справочник</label>
                  <select class="form-control" name="select_dic" id="select_dic" data-dropup-auto="false">
                      <option selected disabled>Выберите Ниже</option>
                  @foreach($dictionaries as $dictionary)
                      <option value="{{$dictionary->id}}">{{$dictionary->label_name}}</option>
                  @endforeach
                  </select>
              @endisset
          </div>
        @endisset

        @isset($insertTypes)
          <div class="form-group">
            <label for="insertType">Выберите Тип Сохранения</label>
            <select class="form-control" id="insertType" name="insertType" data-dropup-auto="false">
              <option selected disabled>Выберите Ниже</option>
              @foreach($insertTypes as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
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
            var input = $( "#inputType option:selected" ).text();
            if (input === 'select') {
                document.getElementById('hidden_div').style.display = "block";
            } else {
                document.getElementById('hidden_div').style.display = "none";
                $('#select_dic').val(null);
            }
        });

        $('#AddButton').click(function(event) {
            var text = $('#addItem').val();
            var labelName = $('#addLabelName').val();
            var inputItem = $('#inputType').val();
            var select_dic = $('#select_dic').val();
            var insertItem = $('#insertType').val();
            var id = $('#temp_id').val();

            if (text == '') {
                alert('Введите название поля');
            }
            if (inputItem === null) {
                alert('Выберите тип вводимого');
            }
            if (insertItem === null) {
                alert('Выберите тип сохранения');
            }
            if(inputItem == 'select' && select_dic === null){
                  alert('Выберите справочник');
            }

            let formData = new FormData();
            formData.append('temp_id', id);
            formData.append('fieldName', text);
            formData.append('labelName', labelName);
            formData.append('inputItem', inputItem);
            formData.append('insertItem', insertItem);
            formData.append('_token', "{{csrf_token()}}");
            if(select_dic != null){
              formData.append('select_dic', select_dic);
            }

            var xhr = new XMLHttpRequest();
            xhr.open("post", "{{url('admin/template_field/store')}}", true);
            xhr.onload = function () {
              if(xhr.status === 200){
                $('#items').load(location.href + ' #items');
              }else{
                alert('Error');
              }
            }.bind(this);
            xhr.send(formData);
        });

        $('#delete').click(function(event) {
            var id = $('#id').val();
            $.post('admin/list/delete', {'id':id, '_token':"{{csrf_token()}}"}, function(data){
                console.log(data);
                $('#items').load(location.href + ' #items');
            });
        });

        $('#saveChanges').click(function(event) {
            var id = $('#id').val();
            var value = $('#addItem').val();
            $.post('admin/list/update ', {'id':id, 'value':value,'_token':"{{csrf_token()}}"}, function(data){
                console.log(data);
                $('#items').load(location.href + ' #items');
            });
        });

    });
</script>
@append
