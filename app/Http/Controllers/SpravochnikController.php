<?php

namespace App\Http\Controllers;

use App\Spravochnik;
use App\InputType;
use App\InsertType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpravochnikController extends Controller
{

    public function index() {

        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        return view('spravochnik.index',compact('inputTypes','insertTypes'));
    }

    public function create(Request $request) {

        $fieldName = $request->fieldName;
        $inputItem = $request->inputItem;
        $insertItem = $request->insertItem;
        $processId = $request->processId;
        $processName = 'апз';
        $tableName = $this->translateSybmols($processName);
        $columns = Schema::getColumnListing($tableName);
        if (Schema::hasTable($tableName)) {

            $columns = Schema::getColumnListing($tableName);
            foreach($columns as $column) {
                if ($column === $fieldName) {
                    return 'такое поле уже существует в таблице';
                } else {
                    $dbQueryString = "ALTER TABLE $tableName ADD $fieldName varchar(255)"; 
                }
            }
            
        } else {
            $dbQueryString = "CREATE TABLE $tableName (
                id INT PRIMARY KEY AUTO_INCREMENT,
                $fieldName varchar(255)
            )";
        }
        $res = DB::statement($dbQueryString);
        dd($res);


    }


    public function createTable() {

        $dbQueryString = "CREATE TABLE Spravochnik (
        id INT PRIMARY KEY, 
        lastName varchar(255),
        firstName varchar(255),
        address varchar(255),
        city varchar(255))";
        DB::statement($dbQueryString);
    }

    private function translateSybmols($text) {

        $rus=array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ');
        $lat=array('a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya',' ');
        return str_replace($rus, $lat, $text);
    }
}
