@foreach($process_roles as $process_role)
  <tr>
    <td>
      <li class="list-group-item my-auto ourItem AddButton" data-name="{{$process_role->name}}" data-id="{{$process_role->role_id}}" data-toggle="modal" data-target="#myModal2">
        @if(mb_strlen($process_role->name, 'utf-8') > 50)
          <div href="#" data-toggle="tooltip" title="{{$process_role->name}}">
            {{mb_substr($process_role->name, 0, 50, 'utf-8')}}...
          </div>
        @else
            {{$process_role->name}}
        @endif
      </li>
    </td>
    <td>
      <form action="{{ url('admin/process_role/update', [$process]) }}" method="POST">
          @csrf
          <div class="form-group">
              <input type="hidden" name="id" value={{$process_role->id}} />
              <input type="number" name="order" value={{$process_role->order}} style="width:70px;" />
              <button type="submit" class="btn btn-primary btn-xs">Изменить</button>
          </div>
      </form>
    </td>
    <td>
      <form action="{{ url('admin/process_role/delete', [$process]) }}" method="POST">
          @csrf
          <div class="form-group">
              <input type="hidden" name="id" value={{$process_role->id}} />
              <button type="submit" class="btn btn-primary btn-xs">Удалить</button>
          </div>
      </form>
    </td>
  </tr>
  @if(count($process_role->child) > 0)
    <tr>
      <td></td>
      <td colspan="2">
        <table border="1" cellpadding="5" style="text-align: center;">
          <td>Роль</td><td>Очередность</td><td></td>
          @include('process.process_roles_list', ['process_roles' => $process_role->child])
        </table>
      </td>
    </tr>
  @endif
@endforeach