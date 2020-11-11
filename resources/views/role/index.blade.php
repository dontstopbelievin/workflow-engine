@extends('layouts.master')

@section('title')
    Список Ролей
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-center">Список Ролей</h3>
                    <!-- <form action="{{ route('role.search') }}" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q"
                                placeholder="Введите название Роли"> <span class="input-group-btn">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form> -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="p-3 mb-5 rounded text-secondary">
                                    <th class="text-center border-0"><h6>№</h6></th>
                                    <th class="w-50 text-left border-0"><h6>Имя</h6></th>
                                    <th class="text-left border-0"><h6>Управление</h6></th>
                                    <th colspan="2" class="text-center border-0"><h6>Действия</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr class="p-3 mb-5 rounded">
                                        <td class="text-center align-middle border"><a href="{{ route('role.view', ['role' => $role]) }}"><h5>{{$loop->iteration}}</h5></a></td>
                                        <td class="w-50 text-left align-middle border"><h5>{{$role->name}}</h5></td>
                                        <td class="text-left align-middle border"><h5>{{$role->cityManagement->name ?? ''}}</h5></td>
                                        <td class="text-right align-middle">
                                            <button class="rounded-circle bg-white" onclick="window.location='{{route('role.edit', ['role' => $role])}}'">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill rounded cicrle" fill="blue" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                </svg>
                                            </button>
                                        </td>
                                        <td class="text-left align-middle">
                                            <form action="{{ route('role.delete', ['role' => $role]) }}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="rounded-circle bg-white"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill border-light" fill="red" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="{{ route('role.create') }}" class="btn btn-info btn-lg my-5">Создать Роль</a>
                    </div>

                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                <h4 class="modal-title" id="title">Add New Item</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id">
                                <p><input type="text" placeholder="Write item here" id="addItem" class="form-control"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="delete" style="display:none" data-dismiss="modal">Delete</button>
                                <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none" >Save changes</button>
                                <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Add Item</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
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
