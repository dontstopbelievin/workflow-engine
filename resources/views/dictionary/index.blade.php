@extends('layouts.master')

@section('title')
    Process Creation
@endsection

@section('content')

        <div class="row">
            <div class="col-md-12">
                <div class="card bg-white">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Справочник <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="items">
                            <table class="table">
                                <thead>
                                    <tr class="shadow p-3 mb-5 rounded text-secondary">
                                        <th><h6>Наименование поля</h6></th>
                                        <th><h6>Тип вводимого</h6></th>
                                        <th><h6>Тип сохраняемого</h6></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($dictionaries as $item)
                                    <tr class="shadow p-3 mb-5 rounded">
                                        <td class="align-middle"><h4>{{$item["labelName"]}}</h4></td>
                                        <td class="align-middle"><h4>{{$item["inputName"]}}</h4></td>
                                        <td class="align-middle"><h4>{{$item["insertName"]}}</h4></td>
                                    </tr>   
                                @endforeach                             
                                </tbody>
                            </tablе>
                        </div>

                    </div>
                
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="title">Добавить новое поле</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id">
                                <p><input type="text" placeholder="Введите название поля" id="addItem" class="form-control"></p>
                                <p><input type="text" placeholder="Введите ярлык поля(label name)" id="addLabelName" class="form-control"></p>
                                <input type="hidden" id="processId" value="1">
                                @isset($inputTypes)
                                    <label for="inputType">Выберите Тип Вводимого</label>
                                    <select class="form-control" name="inputType" id="inputType">
                                    <option selected disabled>Выберите Ниже</option>
                                    @foreach($inputTypes as $type)
                
                                        <option value="{{$type->name}}">{{$type->name}}</>
                                    @endforeach
                                    </select>
                                @endisset
                                <div id="hidden_div" style="display: none;">
                                @isset($options)
                                    @foreach ($options as $option)
                                        <div class="checkbox">
                                            <label><input class="get_value" type="checkbox" value="{{$option->name}}">{{$option->name}}</label>
                                        </div>
                                    @endforeach   
                                @endisset
                                </div>
                                @isset($insertTypes)
                                <label for="inputType">Выберите Тип Сохранения</label>
                                    <select class="form-control" name="insertType" id="insertType">
                                    <option selected disabled>Выберите Ниже</option>
                                    @foreach($insertTypes as $type)
                                        <option value="{{$type->name}}">{{$type->name}}</option>
                                    @endforeach
                                    </select>
                                @endisset
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="delete" style="display:none" data-dismiss="modal">Удалить</button>
                                <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none" >Сохранить изменения</button>
                                <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Добавить</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>



    {{csrf_field()}}


    {{--<div><a href="{{route('selectoptions.create')}}">Оздать опции</a></div>--}}
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
                var selectedOptions = [];

                $('.get_value').each(function(){
                if($(this).is(":checked"))
                {
                    selectedOptions.push($(this).val());
                }
                });

                if (text == '') {
                    alert('Введите название поля');
                    alert(selectedOptions);
                }  
                if (inputItem === null) {
                    alert('Выберите тип вводимого');
                } 
                if (insertItem === null) {
                    alert('Выберите тип сохранения');
                }
                $.post('dictionary/create', {'fieldName':text,'labelName': labelName,'inputItem': inputItem, 'insertItem': insertItem, 'processId': processId, 'selectedOptions':selectedOptions, '_token':$('input[name=_token]').val()}, function(data){
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
        
        });
    </script>
@endsection


