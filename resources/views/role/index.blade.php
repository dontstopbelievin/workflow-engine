@extends('layouts.app')

@section('title')
    Список Ролей
@endsection

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                          <div class="col-md-3">
                            <a href="{{ url('admin/role/create') }}" class="btn btn-info">Добавить роль</a>
                          </div>
                          <div class="col-md-6">
                            <h4 class="page-title text-center">Роли</h4>
                          </div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
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
                                  <td>{{$loop->iteration}}</td>
                                  <td><a href="{{ url('admin/role/view', ['admin/role' => $role]) }}">{{$role->name}}</a></td>
                                  <td>{{$role->cityManagement->name ?? ''}}</td>
                                  <td>
                                    <div class="row">
                                      <button class="btn btn-link btn-simple-primary" data-original-title="Изменить"  onclick="window.location='{{url('admin/role/edit', ['role' => $role])}}'">
                                          <i class="la la-edit"></i>
                                      </button>
                                      <form action="{{ url('admin/role/delete', ['role' => $role]) }}" method="post">
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
                $.post('admin/list/delete', {'id':id, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });
            $('#saveChanges').click(function(event) {
                var id = $('#id').val();
                var value = $('#addItem').val();
                $.post('admin/list/update ', {'id':id, 'value':value,'_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });
        });
    </script>
@append