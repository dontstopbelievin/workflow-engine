<div class="row">
    <div class="col-md-6" id="templateFieldsId">
        @foreach($arrayToFront as $item)
            @if($item->inputName === 'file')
                <label class="in_label">{{$item->labelName}}</label>
                <input type="file" name={{$item->name}} class="form-control" multiple>
            @elseif($item->inputName === 'text')
                <label class="in_label">{{$item->labelName}}</label>
                <input type="text" name={{$item->name}} id={{$item->name}} value="{{Auth::user()->{$item->name} ?? ''}}" class="form-control">
            @elseif($item->inputName === 'hidden')
                <input type="hidden" name={{$item->name}} id={{$item->name}} class="form-control">
            @elseif($item->inputName === 'select')
                <label class="in_label">{{$item->labelName}}</label>
                <select name="{{$item->name}}" id="{{$item->name}}" class="form-control">
                    <label>$item->name</label>
                    <option selected disabled>Выберите Ниже</option>
                    @foreach($item->options as $val)
                        <option value="{{$val->name_rus}}">{{$val->name_rus}}</option>
                    @endforeach
                </select>
            @else
                ne eby
            @endif
        @endforeach
        <input type="hidden" name="process_id" value={{$process->id}}>
        <div style="margin-top: 20px">
            <button type="submit" onclick="create_applic()" class="btn btn-primary">Подать заявку</button>
        </div>
    </div>
    <div class="col-md-6">
        <!-- <button class="btn btn-primary" id="s_h_but" onclick="show_hide_map()" style="margin:10px 0px;">Показать карту</button> -->
        <!-- <button class="btn btn-primary" id="s_point" onclick="save_point()" style="margin:10px 0px;">Сохранить точку</button> -->
        <div id="viewDiv" style=""></div>
    </div>
</div>