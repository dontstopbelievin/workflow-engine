@extends('layouts.master')

@section('title')
    Список Ролей
@endsection

@section('content')

      <div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Список ролей</h4>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
						<a href="{{ route('role.create') }}" class="btn btn-info">Создать Роль</a><br><br>
						<div class="card">
							<!-- <div class="card-header">
				        <div class="card-title">Table</div>
				      </div> -->
							<div class="card-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th style="width:7%;">№</th>
											<th style="width:60%;">ИМЯ</th>
											<th style="width:20%;">УПРАВЛЕНИЕ</th>
											<th style="width:13%;">ДЕЙСТВИЯ</th>
										</tr>
									</thead>
									<tbody>
                    @foreach($roles as $role)
                      <tr>
                          <td><a href="{{ route('role.view', ['role' => $role]) }}">{{$loop->iteration}}</a></td>
                          <td>{{$role->name}}</td>
                          <td>{{$role->cityManagement->name ?? ''}}</td>
                          <td>
                            <div class="row">
                              <button class="btn btn-link btn-simple-primary" data-original-title="Изменить"  onclick="window.location='{{route('role.edit', ['role' => $role])}}'">
                                  <i class="la la-edit"></i>
                              </button>
                              <form action="{{ route('role.delete', ['role' => $role]) }}" method="post">
                                  {{csrf_field()}}
                                  {{method_field('DELETE')}}
                                  <button type="submit" class="btn btn-link btn-danger" data-original-title="Удалить">
                                    <i class="la la-times"></i>
                                  </button>
                              </form>
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
@endsection

@section('scripts')

    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

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
                $('#title').text('Add New Item');
                $('#addItem').val("");
                $('#delete').hide('400');
                $('#saveChanges').hide('400');
                $('#AddButton').show('400');
            });

            $('#AddButton').click(function(event) {
                var name = $('#addItem').val();
                console.log(name);
                if (name == '') {
                    alert('Please type anything');
                }
                $.post('roles/create', {'name':name, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
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
            // $( function() {
            //
            //     $( "#searchItem" ).autocomplete({
            //         source: 'http://127.0.0.1:8000/list/search'
            //     });
            // } );
        });
    </script>

@endsection
