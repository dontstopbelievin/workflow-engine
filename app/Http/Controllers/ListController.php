<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Item;

class ListController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('list.list', compact('items'));
    }

    public function create(Request $request)
    {
        $item = new Item;
        $item->item = $request->text;
        $item->save();
        return 'Done';
    }

    public function delete(Request $request) {
      Item::where('id', $request->id)->delete();
    }

    public function update(Request $request) {

        $item = Item::find($request->id);
        $item->item = $request->value;
        $item->update();
        return $request->all();
    }

    public function search(Request $request) {
        $term = $request->term;
        $items=Item::where('item', 'LIKE', '%'.$term.'%')->get();
        if(count($items) == 0) {
            $searchResult[] = 'No item found';
        } else {
            foreach( $items as $key => $value) {
                $searchResult[] = $value->item;
            }
        }
        return $searchResult;
    }
}
