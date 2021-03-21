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
        $dictionaries = $this->getAllDictionaries();
        return view('dictionary.index',compact('inputTypes','insertTypes','dictionaries'));
    }

    public function create(Request $request) {
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

        $dictionary = new Dictionary ([
            'name' => $fieldName,
            'label_name' => $labelName,
            'input_type_id' => $input->id,
            'insert_type_id' => $insert->id,
        ]);
        $dictionary->save();
        if ($inputItem == 'select' && $request->has('selectedOptions')) {
            foreach($selectOptions as $option) {
                $optn = new SelectOption;
                $optn->name_rus = $option;
                $optn->dictionary_id = $dictionary->id;
                $optn->save();
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
