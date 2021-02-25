<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\TemplateField;
use App\InputType;
use App\InsertType;
use App\SelectOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\dbQueries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    use dbQueries;

    public function index() {

        $acceptedTemplates = Template::accepted()->get(); // make camelcase
        $rejectedTemplates = Template::rejected()->get();
        return view('template.index', compact('acceptedTemplates', 'rejectedTemplates'));
    }

    public function create() {
        return view('template.create');
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'template_state' => 'required|integer',
                'process_id' => 'required|integer',
                'template_doc_id' => 'required|integer',
                'role_id' => 'required|integer',
                'order' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->with('failure', $validator->errors());
            }
            $template = new Template([
                'table_name' => $request->name,
                'accept_template' => $request->template_state,
                'process_id' => $request->process_id,
                'template_doc_id' => $request->template_doc_id,
                'role_id' => $request->role_id,
                'order' => $request->order,
            ]);
            $template->save();
            DB::commit();
            return Redirect::action([TemplateFieldController::class, 'create'], [$template])->with('status','Шаблон успешно создан');
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit(Template $template) {

        return view('template.edit', compact('template'));
    }

    public function update($id, Request $request) {
        $isTouch = isset($request->file_input);
        if($isTouch){
          $docPath = request()->file_input->store('templates', 'public');
          $template = Template::where('id', $id)->update(['name' => $request->name, 'doc_path' => $docPath]);
        }else{
          $template = Template::where('id', $id)->update(['name' => $request->name]);
        }

        return 'Шаблон успешно обновлен';
    }

    public function delete($id) {
        $template = Template::where('id', $id)->delete();
        //$template->delete();
        return 'Шаблон успешно удален';
    }
}
