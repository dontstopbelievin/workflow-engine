<?php

namespace App\Http\Controllers;

use App\Spravochnik;
use App\InputType;
use App\InsertType;
// use App\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpravochnikController extends Controller
{

    public function index() {

        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $dictionaries = $this->getAllDictionaries();
        // dd($dictionaries);
        return view('spravochnik.index',compact('inputTypes','insertTypes','dictionaries'));
    }
    
    public function create(Request $request) {

        $fieldName = $request->fieldName;
        $inputItem = $request->inputItem;
        $insertItem = $request->insertItem;
        $processId = $request->processId;

        $validatedData = $request->validate([
            'fieldName' => 'required',
            'inputItem' => 'required',
            'insertItem' => 'required',
            'processId' => 'required',
        ]);
        $spravochniks = Spravochnik::all();
        foreach($spravochniks as $spr) {
            if ($spr->name === $fieldName) {
                return 'Такое поле в базе уже есть';
            }
        }
        $input = InputType::where('name', $inputItem)->first();
        $insert = InsertType::where('name', $insertItem)->first();

        $spravochnik = new Spravochnik ([
            'name' => $fieldName,
            'input_type_id' => $input->id,
            'insert_type_id' => $insert->id,
        ]);
        $spravochnik->save();
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

    private function getAllDictionaries() {
        $query = DB::table('spravochniks')
        ->join('input_types', 'spravochniks.input_type_id', '=', 'input_types.id')
        ->join('insert_types', 'spravochniks.insert_type_id', '=', 'insert_types.id')
        ->select('spravochniks.name', 'input_types.name as inputName', 'insert_types.name as insertName')
        ->get()->toArray();
        // dd($query);
        $res = json_decode(json_encode($query), true);
        return $res;
    }

    public function calc() {
        $today = date("2020/12/20");
        // $today = date("Y/m/d");
        // dd(gettype($today));
        $todayDay = date('d', strtotime($today));
        $todayYear = date('Y', strtotime($today));
        $todayMonth = date('m', strtotime($today));
        $quarterToday = $this->getQuarterFromDate($today);

        $year = 2020; //за какой год делает оплату

        $quarter = 1; //за какой квартал делает оплату

        if (intval($year)  >=  $todayYear) {
            if ($quarterToday >= intval($quarter)) {
            //   if ($todayDay<=10 && in_array($todayMonth, array('01', '04', '07', '10'))) {
            //     dd('Оплачено');
            //   } 
              $diff = 0;
              if ($quarter === 1) {
                $diff = abs(strtotime($today) - strtotime('2020/01/01'));
                $diff = $diff / 60/60/24;
              } else if ($quarter === 2) {
                $diff = abs(strtotime($today) - strtotime('2020/04/01'));
                $diff = $diff / 60/60/24;
              } else if ($quarter === 3) {
                $diff = abs(strtotime($today) - strtotime('2020/07/01'));
                $diff = $diff / 60/60/24;
              } else if ($quarter === 4) {
                $diff = abs(strtotime($today) - strtotime('2020/10/01'));
                $diff = $diff / 60/60/24;
              }
              dd('Оплата с просрочкой на ' .$diff .' дней');
            } else if ($quarterToday < intval($quarter)) {
              return dd('Оплачено');
            } else {
              return dd('Просрочено');
            }
          } else {
            return dd('Не оплачено');
          }
    }
    private function getQuarterFromDate($date) {
        $month = date('m', strtotime($date));
        if (3 >= $month) {
          return 1;
        } else if (6 >= $month) {
          return 2;
        } else if (9 >= $month) {
          return 3;
        } else {
          return 4;
        }
      }
}
