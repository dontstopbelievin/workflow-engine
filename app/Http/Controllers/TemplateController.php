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
        
        $templateState = $request->template_state === "accepted";
        $request->validate([
            'name' => 'required',
            'template_state' => 'required',
        ]);
        $template = new Template([
            'name' => $request->name,
            'accept_template' => $templateState,
        ]);
        $template->save();
        $process = Process::find($request->processId);
        if ($request->template_state === "accepted") {
            $process->update(['accepted_template_id' => $template->id]);
            return Redirect::route('templatefield.create', [$template])->with('status','Шаблон успешно создан');
        } else if ($request->template_state === "rejected") {
            $process->update(['rejected_template_id' => $template->id]);
            return Redirect::back();
        }
        echo('404 not found');
    }

    public function edit(Template $template) {

        return view('template.edit', compact('template'));
    }

    public function update(Request $request, Template $template) {

        $template->name = $request->name;
        $template->doc_path = $request->file_input;
        $template->update();
        return Redirect::route('template.index')->with('status','Шаблон успешно обновлен');
    }

    public function delete(Template $template) {
        
        $template->delete();
        return Redirect::route('template.index')->with('status','Шаблон успешно удален');
    }
}
