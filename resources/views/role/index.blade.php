@extends('layouts.master')

@section('title')
    Список Ролей
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Список Ролей | Всего: {{$rolesCount}} <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h4>
                    <form action="{{ route('role.search') }}" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q"
                                placeholder="Введите название Роли"> <span class="input-group-btn">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
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
                <div class="container">
                    @if(isset($details))
                        <p> Результаты поиска на <b> {{ $query }} </b> :</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Имя</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                            <tr>
                                <td><a href="{{ route('role.view', ['detail' => $detail]) }}">{{$detail->id}}</a></td>
                                <td>{{$detail->name}}</td>
                                <td><a href="{{ route('role.edit', ['detail' => $detail]) }}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                <td>
                                    <form action="{{ route('role.delete', ['detail' => $detail]) }}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                {{csrf_field()}}
                @if(empty($details))
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>№</th>
                                <th>Имя</th>
                                <th>Дата создания</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td><a href="{{ route('role.view', ['role' => $role]) }}">{{$role->id}}</a></td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$time->toDateString() }}</td>
                                    <td><a href="{{ route('role.edit', ['role' => $role]) }}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                    <td>
                                        <form action="{{ route('role.delete', ['role' => $role]) }}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="{{ route('role.create') }}" class="btn btn-primary">Создать Роль</a>
                    </div>

                </div>
                @endif
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
                var text = $('#addItem').val();
                console.log(text);
                if (text == '') {
                    alert('Please type anything');
                }
                $.post('roles/create', {'text':text, '_token':$('input[name=_token]').val()}, function(data){
                    console.log(data);
                    // $('#items').load(location.href + ' #items');
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
