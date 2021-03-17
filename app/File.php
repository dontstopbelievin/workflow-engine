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
        $file_name = bcrypt($name . microtime());
        $file_url = $url . '/' . $file_name . '.xml';

        Storage::put($file_url, $content);

        if (!Storage::disk('local')->exists($file_url)) {
            return false;
        }

        $item = new File();
        $item->name = $name; // Название файла
        $item->url = $file_url; // Ссылка на файл
        $item->extension = 'xml'; // Расширение файла
        $item->content_type = 'text/xml'; // Тип файла
        $item->size = filesize(Storage::path($file_url)); // Размер файла
        $item->hash = $file_name; // Хэш файла
        $item->category_id = $category; // ИД категории
        $item->user_id = Auth::user()->id; // ИД пользователя

        if (!$item->save()) {
            return false;
        }
        return $item;
    }


}
