<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    public static function addXmlItem($name, $category, $url, $content)
    {
        $file_name = $name;
        $file_url = $url . '/' . $file_name . '.xml';
        $hash = bcrypt($file_name . microtime());

        // dd($file_url);
        Storage::put($file_url, $content);

        $item = File::where('url', $file_url)->where('name',$file_name)->first();

        if($item){
          $item->size = filesize(Storage::path($file_url)); // Размер файла
          $item->update();
        }else{
          Storage::put($file_url, $content);
          $item = new File();
          $item->name = $file_name; // Название файла
          $item->url = $file_url; // Ссылка на файл
          $item->extension = 'xml'; // Расширение файла
          $item->content_type = 'text/xml'; // Тип файла
          $item->size = filesize(Storage::path($file_url)); // Размер файла
          $item->hash = $hash; // Хэш файла
          $item->category_id = $category; // ИД категории
          $item->user_id = Auth::user()->id; // ИД пользователя
          if (!$item->save()) {
              return false;
          }
        }

        return $item;
    }


}
