<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\TemplateField;
use App\InputType;
use App\InsertType;
use App\SelectOption;
use Illuminate\Http\Request;
use App\Traits\dbQueries;

class TemplateFieldsController extends Controller
{
    use dbQueries;

    public function create(Template $template) {

        $id = $template->id;
        $process = Process::where('accepted_template_id', $id)->orWhere('rejected_template_id', $id)->first();
        $processId = $process->id;
        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $options = SelectOption::all();
        $oTemplateFields = $this->getAllTemplateFields($template->id);
        return view('templatefield.create', compact('id', 'oTemplateFields','inputTypes','insertTypes','options','processId'));
    }

    public function store(Request $request) {

        $inputItem = InputType::where('name',$request->inputItem)->first();
        $insertItem = InsertType::where('name',$request->insertItem)->first();
        $templateField = new TemplateField;
        $templateField->name = $request->fieldName;
        $templateField->label_name = $request->labelName;
        $templateField->input_type_id = $inputItem->id;
        $templateField->insert_type_id = $insertItem->id;
        $templateField->template_id = $request->tempId;
        $templateField->save();
    }
}
