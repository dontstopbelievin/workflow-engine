@extends('layouts.master')

@section('title')
   Городские организации
@endsection

@section('content')

      <div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<div class="d-flex justify-content-between">
							<div class="">
								<h4 class="page-title">Организации</h4>
							</div>
							<div class="">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus"></i></button>
							</div>
						</div>
						<div class="card">
							<!-- <div class="card-header">
				        <div class="card-title">Table</div>
				      </div> -->
							<div class="card-body">
								<table class="table table-hover">
			            <thead>
			              <tr>
			                <th>#</th>
			                <th>НАИМЕНОВАНИЕ ОРГАНИЗАЦИИ</th>
			              </tr>
			            </thead>
			            <tbody>
                    @foreach($cityManagements as $cityManagement)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td class="ourItem" data-toggle="modal" data-target="#AddModal">
                              {{$cityManagement->name}}
                              <input type="hidden" id="itemId" value = {{$cityManagement->id}}>
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
                  <button type="button" class="btn btn-warning" id="delete" style="display:none" data-dismiss="modal">Удалить</button>
                  <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none" >Сохранить изменения</button>
                  <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Добавить</button>
              </div>
            </div>
          </div>
        </div>
      </div>

{{csrf_field()}}
<script>
    $(document).ready(function() {

        $(document).on('click', '.ourItem', function(event) {
            var text = $(this).text();
            var id  = $(this).find('#itemId').val();
            $('#title').text('Изменить организацию');
            text = $.trim(text);
            $('#addItem').val(text);
            $('#delete').show('400');
            $('#saveChanges').show('400');
            $('#AddButton').hide('400');
            $('#id').val(id);
            console.log(text);
        });

        $(document).on('click', '#addNew', function(event) {
            $('#title').text('Добавить организацию');
            $('#addItem').val("");
            $('#delete').hide('400');
            $('#saveChanges').hide('400');
            $('#AddButton').show('400');
        });

        $('#AddButton').click(function(event) {
            var text = $('#addItem').val();

            if (text == '') {
                alert('Введите название');
            }
            $.post('city', {'text':text, '_token':$('input[name=_token]').val()}, function(data){
                console.log(data);
                $('#items').load(location.href + ' #items');
            });
        });

        $('#delete').click(function(event) {
            var id = $('#id').val();
            $.post('city/delete', {'id':id, '_token':$('input[name=_token]').val()}, function(data){
                console.log(data);
                $('#items').load(location.href + ' #items');
            });
        });
        $('#saveChanges').click(function(event) {
            var id = $('#id').val();
            var value = $('#addItem').val();
            $.post('city/update ', {'id':id, 'value':value,'_token':$('input[name=_token]').val()}, function(data){
                console.log(data);
                $('#items').load(location.href + ' #items');
            });
        });
        $( function() {

            $( "#searchItem" ).autocomplete({
                source: 'http://127.0.0.1:8000/list/search'
            });
        } );
    });
</script>
@endsection
