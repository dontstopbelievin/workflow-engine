<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TemplateController extends Controller
{
    public function index() {
        $accepted_templates = Template::accepted()->get();
        $rejected_templates = Template::rejected()->get();
        return view('template.index')->with(compact('accepted_templates', 'rejected_templates'));
    }

    public function create() {
        return view('template.create');
    }

    public function store(Request $request) {
        $template_state = $request->template_state === "accepted";
        $docpath = request()->file_input->store('templates', 'public');
        $request->validate([
            'name' => 'required',
            'template_state' => 'required',
            'file_input' => ['required', 'file'] // max size of 5 mb
        ]);

        $template = new Template([
            'name' => $request->get('name'),
            'doc_path' => $docpath,
            'accept_template' => $template_state,
        ]);
        $template->save(); 
        return Redirect::route('template.index')->with('status','Шаблон успешно создан');;
    }

    public function edit(Template $template) {
        return view('template.edit')->with(compact('template'));
    }

    public function update(Request $request, Template $template) 
    {
        $template->name = $request->input('name');
        $template->doc_path = $request->input('file_input');
        $template->update();
        return Redirect::route('template.index')->with('status','Шаблон успешно обновлен');
    }

    public function delete(Template $template) 
    {
        $template->delete();
        return Redirect::route('template.index')->with('status','Шаблон успешно удален');
    }
}
