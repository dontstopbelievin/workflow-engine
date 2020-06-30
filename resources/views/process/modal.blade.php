@extends('process.create')

@section('modal-content')
    <div class="container"> 
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
                <div class="modal-content">
                <label for="fields">Состав полей</label>
                    <div class="modal-header">
                        <h4 class="modal-title">Список Полей</h4>
                    </div>
                    <form action="/process/fields" method="GET">
                        <div class="modal-body">
                            @isset($fields)
                                @foreach ($fields as $field)
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fields[]" value="{{$field->name}}">{{$field->name}}</label>
                                    </div>
                                @endforeach   
                            @endisset
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Выбрать</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        </div>      
                    </form>
                </div>                                          
            </div>
        </div>     
    </div>  
@endsection