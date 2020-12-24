@extends('layouts.master')

@section('title')
    Создание Полей
@endsection

@section('content')

      <div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<div class="d-flex justify-content-between">
							<h4 class="page-title">Справочник</h4>
						</div>
            <div class="mb-3">
              <button type="button" id="addNew" class="btn btn-info" data-toggle="modal" data-target="#myModal">Добавить</button>
            </div>
						<div class="card">
							<!-- <div class="card-header">
				        <div class="card-title">Table</div>
				      </div> -->
							<div class="card-body">
								<table class="table table-hover" id="items">
                  <thead>
                    <tr>
                      <th style="width:7%;">#</th>
                      <th style="width:20%;">НАИМЕНОВАНИЕ УСЛУГИ</th>
											<th style="width:20%;">ТИП ВВОДИМОГО</th>
											<th style="width:20%;">ТИП СОХРАНЯЕМОГО</th>
                      <th style="width:13%;">Действия</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($dictionaries as $item)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$item["labelName"]}}</td>
                          <td>{{$item["inputName"]}}</td>
                          <td>{{$item["insertName"]}}</td>
                          <td>
                            <div class="row">
                              <button class="btn btn-link btn-simple-primary" data-original-title="Изменить" data-toggle="modal" data-target="#">
                                  <i class="la la-edit"></i>
                              </button>
                              <button class="btn btn-link btn-simple-danger">
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



      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    		<div class="modal-dialog modal-dialog-centered" role="document">
    			<div class="modal-content">
    				<div class="modal-header bg-primary">
    					<h6 class="modal-title" id="title">Добавить справочник</h6>
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
  							<input type="text" class="form-control" id="addLabelName" placeholder="Введите ярлык поля(label name)">
  						</div>
              <input type="hidden" id="processId" value="1">
              @isset($inputTypes)
                <div class="form-group">
                  <label for="inputType">Выберите Тип Вводимого</label>
                  <select class="form-control" name="inputType" id="inputType" data-dropup-auto="false">
                    <option selected disabled>Выберите Ниже</option>
                    @foreach($inputTypes as $type)
                      <option value="{{$type->name}}">{{$type->name}}</>
                    @endforeach
                  </select>
                </div>
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
                <div class="form-group">
                  <label for="insertType">Выберите Тип Сохранения</label>
                  <select class="form-control" id="insertType" name="insertType" data-dropup-auto="false">
                    <option selected disabled>Выберите Ниже</option>
                    @foreach($insertTypes as $type)
                        <option value="{{$type->name}}">{{$type->name}}</option>
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

    {{csrf_field()}}


    {{--<div><a href="{{route('selectoptions.create')}}">Оздать опции</a></div>--}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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
