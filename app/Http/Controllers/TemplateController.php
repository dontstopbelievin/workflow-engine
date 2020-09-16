<?php

namespace App\Http\Controllers;

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
    public function index() {

        $acceptedTemplates = Template::accepted()->get(); // make camelcase
        $rejectedTemplates = Template::rejected()->get();
        return view('template.index', compact('acceptedTemplates', 'rejectedTemplates'));
    }
    use dbQueries;
    public function create() {
        return view('template.create');
    }

    public function store(Request $request) {

        $templateState = $request->template_state === "accepted";

        $request->validate([
            'name' => 'required',
            'template_state' => 'required',
            'file_input' => ['required', 'file'] // max size of 5 mb
        ]);
        $docPath = request()->file_input->store('templates', 'public');

        $template = new Template([
            'name' => $request->name,
            'doc_path' => $docPath,
            'accept_template' => $templateState,
        ]);
        $template->save();
        return Redirect::route('templatefield.create', [$template])->with('status','Шаблон успешно создан');
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
