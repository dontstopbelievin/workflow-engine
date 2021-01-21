@extends('layouts.master')

@section('title')
   Шаблоны
@endsection

@section('content')

    <div class="main-panel">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" id="success">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert" id="successMessage">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body" id="acceptedTemplates">
                    <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    <div class="table-responsive">
                        <table class="table" name="accepted_table">
                            <h4 class="card-title">Шаблоны одобрения | Всего: {{count($acceptedTemplates)}}</h4>
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Название Шаблона</th>
                                    <th>Дата создания</th>
                                </tr>
                            </thead>
                            <tbody>
                            @isset($acceptedTemplates)
                                @foreach ($acceptedTemplates as $template)
                                    <tr class="ourItem" data-toggle="modal" data-target="#myModal">
                                        <td>{{$template->id}}</td>
                                        <td>{{$template->name}}</td>
                                        <td>{{$template->created_at->toDateString() }}</td>
                                        <input type="hidden" id="templateId" value = {{$template->id}}>
                                        <input type="hidden" id="templateName{{$template->id}}" value = "{{$template->name}}">
                                        <input type="hidden" id="templateType{{$template->id}}" value = {{1}}>
                                        <input type="hidden" id="templatePath{{$template->id}}" value = "{{$template->doc_path}}">
                                    </tr>
                                @endforeach
                            @endisset

                            </tbody>
                        </table>
                      </div>
                      <div class="table-responsive" id="rejectedTemplates">
                        <table class="table" name="reject_table">
                        <h4 class="card-title">Шаблоны отказа | Всего: {{count($rejectedTemplates)}}</h4>
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Название Шаблона</th>
                                <th>Дата создания</th>
                            </tr>
                        </thead>
                        <tbody>
                        @isset($rejectedTemplates)
                            @foreach($rejectedTemplates as $template)
                              <tr class="ourItem" data-toggle="modal" data-target="#myModal">
                                  <td>{{$template->id}}</td>
                                  <td>{{$template->name}}</td>
                                  <td>{{$template->created_at->toDateString() }}</td>
                                  <input type="hidden" id="templateId" value = {{$template->id}}>
                                  <input type="hidden" id="templateName{{$template->id}}" value = "{{$template->name}}">
                                  <input type="hidden" id="templateType{{$template->id}}" value = {{0}}>
                                  <input type="hidden" id="templatePath{{$template->id}}" value = "{{$template->doc_path}}">
                              </tr>
                            @endforeach
                        @endisset
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title">Add New Item</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <div class="">
                                    <label for="fieldName">Название шаблона</label>
                                    <input type="hidden" name="id" id="id">
                                    <input type="text" class="form-control" name="name" id="fieldName">
                                  </div>
                                  <div class="templateType" id="templateType">
                                    <label for="accept_template">Выберите тип шаблона:</label>
                                    <select class="form-control" name="template_state" id="accept_template">
                                        <option value="accepted">Шаблон одобрения</option>
                                        <option value="declined">Шаблон отказа</option>
                                    </select>
                                  </div>
                                  <label for="templateName">Выберите шаблон</label>
                                  <div class="custom-file mt-1 col-md-12" id="templateName">
                                      <input type="file" class="custom-file-input" id="customFile" name="file_input">
                                      <label class="custom-file-label" for="customFile">Выберите Файл</label>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="delete" style="display:none" data-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none" >Сохранить изменения</button>
                        <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Добавить шаблон</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>

    {{csrf_field()}}
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

          $(document).on('click', '.ourItem', function(event) {
                  var id  = $(this).find('#templateId').val();

                  var text = $('#templateName'+id).val();
                  $('#title').text('Изменить шаблон');
                  $('#id').val(id);
                  $('#fieldName').val(text);
                  $('#delete').show('400');
                  $('#templateType').hide('400');
                  $('#saveChanges').show('400');
                  $('#AddButton').hide('400');
                  console.log(text);
          });

            $(document).on('click', '#addNew', function(event) {
                    $('#title').text('Создать новый шаблон');
                    $('#fieldName').val("");
                    $('#templateType').show('400');
                    $('#delete').hide('400');
                    $('#saveChanges').hide('400');
                    $('#AddButton').show('400');
            });

            $('#AddButton').click(function(event) {
                var formData = new FormData();
                formData.append('file_input', $('input[type=file]')[0].files[0]);
                formData.append('name', $('#fieldName').val());
                formData.append('template_state', $('#accept_template').val());
                formData.append('_token', $('input[name=_token]').val());
                $.ajax({
                  url: '/templates/create',
                  data: formData,
                  processData: false,
                  contentType: false,
                  type: 'POST',
                  success: function(data){
                    alert(data);
                    $('#successMessage').val(data);
                    $('#success').load(location.href + ' #success');
                    $('#acceptedTemplates').load(location.href + ' #acceptedTemplates');
                    $('#rejectedTemplates').load(location.href + ' #rejectedTemplates');
                  }
                });
            });

            $('#delete').click(function(event) {
                var id = $('#id').val();
                $.post('/template-delete/' + id, {'_token':$('input[name=_token]').val()}, function(data){
                    alert(data);
                    $('#acceptedTemplates').load(location.href + ' #acceptedTemplates');
                    $('#rejectedTemplates').load(location.href + ' #rejectedTemplates');
                });
            });

            $('#saveChanges').click(function(event) {
                var formData = new FormData();
                var id = $('#id').val();
                var file = $('input[type=file]')[0].files[0];
                if(file!==undefined) {
                    formData.append('file_input', file);
                }
                formData.append('name', $('#fieldName').val());
                formData.append('_token', $('input[name=_token]').val());
                $.ajax({
                    url: '/template-update/' + id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){
                        alert(data);
                        $('#acceptedTemplates').load(location.href + ' #acceptedTemplates');
                        $('#rejectedTemplates').load(location.href + ' #rejectedTemplates');
                    }
                });
            });

        });
    </script>


@endsection

@section('scripts')
@endsection
