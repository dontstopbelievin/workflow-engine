@extends('layouts.master')

@section('title')
   Роли
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Городские Управлнеия <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                </div>
                <div class="panel-body" id="items">
                    <ul class="list-group">
                        @foreach($cityManagements as $cityManagement)
                            <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{$cityManagement->name}}
                                <input type="hidden" id="itemId" value = {{$cityManagement->id}}>
                            </li>

                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" name="item" id="searchItem" placeholder="Search">
            </div>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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


{{csrf_field()}}
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

            if (text == '') {
                alert('Please type anything');
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


