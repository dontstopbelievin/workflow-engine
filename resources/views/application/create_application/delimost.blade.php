<div class="col-md-6" id="templateFieldsId">
    @foreach($arrayToFront as $item)
        <label>{{$item->labelName}}</label>
        @if($item->inputName === 'file')
            <input type="file" name={{$item->name}} class="form-control" multiple>
        @elseif($item->inputName === 'text')
            <input type="text" name={{$item->name}} id={{$item->name}} value="{{$egkn->firstname ?? ''}}" class="form-control">
        @elseif($item->inputName === 'url')
            <input type="text" name={{$item->name}} id={{$item->name}} class="form-control">
        @elseif($item->inputName === 'image')
            <input type="file" name={{$item->name}} id={{$item->name}} class="form-control">
        @else
            <select name="{{$item->name}}" id="{{$item->name}}" class="form-control">
                <label>$item->name</label>
                <option selected disabled>Выберите Ниже</option>
                @foreach($item->options as $val)
                    <option value="{{$val->name_rus}}">{{$val->name_rus}}</option>
                @endforeach
            </select>
        @endif
    @endforeach
    <label>Кадастровый номер</label>
    <input type="text" id="cadastr_number" value="" class="form-control">
    <button class="btn btn-primary" onclick="add_land()" style="margin:10px 0px;">Добавить</button>
    <button class="btn btn-primary" onclick="find_kadastr()" style="margin:10px 0px;">Поиск по кадастру</button>
    <input type="hidden" name="process_id" value={{$process->id}}>
    <button class="btn btn-primary" id="s_h_but" onclick="show_hide_map()" style="margin:10px 0px;">Показать карту</button>
    <div id="viewDiv" style="height: 0px"></div>
    <div style="margin-top: 20px">
        <button type="submit" onclick="create_applic()" class="btn btn-primary">Подать заявку</button>
    </div>
</div>