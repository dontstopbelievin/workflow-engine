<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\TemplateField;
use App\InputType;
use App\InsertType;
use App\SelectOption;
use App\Role;
use Illuminate\Http\Request;
use App\Traits\dbQueries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TemplateFieldController extends Controller
{
    use dbQueries;

    public function create(Template $template) {

        $process = Process::where('id', $template->process_id)->first();
        $processId = $process->id;
        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $options = SelectOption::all();
        $oTemplateFields = $this->getAllTemplateFields($template->id);

        return view('templatefield.create', compact('template', 'oTemplateFields','inputTypes','insertTypes','options','processId'));
    }

    public function store(Request $request) {
        $inputItem = InputType::where('name', $request->inputItem)->first();
        $insertItem = InsertType::where('name', $request->insertItem)->first();
        $templateField = new TemplateField;
        $templateField->name = $request->fieldName;
        $templateField->label_name = $request->labelName;
        $templateField->input_type_id = $inputItem->id;
        $templateField->insert_type_id = $insertItem->id;
        $templateField->template_id = $request->temp_id;
        $templateField->save();
        return response()->json(['success' => true], 200);
    }
}
