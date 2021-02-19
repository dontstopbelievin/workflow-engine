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
            $request->validate([
                'name' => 'required',
                'template_state' => 'required',
            ]);
            $templateState = $request->template_state === "accepted";
            // delete old one?
            $template = new Template([
                'name' => $request->name,
                'accept_template' => $templateState,
            ]);
            $template->save();
            $process = Process::find($request->processId);
            if ($request->template_state === "accepted") {
                $process->update(['accepted_template_id' => $template->id]);
                DB::commit();
                return Redirect::to('template_field/create', [$template])->with('status','Шаблон успешно создан');
            } else if ($request->template_state === "rejected") {
                $process->update(['rejected_template_id' => $template->id]);
                DB::commit();
                return Redirect::back()->with('status','Шаблон отказа успешно создан');
            }
            return response()->json(['message' => 'template not found'], 500);
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
