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

//        dd($request->input());

        $fieldName = $request->fieldName;
        $labelName = $request->labelName;
        $inputItem = $request->inputItem;
        $insertItem = $request->insertItem;
        $processId = $request->processId;
        $selectOptions = $request->selectedOptions;

        $validatedData = $request->validate([
            'fieldName' => 'required',
            'labelName' => 'required',
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
            'label_name' => $labelName,
            'input_type_id' => $input->id,
            'insert_type_id' => $insert->id,
        ]);
        $dictionaries->save();

        $dic = Dictionary::where('name', $fieldName)->first();
        $dicId = $dic->id; // айди поля, которое только что сохранили
        
        if ($request->has('selectedOptions')) {
            foreach($selectOptions as $key=>$value) {
            $optn = SelectOption::where('name', $value)->first();
            $dic->selectOptions()->attach($optn);
            }
        }
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

}
