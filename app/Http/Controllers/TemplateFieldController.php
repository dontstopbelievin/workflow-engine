<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\TemplateField;
use App\InputType;
use App\InsertType;
use App\SelectOption;
use App\Dictionary;
use App\Role;
use Illuminate\Http\Request;
use App\Traits\dbQueries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TemplateFieldController extends Controller
{
    use dbQueries;

    public function create(Template $template) {

        $id = $template->id;
        $template_name = $template->name;
        $process = Process::where('accepted_template_id', $id)->orWhere('rejected_template_id', $id)->first();
        $processId = $process->id;
        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $options = SelectOption::all();
        $dictionaries = Dictionary::where('input_type_id', 3)->get();
//        dd($dictionaries);
        $roles = DB::table('process_role')
                    ->join('roles', 'roles.id', '=', 'process_role.role_id')
                    ->where('process_role.process_id', '=', $process->id)
                    ->get('roles.name');

        $oTemplateFields = $this->getAllTemplateFields($template->id);
        return view('templatefield.create', compact('id', 'oTemplateFields','inputTypes','insertTypes','options','processId', 'roles', 'template_name', 'dictionaries'));
    }

    public function store(Request $request) {
        $inputItem = InputType::where('name', $request->inputItem)->first();
        $insertItem = InsertType::where('name', $request->insertItem)->first();
        $role = Role::where('name', $request->role)->first();
        $templateField = new TemplateField;
        $templateField->name = $request->fieldName;
        $templateField->label_name = $request->labelName;
        $templateField->input_type_id = $inputItem->id;
        $templateField->insert_type_id = $insertItem->id;
        $templateField->template_id = $request->tempId;
        $templateField->can_edit_role_id = $role->id;
        $templateField->save();
        return response()->json(['success' => true], 200);
    }
}
