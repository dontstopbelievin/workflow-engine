<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TemplateController extends Controller
{
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
        $docPath = request()->file_input->store('templates', 'public');
        $request->validate([
            'name' => 'required',
            'template_state' => 'required',
            'file_input' => ['required', 'file'] // max size of 5 mb
        ]);

        $template = new Template([
            'name' => $request->name,
            'doc_path' => $docPath,
            'accept_template' => $templateState,
        ]);
        $template->save();
        return 'Шаблон успешно создан';
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
