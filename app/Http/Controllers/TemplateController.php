<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;

class TemplateController extends Controller
{
    public function index() {
        $accepted_templates = Template::all()->where('accept_template', 1);
        $rejected_templates = Template::all()->where('accept_template', 0);
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
        $accepted_templates = Template::all()->where('accept_template', 1);
        $rejected_templates = Template::all()->where('accept_template', 0);
        // return view('template.index')->with(compact('accepted_templates', 'rejected_templates'));
        return redirect('/templates');
    }
    public function delete($id) 
    {
        $value = Template::findOrFail($id);
        $value->delete();
        return redirect('/templates')->with('status','Your Data Is Deleted');
    }
    
    
}
