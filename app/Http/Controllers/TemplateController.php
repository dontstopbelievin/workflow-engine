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
use Illuminate\Support\Facades\Schema;
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
                'table_name' => 'required|string',
                'template_state' => 'required|integer',
                'process_id' => 'required|integer',
                'template_doc_id' => 'required|integer',
                'role_id' => 'required|integer',
                'order' => 'required|integer',
                'to_citizen' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->with('failure', $validator->errors());
            }
            $t_name = $request->table_name;
            if (!Schema::hasTable($t_name)) {
                $dbQueryString = "CREATE TABLE $t_name (id INT PRIMARY KEY AUTO_INCREMENT)";
                DB::statement($dbQueryString);
            }else{
                return Redirect::back()->with('failure', 'Таблица с таким именем уже существует.');
            }
            if (!Schema::hasColumn($t_name, 'application_id')) {
                $dbQueryString = "ALTER TABLE $t_name ADD  application_id INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($t_name, 'pdf_url')) {
                $dbQueryString = "ALTER TABLE $t_name ADD  pdf_url varchar(255)";
                DB::statement($dbQueryString);
            }
            $template = new Template([
                'table_name' => $t_name,
                'accept_template' => $request->template_state,
                'process_id' => $request->process_id,
                'template_doc_id' => $request->template_doc_id,
                'role_id' => $request->role_id,
                'order' => $request->order,
                'to_citizen' => $request->to_citizen,
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
          $template = Template::where('id', $id)->update(['name' => $request->name, 'pdf_url' => $docPath]);
        }else{
          $template = Template::where('id', $id)->update(['name' => $request->name]);
        }

        return 'Шаблон успешно обновлен';
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $template = Template::where('id', $id)->first();
            if(!Schema::hasTable($template->table_name)){
                return Redirect::back()->with('failure', 'Таблица шаблона не найдена.');
            }
            $template_records = DB::table($template->table_name)->count();
            if($template_records > 0){
                return Redirect::back()->with('failure', 'В таблице шаблона есть записи.');
            }
            TemplateField::where('template_id', $id)->delete();
            Schema::dropIfExists($template->table_name);
            $template->delete();
            DB::commit();
            return Redirect::back()->with('success', 'Шаблон успешно удален');
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('errors', $e->getMessage());
        }
    }
}
