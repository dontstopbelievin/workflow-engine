<div class="col-md-6">
    @foreach($arrayToFront as $item)
        <label>{{$item->labelName}}</label>
        @if($item->inputName === 'file')
            <input type="file" name={{$item->name}} class="form-control" multiple>
        @elseif($item->inputName === 'text')
            <input type="text" name={{$item->name}} id={{$item->name}} value="{{Auth::user()->{$item->name} ?? ''}}" class="form-control">
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
    <input type="hidden" name="process_id" value = {{$process->id}}>
    @if($process->need_map)
        <button class="btn btn-primary" onclick="add_land()" style="margin:10px 0px;">Добавить</button>
        <button class="btn btn-primary" id="s_h_but" onclick="show_hide_map()" style="margin:10px 0px;">Показать карту</button>
        <div id="viewDiv" style="height: 0px"></div>
    @endif
    <div style="margin-top: 20px">
        <button type="submit" onclick="create_applic()" class="btn btn-primary">Подать заявку</button>
    </div>
</div>