<?php

namespace App\Http\Controllers;

use App\Dictionary;
use App\InputType;
use App\InsertType;
use App\SelectOption;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DictionaryController extends Controller
{

    use dbQueries;
    public function index() {

        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $options = SelectOption::all();
        $dictionaries = $this->getAllDictionaries();
        return view('dictionary.index',compact('inputTypes','insertTypes','dictionaries','options'));
    }
    
    public function create(Request $request) {

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
//        $columns = Schema::getColumnListing($tableName);
        if (Schema::hasTable($tableName)) {
            $columns = Schema::getColumnListing($tableName);
            if ($columns) {
                foreach($columns as $column) {
                    if ($column === $fieldName) {
                        return 'такое поле уже существует в таблице';
                    } else {
                        $dbQueryString = "ALTER TABLE $tableName ADD $fieldName varchar(255)";
                    }
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
        $dictionariesWithOptions = $this->addOptionsToDictionary($dictionaries);
        dd($dictionaries, $dictionariesWithOptions);
        return view('dictionary.create',compact('dictionariesWithOptions'));
    }

    public function saveToTable(Request $request) {

        dd($request->input());
    }




//    public function add() {
//        $today = date("2020/3/21");
//
//        $todayDay = intval(date('d', strtotime($today)));
//        $todayYear = intval(date('Y', strtotime($today)));
//        $todayMonth = intval(date('m', strtotime($today)));
//        $quarterToday = $this->getQuarterFromDate($today);
////        dd(gettype($todayDay), $todayYear, $todayMonth);
//        $validDays = [21,22,23,24,25,26,27,28,29,30,31];
//        $year = 2020; //за какой год делает оплату
//
//        $quarter = 2; //за какой квартал делает оплату
//        $specialStatus = false;
//        if (intval($year)  >=  $todayYear) {
//            if ($quarterToday >= intval($quarter)) { // если сегодняшний квартал больше или равен кварталу, за который оплачивает
//              $diff = 0;
//              if ($quarter === 1) {
//                $diff = abs(strtotime($today) - strtotime('2020/01/01'));
//                $diff = $diff / 60/60/24;
//              } else if ($quarter === 2) {
//                $diff = abs(strtotime($today) - strtotime('2020/04/01'));
//                $diff = $diff / 60/60/24;
//              } else if ($quarter === 3) {
//                $diff = abs(strtotime($today) - strtotime('2020/07/01'));
//                $diff = $diff / 60/60/24;
//              } else if ($quarter === 4) {
//                $diff = abs(strtotime($today) - strtotime('2020/10/01'));
//                $diff = $diff / 60/60/24;
//              }
//              dd('Оплата с просрочкой ' .$diff .' дней', $specialStatus);
//            } else {
//                if ($quarter === 1 && $todayMonth === 12 && in_array($todayDay , $validDays)) {
//                    $specialStatus = true;
//                } else if ($quarter === 2 && $todayMonth === 3 && in_array($todayDay, $validDays)){
//                    $specialStatus = true;
//                } else if ($quarter === 3 && $todayMonth === 6 &&  in_array($todayDay,$validDays)){
//                    $specialStatus = true;
//                } else if ($quarter === 4 && $todayMonth === 9 && in_array($todayDay,$validDays)){
//                    $specialStatus = true;
//                }
//              return dd('Оплачено', $specialStatus);
//            }
//          } else {
//            return dd('Не оплачено', $specialStatus);
//          }
//    }
//    private function getQuarterFromDate($date) {
//        $month = date('m', strtotime($date));
//        if (3 >= $month) {
//          return 1;
//        } else if (6 >= $month) {
//          return 2;
//        } else if (9 >= $month) {
//          return 3;
//        } else {
//          return 4;
//        }
//      }
}
