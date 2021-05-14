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
use Illuminate\Support\Facades\Validator;
use App\DictDefaultValues;

class TemplateFieldController extends Controller
{
    use dbQueries;

    public function create(Template $template) {

        $process = Process::where('id', $template->process_id)->first();
        $processId = $process->id;
        $inputTypes = InputType::all();
        $insertTypes = InsertType::all();
        $options = SelectOption::all();
        $dictionaries = Dictionary::where('input_type_id', 3)->get();
        $temp_fields = $this->getAllTemplateFields($template->id);
        return view('templatefield.create', compact('template', 'temp_fields','inputTypes','insertTypes','options','processId', 'dictionaries'));
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'fieldName' => 'required|string',
                'labelName' => 'required|string',
                'inputItem' => 'required|integer',
                'insertItem' => 'required|integer',
                'temp_id' => 'required|integer',
                'select_dic' => 'nullable|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 500);
            }
            $templateField = new TemplateField;
            $templateField->name = $request->fieldName;
            $templateField->label_name = $request->labelName;
            $templateField->input_type_id = $request->inputItem;
            $templateField->insert_type_id = $request->insertItem;
            $templateField->template_id = $request->temp_id;
            $templateField->select_dic = $request->select_dic;
            $templateField->save();

            $table_name = Template::find($request->temp_id)->table_name;
            if($request->inputItem == 4){
                $dbQueryString = "ALTER TABLE $table_name ADD COLUMN `$request->fieldName` text";
            }else{
                $dbQueryString = "ALTER TABLE $table_name ADD COLUMN `$request->fieldName` varchar(255)";
            }
            DB::statement($dbQueryString);
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            DB:rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    } // HERE!!!

    public function def_value($field_id) {

        $field = TemplateField::find($field_id);
        $template = Template::find($field->template_id);
        $def_values = DB::table('dic_default_values')->where('field_id', $field_id)->get();
        return view('templatefield.def_value', compact('template', 'field', 'def_values'));
    }

    public function def_value_store(Request $request) {
        try {
            $validator = Validator::make($request->all(),[
                'title' => 'required|string',
                'text' => 'required|string',
                'field_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->with('error', $validator->errors());
            }

            $item = new DictDefaultValues;
            $item->title = $request->title;
            $item->text = $request->text;
            $item->field_id = $request->field_id;
            $item->save();
            return Redirect::back()->with('success', 'Успешно добавлен.');
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    } // HERE!!!

    public function delete($id)  // HERE!!!
    {
        try {
            $item = DictDefaultValues::find($id);
            $item->delete();
            return Redirect::back()->with('status', 'Значение успешно удалено.');
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
}
