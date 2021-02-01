<?php

namespace App\Http\Controllers;

use App\EgknService;
use App\Process;
use Illuminate\Http\Request;
use App\Traits\dbQueries;
use Illuminate\Support\Facades\Redirect;

class EgknServiceController extends Controller
{
    use dbQueries;

    public function index()
    {
        $aFields = EgknService::where('passed_to_process', 0)->get();
        return view('egknservice.index', compact('aFields'));
    }

    public function view(Request $request)
    {
        $aFields = EgknService::where('id', $request->id)->get()->toArray();
        return view('egknservice.view', compact('aFields'));
    }

    public function load()
    {
        return Redirect::back();
    }

    public function status(Request $request)
    {
        $aField = EgknService::where('id', $request->id)->first();
        $aField->egkn_status = 'Зарегистрировано';
        $aField->update();
        return Redirect::back();
    }

    public function act(Request $request)
    {
        $egkn = EgknService::find($request->id);
// try to do this by using ddd
        $process = Process::find(17);
        $tableName = $this->getTableName($process->name);
        $tableColumns = $this->getColumns($tableName);
        $originalTableColumns = $this->getOriginalColumns($tableColumns);
        $dictionaries = $this->getAllDictionaries();
        $res = [];

        foreach($dictionaries as $item) {
            foreach($originalTableColumns as $column) {
                if($item["name"] === $column) {
                    array_push($res, $item);
                }
            }
        }
        $dictionariesWithOptions = $this->addOptionsToDictionary($res);
        $arrayToFront = $this->getAllDictionariesWithOptions($dictionariesWithOptions);

        return view('application.create', compact('process', 'arrayToFront','egkn'));
    }


    private function getAllDictionariesWithOptions($dictionariesWithOptions) {
        $arrayToFront = [];
        foreach($dictionariesWithOptions as $item) {
            $replaced = str_replace(' ', '_', $item["name"]);
            $item["name"] = $replaced;
            array_push($arrayToFront, $item);
        }
        return $arrayToFront;
    }

}
