<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;

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
        return redirect('/templates')->with('status','Шаблон успешно создан');;
    }

    public function edit($id) {
        $template = Template::findOrFail($id);
        return view('template.edit')->with('template', $template);
    }

    public function update(Request $request, $id) 
    {
        $template = Template::find($id);
        $template->name = $request->input('name');
        $template->doc_path = $request->input('file_input');
        $template->update();
        return redirect('/templates')->with('status','Шаблон успешно обновлен');
    }

    public function delete($id) 
    {
        $value = Template::findOrFail($id);
        $value->delete();
        return redirect('/templates')->with('status','Шаблон успешно удален');
    }
}
