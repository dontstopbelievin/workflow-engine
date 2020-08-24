<?php

namespace App\Http\Controllers;

use App\Dictionary;
use App\InputType;
use App\InsertType;
use App\SelectOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DictionaryController extends Controller
{

    public function index() {

        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $options = SelectOption::all();
        $dictionaries = $this->getAllDictionaries();
        return view('dictionary.index',compact('inputTypes','insertTypes','dictionaries','options'));
    }
    
    public function create(Request $request) {

        // dd($request->input());
        $fieldName = $request->fieldName;
        $inputItem = $request->inputItem;
        $insertItem = $request->insertItem;
        $processId = $request->processId;
        $selectOptions = $request->selectedOptions;

        $validatedData = $request->validate([
            'fieldName' => 'required',
            'inputItem' => 'required',
            'insertItem' => 'required',
            'processId' => 'required',
        ]);
        $dictionaries = Dictionary::all();
        foreach($dictionaries as $spr) {
            if ($spr->name === $fieldName) {
                return 'Такое поле в базе уже есть';
            }
        }
        $input = InputType::where('name', $inputItem)->first();
        $insert = InsertType::where('name', $insertItem)->first();

        $dictionaries = new Dictionary ([
            'name' => $fieldName,
            'input_type_id' => $input->id,
            'insert_type_id' => $insert->id,
        ]);
        $dictionaries->save();

        $dic = Dictionary::where('name', $fieldName)->first();
        $dicId = $dic->id; // айди поля, которое только что сохранили
        
        if ($request->has('selectedOptions')) {
          foreach($request->selectedOptions as $key=>$value) {
            $optn = SelectOption::where('name', $value)->first();
            $dic->selectOptions()->attach($optn);
        }
        }
        
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

    public function createFields() {
        $dictionaries = $this->getAllDictionaries();
        $dictionariesWithOptions = [];
        foreach($dictionaries as $dictionary) {

            if($dictionary["inputName"] === 'select') {
                $options = $this->getOptionsOfThisSelect($dictionary["name"]);
                $dictionary["inputName"] = $options;
            }
            array_push($dictionariesWithOptions, $dictionary);
        }

//        dd($dictionariesWithOptions);
        return view('dictionary.create',compact('dictionariesWithOptions'));
    }

    public function saveToTable(Request $request) {
//        dd('here');
        dd($request->input());
    }

    public function getOptionsOfThisSelect($name) {

        $dics = Dictionary::where('name', $name)->first()->selectOptions()->get();
        $selectedOptions = [];
        foreach ($dics as $dic) {
            array_push($selectedOptions, $dic->name);
        }
        return $selectedOptions;
    }



    private function translateSybmols($text) {

        $rus=array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ');
        $lat=array('a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya',' ');
        return str_replace($rus, $lat, $text);
    }

    private function getAllDictionaries() {
        $query = DB::table('dictionaries')
        ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
        ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
        ->select('dictionaries.name', 'input_types.name as inputName', 'insert_types.name as insertName')
        ->get()->toArray();
        $res = json_decode(json_encode($query), true);
        return $res;
    }

    public function add() {
        $today = date("2020/3/21");

        $todayDay = intval(date('d', strtotime($today)));
        $todayYear = intval(date('Y', strtotime($today)));
        $todayMonth = intval(date('m', strtotime($today)));
        $quarterToday = $this->getQuarterFromDate($today);
//        dd(gettype($todayDay), $todayYear, $todayMonth);
        $validDays = [21,22,23,24,25,26,27,28,29,30,31];
        $year = 2020; //за какой год делает оплату

        $quarter = 2; //за какой квартал делает оплату
        $specialStatus = false;
        if (intval($year)  >=  $todayYear) {
            if ($quarterToday >= intval($quarter)) { // если сегодняшний квартал больше или равен кварталу, за который оплачивает
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
              dd('Оплата с просрочкой ' .$diff .' дней', $specialStatus);
            } else {
                if ($quarter === 1 && $todayMonth === 12 && in_array($todayDay , $validDays)) {
                    $specialStatus = true;
                } else if ($quarter === 2 && $todayMonth === 3 && in_array($todayDay, $validDays)){
                    $specialStatus = true;
                } else if ($quarter === 3 && $todayMonth === 6 &&  in_array($todayDay,$validDays)){
                    $specialStatus = true;
                } else if ($quarter === 4 && $todayMonth === 9 && in_array($todayDay,$validDays)){
                    $specialStatus = true;
                }
              return dd('Оплачено', $specialStatus);
            }
          } else {
            return dd('Не оплачено', $specialStatus);
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
