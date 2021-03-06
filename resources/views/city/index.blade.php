@extends('layouts.app')

@section('title')
   Городские организации
@endsection

@section('content')
  <div class="main-panel">
		<div class="content">
			<div class="container-fluid">
				<div class="card">
					<div class="card-header">
            <div class="row">
              <div class="col-md-3">
                <button type="button" id="addNew" class="btn btn-info" data-toggle="modal" data-target="#AddModal">Добавить организацию</button>
              </div>
              <div class="col-md-6">
                <h4 class="page-title text-center">Организации</h4>
              </div>
            </div>
            <div class="alert alert-danger" id="error_box" style="display:none;">
              <!-- errors HERE -->
            </div>
		      </div>
					<div class="card-body">
						<table class="table table-hover">
	            <thead>
	              <tr>
	                <th style="width:7%;">#</th>
	                <th style="width:80%;">НАИМЕНОВАНИЕ ОРГАНИЗАЦИИ</th>
                  <th style="width:13%;">Действия</th>
	              </tr>
	            </thead>
	            <tbody>
                @foreach($cityManagements as $cityManagement)
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>
                          {{$cityManagement->name}}
                      </td>
                      <td>
                        <div class="row">
                          <button class="ourItem btn btn-link btn-simple-primary" data-original-title="Изменить" data-toggle="modal" data-target="#AddModal">
                              <i class="la la-edit"></i>
                              <input type="hidden" id="itemId" value = {{$cityManagement->id}}>
                              <h6 style="display: none;">{{$cityManagement->name}}</h6>
                          </button>
                          <button class="btn btn-link btn-simple-danger" id="delete">
                            <input type="hidden" id="idDel" value="{{$cityManagement->id}}">
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

  <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h6 class="modal-title" id="title">Добавить организацию</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <input type="hidden" id="id">
          <div class="form-group">
            <input type="text" placeholder="Введите название" id="addItem" class="form-control">
          </div>
          <div class="modal-footer">
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

        $(document).on('click', '.ourItem', function(event) {
            var text = $(this).text();
            var id  = $(this).find('#itemId').val();
            $('#title').text('Изменить организацию');
            text = $.trim(text);
            $('#addItem').val(text);
            $('#saveChanges').show('400');
            $('#AddButton').hide('400');
            $('#id').val(id);
            console.log($('#addItem').val());
            console.log(id);
            console.log(text);
        });

        $(document).on('click', '#addNew', function(event) {
            $('#title').text('Добавить организацию');
            $('#addItem').val("");
            $('#saveChanges').hide('400');
            $('#AddButton').show('400');
        });

        $('#AddButton').click(function(event) {
            var text = $('#addItem').val();

            $.post('/admin/city', {'text':text, '_token':$('input[name=_token]').val()})
                .done( function(data) {
                    console.log(data);
                    $('#error_box').hide('400');
                    $('#items').load(location.href + ' #items');
                 })
                .fail( function(xhr, textStatus, errorThrown) {
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
            var id = $('#idDel').val();
            $.post('/admin/city/delete', {'id':id, '_token':$('input[name=_token]').val()})
                .done( function(data) {
                    console.log(data);
                    $('#error_box').hide('400');
                    $('#items').load(location.href + ' #items');
                 })
                .fail( function(xhr, textStatus, errorThrown) {
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
            $.post('/admin/city/update ', {'id':id, 'value':value,'_token':$('input[name=_token]').val()})
                .done( function(data) {
                    console.log(data);
                    $('#error_box').hide('400');
                    $('#items').load(location.href + ' #items');
                 })
                .fail( function(xhr, textStatus, errorThrown) {
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
        $( function() {
            $( "#searchItem" ).autocomplete({
                source: 'http://127.0.0.1:8000/list/search'
            });
        } );
    });
</script>
@append
